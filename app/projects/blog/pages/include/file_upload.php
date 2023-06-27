<?php

$fileObj = $_FILES['input-name'];
if($fileObj and $fileObj['name']) {

    $uploader = new FileUpload('input-name',[
        'target_dir'    => IMAGES,
        'target_file'   => function ($file_name) { return uniqid() . '-' . $file_name; }
    ]);
    [$Ok, $file, $mssg] = $uploader->Action();
    if($Ok) {
        $newFileName = basename($uploader->target_file);
    } else {
        throw new Exception(ll('Error uploading file'));
    }
    
} else {
    $uploadFile = REQUEST::getParam('image-file');
    $patt = '<post>';
    if(str_starts($uploadFile, $patt )) {
        $newFileName = substr($uploadFile, 6); 
    } else {

        $newFileName = uniqid() . '-' . basename($uploadFile); 
        if($uploadFile) {
            // $base_name = basename( $uploadFile );
            $content = file_get_contents($uploadFile);
            file_put_contents(IMAGES . $newFileName, $content);
        }
    }
}
