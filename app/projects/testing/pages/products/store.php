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

// $module = ROUTER::ModuleName();
// $action = ROUTER::ActionName();
// $method = ROUTER::MethodName();

// var_dump("********", $method, $module, $action);

$request = [];
$request['title'] = $_REQUEST['title'];
$request['description'] = $_REQUEST['description'];

$fileObj = $_FILES['input-name'];

if($fileObj and $fileObj['name']) {
    
    $newFileName = uniqid() . '-' . $fileObj['name']; 
    $request['image'] = $fileObj['name'];
    $imageObject = new FileDownload($fileObj['tmp_name'], $fileObj['name'], $fileObj['type']);
    $imageObject->move( IMAGES, $newFileName );
} else {
    $uploadFile = REQUEST::getParam('image-file');
    $newFileName = uniqid() . '-' . basename($uploadFile); 
    if($uploadFile) {
        // $base_name = basename( $uploadFile );
        $content = file_get_contents($uploadFile);
        file_put_contents(IMAGES . $newFileName, $content);
    }
}

// $file_name = $_FILES['image']['name'];
// $request['image'] = $file_name;
// $newFileName = uniqid() .'-'.$file_name; 
// $imageObject = new FileDownload($_FILES['image']['tmp_name'], $_FILES['image']['name'], $_FILES['image']['type']);
// $imageObject->move( IMAGES, $newFileName );
// // $form = new DataLinkForm;

Post::make('insert', 0, [
    'slug' => make_slug($request['title']),
    'title' => $request['title'],
    'description' => $request['description'],
    'image_path' => $newFileName,
    'user_id' => 2,
    'created_at' => date('c'),
    'updated_at' => date('c'),
]);

Session::set('message', 'Post was added successfully');
// dd("???");

UrlHelper::Redirect( route('blog') );
?>