<?php

class email {
    private $_head = array();
    private $_to = array();
    private $_attach, $_attach_head, $_attach_uid = null;
    private $_baslik;

    function email() {
        $h = strtr($_SERVER['SERVER_NAME'], array('www.' => ''));
        $this->from($h, 'no-reply@' . $h);
        return $this;
    }

    function set($to, $from_baslik, $from_email, $baslik) {
        $this->to($to);
        $this->from($from_baslik, $from_email);
        $this->baslik($baslik);
        return $this;
    }

    function attach($path, $name = '') {
        $file_size = filesize($path);
        $handle = fopen($path, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $name = $name ? $name : basename($path);

        if (!$this->_attach_head) {
            $this->_attach_uid = md5(uniqid(time()));
            $this->_attach_head = "Content-Type: multipart/mixed; boundary=\"" . $this->_attach_uid . "\"\r\n\r\n";
            $this->_attach_head .= "This is a multi-part message in MIME format.\r\n";
            $this->_attach_head .= "--" . $this->_attach_uid . "\r\n";
        }

        $this->_attach .= "--" . $this->_attach_uid . "\r\n";
        $this->_attach .= "Content-Type: application/octet-stream; name=\"" . $name . "\"\r\n"; // use different content types here
        $this->_attach .= "Content-Transfer-Encoding: base64\r\n";
        $this->_attach .= "Content-Disposition: attachment; filename=\"" . $name . "\"\r\n\r\n";
        $this->_attach .= chunk_split(base64_encode($content)) . "\r\n\r\n";
    }

    function to($email, $isim = '') {
        $this->_to[] = $isim ? $this->_cevir($isim) . " <$email>" : $email;
        return $this;
    }

    function cc($email, $isim = '') {
        $this->_cc[] = $isim ? $this->_cevir($isim) . " <$email>" : $email;
        return $this;
    }

    function bcc($email, $isim = '') {
        $this->_cc[] = $isim ? $this->_cevir($isim) . " <$email>" : $email;
        return $this;
    }

    function subject($a) {
        $this->_baslik = $this->_cevir($a);
        return $this;
    }

    function baslik($a) {
        $this->_baslik = $this->_cevir($a);
        return $this;
    }

    function from($k, $v) {
        $this->_from = array($k, $v);
        return $this;
    }

    function css($c) {
        $this->_css = $c;
        return $this;
    }

    function gonder($mesaj, $tip = 'plain', $logo = 0) {
        $head = "From: " . $this->_from[0] . " <" . $this->_from[1] . ">\r\n";
        $head .= "Reply-To: " . $this->_from[0] . " <" . $this->_from[1] . ">\r\n";
        $head .= "Return-Path: " . $this->_from[0] . " <" . $this->_from[1] . ">\r\n";
        $head .= $this->_cc ? "Cc:" . implode($this->_cc, ',') . "\r\n" : '';
        $head .= $this->_bcc ? "Bcc:" . implode($this->_bcc, ',') . "\r\n" : '';
        $head .= "MIME-Version: 1.0\r\n";
        $head .= $this->_attach ? $this->_attach_head : '';
        $head .= "Content-Type: text/$tip; charset=iso-8859-9\r\n";
        $head .= $this->_cevir($mesaj) . "\r\n";
        $head .= $this->_attach ? $this->_attach . "--" . $this->_attach_uid . "--" : '';

        $this->_to = implode($this->_to, ',');

        return @mail($this->_to, $this->_baslik, "", $head);
    }

    private function _cevir($t) {
        return mb_convert_encoding($t, 'iso-8859-9', 'utf-8');
    }
}