<?php

/*
 *
 * hazırweb mysql connection driver
 *
 */

class mysqldriver {
    /*
     * 	Global config dosyasi
     */
    private $config;

    /*
     * 	site_id değişkeni, kurucu fonksiyon ile atanıyor
     */
    public $sid;

    /*
     * site dili
     */
    public $dil;

    private static $_sonuc;

    /*
     * 	kurucu fonksiyon
     */
    function __construct() {
        global $ayar;

        $this->config = $ayar['db'];
        $this->sid = &$ayar['id'];

        return $this;
    }

    /*
     * 	veritabanı bağlantısını kur ve veritabanini belirle
     */
    function baglan() {
        $c = $this->config;

        if (!@mysql_connect($c['host'], $c['user'], $c['pass'])) {
            die('Sistem hatası : 1001');
        }

        if (!@mysql_select_db($c['name'])) {
            die('Sistem hatası : 1002');
        }

        //veritabani utf8 dönüşümü
        self::exec('set names utf8');

        return $this;
    }

    /* v.3
    * 	tüm sorguların çıkış yaptıgı global sorgu fonksiyonu
    */
    public function sorgu($sql, $p = NULL) {
        if ($p !== NULL) $sql = $this->_parse(func_get_args());
        $this->_sonuc = mysql_query($sql);
        return $this;
    }

    public function hata() {
        return mysql_error();
    }

    // v.3
    public function id() {
        return mysql_insert_id();
    }

    public function liste() {
        $d = array();
        while ($a = @mysql_fetch_assoc($this->_sonuc)) $d[] = $a;
        return $d;
    }

    public function to_tree($private_key, $second_key, $double = false) {
        if ($v['list'] = $this->sozluk($private_key)) {
            foreach ($v['list'] as &$d) {
                if ($v['list'][$d[$second_key]]) $agac[$d[$second_key]] = &$v['list'][$d[$second_key]];
                $agac[$d[$second_key]]['child'][$d[$private_key]] = &$d;
                if ($double) $d['parent'] = &$agac[$d[$second_key]];
            }

            $v['tree'] = $agac;
        }
        return $v;
    }

    public function listeObj() {
        $d = array();
        while ($a = @mysql_fetch_object($this->_sonuc)) $d[] = $a;
        return $d;
    }

    public function sozluk($k = '', $v = '') {
        $d = array();

        if ($k !== '' && $v !== '') while ($a = @mysql_fetch_assoc($this->_sonuc)) {
            $d[$a[$k]] = $a[$v];
        }
        elseif ($k !== '' && $v === '') while ($a = @mysql_fetch_assoc($this->_sonuc)) {
            $d[$a[$k]] = $a;
        }

        return $d;
    }

    public function satir() {
        return @mysql_fetch_assoc($this->_sonuc);
    }

    public function satirObj() {
        return @mysql_fetch_object($this->_sonuc);
    }

    public function sonuc($kolon = 0, $satir = 0) {
        return @mysql_result($this->_sonuc, $satir, $kolon);
    }

    public function sayi() {
        if ($s = @mysql_affected_rows()) return $s;
        else return @mysql_num_rows($rows);
    }

    public function temizle() {
        if ($this->_sonuc) mysql_free_result($this->_sonuc);
    }

    private function _parse($p) {
        return vsprintf(array_shift($p), $p);
    }

    function transaction() {
        $this->sorgu('start transaction');
    }

    function commit() {
        $this->sorgu('commit');
    }

    function rollback() {
        $this->sorgu('rollback');
    }

    protected function _sec($in, $del_tags = true) {
        $out = $in;
        $out = strip_tags($in, '<a><blockquote><br><div><em><embed><font><h1><h2><h3><h4><h5><h6><h7><hr><img><li><object><ol><p><param><span><strike><strong><sub><sup><table><tbody><td><th><tr><u><ul>');
        $out = mysql_real_escape_string($out);

        return (is_numeric($out) ? $out : "'" . $out . "'");
    }

    //--------------------v3end

    /*
     * mysql_query multiparameter versiyonu
     */
    public function e($sql, $p = 0) {
        if ($p) $sql = $this->_parse(func_get_args());
        if (mysql_query($sql)) return (mysql_insert_id() | true);
        else return false;
    }

    //mysql query result
    public function qr($sql, $p = false) {
        if ($p) $sql = $this->_parse(func_get_args());
        return self::get_line(self::query($sql));
    }

    //mysql query result
    public function qra($sql) {
        return self::fa(self::query($sql));
    }

    /*
     * 	tüm sorguların çıkış yaptıgı global sorgu fonksiyonu
     */
    public function query($sql) {
        return mysql_query($sql);
    }

    /*
     * 	kaç satırın etkilendiğini gösteren fonksiyon
     */
    public function affected() {
        return mysql_affected_rows();
    }

    /*
     * dml fonksiyonumuz
     */
    public function exec($sql) {
        if (mysql_query($sql)) {
            if ($id = mysql_insert_id()) return $id;
            else return true;
        } else return false;
    }

    public function free($res) {
        if ($res) mysql_free_result($res);
    }

    public function query_r($sql) {
        return self::get_line(self::query($sql));
    }

    public function query_r_a($sql) {
        return self::get_line_a(self::query($sql));
    }

    public function get_assoc($sql) {
        return mysql_fetch_assoc(self::query($sql));
    }

    protected function sec($s) {
        return strip_tags(addslashes($s));
    }

    protected function fo(&$res) {
        //if(!$res) echo mysql_errno();
        $line = @mysql_fetch_object($res);
        self::free($res);
        return $line;
    }

    protected function fa(&$res) {
        //if(!$res) echo mysql_errno();
        $line = @mysql_fetch_assoc($res);
        self::free($res);
        return $line;
    }

    protected function get_line(&$res) {
        return $this->fo($res);
    }

    protected function get_line_a(&$res) {
        //if(!$res) echo mysql_errno();
        return @mysql_fetch_assoc($res);
    }

    public function get_list($sql) {
        $d = array();
        $res = $this->query($sql);
        while ($a = @mysql_fetch_object($res)) $d[] = $a;
        self::free($res);
        return $d;
    }

    public function get_list_a($sql, $col = '') {
        $a = $d = array();
        $res = $this->query($sql);
        if ($col) while ($a = @mysql_fetch_assoc($res)) $d[$a[$col]] = $a;
        else     while ($a = @mysql_fetch_assoc($res)) $d[] = $a;
        self::free($res);
        return $d;
    }

    public function gdict($sql) {
        $res = self::query($sql);
        while ($d = mysql_fetch_array($res)) {
            $e[$d[0]] = $d[1];
        }
        self::free($res);
        return $e;
    }

    protected function get_list_value($sql, $all = false) {
        $res = self::query($sql);

        if ($all) {
            while ($d = mysql_fetch_array($res)) $a[] = $d;
        } else {
            while ($d = mysql_fetch_array($res)) {
                $a[] = $d[0];
            }
        }

        self::free($res);
        return $a;
    }

    //get function
    public function ga($table, $id, $use_site_id = true) {
        return $this->fa($this->query("SELECT * FROM $table where id=$id"));
    }

    //get function
    public function go($table, $id, $use_site_id = true) {
        return $this->fo($this->query("SELECT * FROM $table where id=$id"));
    }

    public function get_id() {
        return mysql_insert_id();
    }
}

;