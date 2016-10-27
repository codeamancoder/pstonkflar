<?php

/*
 * ikobi singleton design pattern implementation
 */

interface Isingleton {
    public static function get_instance($params = array());
}