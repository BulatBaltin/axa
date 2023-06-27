<?
$slug = REQUEST::getParam('slug');
$post = Post::findOneBy(['slug' => $slug ]);
?>