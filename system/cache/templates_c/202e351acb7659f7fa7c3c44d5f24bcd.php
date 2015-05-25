<?php $condBtn = $class != 'btn inWL'?>
<div class="btnWish btn-wish <?php if(!$condBtn): ?>btn-wish-in<?php endif; ?>" data-id="<?php echo $varId?>">
    <button 
        class="toWishlist"
        type="button"
        data-rel="tooltip"
        data-title="<?php echo lang ('В список желаний','light'); ?>"

        <?php if($is_logged_in): ?>
            data-drop="#wishListPopup"
            data-source="<?php echo site_url ('/wishlist/renderPopup/'. $varId); ?>"
        <?php else:?>
            data-drop="#dropAuth"
        <?php endif; ?>
        <?php if(!$condBtn): ?>
            style="display: none;"
        <?php endif; ?>
        >
        <span class="icon_wish"></span>
        <span class="text-el d_l"><?php echo lang ('В список желания','light'); ?></span>
    </button>
    <button class="inWishlist" type="button" data-rel="tooltip" data-title="<?php echo lang ('В списке желаний','light'); ?>" <?php if($condBtn): ?>style="display: none;"<?php endif; ?>>
        <span class="icon_wish"></span>
        <span class="text-el d_l"><?php echo lang ('В списке желания','light'); ?></span>
    </button>
</div>
<?php $mabilis_ttl=1432206589; $mabilis_last_modified=1426010500; //templates/light/wishlist/button.tpl ?>