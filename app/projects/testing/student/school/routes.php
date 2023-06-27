<?
$routes = new ROUTER;
$routes->Folder('student.school.crud')

    ->Add('stydentik.add', 'students/add', 'add')
    ->Add('scolar.add', 'students/add', 'add')
    ->Add('stydentik.edit', 'students/edit', 'edit');

// ROUTER::Route('stydentik.add', 'students/add', 'student.school.crud@add');
// ROUTER::Route('stydentik.edit', 'students/edit', 'student.school.crud@edit');
