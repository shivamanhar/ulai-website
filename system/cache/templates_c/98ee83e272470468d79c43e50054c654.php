<?php $count = $CI->load->module('wishlist')->getUserWishListItemsCount($CI->dx_auth->get_user_id())?>
<div class="wish-list-btn tinyWishList">
    <button data-href="<?php echo site_url ('wishlist'); ?>" data-drop=".drop-info-wishlist" data-place="inherit" data-overlay-opacity="0">
        <span class="icon_wish_list"></span>
        <span class="text-wish-list">
            <span class="js-empty empty" <?php if($count == 0): ?>style="display: inline"<?php endif; ?>>
                <span class="text-el"><?php echo lang ('Список желаний','light'); ?> </span>
                <span class="text-el">(</span>
                <span class="text-el wishListCount">0</span>
                <span class="text-el">)</span>
            </span>
            <span class="js-no-empty no-empty" <?php if($count != 0): ?>style="display: inline"<?php endif; ?>>
                <span class="text-el"><?php echo lang ('Список желаний','light'); ?> </span>
                <span class="text-el">(</span>
                <span class="text-el wishListCount"><?php echo $count?></span>
                <span class="text-el">)</span>
            </span>
        </span>
    </button>
</div>
<div class="drop drop-info drop-info-wishlist">
    <span class="helper"></span>
    <span class="text-el">
        <?php echo lang ('Ваш список', 'light'); ?> <br/>
        “<?php echo lang ('Список желаний', 'light'); ?>” <?php echo lang ('пуст', 'light'); ?></span>
</div><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/wish_list_data.tpl ?>