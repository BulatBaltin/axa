<?
class MenuItem {
    private $item;
    private $builder;
    function __construct($builder, $item)
    {
        $this->builder = $builder;
        $this->item = $item;
    }
    function Add( $item) {
        $menuItem = new MenuItem($this->builder, $item);
        $this->builder->items[] = $menuItem;
        return $menuItem;
    }
}
class MenuBuilder {
    private $item;
    public $items;
    function __construct($item = null)
    {
        $this->item  = $item;
        $this->items = [];
    }
    function AddNode( $item) {
        $menuItem = new MenuBuilder($item);
        $this->items[] = $menuItem;
        return $this->items[count($this->items)-1];
    }
    function Add( $item) {
        $menuItem = new MenuItem($this, $item);
        $this->items[] = $menuItem;
        return $this;
    }
}

$menu = new MenuBuilder;
$menu->AddNode([
'name' => 'User management', 
'icon' => 'fa-fw fas fa-users nav-icon', 
])
    ->Add([
        'name' => 'Permissions', 
        'href'=>'/dashboard/permissions',
        'icon'=>'fa-fw fas fa-unlock-alt nav-icon' 
    ])
    ->Add([
        'name' => 'Roles', 
        'href'=> route('dashboard-roles'),
        'icon'=>'fa-fw fas fa-briefcase nav-icon' 
    ])
    ->Add([
        'name' => 'Users', 
        'href'=> route('dashboard-users'),
        'icon'=>'fa-fw fas fa-user nav-icon' 
    ]);
    
$menu->Add([
    'name' => 'Expense Categories', 
    'href'=> route('admin-expense-categories'),
    'icon'=>'fa-fw fas fa-list nav-icon' 
]);    

$x_shift = 0;
$root_dir = __DIR__ . '/';
$left_menu_items = [
[
'name' => 'User management', 
'icon' => 'fa-fw fas fa-users nav-icon', 
'items' => 
    [
        [
            'name' => 'Permissions', 
            'href'=>'/dashboard/permissions',
            'icon'=>'fa-fw fas fa-unlock-alt nav-icon' 
        ],
        [
            'name' => 'Roles', 
            'href'=> route('dashboard-roles'),
            'icon'=>'fa-fw fas fa-briefcase nav-icon' 
        ],
        [
            'name' => 'Users', 
            'href'=> route('dashboard-users'),
            'icon'=>'fa-fw fas fa-user nav-icon' 

        ],
    ]
],
[
'name' => 'Javascript', 
'icon' => 'fa-fw fas fa-users nav-icon', 
'items' => 
    [
        [
            'name' => 'JS Tricks', 
            // 'href'=> route('test.js-trick-1'), //'/js-trick/trick1',
            'href'=> 'test.js-trick-1', //'/js-trick/trick1',
            'icon'=>'fa-fw fas fa-unlock-alt nav-icon' 
        ],
        [
            'name' => 'Roles', 
            'href'=> route('dashboard-roles'),
            'icon'=>'fa-fw fas fa-briefcase nav-icon' 
        ],
        [
            'name' => 'Users', 
            'href'=> route('dashboard-users'),
            'icon'=>'fa-fw fas fa-user nav-icon' 

        ],
    ]
],
[
    'name' => 'Expense Categories', 
    'href'=> 'admin-expense-categories',
    'icon'=>'fa-fw fas fa-list nav-icon' 
],
[
    'name' => 'Animation typewriter (css)', 
    'title' => 'Animation typewriter using css steps', 
    'href'=> 'test.plus-01',
    'icon'=>'fa-solid fa-typewriter nav-icon' 
],
[
    'name' => 'CSS Tricks 1(5)', 
    'title' => 'Animation typewriter using css steps', 
    'href'=> 'test.css-tricks-01',
    'icon'=>'fa-solid fa-keyboard nav-icon' 
],
[
    'name' => 'CSS Tricks 2(5)', 
    'title' => 'Animation typewriter using css steps', 
    'href'=> 'test.css-tricks-02',
    'icon'=>'fa-solid fa-keyboard nav-icon' 
],
[
    'name' => 'CSS Tricks 3-5: Clip, Fonts, Gradients', 
    'title' => '(3-5) Clip, Fonts, Gradients', 
    'href'=> 'test.css-tricks-03',
    'icon'=>'fa-solid fa-keyboard nav-icon' 
],
[
    'name' => 'PDF Printing', 
    'title' => 'PDF Printing', 
    'href'=> 'test.print-pdf',
    'icon'=>'fa-solid fa-keyboard nav-icon' 
],

];