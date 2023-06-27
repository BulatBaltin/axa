<?
$routes = new ROUTER;
$routes->
    Project('projects.home')    // 3-d parameter -> pages.blog.pages@create
        ->Module('frontpage')   // 3-d parameter -> pages.blog.pages@create
            ->Prefix('')        // 1-st parameter, adds 'blog.' -> 'blog.post-create'

    ->Add('home',  '',   'index')
    ->Add('admin-fancy-home','admin/fancy/home','fancy-home')
    ; 
