<?

/**
 * Class DU
 * @author Serkan K.
 */
class DU {
    public static function showAndDie($obj) {
        $args = func_get_args();
        $str = "<div style='background-color: #d0d0d0; color:#333; font-family: tahoma; padding: 3px;'>\n";
        $str .= "<h4>Application has died at " . self::whereAmI(0) . "</h4>";
        $str .= "<div style='background-color: #fff; margin-left: 20px;'>";
        foreach ($args as $arg) {
            $str .= "'" . print_r($arg, true) . "'\n";
        }
        $str .= "</div>";

        if (ENVIRONMENT === 'testing') {
            die("<pre>{$str}</pre></div>");
        }
    }

    public static function show($obj) {
        $args = func_get_args();
        $str = "<div style='color: black; border:1px solid yellow'>\n";
        foreach ($args as $arg) {
            $str .= "'" . print_r($arg, true) . "'\n";
        }
        if (ENVIRONMENT === 'testing') {
            echo("<pre>{$str}</pre></div>");
        }
    }

    public static function getClientIp() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;

    }

    public static function showPlain() {
        $args = func_get_args();
        $str = NULL;
        foreach ($args as $arg) {
            $str .= "'" . print_r($arg, true) . "'\n";
        }
        echo $str;
    }

    public static function showAndDiePlain() {
        $args = func_get_args();
        $str = NULL;
        foreach ($args as $arg) {
            $str .= "'" . print_r($arg, true) . "'\n";
        }
        die($str);
    }

    public static function showInFirebug($obj) {
        echo("<script>var debug=" . json_encode(func_get_args()) . ";console.log(debug);</script>");
    }

    public static function showInFirebugAndDie($obj) {
        die("<script>var debug=" . json_encode(func_get_args()) . ";console.log(debug);</script>");
    }

    public static function log($obj) {
        $args = func_get_args();
        $message = "";
        foreach ($args as $arg) {
            $message .= "'" . print_r($arg, true) . "'\n";
        }
        $file = self::whereAmI(0);
        $file = str_replace(PATH_TO_ROOT, '', $file);
        $now = date("F j, Y, G:i:s");
        $message = "pid:" . getmypid() . " | {$now}: [{$file}] {$message}";

        $fp = fopen(PATH_TO_TMP . "debug.txt", "a");
        fwrite($fp, $message);
        fclose($fp);
    }

    public static function whereAmI($offset = 0) {
        $entries = debug_backtrace();
        if (!is_array($entries)) return "";
        $fileName = $entries[$offset]['file'];
        $lineNumber = $entries[$offset]['line'];
        $functionName = $entries[$offset]['function'];
        $className = $entries[$offset]['class'];

        return "{$fileName}:{$lineNumber} {$functionName} {$className} {}()";
    }

    public static function showStack() {
        DU::log(DU::whereAmI(0));
    }
}
