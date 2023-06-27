<?
class Trackingmap extends dmModel {
    static function GetTableName() {
        return 'trackingmap';
    }

    static function getKeys($params)
    {
        $arKeys = explode(';', $params); //$map['params']);
        $token = isset($arKeys[0]) ? $arKeys[0] : "";
        $key1 = isset($arKeys[1]) ? $arKeys[1] : "";
        $key2 = isset($arKeys[2]) ? $arKeys[2] : "";
        return [$token, $key1, $key2];
    }
    // 'company', $company, 'Teamwork'
    static function findCredentials(string $objecttype, array $object, string $trackingName, $company_id)
    {
        $mapper = self::findOneBy([
            'trackingname'  => $trackingName,
            'objecttype'    => $objecttype,
            'objectid'      => $object['id'],
            'company_id'    => $company_id,
        ]);

        if ($mapper and $mapper['params']) { // Trackingmap record
            $keys = $mapper['params'];
            [$token, $key1, $key2] = self::getKeys($keys);
            return ['token' => $token, 'key1' => $key1, 'key2' => $key2, 'map' => $mapper];
        }
        return ['token' => '', 'key1' => '', 'key2' => '', 'map' => null];
    }
}