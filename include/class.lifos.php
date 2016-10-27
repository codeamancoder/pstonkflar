<?php

class lifos {
    static function clean_string_for_link($str) {
        return strtolower(strtr(trim($str), array(' ' => '-', '\'' => '-', '�' => '', ':' => '', '’' => '', '^' => '', 'Č' => 'c', 'č' => 'c', 'Ğ' => 'g', 'Ğ' => 'g', 'ğ' => 'g', 'Ş' => 's', 'ş' => 's', 'Ö' => 'o', 'ö' => 'o', 'Ü' => 'u', 'ü' => 'u', '"' => '', 'ğ' => 'g', 'Ş' => 's', 'ş' => 's', 'İ' => 'i', 'ı' => 'i', 'Ç' => 'c', 'ç' => 'c', 'Ü' => 'u', 'ü' => 'u', 'Ö' => 'o', 'ö' => 'o', 'ı' => 'i', 'İ' => 'i', 'é' => 'i', 'â' => 'a', 'Ê' => 'e', 'Â' => 'a', '?' => '', '*' => '', ',' => '', ';' => '', ')' => '', '(' => '', '{' => '', '}' => '', '[' => '', ']' => '', '!' => '', '+' => '', '"' => '', '%' => '', '&' => '', '#' => '', '$' => '', '=' => '', 'ê' => 'e', '"' => '', '…' => '', '“' => '', '”' => '')));
    }

    static function db_data_time() {
        return date('Y-m-d H:i:s', time());
    }

    static function db_data() {
        return date('Y-m-d', time());
    }

    static function to_web_date($date) {
        $a = strtotime($date);
        return date('d.m.Y', $a);
    }

    static function convert_case_title($t) {
        return strtr(mb_convert_case(strtr($t, array('I' => 'ı')), MB_CASE_TITLE, "utf-8"), array('Ve ' => 've '));
    }

    static function substr($str, $len, $suffix = '') {
        return strlen($str) > $len ? mb_substr($str, 0, $len, 'utf8') . $suffix : $str;
    }

    static function captcha($degistir = "") {
        return "<img src=\"/include/lib/captcha/captcha.php\" id=\"captcha\" /> <a href=\"javascript:;\" onclick=\" document.getElementById('captcha').src='/include/lib/captcha/captcha.php?'+Math.random(); document.getElementById('captcha-form').focus();\" id=\"change-image\">" . $degistir . "</a>";
    }

    static function captcha_code() {
        return $_SESSION['captcha'];
    }

    static function captcha_clean() {
        $_SESSION['captcha'] = null;
    }

    static function star_rating($rating = 60, $rate = true) {
        $out .= '<div class="rating' . ($rate ? ' live' : '') . '" style="background:url(/static/' . THEME . '/img/rate_0.png);width:95px;height:19px;cursor:pointer;"><div class="lifos-percent" style="width:' . $rating . '%;background:url(/static/' . THEME . '/img/rate_1.png);float:left;height:20px;"></div></div>';

        $out .= $rate ?
            '<input type="hidden" name="rating" value="' . $rating . '">' . factory::get('js')->ready()->add("
            var rating=" . ($rating ? $rating : 0) . ";
	        var pos = $('.rating.live').offset();
			var rate = 0;
			var x;
					
            $('.rating.live').mousemove(function(e){
				rate = (e.pageX-$(this).offset().left) / 95 * 100;
	            x = (Math.floor(rate/20)+1)*20;
	            $('.lifos-percent',$(this)).css('width',x+'%');
            }).mouseleave(function(e){
				rate = (e.pageX-$(this).offset().left) / 95 * 100;
	            x = (Math.floor(rate/20)+1)*20;
	            $('.lifos-percent',$(this)).css('width',rating+'%');
            }).click(function(e){
				rate = (e.pageX-$(this).offset().left) / 95 * 100;
	            x = (Math.floor(rate/20)+1)*20;
	            rating = x;
	            $('input[name=rating]').val(x);
            });
	    ")->getAll() : '';

        return $out;
    }

    static function ip() {
        return $_SERVER['REMOTE_ADDR'];
    }
}