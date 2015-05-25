<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

$com_info = array(
    'menu_name' => lang('Сбербанк', 'payment_method_sberbank'), // Menu name
    'description' => lang('Метод оплаты Сбербанк', 'payment_method_sberbank'),            // Module Description
    'admin_type' => 'window',       // Open admin class in new window or not. Possible values window/inside
    'window_type' => 'xhr',         // Load method. Possible values xhr/iframe
    'w' => 600,                     // Window width
    'h' => 550,                     // Window height
    'version' => '0.1',             // Module version
    'author' => 'v.dushko',  // Author info
    'icon_class' => 'icon-barcode'
);

/* End of file module_info.php */
