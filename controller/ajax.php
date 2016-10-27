<?php

/*
 * ajax controller
 */

class ajax extends controller {

    /*
     * mektup ajax methodlar
     */
    function fotograf() {
        echo factory::get('dosyalar')->ajax($ba[2]);
        exit();
    }
}