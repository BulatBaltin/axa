<?
class ProjectenPoint extends dmModel {
    static function GetTableName() {
        return 'projecten_points';
    }

    private $id;
    private $name;
    private $projecten;
    private $point;
    private $date;

    public function getStructure() {
        return [
            'id' => 0,
            'name' => '',
            'projecten_id' => 0,
            'point' => 0,
            'date' => '',
        ];
    }
}