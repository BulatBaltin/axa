<?php
class survey extends dlModel{
    public static $_cache = [];
    
    function __construct() {
        parent::__construct();
        $this->setTableName("survey","Опитування");
        $this->NOTAddable();
        $this->NOTDeletable();
        
        $this->AddFields([
            [new Text("",STRONG,50),"high","Високий рівень небезпеки"],                    
            [new Text("",STRONG,50),"middle","Cередній рівень небезпеки"],                    
            [new Text("",STRONG,50),"low","Низький рівень небезпеки"],                    
        ]);
    }

    static function calc_result( $result ) {

        $survey = dlModel::Create('survey');
        $record = $survey->getRecById(1);
        
        $record['high'] += $result[0];
        $record['middle'] += $result[1];
        $record['low'] += $result[2];
        
        $survey->UpdateExt(1, ['high','middle','low'], [$record['high'],$record['middle'],$record['low']]);
        
        $record['total'] = $record['high'] + $record['middle'] + $record['low'];
        
        $record['high']      = round(($record['high'] / $record['total'] * 100));
        $record['middle']   = round(($record['middle'] / $record['total'] * 100));
        $record['low']    = 100 - $record['high'] - $record['middle'];
        
        return $record;
    }

    static function define_result( $block1, $block2 ) {

        if($block1 >= 2) {
            $result = [1, 0, 0];
            $text = 'Високий рівень небезпеки';
            $color = "red";
        }
        elseif (($block1 = 1 and $block2 >= 7) or ($block1 = 0  and $block2 >= 14) )  {
        
            $result = [0, 1, 0];
            $text = 'Cередній рівень небезпеки';
            $color = "blue";
        }
        else {
            $result = [0, 0, 1];
            $text = 'Низький рівень небезпеки';
            $color = "green";
        }
        return [$result, $text, $color];
    }

}
  
?>
