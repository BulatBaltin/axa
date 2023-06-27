<?php
class AzureAuth {
    private $appId;
    private $tenantId;
    private $secretVal;
    private $redirectUri;
    private $userdata;
    private $error_email;

    function __construct( $opts )
    {
        $options = [
            'appId' => '163a34ab-e299-4793-8092-1a0b5c76d7f1',
            'tenantId' => '51976ccc-ae7a-4fcc-b1ec-3647772c1648',
            'secretVal' => 'b3RpLQAkfFiwcSc9~_2c1hKw6x.f9D_jqr',
            'redirectUri' => "https://www.profitesting.kz/backend/ms-login"
        ];

        $options += $opts;
        $this->appId = $options['appId'];
        $this->tenantId = $options['tenantId'];
        $this->secretVal = $options['secretVal'];
        $this->redirectUri = $options['redirectUri'];
        $this->error_email = null;
    }

    function redirectToMicrosoft() {
        //the user session, let's start it and utilize its ID later
        session_start();

        //First stage of the authentication process; This is just a simple redirect (first load of this page)
        $url = "https://login.microsoftonline.com/" . $this->tenantId . "/oauth2/v2.0/authorize?";
        $url .= "state=" . session_id();  //This at least semi-random string is likely good enough as state identifier
        $url .= "&scope=User.Read";  //This scope seems to be enough, but you can try "&scope=profile+openid+email+offline_access+User.Read" if you like
        $url .= "&response_type=code";
        $url .= "&approval_prompt=auto";
        $url .= "&client_id=" . $this->appId; // Application (client) ID
        $url .= "&redirect_uri=" . urlencode($this->redirectUri);
        header("Location: " . $url);  //So off you go my dear browser and welcome back for round two after some redirects at Azure end
    }

    function fetchUserDataCredentials() {
        //the user session, let's start it and utilize its ID later
        session_start();

        //Checking that the session_id matches to the state for security reasons
        if (strcmp(session_id(), $_GET["state"]) == 0) {
            //Verifying the received tokens with Azure and finalizing the authentication part
            $content = "grant_type=authorization_code";
            $content .= "&client_id=" . $this->appId;
            $content .= "&redirect_uri=" . urlencode($this->redirectUri);
            $content .= "&code=" . $_GET["code"];
            $content .= "&client_secret=" . urlencode($this->secretVal);

            $options = [
                "http" => [  //Use "http" even if you send the request with https
                    "method"  => "POST",
                    "header"  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "Content-Length: " . strlen($content) . "\r\n",
                    "content" => $content
                ]
            ];

            $context = stream_context_create($options);
            
            $json = file_get_contents("https://login.microsoftonline.com/" . $this->tenantId . "/oauth2/v2.0/token", false, $context);

            $authdata = $this->decodeJsonAccessToken($json, $options);

            $this->userdata = $this->fetchBasicInfo($authdata);

        }
    }
    // $azure->selectUserData(['displayName', 'mail']);
    function selectUserData($keys) {
        $result = [];
        foreach($keys as $key) {
            if (isset($this->userdata[$key])) {
                $result[$key] = $this->userdata[$key];
            }
        }
        return $result;
    }
    
    private function fetchBasicInfo($authdata) {

        //Fetching the basic user information that is likely needed by your application
        $options = array(
            "http" => array(  //Use "http" even if you send the request with https
            "method" => "GET",
            "header" => "Accept: application/json\r\n" .
                "Authorization: Bearer " . $authdata["access_token"] . "\r\n"
            )
        );
        $context = stream_context_create($options);

        $json = file_get_contents("https://graph.microsoft.com/v1.0/me", false, $context);

        if ($json === false) errorhandler(
            array("Description" => "Error received during user data fetch.", "PHP_Error" => error_get_last(), "\$_GET[]" => $_GET, "HTTP_msg" => $options), $this->error_email);

        //This should now contain your logged on user information
        $userdata = json_decode($json, true);

        if (isset($userdata["error"])) errorhandler(
            array("Description" => "User data fetch contained an error.", "\$userdata[]" => $userdata, "\$authdata[]" => $authdata, "\$_GET[]" => $_GET, "HTTP_msg" => $options), $this->error_email);        
        
        return $userdata;
        // array(12) {
        //     ["@odata.context"]=>
        //     string(56) "https://graph.microsoft.com/v1.0/$metadata#users/$entity"
        //     ["businessPhones"]=>
        //     array(0) {
        //     }
        //     ["displayName"]=>
        //     string(12) "Bulat Baltin"
        //     ["givenName"]=>
        //     string(5) "Bulat"
        //     ["jobTitle"]=>
        //     NULL
        //     ["mail"]=>
        //     string(22) "bulat.baltin@gmail.com"
        //     ["mobilePhone"]=>
        //     NULL
        //     ["officeLocation"]=>
        //     NULL
        //     ["preferredLanguage"]=>
        //     string(2) "en"
        //     ["surname"]=>
        //     string(6) "Baltin"
        //     ["userPrincipalName"]=>
        //     string(60) "bulat.baltin_gmail.com#EXT#@bulatbaltingmail.onmicrosoft.com"
        //     ["id"]=>
        //     string(36) "eba9d848-4bf6-42f4-9426-6d153cb10624"
        //   }

    }
    private function decodeJsonAccessToken($json, $options) {
        if ($json === false) $this->errorhandler(
            array("Description" => "Error received during Bearer token fetch.", "PHP_Error" => error_get_last(), "\$_GET[]" => $_GET, "HTTP_msg" => $options), $this->error_email);

        $authdata = json_decode($json, true);
        if (isset($authdata["error"])) $this->errorhandler(
            array("Description" => "Bearer token fetch contained an error.", "\$authdata[]" => $authdata, "\$_GET[]" => $_GET, "HTTP_msg" => $options), $this->error_email);
      
        return $authdata;

        // array(5) {
        //     ["token_type"]=>
        //     string(6) "Bearer"
        //     ["scope"]=>
        //     string(30) "User.Read profile openid email"
        //     ["expires_in"]=>
        //     int(3599)
        //     ["ext_expires_in"]=>
        //     int(3599)
        //     ["access_token"]=>
        //     string(2440) "eyJ0eXAiOiJK...RMkc83Kw"
        //   }

    }

    private function errorhandler($input, $email = null)
    {
      $output = "PHP Session ID:    " . session_id() . PHP_EOL;
      $output .= "Client IP Address: " . getenv("REMOTE_ADDR") . PHP_EOL;
      $output .= "Client Browser:    " . $_SERVER["HTTP_USER_AGENT"] . PHP_EOL;
      $output .= PHP_EOL;
      //Start capturing the output buffer
      ob_start();  
      //This is not for debug print, this is to collect the data for the email
      var_dump($input);  
      //Storing the output buffer content to $output
      $output .= ob_get_contents();  
      ob_end_clean();  
      echo $output;
      //While testing, you probably want to comment the next row out
      if($email) {
          mb_send_mail($email, "Your Azure AD Oauth2 script faced an error!", $output, "X-Priority: 1\nContent-Transfer-Encoding: 8bit\nX-Mailer: PHP/" . phpversion());
      }
      exit;
    }
    
}