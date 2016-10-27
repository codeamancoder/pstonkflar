<?php
session_set_cookie_params(0, '/' . '.pistonkafalar.com');
require_once 'include/include.php';

$sayfa = factory::get('sayfa');
$sayfa->olustur(); // new sayfa();
//$sayfa->olustur();
?>
