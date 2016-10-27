<?php
	require_once 'include/include.php';

    $sayfa = new Sayfa();

    $mod = getRequest('action',0);
    $action = getRequest('action',1);


    if($mod == 'uye')
    {
        if($action == 'yeni')
        {
            $data = $data = array(
                'isim'=>$_GET['isim'],
                'eposta'=>$_GET['eposta'],
                'kayittarihi'=>dbDateTime(),
                'sifre' => $_GET['sifre'] ? md5($_GET['sifre']) : $_GET['sifre_md5']);
            echo $db->add('mod_uye',$data,1);
        }
    }