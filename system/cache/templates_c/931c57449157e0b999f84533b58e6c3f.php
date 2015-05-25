<div class="frame-user-toolbar<?php if($_COOKIE['condUserToolbar'] == 1 || !isset($_COOKIE['condUserToolbar'])): ?> active<?php endif; ?>">
    <div class="container inside-padd">
        <?php $countSh = getProductViewsCount()?>
        <div class="content-user-toolbar">
            <ul class="items items-user-toolbar">
                <li class="box-1">
                    <div class="btn-already-show<?php if($countSh): ?> pointer<?php endif; ?>">
                        <button type="button" data-drop=".frame-already-show" data-effect-on="slideDown" data-effect-off="slideUp" data-place="inherit">
                            <span class="icon_view"></span>
                            <span class="text-view-list">
                                <span class="text-el d_l_1"><?php echo lang ("Просмотренные товары",'light'); ?></span>
                                <span class="text-el">&nbsp;(<?php echo $countSh?>)</span>
                            </span>
                        </button>
                    </div>
                </li>
                <li class="box-2">
                    <?php $this->include_shop_tpl('wish_list_data', '/var/www/templates/light'); ?>
                </li>
                <li class="box-3">
                    <?php $this->include_shop_tpl('compare_data', '/var/www/templates/light'); ?>
                </li>
                <li class="box-4">
                    <div class="btn-toggle-toolbar">
                        <button type="button" data-rel="0" <?php if($_COOKIE['condUserToolbar'] == 0 && isset($_COOKIE['condUserToolbar'])): ?>style="display: none;"<?php else:?> class="activeUT"<?php endif; ?>>
                            <span class="text-el"><?php echo lang ('Свернуть','light'); ?></span>
                        </button>
                        <button type="button" data-rel="1" class="show<?php if($_COOKIE['condUserToolbar'] == 0 || isset($_COOKIE['condUserToolbar'])): ?> activeUT<?php endif; ?>" <?php if($_COOKIE['condUserToolbar'] == 1 ||  !isset($_COOKIE['condUserToolbar'])): ?>style="display: none;"<?php endif; ?>>
                            <span class="icon_arrow_down"></span>
                            <span class="text-el"><?php echo lang ('Развернуть','light'); ?></span>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
        <div class="btn-to-up">
            <button type="button">
                <span class="icon_arrow_p icon_arrow_p2"></span>
                <span class="text-el ref t-d_n"><?php echo lang ('Наверх','light'); ?></span>
            </button>
        </div>
    </div>
    <div class="drop frame-already-show">
        <div class="content-already-show">
            <div id="ViewedProducts">
                <?php echo widget ('ViewedProducts'); ?>
            </div>
        </div>
    </div>
</div>
<?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/user_toolbar.tpl ?>