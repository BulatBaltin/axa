<?php

class LingoStar
{
    static $Translation;
    static $lang;

    public function __construct()
    {
        $this->load();
    }
    function getLang()
    {
        return self::$lang;
    }
    function load()
    {
        $user = User::GetUser();
        $lang = null;
        if ($user) {
            $lingo_id = $user['lingo_id']; //->getLingoCode();
            $lingo = Language::find($lingo_id);
        }
        if (!$lingo) {
            $lang = 'en';
        } else {
            $lang = $lingo['code'];
        }
        if ($lang !== self::$lang) {
            if ($lang !== 'en') {

                $filename = ROUTER::ProjectPath(). "lingos/en_" . $lang . "/trans.txt";
                if (file_exists($filename)) {
                    $trans = file($filename);
                    self::$Translation = $this->convert($trans);
                } else {
                    self::$Translation = [];
                }
            } else {
                self::$Translation = [];
            }
            self::$lang = $lang;
        }
    }
    function convert($trans)
    {
        $key_val = [];
        foreach ($trans as $entry) {
            $entry = trim($entry);
            if (strpos($entry, "//") === false) {
                $aa = explode("=>",  $entry);
                if (count($aa) > 1) {
                    $key_val[trim($aa[0])] = trim($aa[1]);
                }
            }
        }
        // dd($key_val);
        return $key_val;
    }
    // ... on fire
    public function trans($key): ?string
    {
        // it is not static as we need Translation to be filled
        if (array_key_exists($key, self::$Translation)) {
            $phrase = self::$Translation[$key];
            return empty($phrase) ? $key : $phrase;
        } else {
            return $key;
        }
    }
    // rarely used, just to check it up
    public function getTranslation()
    {
        // return $this->Translation;
        return self::$Translation;
    }
    public function getKeysTranslation(string $lang = 'nl')
    {
        return $this->getPartsTranslation($lang, true);
    }
    public function getPhrasesTranslation(string $lang = 'nl')
    {
        return $this->getPartsTranslation($lang, false);
    }
    function getPartsTranslation(string $lang = 'nl', bool $keys = true)
    {
        if ($lang === 'en') {
            $lang = 'nl';
        }

        $result = '';
        $filename = ROUTER::ProjectPath(). "lingos/en_" . $lang . "/trans.txt";
        if (file_exists($filename)) {

            $trans = file($filename);
            foreach ($trans as $entry) {
                $entry = trim($entry);
                if (strpos($entry, "//") === false) {
                    $aa = explode("=>",  $entry);
                    if (count($aa) > 1) {
                        if ($keys) {
                            $result .= trim($aa[0]) . PHP_EOL;
                        } else {
                            $result .= trim($aa[1]) . PHP_EOL;
                        }
                    }
                }
            }
        }
        return $result;
    }

    static function createLingoFile(string $lang, string $content, bool $upper = true)
    {
        $filename = ROUTER::ProjectPath(). "lingos/en_nl/trans.txt";
        // $phrases = preg_split("/\r\n|\n|\r/", $content);
        $phrases = explode(PHP_EOL, $content);
        $all_records = file($filename);
        $result = "";
        $index = 0;
        foreach ($all_records as $record) {
            if (strpos($record, '=>') !== false) {
                $aa = explode("=>", $record);
                if (count($phrases) > $index) {
                    $fraza = $upper ? ucfirst($phrases[$index]) : $phrases[$index];
                    $result .= $aa[0] . " => " . $fraza . PHP_EOL;
                    ++$index;
                } else {
                    $result .= $aa[0] . " => " . PHP_EOL;
                }
            } else {
                $result .= $record;
            }
        }

        // Put down result into file
        $folder = ROUTER::ProjectPath(). "lingos/en_" . trim($lang);
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $filename = $folder . "/trans.txt";
        // dump($filename);
        // dd($result);
        file_put_contents($filename, $result);
    }
}
