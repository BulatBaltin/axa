<?php

// class SecurityController extends AbstractController
// {
//     /**
//      * @Route("/login", name="app_login")
//      */
//     public function login(AuthenticationUtils $authenticationUtils): Response
//     {
//         // if ($this->getUser()) {
//         //    $this->redirectToRoute('target_path');
//         // }
//         // dump('Step-7');
//         // get the login error if there is one
//         $error = $authenticationUtils->getLastAuthenticationError();
//         if ($error) {
//             $error = Messager::renderError("Incorrect username / email or password");
//         }

//         // last username entered by the user
//         $lastUsername = $authenticationUtils->getLastUsername();

//         // return $this->render('security/zlogin.html.twig', [
//         return $this->render('base/zlogin.html.twig', [
//             'mssg' => $error,
//             'last_username' => $lastUsername,
//             'ProjectTitle' => 'INVOICE AUTOMATION',
//         ]);
//     }

//     /**
//      * @Route("/logout", name="app_logout")
//      */
//     public function logout()
//     {
//         throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
//     }
// }

APP::isLayout(false); // Direct page

$last_username = '';
$ProjectTitle = 'INVOICE AUTOMATION';
$session = new DataLinkSession();
$mssg = $session->get('login_error');
if($mssg) {
    $session->clear();
    // dd($mssg);
} 
// $mssg = REQUEST::getParam('error', '');

$form = new LoginType();
