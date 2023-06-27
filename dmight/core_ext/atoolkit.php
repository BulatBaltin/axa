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
    private $originalName;
    private $mimeType;
    private $error;
    private $test;
    
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
            dump('Bad-1');
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

function print_line_dump( $content, $space, $eol ) {
    // echo '<br>', str_repeat('. ', $space). $content;
    echo $eol, str_repeat('. ', $space). $content;
}
function print_array(&$vars, &$space, $tag = false, $eol = '<br>') {
    $step = 3;
    $old_space = $space;
    $text = ($tag ? $tag . '=>' : '').'(array) size('.count( $vars).') [';
    print_line_dump($text, $space, $eol);

    $space += $step;
    foreach ($vars as $key => $v) {
        if(is_array($v)) {
            print_array($v, $space, $key, $eol);

        } elseif(is_object($v)) {
            echo $eol, str_repeat('. ', $space), $tag ? $tag .'=>': '';
            var_export($v);

        } else {
            $text =  $key . ' => ' . $v;
            print_line_dump($text, $space, $eol);
        }
    }
    print_line_dump(']', $old_space, $eol);

    $space = $old_space;
    return;
}
function dump(...$vars)
{
    $space = 0;
    $eol = "<br>";
    foreach ($vars as $val) {
        if(is_array($val)) {
            print_array($val, $space);
        } elseif(is_object($val)) { 
            echo $eol;
            var_export($val);
        } else 
            echo $eol, $val ;
    }
}
function dump_ret(...$vars)
{
    ob_start();
    $space  = 0;
    $eol    = PHP_EOL;
    foreach ($vars as $val) {
        if(is_array($val)) {
            print_array($val, $space, false, $eol);
        } elseif(is_object($val)) { 
            echo $eol; //'<br>';
            var_export($val);
        } else 
            echo $eol, $val ;
    }
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function dd(...$vars)
{
    dump(...$vars);
    exit(1);
}

// function esc_single_double_quote($value) {
//     if(strpos($value, "'")) $value = str_replace("'", "\'", $value);
//     if(strpos($value, '"')) $value = str_replace('"', '\"', $value);
//     return $value;
// }
function sql_value($value) { 
    if(is_string($value))   return "'".DataBase::real_escape_string($value)."'";
    if(is_numeric($value))  return $value;
    if($value === null)     return 'NULL';
    if(is_bool($value))     return $value ? 'TRUE' : 'FALSE';
    if($value instanceof DateTime) return $value->format('Y-m-d H:i:s')."'";

    // $value = esc_single_double_quote($value);
    $value = DataBase::real_escape_string($value);
    $value = $value."'";
    return $value;
}
function sql_value_eq($value) { 
    if(is_string($value))   return " ='".DataBase::real_escape_string($value)."'";
    if(is_numeric($value))  return ' =' .$value;
    if($value === null)     return ' IS NULL';
    if(is_bool($value))     return ' =' .$value ? 'TRUE' : 'FALSE';
    if($value instanceof DateTime) return " ='" . $value->format('Y-m-d H:i:s')."'";

    // $value = esc_single_double_quote($value);
    $value = DataBase::real_escape_string($value);
    $value = " ='".$value."'";
    return $value;
}
function roundEx($value, $precision, $mode = PHP_ROUND_HALF_UP ) {
    if(is_numeric($value)) return round($value, $precision, $mode);
    return 0;
}
function str_has($haystack, $needle) {
    if(!is_string($haystack) and !is_string($needle)) return false;
    return stripos($haystack, $needle) !== false;
}