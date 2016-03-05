<?php

namespace PHPCrawler\Utils;

class Utils {

    function __construct() {
        
    }

    public static function get_file_extension($file_name) {
        return substr(strrchr($file_name, '.'), 1);
    }

    /**
     * Extract numbers from a string
     * @param type $str
     * @return type
     */
    public static function get_numerics($str) {
        // preg_match("/\d+/", $str, $matches);
        preg_match_all('!\d+!', $str, $matches);
        return end($matches[0]);
    }
    /**
     * Remove � character
     * http://stackoverflow.com/questions/1401317/remove-non-utf8-characters-from-string
     * 
     * @param type $string
     * @return type
     */
    public static function remove_special_character($string) {
        $string = trim($string);
        $regex = <<<'END'
/
  (
    (?: [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
    |   [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
    |   [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
    |   [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
    ){1,100}                        # ...one or more times
  )
| .                                 # anything else
/x
END;
        return preg_replace($regex, '$1', $string);
    }
    
    /**
     * 
     * @param type $dec
     * @return type
     */
    public static function unichr($dec) {
        if ($dec < 128) {
            $utf = chr($dec);
        } else if ($dec < 2048) {
            $utf = chr(192 + (($dec - ($dec % 64)) / 64));
            $utf .= chr(128 + ($dec % 64));
        } else {
            $utf = chr(224 + (($dec - ($dec % 4096)) / 4096));
            $utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64));
            $utf .= chr(128 + ($dec % 64));
        }
        return $utf;
    }

    public static function create_alias($text) {
        $marTViet = array(
            '&', ',', '[', ']', '(', ')', '"', '/', '.', ' ', "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
            , "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", "́", "̀", "̉", '̣', '̃'
        );

        $marKoDau = array(
            '-', '-', '-', '-', '-', '-', '', '', '', '-', "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", '', '', '', '', ''
        );
        $alias = str_replace($marTViet, $marKoDau, trim($text));
        return strtolower($alias);
    }

    public static function alias($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|A|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "a", $str);
        $str = preg_replace("/(B)/", "b", $str);
        $str = preg_replace("/(C)/", "c", $str);
        $str = preg_replace("/(đ|D|Đ)/", "d", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|E|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "e", $str);
        $str = preg_replace("/(F)/", "f", $str);
        $str = preg_replace("/(G)/", "g", $str);
        $str = preg_replace("/(H)/", "h", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ)/", "i", $str);
        $str = preg_replace("/(J)/", "j", $str);
        $str = preg_replace("/(K)/", "k", $str);
        $str = preg_replace("/(L)/", "l", $str);
        $str = preg_replace("/(M)/", "m", $str);
        $str = preg_replace("/(N)/", "n", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|O|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "o", $str);
        $str = preg_replace("/(P)/", "p", $str);
        $str = preg_replace("/(Q)/", "q", $str);
        $str = preg_replace("/(R)/", "r", $str);
        $str = preg_replace("/(S)/", "s", $str);
        $str = preg_replace("/(T)/", "t", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "u", $str);
        $str = preg_replace("/(V)/", "v", $str);
        $str = preg_replace("/(W)/", "w", $str);
        $str = preg_replace("/(X)/", "x", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "y", $str);
        $str = preg_replace("/(Z)/", "z", $str);
        $str = preg_replace("/(!|@|%|\^|\*|\(|\)|\+|\=|<|>|\?|\/|,|\.|\:|\;|\'|\"|\“|\”|\&|\#|\[|\]|~|$|_)/", "", $str);
        $str = str_replace("&*#39;", "", $str);
        $str = str_replace(" ", "-", $str);
        $str = str_replace('́', "", $str);
        $str = str_replace('̀', "", $str);
        $str = str_replace('̉', "", $str);
        $str = str_replace('̣', "", $str);
        $str = str_replace('̃', "", $str);

        return $str;
    }

    public static function generate_password($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    public static function UUID($length = 8) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    /**
     * @desc turns line breaks in forms into HTML <br> <br/> or <p></p> tags
     * @param type $string
     * @param type $line_breaks
     * @param type $xml
     * @return type
     */
    public static function nl2p($string, $line_breaks = true, $xml = true) {
        // remove existing HTML formatting to avoid double tags
        $string = str_replace(array('<p>', '</p>', '<br>', '<br/>'), '', $string);

        // convert single line breaks into <br> or <br/> tags
        if ($line_breaks == true) {
            return '<p>' . preg_replace(array("/\r/", "/\n{2,}/", "/\n/"), array('', '</p><p>', '<br' . ($xml == true ? '/' : '') . '>'), $string) . '</p>';
        } else {
            return '<p>' . preg_replace("/\n/", "</p>\n<p>", trim($string)) . '</p>';
        }
    }

    public static function wordLimit($str, $limit = 100, $strip_tags = true, $end_char = ' &#8230;') {
        if (trim($str) == '') {
            return $str;
        }

        if ($strip_tags) {
            $str = strip_tags($str);
        }
        $words = explode(' ', $str);
        $string = '';
        if (count($words) > $limit) {
            for ($i = 0; $i < $limit; $i++) {
                //check if $word length if larger then 4
                $string .= $words[$i] . ' ';
            }
        } else {
            $string = $str;
        }
        return rtrim($string) . $end_char;
    }


    /*
     * Convert to safe characters
     * 
     * @desc : remove the accent not '-'
     */

    public static function vt_safe_vietnamese_meta($str, $lower = true, $vietnamese = true, $special = false, $accent = false) {
        $str = $lower ? strtolower($str) : $str;
        // Remove Vietnamese accent or not
        $str = $accent ? self::vt_remove_vietnamese_accent($str) : $str;

        // Replace special symbols with spaces or not
        $str = $special ? self::vt_remove_special_characters($str) : $str;

        // Replace Vietnamese characters or not
        $str = $vietnamese ? self::vt_replace_vietnamese_characters($str) : $str;

        return $str;
    }

    /*
     * Convert to safe characters
     */

    public static function vt_safe_vietnamese($str, $lower = true, $vietnamese = true, $special = true, $accent = true) {
        $str = $lower ? strtolower($str) : $str;
        // Remove Vietnamese accent or not
        $str = $accent ? self::vt_remove_vietnamese_accent($str) : $str;

        // Replace special symbols with spaces or not
        $str = $special ? self::vt_remove_special_characters($str) : $str;

        // Replace Vietnamese characters or not
        $str = $vietnamese ? self::vt_replace_vietnamese_characters($str) : $str;

        $str = str_replace('/', ' ', $str);
        $str = str_replace('.', ' ', $str);
        $str = str_replace(',', ' ', $str);
        $str = str_replace(' ', '-', $str);

        return $str;
    }

    /*
     * Remove 5 Vietnamese accent / tone marks if has Combining Unicode characters
     * Tone marks: Grave (`), Acute(�), Tilde (~), Hook Above (?), Dot Bellow(.)
     */

    public static function vt_remove_vietnamese_accent($str) {

        $str = preg_replace("/[\x{0300}\x{0301}\x{0303}\x{0309}\x{0323}]/u", "", $str);

        return $str;
    }

    /*
     * Remove or Replace special symbols with spaces
     */

    public static function vt_remove_special_characters($str, $remove = true) {

        // Remove or replace with spaces
        $substitute = $remove ? "" : " ";

        $str = preg_replace("/[\x{0021}-\x{002D}\x{002F}\x{003A}-\x{0040}\x{005B}-\x{0060}\x{007B}-\x{007E}\x{00A1}-\x{00BF}]/u", $substitute, $str);

        return $str;
    }

    /*
     * Replace Vietnamese vowels with diacritic and Letter D with Stroke with corresponding English characters
     */

    public static function vt_replace_vietnamese_characters($str) {

        $str = preg_replace("/[\x{00C0}-\x{00C3}\x{00E0}-\x{00E3}\x{0102}\x{0103}\x{1EA0}-\x{1EB7}]/u", "a", $str);
        $str = preg_replace("/[\x{00C8}-\x{00CA}\x{00E8}-\x{00EA}\x{1EB8}-\x{1EC7}]/u", "e", $str);
        $str = preg_replace("/[\x{00CC}\x{00CD}\x{00EC}\x{00ED}\x{0128}\x{0129}\x{1EC8}-\x{1ECB}]/u", "i", $str);
        $str = preg_replace("/[\x{00D2}-\x{00D5}\x{00F2}-\x{00F5}\x{01A0}\x{01A1}\x{1ECC}-\x{1EE3}]/u", "o", $str);
        $str = preg_replace("/[\x{00D9}-\x{00DA}\x{00F9}-\x{00FA}\x{0168}\x{0169}\x{01AF}\x{01B0}\x{1EE4}-\x{1EF1}]/u", "u", $str);
        $str = preg_replace("/[\x{00DD}\x{00FD}\x{1EF2}-\x{1EF9}]/u", "y", $str);
        $str = preg_replace("/[\x{0110}\x{0111}]/u", "d", $str);

        return $str;
    }
    /**
     * Returns all cookies from the give response-header.
     *
     * @param string $header      The response-header
     * @return array Numeric array containing all cookies as array.
     */
    public static function getCookiesFromHeader($header) {
        $cookies = array();

        $hits = preg_match_all("#[\r\n]set-cookie:(.*)[\r\n]# Ui", $header, $matches);

        if ($hits && $hits != 0) {
            for ($x = 0; $x < count($matches[1]); $x++) {
                $cookies[] = $matches[1][$x];
            }
        }

        return $cookies;
    }

    /**
     * Returns the redirect-URL from the given HTML-header
     *
     * @return string The redirect-URL or NULL if not found.
     */
    public static function getRedirectURLFromHeader(&$header) {
        // Get redirect-link from header
        preg_match("/((?i)location:|content-location:)(.{0,})[\n]/", $header, $match);

        if (isset($match[2])) {
            $redirect = trim($match[2]);
            return $redirect;
        } else
            return null;
    }    
}
