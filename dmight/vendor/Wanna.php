<?
class Wanna {
    private $mssg;
    function __construct($mssg)
    {
        $this->mssg = $mssg;        
    }
    function Print( $mssg ) {
        echo '<br>', $mssg;

        $obj = new Swanna();

        echo '<br>', $this->mssg;
        echo '<br>', $obj->PlusPlus([2,2,2,2]);
    }
}