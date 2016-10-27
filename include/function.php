<?php

function get_asset($path = NULL, $type = 'img', $commonPath = FALSE) {
    if ($path) {
        if (!$commonPath) {
            if (defined('THEME')) {
                return '/static/' . THEME . '/' . $type . '/' . $path . '?v=' . APP_VER;
            }
            return '/static/' . $type . '/' . $path . '?v=' . APP_VER;

        }
        return '/static/lib/' . $path . '?v=' . APP_VER;
    }
}

function get_etiket($blog, $limit = 5) {
    global $db;
    return $db->sorgu("select * from etiket where blog_id=%d limit {$limit}", $blog->id)->listeObj();
}

function getRequest($p, $b = false, $s = false) {
    $a = $_REQUEST[$p];
    $a = explode('/', $a);

    if ($s) {
        return implode('/', array_slice($a, $b, $s));
    } elseif ($b !== false) {
        return $a[$b];
    } else return $_REQUEST[$p];
}

function getRequests($p) {
    $a = $_REQUEST[$p];
    return @explode('/', $a);
}

function share() {
    return '
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4ee9eaed0852d3b9" async="async"></script>
<div class="addthis_sharing_toolbox"></div>';
}

/*
 *  girilen textdeki zararlı olabilecek tag ve karakterleri temizle
*/
function fi($in, $del_tags = true) {
    $out = $in;
    $out = strip_tags($in, '<a><blockquote><br><div><em><embed><font><h1><h2><h3><h4><h5><h6><h7><hr><img><li><object><ol><p><param><span><strike><strong><sub><sup><table><tbody><td><th><tr><u><ul>');
    $out = mysql_real_escape_string($out);
    return $out;
}

function todbdate($date) {
    $a = explode(".", $date);
    return $a[2] . '-' . $a[1] . '-' . $a[0];
}

/*
 *  array to query_string
*/
function a2q($a) {
    foreach ($a as $k => $v)
        $s .= $k . '=' . $v . '&';
    return '?' . $s;
}

function sayac($sayi) {
    $sayi = "$sayi";

    for ($i = 0; $i < strlen($sayi); $i++) $o .= '<img src="/static/' . THEME . '/img/sayi/' . $sayi[$i] . '.gif">';

    return $o;
}

function dbDateTime() {
    return date('Y-m-d H:i:s', time());
}

function dbDate() {
    return date('Y-m-d', time());
}

function hata_olustur($err) {
    return '<div class="hata">' . (is_array($err) ? implode('<br>', $err) : $err) . '</div>';
}

function basarili($err) {
    return '<div class="basarili">' . (is_array($err) ? implode('<br>', $err) : $err) . '</div>';
}

function get_ay_str($ay) {
    $aylar = array('Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');
    return $aylar[$ay - 1];
}

function bv_substr($str, $len, $suffix = ' ...') {
    return strlen($str) > $len ? mb_substr($str, 0, $len, 'utf8') . $suffix : $str;
}

function aprintf($format, $array, $cover = false) {
    preg_match_all("/{(.*?)}/i", $format, $m);

    if ($m[1]) {
        foreach ($m[1] as &$v) {
            $c['{' . $v . '}'] = $array[$v];
        }

        return $cover ? sprintf($cover, strtr($format, $c)) : strtr($format, $c);
    } else return $format;

}

function towebdate($date) {
    $a = strtotime($date);
    return date('d.m.Y', $a);
}

function _imp(&$item, $key, $f) {
    foreach ($f[1][1] as $k => $v) {
        $a['{' . $v . '}'] = $item[$v];
    }
    if ($a) $item = strtr($f[0], $a);
}

function imprintf($array, $format, $glue = '', $cover = '') {
    if (!$array) return;

    preg_match_all("/{(.*?)}/i", $format, $m);

    array_walk($array, '_imp', array($format, $m));

    $o = implode($glue, @array_reverse($array));
    if ($cover) $o = strtr($cover, array('%s' => $o));

    return $o;
}

/*
 *  8859-9 dan 8859-1 e geçiş
*/
function tr2en($str) {
    return strtr($str, array('ç' => 'c', 'Ç' => 'C', 'ğ' => 'g', 'Ğ' => 'G', 'ı' => 'i', 'İ' => 'I', 'ö' => 'o', 'Ö' => 'O', 'ş' => 's', 'Ş' => 'S', 'ü' => 'u', 'Ü' => 'U'));
}