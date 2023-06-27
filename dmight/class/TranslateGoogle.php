<?php

class TranslateGoogle
{
    private $api_key;
    private $debug;
    public function __construct($token = null, $debug = false)
    {
        if ($token) {
            $this->api_key = $token;
        } else {
            $this->api_key = 'AIzaSyC6gHIqZvcciRZy3PiWC2OutrxAcv-lhVc';
        }
        // $this->api_key = 'AIzaSyC6gHIqZvcciRZy3PiWC2OutrxAcv-lhVc'; 
        $this->debug = $debug;
    }

    public function Translate(string $text, string $source = 'en', string $target = 'nl')
    {
        $curl = curl_init();
        $entext = urlencode($text);
        curl_setopt_array($curl, array(
            CURLOPT_URL =>
            "https://www.googleapis.com/language/translate/v2?key={$this->api_key}&source={$source}&target={$target}&callback=translateText&q={$entext}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic Y2tfMzY3YTA0ODllMmRkNDBkZDUyZGVkYTQyOTU0YmE0NGRhYzAzZGEwMDpjc18yMTdiYjAwOTM3MDNlYjI5ODE1NDI4MGFiOThiNjc0ZDlhNWMzNTMy"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // dump($response);
        if ($response) {
            // $response = json_decode($response);
            $response = $this->getTranslation($response);
            return $response ? $response : $text;
        }
        return $text;
    }
    function getTranslation($json_response) {
        if($this->debug) {
            // dd($json_response);
            return $this->api_key . " " . $json_response;
        }
        $point = strpos($json_response, '"translatedText":');
        if($point >= 0) {
            $point += 19;
            $ret = explode('"', substr($json_response,$point));
            if(count($ret) > 0) {
                $trans = $ret[0];
                if(substr($trans,0,8) == 'nslateTe') return false;
                return $trans;
            }
        }
        return '';
    }
}
