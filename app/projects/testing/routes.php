<?

ROUTER::ModuleRoute('test.tests',   'test/tests',   'projects.testing:tests');
ROUTER::ModuleRoute('css',          'css',          'projects.testing:tests');
ROUTER::ModuleRoute('test.student', 'test/student', 'projects.testing:student');
ROUTER::ModuleRoute('test.pages',   'test/pages',   'projects.testing:pages');
ROUTER::ModuleRoute('test.mollie',  'test/mollie',  'projects.testing:mollie');


// $routes = new ROUTER;
//     $routes->Project('shop') // 3-d param -> shopping@add
//     ->Prefix('shop')
//     ->Add('', 'shop', 'index')
//     ->Add('index', 'shop', 'index')
//     ->Add('add', 'shop/add', 'add')
//     ->Add('edit', 'shop/edit', 'edit');

// ROUTER::Route('stydentik.add', 'students/add', 'student.school.crud@add');
// ROUTER::Route('stydentik.edit', 'students/edit', 'student.school.crud@edit');
