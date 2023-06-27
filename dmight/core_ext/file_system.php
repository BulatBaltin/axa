    <?php
class FILE_SYSTEM {

    public static function getFileNameAndExtension($file_name){
        $path_parts = pathinfo($file_name);
        $file_name = $path_parts['filename'];
        if($path_parts['dirname']){
            $file_name = $path_parts['dirname']."/".$path_parts['filename'];
        }
        return [$file_name, $path_parts['extension']];
    }

    // @Bulat 2021-05-21
    public static function provideDirFiles($dir, $actor, $ext)
    {
        // dd($dir, __DIR__, getDocumentRoot());
        $opened_dir = opendir($dir);
        while ($element=readdir($opened_dir)){
            $fext=substr($element,strlen($ext)*-1);
            if(($element!='.') && ($element!='..') && ($fext==$ext)){
                // $actor->handle($dir.$element);
                $actor->handle($element);
            }
        }
        closedir($opened_dir);
    }
    public static function getDirFiles($dir, $ext='php')
    {
        $opened_dir = opendir($dir);
        $files = [];
        while ($element=readdir($opened_dir)){
            $fext=substr($element,strlen($ext)*-1);
            if(($element!='.') && ($element!='..') && ($fext==$ext)){
                $files[] = $dir.$element;
            }
        }
        closedir($opened_dir);
        return $files;
    }
    public static function includeDir($dir, $ext='php')
    {
        $opened_dir = opendir($dir);
         
        while ($element=readdir($opened_dir)){
            $fext=substr($element,strlen($ext)*-1);
            if(($element!='.') && ($element!='..') && ($fext==$ext)){
                include_once($dir.$element);
            }
        }
        closedir($opened_dir);
    }

    // public static function removeDirRec($dir)
    // {
    //     if ($objs = glob($dir."/*")) {
    //         foreach($objs as $obj) {
    //             is_dir($obj) ? removeDirRec($obj) : unlink($obj);
    //         }
    //     }
    //     rmdir($dir);
    // }
    
    public static function downloadFile($filename, $mimetype='application/octet-stream') 
    {    
        if (!file_exists($filename)) die('File not found: '. $filename);

        $from=$to=0; $cr=NULL;

        if (isset($_SERVER['HTTP_RANGE'])) {
            $range=substr($_SERVER['HTTP_RANGE'], strpos($_SERVER['HTTP_RANGE'], '=')+1);
            $from=strtok($range, '-');
            $to=strtok('/'); if ($to>0) $to++;
            if ($to) $to-=$from;
            header('HTTP/1.1 206 Partial Content');
            $cr='Content-Range: bytes ' . $from . '-' . (($to)?($to . '/' . ($to+1)):filesize($filename));
        } else    header('HTTP/1.1 200 Ok');

        $etag=md5($filename);
        $etag=substr($etag, 0, 8) . '-' . substr($etag, 8, 7) . '-' . substr($etag, 15, 8);
        header('ETag: "' . $etag . '"');

        header('Accept-Ranges: bytes');
        header('Content-Length: ' . (filesize($filename)-$to+$from));
        if ($cr) header($cr);

        header('Connection: close');
        header('Content-Type: ' . $mimetype);
        header('Last-Modified: ' . gmdate('r', filemtime($filename)));
        $f=fopen($filename, 'r');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '";');
        if ($from) fseek($f, $from, SEEK_SET);
        if (!isset($to) or empty($to)) {
            $size=filesize($filename)-$from;
        } else {
            $size=$to;
        }
        $downloaded=0;
        while(!feof($f) and !connection_status() and ($downloaded<$size)) {
            echo fread($f, 512000);
            $downloaded+=512000;
            flush();
        }
        fclose($f);
    }
}


class dlFile{
    public $file;
    public $eos;
    function __construct($file_path){
       $this->file = fopen($_SERVER['DOCUMENT_ROOT'].$file_path,"w");
       if(!$this->file){
          echo("Ошибка открытия файла ".$file_path);
       }
       $this->eos="\r\n";
    }
    
    function WriteStr($str){   
       fputs( $this->file, $str.$this->eos);   
    }
    
    function WriteArray($arr,$close_after = false){
        foreach( $arr as $arr_elem ){
            $this->WriteStr($arr_elem);
        }   
        if($close_after){
            $this->Close();
        }
    }
    
    function Close(){
        fclose($this->file);
    }
}
?>