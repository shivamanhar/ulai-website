<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$com_info = array(
    'menu_name' => lang('Mobile version', 'mobile'), // Menu name
    'description' => lang('Allows you to connect a mobile version of an Online Store', 'mobile'), // Module Description
    'admin_type' => 'window', // Open admin class in new window or not. Possible values window/inside
    'window_type' => 'xhr', // Load method. Possible values xhr/iframe
    'w' => 600, // Window width
    'h' => 550, // Window height
    'version' => '0.1', // Module version
    'author' => 'dev', // Author info
    'type' => 'shop',                // CMS version
    'icon_class' => 'icon-signal'
);

/* End of file module_info.php */
