<?

// var_dump($_SERVER);
// dump("=============");
// var_dump($_REQUEST);
// dump("=============");
// var_dump($_FILES);
// dump("============= POST");
// var_dump($_POST);
// dump("============= GET");
// var_dump($_GET);

try {
    $id = REQUEST::getParam('id');
    $post = Post::find($id);

    $request = [];
    $request['title'] = $_REQUEST['title'];
    $request['description'] = $_REQUEST['description'];

    $fileObj = $_FILES['input-name'];

    $newFileName = $post['image_path']; 
    if($fileObj and $fileObj['name']) {

        $request['image'] = $fileObj['name'];
        $imageObject = new FileDownload($fileObj['tmp_name'],$fileObj['name'],$fileObj['type']);
        $imageObject->move( IMAGES, $newFileName );
    } else {
        $uploadFile = REQUEST::getParam('image-file');
        if($uploadFile) {
            // $base_name = basename( $uploadFile );
            $content = file_get_contents($uploadFile);
            file_put_contents(IMAGES . $newFileName, $content);
        }
    }

    $return = Post::make('update', $id, [
        'title' => $request['title'],
        'description' => $request['description'],
        // 'image_path' => $newFileName,
        'updated_at' => date('c'),
    ]);

    Session::set('message', 'Post was updated successfully');
    // dd("???",$id, $return);

    UrlHelper::Redirect( route('blog') );
} catch (Exception $e) {
    dd($e->getMessage());
}

?>