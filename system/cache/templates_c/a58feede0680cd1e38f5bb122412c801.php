<?php if($compare = $CI->session->userdata('shopForCompare')): ?>
    <?php $count = count($compare);?>
<?php else:?>
    <?php $count = 0;?>
<?php endif; ?>
<div class="compare-list-btn tinyCompareList">
    <button data-href="<?php echo shop_url ('compare'); ?>" data-drop=".drop-info-compare" data-place="inherit" data-overlay-opacity="0">
        <span class="icon_compare_list"></span>
        <span class="text-compare-list">
            <span class="js-empty empty" <?php if($count == 0): ?>style="display: inline"<?php endif; ?>>
                <span class="text-el"><?php echo lang ('Товары на сравнение','light'); ?> </span>
                <span class="text-el">(</span>
                <span class="f-s_0">
                    <span class="text-el compareListCount">0</span>
                </span>
                <span class="text-el">)</span>
            </span>
            <span class="js-no-empty no-empty" <?php if($count != 0): ?>style="display: inline"<?php endif; ?>>
                <span class="text-el"><?php echo lang ('Товары на сравнение','light'); ?> </span>
                <span class="text-el">(</span>
                <span class="f-s_0">
                    <span class="text-el compareListCount"></span>
                </span>
                <span class="text-el">)</span>
            </span>
        </span>
    </button>
</div>
<div class="drop drop-info drop-info-compare">
    <span class="helper"></span>
    <span class="text-el">
        <?php echo lang ('Ваш список', 'light'); ?><br/>
        “<?php echo lang ('Список сравнения', 'light'); ?>” <?php echo lang ('пуст', 'light'); ?></span>
</div><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/compare_data.tpl ?>