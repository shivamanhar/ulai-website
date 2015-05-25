<?php if(count($brands) > 0): ?>
    <div class="horizontal-carousel">
        <div class="big-container frame-brands">
            <div class="items-carousel">
                <?php /*carousel-js-css*/?>
                <div class="frame-brands-carousel">
                    <div class="content-carousel">
                        <ul class="items items-brands">
                            <?php if(is_true_array($brands)){ foreach ($brands as $brand){ ?>
                                <li>
                                    <a href="<?php echo shop_url ( $brand['full_url'] ); ?>" class="frame-photo-title">
                                        <span class="photo-block">
                                            <span class="helper"></span>
                                            <img src="<?php echo media_url ( $brand['img_fullpath'] ); ?>" alt="<?php echo $brand['name']; ?>"/>
                                        </span>
                                    </a>
                                </li>
                            <?php }} ?>
                        </ul>
                    </div>
                    <div class="frame-button-brand t-a_c">
                        <span class="show-all-brands btn-def">
                            <a href="<?php echo shop_url ('brand/'); ?>" class="t-d_n f-s_0">
                                <span class="text-el"><?php echo lang ('Все бренды','light'); ?></span>
                            </a>
                        </span>
                    </div>
                    <div class="group-button-carousel">
                        <button type="button" class="prev arrow">
                            <span class="icon_arrow_p"></span>
                        </button>
                        <button type="button" class="next arrow">
                            <span class="icon_arrow_n"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/widgets/brands.tpl ?>