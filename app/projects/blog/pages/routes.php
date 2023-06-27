<?
// dd('BLOG');

$routes = new ROUTER;
$routes->
    Project('projects.blog') // 3-d parameter -> pages.blog.pages@create
        ->Module('pages') // 3-d parameter -> pages.blog.pages@create
            ->Prefix('blog') // 1-st parameter, adds 'blog.' -> 'blog.post-create'

    ->Add('',               'get:blog',             'index')
    ->Add('post-create',    'blog/create',          'create')
    ->Add('post-store',     'post:blog/store',      'store')
    ->Add('post-update',    'post:blog/{id}/update','update')
    ->Add('post-edit',      'blog/{id}/edit',       'edit')
    ->Add('post-show',      'get:blog/{slug}',      'show')
    ->Add('blog-last-post', 'get:blog-last-post',   'show')
    ->Add('post-delete',    'post:blog/{id}/delete','delete')
    ->Add('blog-ajax',      'get|post:blog-ajax',   'ajax.test-grid')
    
        // ->Module('pages.blog') // 3-d parameter -> pages.blog.pages@create
    ; 
