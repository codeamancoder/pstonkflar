<?php

include 'class.phpmailer.php';

class mailer extends PHPMailer {
    function __construct() {
        $this->IsSMTP();
        $this->SMTPAuth = true;
        $this->Host = 'smtp.yandex.ru';
        $this->Port = '587';
        $this->SMTPSecure = 'tls';
        $this->Username = 'iletisim@pistonkafalar.com';
        $this->Password = 'ySBzXwo4';
        $this->SetFrom($this->Username, 'Piston Kafalar');
        $this->AddReplyTo($this->Username, 'Piston Kafalar');
        $this->AltBody = 'Bu epostayı görüntülemek için lütfen HTML desteği olan bir eposta görüntüleyici kullanınınız';
        $this->CharSet = 'utf-8';
    }

    function fast_send($email, $name, $title, $msg, $bcc = false) {
        $this->AddAddress($email, $name);
        if ($bcc) $this->AddBCC($bcc);
        $this->Subject = $title;
        $this->MsgHTML($msg);
        return $this->Send();
    }
}