<?php $cart = \Cart\BaseCart::getInstance()?>
<?php $count = $cart->getTotalItems()?>
<?php $price = $cart->getTotalPrice()?>
<?php $priceOrigin = $cart->getOriginTotalPrice()?>

<?php if($count == 0): ?>
    <div class="btn-bask">
        <button>
            <span class="frame-icon">
                <span class="icon_cleaner"></span>
            </span>
            <span class="text-cleaner">
                <span class="helper"></span>
                <span>
                    <span class="text-el topCartCount">0</span>
                </span>
            </span>
        </button>
    </div>
<?php else:?>
    <div class="btn-bask pointer">
        <button class="btnBask">
            <span class="frame-icon">
                <span class="icon_cleaner"></span>
            </span>
            <span class="text-cleaner">
                <span class="helper"></span>
                <span>
                    <span class="ref text-el"><?php echo lang ('Корзина', 'light'); ?></span>
                    <span class="text-el topCartCount"><?php echo $count?></span>
                </span>
            </span>
        </button>
    </div>
<?php endif; ?><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/cart_data.tpl ?>