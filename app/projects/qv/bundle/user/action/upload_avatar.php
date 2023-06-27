<?php
try {
    $boss       = User::getUser();
    $company    = User::getCompany($boss);

    $user_id    = REQUEST::getParam('id');
    $user       = User::find($user_id);

    $file_input_name = 'avatarimage'; // input name
    $uploader = new FileUpload($file_input_name,[
        'target_dir' =>'images/',
    ]);
    [$Ok, $file, $mssg] = $uploader->Action();

    if($Ok) {
        $file = '/'.$file; // Why I need it ???
        $user['avatarfile'] = $file;
        $Ok = User::Commit($user, ['avatarfile']);
    }
    if($Ok) {
        $return = "success";
        $mssg   = Messager::renderSuccess($mssg . ' '. $file);
    } else {
        throw new Exception(ll('Error uploading file').' '. $mssg);
    }

} catch (Exception $e) {
    $return = 'error';
    $mssg   = Messager::renderError(ll("System Error").': '. $e->getMessage());
}

$content = [
    "return" => $return,
    'mssg' => $mssg,
    'client_id' => $user_id,
];
// dd($content);
Json_Response($content);
