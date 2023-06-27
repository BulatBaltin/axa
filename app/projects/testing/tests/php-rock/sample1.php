<?php
// methods and anonymous Classes

// Generally, in PHP7, using the following forms are all possible:

//     // Everything inside `<something>` brackets means one or more expressions
//     // to form something
    
//     // Dynamic function call via function name
//     (<function_name>)(arguments);
    
//     // Dynamic function call on a callable property
//     ($object->{<property_name>})(arguments);
    
//     // Dynamic method call on an object
//     $object->{<method_name>}(arguments);
//     $object::{<method_name>}(arguments);
    
//     // Dynamic method call on a dynamically-generated object
//     (<object>)->{<method_name>}(arguments);
//     (<object>)::{<method_name>}(arguments);
    
//     // Dynamic method call, statically
//     ClassName::{<method_name>}(arguments);
//     (<class_name>)::{<method_name>}(arguments);
    
//     // Dynamic method call, array-like (no different between static
//     // and non-static calls
//     [<object>, <method_name>](arguments);
    
//     // Dynamic method call, array-like, statically
//     [<class_name>, <method_name>](arguments);



// ($object->{<property_name>})();

// A more elegant way added in PHP7 is the following:

// [<object>, <method_name>](arguments);
// [<class_name>, <method_name>](arguments); // Static calls only

class Foo
{
    public function nonStaticCall()
    {
        echo "Non-static call";
    }
    public static function staticCall()
    {
        echo "Static call";
    }

    function GetName() {
        return 'Silly Jouhny';
    }
    static function GetAny($cargo) {
        return $cargo;
    }
}
