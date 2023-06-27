<?
class CompanyRepository extends Repository {

    static function getTrackinglstArr( $company ): ?array
    {
        $tracks = Trackingmap::findBy([
            'company_id'    => $company['id'],
            'objecttype'    => 'company',
            'objectid'      => $company['id'],
            'trackingname'  => 'Teamwork',
        ]);
        $trackings = [];
        foreach ($tracks as $track) {
            $trackings[$track['trackingname']] = $track['trackingname'];
        }
        return $trackings;
    }

}