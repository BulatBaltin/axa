<?
$slug = REQUEST::getParam('slug');

// dd('$slug= ' . $slug);

if(ROUTER::getRouteInfo()['slug'] == 'blog-last-post') {
    $post = Post::findUpdated();
}
else
    $post = Post::findOneBy(['slug' => $slug ]);

if(!$post) $post = Post::findUpdated();
?>