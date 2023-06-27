<?
// class tester {

// public function __get(string $name)
// {
//     return $this->$name();
// }
// public function contents()
// {
//     return 'The true contents of the box';
// }
// /**
//  * The single value that should be used to represent the resource when being displayed.
//  *
//  * @var string
//  */
// public static $title = 'title:code';
// // public static $'title:ext';

// /**
//  * The columns that should be searched.
//  *
//  * @var array
//  */
// public static $search = [
//     'id', 'code',
// ];

// // protected $into = 'Intro';
//     function say ($code) {
//         // $this->title = new class { public $code = 300; };
//         $this->{'title:code'} = 1234567;
//         $this->name = '0000000000000000';
//         echo $this->{'title:code'};
//         echo $this->name;

//         // echo $this->{'into:' . $code};
//     }
// }

// $o = new stdClass();
// $o->{'code:out'} = 1000;
// echo 'code:out ', $o->{'code:out'};

// $test = new tester;

// $test->say('100');
// echo '<br>', $test->contents;

// $any = new class {};
// $any->name = "My name";
// $any->{'true:name'} = "My true name";
// echo '<br>', $any->name;
// echo '<br>', $any->{'true:name'};

// die;

// $deep = new AGreatTest;
// dd($deep->Output());

$posts = Post::findAll(['updated_at'=>'DESC']);
// App::$debug = true;
