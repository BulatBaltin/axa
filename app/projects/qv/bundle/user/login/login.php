<?php
// use form\customer\ClientType;

try {

    $username  = REQUEST::getParam('username');
    $password  = REQUEST::getParam('password');

    // dd($username, $password);

    $user = User::findOneBy([ // arrays are linked with 'OR'
        ['username' => $username],
        ['email'    => $username]
    ]);

    $mssg = '';
    $check = ValidateData($mssg, $user, $username, $password);

    $session = new DataLinkSession();
    if(!$check) {
        // dd($mssg);
        $mssg = Messager::renderError($mssg);
        $session->login_error = $mssg;
        // UrlHelper::RedirectRoute('qv.user.login', ['error'=> $mssg]);
        UrlHelper::RedirectRoute('qv.user.login');
        exit();
    }

    $session->boss_user = $user;

    UrlHelper::RedirectRoute('qv.dashboard');

    // dump(DataBase::$sql);
    // dd($username, $password, $user);
} catch (Exception $e) {
    dd( DataBase::$sql );
} 

function ValidateData(&$mssg, $user, $username, $password) {
    if(empty($user)) {
        $mssg = 'Error: User not found';
        return false;
    }
    $checkPass = password_verify($password, $user['password']);
    if(!$checkPass) {
        $mssg = 'Error: Wrong password';
        return false;
    }
    return true;
}
//     $boss       = User::getUser();
//     $company    = User::getCompany($boss);

//     $user_id  = REQUEST::getParam('id');
//     $form_part  = REQUEST::getParam('part');
//     $form_data  = REQUEST::getForm(); // _POST
    
//     $return = "success";
//     $mssg   = Messager::renderSuccess();
    
//     if (!$user_id) { // New customer - client, when multiple updates
//         $user_id  = $form_data['id'];
//     }
//     if(!$user_id) { // New customer - client
//         $user = User::getDefault();
//     } else {
//         $user = User::find($user_id);
//     }
//     $user['company_id'] = $company['id'];
// // -----------------------------
// // match ($value) {
// //     0 => '0',
// //     1, 2 => "1 or 2",
// //     default => "3",
// // };
//     $fld_list = false;
//     $form = new UserType();
//     switch ($form_part) {
//         case '1':
//             User::setRoles($user, ['ROLE_DEVELOPER']);
//             $fld_list = ['username','name','sirname', 'telephone','lingo_id', 'country_id'];
//             break;
//         case '2':
//             $fld_list = ['email', 'chatemail'];
//             break;
//         case '3':
//             $fld_list = ['password1', 'password2' ]; // it doen't set in $user
//             break;
//         case '4':
//             $fld_list = ['sendmail', 'dailygoal'];
//             // $user['visibility'] = chop($form_data['list'], ','); 
//             break;
//         default:
//             # code...
//             break;
//     }
//     if($fld_list) {
//         // dump($form_data, $fld_list, $user);
//         $form->FillByName($user, $form_data, $fld_list);
//     }
//     // dd($form_data, $fld_list, $user);
//     if ($user['hash'] == "") {
//         $guid = uniqid();
//         $user['hash'] = $guid; 
//     }
//     $errors = ValidateData($user, $form_data, $fld_list);
//     if($errors) {
//         $return = 'error';
//         $mssg   = Messager::renderError( '<b>Errors:</b><br>' . $errors );
//     } elseif ($return == 'success') {

//         if($form_part == 3){ // password
//             $encoded = User::encodePassword($form_data['password1']);
//             $user['password'] = $encoded;
//         }
//         // insert (update) into db
//         $user_id = User::Commit($user);        
//     }
// } catch (Exception $e) {
//     $return = 'error';
//     $mssg   = Messager::renderError("System Error: " . $e->getMessage());
// }

// $content = [
//     "return" => $return,
//     'mssg' => $mssg,
//     'user_id' => $user_id,
// ];
// // dd($content);
// Json_Response($content);

// function ValidateData($user, $form_data, $fld_list) {
//     $errors = '';
//     foreach($fld_list as $field_name) {
//         $mssg   = '';
//         if(!ValidateField($mssg, $field_name, $user, $form_data)) {
//             $errors .= '<br>'.$mssg;
//         }
//     }
//     return $errors;
// }
// function ValidateField(&$mssg, $field_name, $user, $form_data) {
//     $prefix = '&diams; ';
//     switch ($field_name) {
//         case 'name':
//             if (empty($form_data['name'])) {
//                 $mssg = $prefix . ll("Business name should not be empty");
//                 return false;
//             }
//             break;
//         case 'password':
//             if (!empty($form_data['password']) and ($form_data['password'] !== $form_data['password0'] or $form_data['password'] < 4)) {
//                 $mssg = $prefix . ll("Incorrect password. Both should be equal and have more than 3 characters");
//                 return false;
//             }
//             break;
//         case 'password1':
//             if (!empty($form_data['password1']) and ($form_data['password1'] !== $form_data['password2'] or $form_data['password1'] < 4)) {
//                 $mssg = $prefix . 
//                 $form_data['password1'] .' = '.$form_data['password2'].'<br>'. 
//                 ll("Incorrect password data: 'New password' and 'Confirm password' do not coincide or less than 4 characters");
//                 return false;
//             }
//             break;
//         case 'email':
//         case 'chatemail':
//             if (empty($form_data['email'])) {
//                 $mssg = $prefix . ll("Email should not be empty");
//                 return false;
//             }
//             if(!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
//                 $mssg = $prefix . ll("Invalid email format");
//                 return false;
//             }
//             break;
        
//         default:
//             break;
//     }
//     return true;
// }

// $user_form = $request->get('user');
// $user_id = $user_form['id'];
// $worker = $repoUser->find($user_id);

// $worker->setRole('ROLE_DEVELOPER');
// $worker->setUsername($user_form['username']);
// $worker->setName($user_form['name']);
// $worker->setSirname($user_form['sirname']);
// $worker->setTelephone($user_form['telephone']);

// $lingo = $em->getRepository(Language::class)->find($user_form['lingo']);
// $worker->setLingo($lingo);

// $country = $em->getRepository(Country::class)->find($user_form['country']);
// $worker->setCountry($country);

// $em->persist($worker);
// $em->flush();

