<?php
/*
 * HazırWeb Data Layer
 *
 * @author can ünlü
 */

require_once DR . '/include/class.mysqldriver.php';

class datalayer extends mysqldriver {

    function __construct() {
        parent::__construct();
        $this->baglan();
    }

    function _prepareVal($array, $type = 'insert') {
        if ($array) {
            if ($type == 'insert') {
                foreach ($array as $k => &$v) $v = $this->_sec($v);
                return $cols = sprintf('(%s) values(%s)', implode(',', array_keys($array)), implode(',', $array));
            } elseif ($type == 'set') {
                foreach ($array as $k => $v) $stack[] = sprintf("%s=%s", $k, $this->_sec($v));
                $stack = implode(',', $stack);
                return $stack;
            } elseif ($type == 'select') {
                foreach ($array as $k => $v) $stack[] = sprintf("%s=%s", $k, $this->_sec($v));
                $stack = implode(' AND ', $stack);
                return $stack;
            }
        }
    }

    function set($mod, $id, $column = array(), $keyName = 'id', $extraconf = '') {
        $this->sorgu("update %s set %s where %s=%d %s", $mod, $this->_prepareVal($column, 'set'), $keyName, $this->_sec($id), $extraconf);
        $aa = $this->sayi();
        return $aa;
    }

    function add($mod, $column = array()) {
        return $this->sorgu("insert into %s%s", $mod, $this->_prepareVal($column, 'insert'))->id();
    }

    function del($mod, $id, $key = 'id') {

        return $this->sorgu("delete from %s where %s=%d $w", $mod, $key, $id);
    }

    function dec($mod, $col, $id, $useSid = true, $key = 'id') {
        if ($useSid) $w = "and sid=$this->sid";
        return $this->sorgu("update %s set %s=%s-1 where %s=%d $w", $mod, $col, $col, $key, $id, $w);
    }

    function inc($mod, $col, $id, $key = 'id', $session = false) {
        if ($session) {
            if (!isset($_SESSION[$mod . '-' . $col . '-' . $id])) {
                $_SESSION[$mod . '-' . $col . '-' . $id] = 1;
                return $this->inc($mod, $col, $id, $key, false);
            }

            return false;
        }

        return $this->sorgu("update %s set %s=%s+1 where %s=%d", $mod, $col, $col, $key, $id);
    }

    function get($mod, $column = array(), $useSid = true, $where = array()) {
        if ($useSid) $where['sid'] = $this->sid;

        $column = is_array($column) ? implode(', ', $column) : $column;
        $where = ($where = $this->_prepareVal($where, 'select')) ? ' where ' . $where : '';

        return $this->sorgu("SELECT %s FROM %s %s", $column, $mod, $where);
    }

    function get_sozluk($mod, $key, $value, $where = array(), $useSid = 0) {
        //$column = is_array($column) ? implode(', ',$column) : $column;
        if ($useSid) $where['sid'] = $this->sid;
        $where = $where ? ' where ' . $this->_prepareVal($where, 'select') : '';

        return $this->sorgu("SELECT %s,%s FROM %s %s", $key, $value, $mod, $where)->sozluk($key, $value);
    }

    function getLink($title, $tbl_name, $sid = true, $old_data = false) {
        $name = preg_replace('/-+/', '-', strtolower(strtr(trim($title), array(' ' => '-', '\'' => '', ':' => '', '’' => '', '^' => '', 'Č' => 'c', 'č' => 'c', 'Ğ' => 'g', 'Ğ' => 'g', 'ğ' => 'g', 'Ş' => 's', 'ş' => 's', 'Ö' => 'o', 'ö' => 'o', 'Ü' => 'u', 'ü' => 'u', '"' => '', 'ğ' => 'g', 'Ş' => 's', 'ş' => 's', 'İ' => 'i', 'ı' => 'i', 'Ç' => 'c', 'ç' => 'c', 'Ü' => 'u', 'ü' => 'u', 'Ö' => 'o', 'ö' => 'o', 'ı' => 'i', 'İ' => 'i', 'I' => 'i', 'é' => 'i', 'â' => 'a', 'Ê' => 'e', 'Â' => 'a', '?' => '', '*' => '', '.' => '', ',' => '', '/' => '-', ';' => '', ')' => '', '(' => '', '{' => '', '}' => '', '[' => '', ']' => '', '!' => '', '+' => '', '"' => '', '%' => '', '&' => '', '#' => '', '$' => '', '=' => '', 'ê' => 'e', '"' => '', '…' => '', '“' => '', '”' => ''))));

        if ($old_data) {
            $res = $this->sorgu("SELECT link FROM %s where %s %s", $tbl_name, $this->_prepareVal($old_data, 'select'), $sid ? ' and sid=' . $this->sid : '')->sonuc(0);
            if ($res) return $res;
        }

        if ($res = $this->sorgu("SELECT link FROM %s where %s link='%s'", $tbl_name, $sid ? ' sid=' . $this->sid . ' and ' : '', $name)->sonuc(0)) {
            $uname = $this->sorgu("SELECT max(CONVERT(if(instr(link,'-'),SUBSTRING_INDEX(link,'-',-1),0),SIGNED)) as son,count(link) as sayi FROM %s where %s link like '%s' and link regexp '^%s\-?[0-9]*$'", $tbl_name, $sid ? 'sid=' . $this->sid . ' and ' : '', $name . '%', $name)->satirObj();
            if ($uname->sayi == 0) return $name;
            else {
                $uu = @split('-', $uname->son);
                $end = end($uu);
                return $name . '-' . (is_numeric($end) ? ++$end : $uname->sayi);
            }
        } else {
            return $name;
        }

    }
}

?>