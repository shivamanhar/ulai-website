<?php

$widgets = array(
    array(
        'title' => lang('Popular/New/Action products'),
        'description' => lang('Displays the unit in the form of a "carousel" with selected products'),
        'method' => 'products'
    ),
    array(
        'title' => lang('Brands'),
        'description' => lang('Displays the unit in the form of a "carousel" with selected brands'),
        'method' => 'brands'
    ),
    array(
        'title' => lang('Viewed products'),
        'description' => lang('Displays already viewed by the user products.'),
        'method' => 'view_product'
    ),
    array(
        'title' => lang('Similar Products'),
        'description' => lang('Displays on the product page block with similar products.'),
        'method' => 'similar_products'
    )
);
