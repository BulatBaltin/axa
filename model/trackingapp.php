<?
class Trackingapp extends dmModel {
    static function GetTableName() {
        return 'trackingapp';
    }

    static function App(?string $trackingApp, $param = [], $user = null)
    {
        // $workSpace = "App\Service\\";
        if (stripos($trackingApp, 'toggl') !== false) {
            $trackingApp = 'ApiToggl';
        } elseif (stripos($trackingApp, 'teamwork') !== false) {
            $trackingApp = 'ApiTeamwork';
        };
        // $trackingApp = $workSpace . $trackingapp;
        $app = new $trackingApp($param, $user);
        return $app;
    }

}