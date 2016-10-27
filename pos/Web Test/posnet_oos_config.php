<?php
    /*
     * posnet_oos_config.php
     *
     */

    /**
     * @package posnet oos
     */

    //Configuration parameters
    define('MID', '6734273367');
    define('TID', '67934685');
    define('POSNETID', '7453');
    define('ENCKEY', '10,10,10,10,10,10,10,10');
    
    //Posnet Sistemi ile ilgili parametreler
    
    define('OOS_TDS_SERVICE_URL', 'https://setmpos.ykb.com/3DSWebService/YKBPaymentService');
    //Posnet XML Servisinin web adresi
    define('XML_SERVICE_URL', 'https://setmpos.ykb.com/PosnetWebService/XML');
        
    define('USEMCRYPTLIBRARY', true);
?>