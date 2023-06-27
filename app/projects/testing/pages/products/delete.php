<?
$id = REQUEST::getParam('id');
$post = Post::find($id);
$return = Post::make('delete', $id );

Session::set('message', "Post {$post['title']} has been deleted successfully");
// dd('>>', $id, $return)
UrlHelper::Redirect( route('blog') );
?>