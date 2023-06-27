<?
$request = [];
$request['title'] = $_REQUEST['title'];
$request['description'] = $_REQUEST['description'];

include('include/file_upload.php');

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