<?
class Rules extends dmModel {
    static function GetTableName() {
        return 'rules';
    }

    static function getFieldChoices()
    {
        return [
            'name'          => 'Project name',
            'description'   => 'Project description',
            'group'         => 'Project group',
            'pid'           => 'Project tracking ID'
        ];
    }

    static function getOperatorChoices()
    {
        return [
            '='         => 'Equal',
            'contains'  => 'Contains',
            '<>'        => 'Not equal',
            '>'         => 'Greater than',
            '=>'        => 'Greater or equal',
            '<'         => 'Less than',
            '<='        => 'Less or equal'
        ];
    }


}