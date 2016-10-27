<?php

class html {
    static function select($liste, $isim, $sel = false, $key = 'id', $val = 'title', $filter = 0, $on = '', $class = '', $valid = '') {
        foreach ($liste as $v) {
            $o .= '<option value="' . $v[$key] . '" ' . ($sel !== false && $sel == $v[$key] ? 'selected' : '') . '>' . $v[$val] . '</option>';
        }
        $ondeger = $on ? ' <option value="0" selected>' . $on . '</option>' : '';

        return '<select name="' . $isim . '" class="' . ($filter ? ' teksecim filtre' : '') . ' ' . $class . '" ' . ($valid ? ' valid="' . $valid . '"' : '') . '>' . $ondeger . $diger . $o . '</select>';
    }

    static function multiselect($liste, $isim, $sel = false, $key = 'id', $val = 'title', $filter = false, $ajax = false, $max = false, $valid = '') {

        foreach ($liste as $v) {
            $o .= '<option value="' . $v[$key] . '" ' . (is_array($sel) && in_array($v[$key], $sel) ? 'selected' : '') . '>' . $v[$val] . '</option>';
        }

        $ondeger = $ondeger ? ' <option value="0">' . $ondeger . '</option>' : '';

        return '<select class="coklusecim' . ($filter ? ' filtre' : '') . '" name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . ($extra ? ' ' . $extra : '') . ' multiple="multiple"  ' . ($max ? 'max="' . $max . '"' : '') . ' ' . ($ajax ? 'ajax="' . $ajax . '"' : '') . ' ' . ($valid ? ' valid="' . $valid . '"' : '') . '>' . $ondeger . $o . '</select>';
    }

    static function selecta($liste, $isim, $sel = false, $ondeger = false, $class = false) {
        foreach ($liste as $k => $v) {
            $o .= '<option value="' . $k . '" ' . (isset($sel) && ($sel !== '') && ($sel == $k) ? 'selected' : '') . '>' . $v . '</option>';
        }

        $ondeger = $ondeger ? ' <option value="">' . $ondeger . '</option>' : '';

        return '<select name="' . $isim . '" class="' . ($class ? $class : '') . '">' . $ondeger . $o . '</select>';
    }

    static function select_range($start, $end, $isim, $sel = false, $ondeger = false, $class = false, $step = 1, $format = false) {
        if ($start > $end) {
            while ($start >= $end) {
                $o .= '<option value="' . $start . '" ' . ($sel && $sel == $start ? 'selected' : '') . '>' . ($format ? sprintf($format, $start) : $start) . '</option>';
                $start -= $step;
            }
        } else {
            while ($start <= $end) {
                $o .= '<option value="' . $start . '" ' . ($sel && $sel == $start ? 'selected' : '') . '>' . ($format ? sprintf($format, $start) : $start) . '</option>';
                $start += $step;
            }
        }

        $ondeger = $ondeger ? ' <option value="">' . $ondeger . '</option>' : '';

        return '<select name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . '>' . $ondeger . $o . '</select>';
    }

    static function select_ay($isim, $sel = false, $ondeger = false, $class = false) {
        $aylar = array('Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');
        foreach ($aylar as $i => $v) {
            $o .= '<option value="' . ($i + 1) . '" ' . ($sel == ($i + 1) ? 'selected' : '') . '>' . $v . '</option>';
        }

        $ondeger = $ondeger ? ' <option value="0">' . $ondeger . '</option>' : '';

        return '<select name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . '>' . $ondeger . $o . '</select>';
    }

    static function text($isim, $val = '', $class = 'istext', $extra = '') {
        return '<input type="text" name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . ' ' . ($val ? 'value="' . $val . '"' : '') . ' ' . $extra . ' >';
    }

    static function itext($isim, $val = '', $info = '', $class = 'istext') {
        return '<input type="text" name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . ' ' . ($val ? 'value="' . $val . '"' : '') . ($info ? ' title="' . $info . '"' : '') . '>';
    }

    static function submit($isim, $val = '', $class = '') {
        return '<input type="submit" name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . ' ' . ($val ? 'value="' . $val . '"' : '') . '>';
    }

    static function hidden($isim, $val) {
        return '<input type="hidden" name="' . $isim . '"  ' . ($val ? 'value="' . $val . '"' : '') . ' >';
    }

    static function iarea($isim, $val, $info, $class = 'isarea') {
        return '<textarea name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . ($info ? ' title="' . $info . '"' : '') . '>' . $val . '</textarea>';
    }

    static function area($isim, $val, $class = '') {
        return '<textarea name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . '>' . $val . '</textarea>';
    }

    static function check($isim, $val = 1, $baslik = false, $sel = false, $class = false) {
        static $c = 0;
        $id = $baslik ? $isim . ($c++) : '';
        $baslik = $baslik ? '<label for="' . $id . '"> ' . $baslik . '</label>' : '';

        return '<input type="checkbox" ' . ($id ? 'id="' . $id . '"' : '') . ' name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . ' ' . ($val ? 'value="' . $val . '"' : '') . ' ' . ($sel ? 'checked' : '') . '>' . $baslik;

    }

    static function radio($isim, $val = 1, $baslik = false, $sel = false, $class = false) {
        static $c = 0;
        $id = $baslik ? $isim . ($c++) : '';
        $baslik = $baslik ? '<label for="' . $id . '"> ' . $baslik . '  </label> ' : '';

        return '<input type="radio" ' . ($id ? 'id="' . $id . '"' : '') . ' name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . ' ' . ($val !== false ? 'value="' . $val . '"' : '') . ' ' . ($sel ? 'checked' : '') . '>' . $baslik;
    }

    static function radiogroup($isim, $dizi = array(), $sel = false, $class = false) {
        foreach ($dizi as $k => $v) {
            $out .= html::radio($isim, $k, $v, $k == $sel) . ' ';
        }

        return $out;
    }

    static function file($isim, $val, $class = '', $attr = '') {
        return '<input type="file" name="' . $isim . '" ' . ($class ? 'class="' . $class . '"' : '') . ' ' . ($val ? 'value="' . $val . '"' : '') . self::_parseAttr($attr) . '>';
    }

    static function editor($isim = 'editor', $val = '') {
        global $ayar;

        $ayar['editor'] = 1;
        return '<textarea cols="80" id="' . $isim . '" name="' . $isim . '" rows="10">' . $val . '</textarea><script type="text/javascript">CKEDITOR.replace( \'' . $isim . '\');</script>';
    }

    static function _parseAttr($attr) {
        if ($attr) {
            foreach ($attr as $k => $v) {
                $o .= ' ' . $k . '="' . $v . '"';
            }
            return $o;
        }
    }

    static function yesno($name, $val) {
        return self::radiogroup($name, array(1 => 'Evet', 0 => 'Hayır'), $val);
    }
}