<?php

try {
    $boss     = User::getUser();
    $company  = User::getCompany($boss);
    $user_id  = REQUEST::getParam('id');
    
    $return = "success";
    $mssg   = Messager::renderSuccess();
    
    if(!$user_id) { // New customer - client
        $user = User::getDefault();
    } else {
        $user = User::find($user_id);
    }
    $user['company_id'] = $company['id'];
    $id         = REQUEST::getParam('tracking_id');

    $startdate = REQUEST::getParam('startdate');
    $stopdate  = REQUEST::getParam('stopdate');
    $company_token  = REQUEST::getParam('company_token');
    $tracking_id    = REQUEST::getParam('togglid'); // delete it?
    $usertoken      = REQUEST::getParam('usertoken');

    // var_dump([
    // $startdate0,
    // $stopdate,
    // $company_token,
    // $tracking_id,
    // $usertoken]
    // );

    // dd($_POST);

    // $stopdate = DateTime::createFromFormat('Y-m-dTH:i', $stopdate);
    // $startdate = $startdate0;
    // $startdate = DateTime::createFromFormat('Y-m-j H:i', $startdate);

    $key = $usertoken . ';' . $company_token . ';' . $tracking_id;

    // $trackList = $em->getRepository(Trackingapp::class);
    $trackapp = Trackingapp::find($id);
    $trackingName = $trackapp['name'];

    $user_track = Trackingmap::findOneBy([
        'company_id' => $company['id'],
        'objecttype' => 'user',
        'objectid' => $user_id,
        'trackingname' => $trackingName,
    ]);
    if (!$user_track) { //                
        $user_track = Trackingmap::GetDefault();
        $user_track['name'] = $user['name'];
        $user_track['importid'] = $tracking_id;
        $user_track['company_id'] = $company['id'];
        $user_track['objecttype'] = 'user';
        $user_track['objectid'] = $user['id'];
        $user_track['trackingapp_id'] = $trackapp['id'];
        $user_track['trackingname'] = $trackingName;
    }
    $startdate  = str_replace('T', ' ', $startdate);
    $stopdate   = str_replace('T', ' ', $stopdate);
    $user_track['startdate']    = $startdate;
    $user_track['finishdate']   = $stopdate;
    if ($user_track['finishdate'] < $user_track['startdate']) {
        $user_track['startdate'] = $stopdate;
    }
    $user_track['params'] = $key;
    $last_rec = Trackingmap::Commit($user_track);
    dlLog::WriteDump($last_rec);
    dlLog::WriteDump($user_track);
    dlLog::WriteDump(Database::$sql);
    dlLog::WriteDump(Database::get_error());

    if(!$last_rec) {
        $mssg   = Messager::renderError('Error updating Tracking data');

    } else {
        $mssg   = Messager::renderSuccess('Tracking data updated '. $last_rec);
    }

} catch (Exception $e) {

    $mssg = Messager::renderError("Error: " . $e->getMessage());
}

echo $mssg;
exit;
