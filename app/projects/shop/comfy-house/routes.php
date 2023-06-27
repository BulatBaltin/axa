<?
// ROUTER::ModuleRoute('shop.home',  'shop', 'projects.shop:comfi-house');
// dd('LOAD HERE');

$route = new ROUTER;
$route
->Project('projects.shop') // 3-d param -> shopping@add
    ->Module('comfy-house') // 3-d param -> shopping@add
        ->Prefix('shop')
// ->Add('', 'shop', 'index')
->Add('index', 'shop', 'index')
->Add('add', 'shop/add', 'add')
->Add('edit', 'shop/edit', 'edit');

// ROUTER::Route('stydentik.add', 'students/add', 'student.school.crud@add');
// ROUTER::Route('stydentik.edit', 'students/edit', 'student.school.crud@edit');
