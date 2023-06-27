<?
class dlCaptcha{
    public static $html_site_key = '6Ld0ReAUAAAAALOSazLYaGcVvrvOCAyN9Cj7UP5R';
    public static $captcha_check_key = '6Ld0ReAUAAAAAAQHT3iySUZLxfC9urK_ob2zXUpi';
    public static function render(){
        echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        echo '<div class="g-recaptcha" data-sitekey="' . self::$html_site_key . '"></div>';
    }
    public static function check(){
        $g_recaptcha_response = REQUEST::getParam("g-recaptcha-response","");
        if(!$g_recaptcha_response){
            return false;
        }

        $json = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . self::$captcha_check_key . "&response=" . $g_recaptcha_response);
        //echo $json;
        $json = json_decode($json,true);
        if($json["success"] == "true"){
            return true;
        }
        else{
            return false;
        }

        //https://www.google.com/recaptcha/api/siteverify

        /*
        POST
        secret	Required. The shared key between your site and reCAPTCHA.
        response	Required. The user response token provided by the reCAPTCHA client-side integration on your site.
        remoteip	Optional. The user's IP address.
        */


        /*
        {
            "success": true|false,
            "challenge_ts": timestamp,  // timestamp of the challenge load (ISO format yyyy-MM-dd'T'HH:mm:ssZZ)
            "hostname": string,         // the hostname of the site where the reCAPTCHA was solved
            "error-codes": [...]        // optional
            }
        */ 

        
    }
}
?>