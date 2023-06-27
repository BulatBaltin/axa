<?

try {
    $id = REQUEST::getParam('id');
    $post = Post::find($id);

    $request = [];
    $request['title'] = $_REQUEST['title'];
    $request['description'] = $_REQUEST['description'];

    if(isset($_FILES['input-name']['name']))
        include('include/file_upload.php');
    else
        $newFileName;

    $data = [
        'id' => $id,
        'slug' => make_slug($request['title']),
        'title' => $request['title'],
        'description' => $request['description'],
        'updated_at' => date('c'),
    ];
    if($newFileName) {
        $data['image_path'] = $newFileName;
    }
    $return = Post::make('update', $id, $data );
    Session::set('message', 'Post was updated successfully');

    $url = route('blog');
    UrlHelper::Redirect( $url );
    
} catch (Exception $e) {
    dd($e->getMessage());
}

?>