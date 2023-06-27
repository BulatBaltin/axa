<?php
class FileException extends \RuntimeException
{
}
class FileNotFoundException extends FileException
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('The file "%s" does not exist', $path));
    }
}
class File extends \SplFileInfo{
    /**
     * Constructs a new file from the given path.
     *
     * @param string $path      The path to the file
     * @param bool   $checkPath Whether to check the path or not
     *
     * @throws FileNotFoundException If the given path is not a file
     */
    public function __construct(string $path, bool $checkPath = true)
    {
        if ($checkPath && !is_file($path)) {
            throw new FileNotFoundException($path);
        }

        parent::__construct($path);
    }

    /**
     * Returns the extension based on the mime type.
     *
     * If the mime type is unknown, returns null.
     *
     * This method uses the mime type as guessed by getMimeType()
     * to guess the file extension.
     *
     * @return string|null The guessed extension or null if it cannot be guessed
     *
     * @see MimeTypes
     * @see getMimeType()
     */
    public function guessExtension()
    {
        if (!class_exists(MimeTypes::class)) {
            throw new \LogicException('You cannot guess the extension as the Mime component is not installed. Try running "composer require symfony/mime".');
        }

        // return MimeTypes::getDefault()->getExtensions($this->getMimeType())[0] ?? null;
        return "";
    }

    /**
     * Returns the mime type of the file.
     *
     * The mime type is guessed using a MimeTypeGuesserInterface instance,
     * which uses finfo_file() then the "file" system binary,
     * depending on which of those are available.
     *
     * @return string|null The guessed mime type (e.g. "application/pdf")
     *
     * @see MimeTypes
     */
    public function getMimeType()
    {
        if (!class_exists(MimeTypes::class)) {
            throw new \LogicException('You cannot guess the mime type as the Mime component is not installed. Try running "composer require symfony/mime".');
        }

        return ""; //MimeTypes::getDefault()->guessMimeType($this->getPathname());
    }

    /**
     * Moves the file to a new location.
     *
     * @return self A File object representing the new file
     *
     * @throws FileException if the target file could not be created
     */
    public function move(string $directory, string $name = null)
    {
        $target = $this->getTargetFile($directory, $name);

        set_error_handler(function ($type, $msg) use (&$error) { $error = $msg; });
        $renamed = rename($this->getPathname(), $target);
        restore_error_handler();
        if (!$renamed) {
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s).', $this->getPathname(), $target, strip_tags($error)));
        }

        @chmod($target, 0666 & ~umask());

        return $target;
    }

    public function getContent(): string
    {
        $content = file_get_contents($this->getPathname());

        if (false === $content) {
            throw new FileException(sprintf('Could not get the content of the file "%s".', $this->getPathname()));
        }

        return $content;
    }

    /**
     * @return self
     */
    protected function getTargetFile(string $directory, string $name = null)
    {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory.', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory.', $directory));
        }

        $target = rtrim($directory, '/\\').\DIRECTORY_SEPARATOR.(null === $name ? $this->getBasename() : $this->getName($name));

        return new self($target, false);
    }

    /**
     * Returns locale independent base name of the given path.
     *
     * @return string
     */
    protected function getName(string $name)
    {
        $originalName = str_replace('\\', '/', $name);
        $pos = strrpos($originalName, '/');
        $originalName = false === $pos ? $originalName : substr($originalName, $pos + 1);

        return $originalName;
    }

}

class FileDownload extends File{
    public function __construct(string $path, string $originalName, string $mimeType = null, int $error = null, bool $test = false)
    {
        $this->originalName = $this->getName($originalName);
        $this->mimeType = $mimeType ?: 'application/octet-stream';
        $this->error = $error ?: \UPLOAD_ERR_OK;
        $this->test = $test;

        // "C:\wamp\tmp\phpA36A.tmp"
        // ^ "hummingbird-hawkmoth-4811285_640.jpg"
        // ^ "image/jpeg"
// dump('path =', $path);
// dump('originalName =', $this->originalName);
// dump('mimeType =', $this->mimeType);
// dump('is_file =', is_file($path));

        $checkPath = (\UPLOAD_ERR_OK === $this->error);
        // parent::__construct($path, \UPLOAD_ERR_OK === $this->error);
        // $path = str_replace('\\', '/', $path);
// dump('Ok-1', is_file($path), $path);
        if ($checkPath && !is_file($path)) {
            throw new FileNotFoundException($path);
        }

        parent::__construct($path);
// dump('Ok-2');

    }
    // protected function getName(string $name)
    // {
    //     $originalName = str_replace('\\', '/', $name);
    //     $pos = strrpos($originalName, '/');
    //     $originalName = false === $pos ? $originalName : substr($originalName, $pos + 1);

    //     return $originalName;
    // }

    // protected function getTargetFile(string $directory, string $name = null)
    // {
    //     if (!is_dir($directory)) {
    //         if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
    //             throw new FileException(sprintf('Unable to create the "%s" directory.', $directory));
    //         }
    //     } elseif (!is_writable($directory)) {
    //         throw new FileException(sprintf('Unable to write in the "%s" directory.', $directory));
    //     }

    //     $target = rtrim($directory, '/\\').\DIRECTORY_SEPARATOR.(null === $name ? $this->getBasename() : $this->getName($name));

    //     return new self($target, false);
    // }

    /**
     * Moves the file to a new location.
     *
     * @return File A File object representing the new file
     *
     * @throws FileException if, for any reason, the file could not have been moved
     */
    public function move(string $directory, string $name = null)
    {
        $source = $this->getPathname();            
        // if ($this->isValid()) {
        //     if ($this->test) {
        //         return parent::move($directory, $name);
        //     }
            $target = $this->getTargetFile($directory, $name);
            // $target = '/images/609bb50ed259b-hummingbird-hawkmoth-4811285_640.jpg';
// dump('*********** MOVE = ' . $source );            
            $error = 'init value';
// dump('Source = ' . $source);            
// dump('Target = ' . $target );
            set_error_handler(function ($type, $msg) use (&$error) { $error = $msg; });
            $moved = move_uploaded_file($source, $target);
// dump('moved = ' . $moved );
            restore_error_handler();
            if (!$moved) {
                throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s).', $source, $target, strip_tags($error)));
            }

            @chmod($target, 0666 & ~umask());

// dump('RETURN target = ' . $target );
            return $target;
        // }

        // switch ($this->error) {
        //     case \UPLOAD_ERR_INI_SIZE:
        //         throw new IniSizeFileException($this->getErrorMessage());
        //     case \UPLOAD_ERR_FORM_SIZE:
        //         throw new FormSizeFileException($this->getErrorMessage());
        //     case \UPLOAD_ERR_PARTIAL:
        //         throw new PartialFileException($this->getErrorMessage());
        //     case \UPLOAD_ERR_NO_FILE:
        //         throw new NoFileException($this->getErrorMessage());
        //     case \UPLOAD_ERR_CANT_WRITE:
        //         throw new CannotWriteFileException($this->getErrorMessage());
        //     case \UPLOAD_ERR_NO_TMP_DIR:
        //         throw new NoTmpDirFileException($this->getErrorMessage());
        //     case \UPLOAD_ERR_EXTENSION:
        //         throw new ExtensionFileException($this->getErrorMessage());
        // }

        // throw new FileException($this->getErrorMessage());
    }


}

class DataLinkForm extends DataLink
{
    function __construct()
    {
        $this->default = 0;
    }
    // function __set($term, $value)
    // {
    //     $this->data[$term] = $value;
    // }
    function __get($term)
    {
        return REQUEST::getParam($term, $this->default); // null;
    }
}
class DataLinkStock extends DataLink
{
    // function __set($term, $value)
    // {
    //     $this->data[$term] = $value;
    // }
    // function __get($term)
    // {
    //     return isset($this->data[$term]) ? $this->data[$term] : $this->default; // null;
    // }
    function setIfNotExist($variables, $value = null)
    {
        foreach ($variables as $term) {
            if (!isset($this->data[$term]))
                $this->data[$term] = $value == null ? $this->default : $value;
        }
    }
    function setFromDataSource($variables, $source)
    {
        foreach ($variables as $term) {
            $this->data[$term] = isset($source[$term]) ? $source[$term] : $this->default;
        }
    }
}
class DataLinkSession extends DataLink
{

    function extract()
    {
        $variables = Session::showSetList();
        foreach ($variables as $term) {
            $$term = Session::get($term);
        }
    }
    function clear()
    {
        Session::unsetAll();
    }
    function __set($term, $value)
    {
        Session::set($term, $value);
    }
    function __get($term)
    {
        return Session::isset($term) ? Session::get($term) : $this->default; // null;
    }
    function setIfNotExist($variables, $value = null)
    {
        foreach ($variables as $term) {
            if (!Session::isset($term)) Session::set($term, $value == null ? $this->default : $value);
        }
    }
    function getIfExist($variables, $value = null)
    {
        foreach ($variables as $term) {
            if (Session::isset($term)) $$term = Session::get($term, $value == null ? $this->default : $value);
        }
    }
}

class DataLink
{
    protected $default = null;
    protected $data = [];
    function __construct($data = array())
    {
        $this->data = $data;
    }
    function __get($term)
    {
        return isset($this->data[$term]) ? $this->data[$term] : $this->default; // null;
    }
    function __set($term, $value)
    {
        $this->data[$term] = $value;
    }
    function setDefault($value)
    {
        $this->default = $value;
        return $this;
    }
    function getDefault()
    {
        return $this->default;
    }
}
