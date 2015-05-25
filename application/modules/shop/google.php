<?php

/**
 * Export to Google
 */
class Google extends ShopController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->core->set_meta_tags("Интернет-магазин - " . site_url());
        $this->render('google');
    }

}