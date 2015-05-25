<div class="frame-baner frame-baner-start_page">
    <section class="carousel-js-css baner container resize cycleFrame">
        <!--remove class="resize" if not resize-->
        <div class="content-carousel">
            <ul class="cycle"><!--remove class="cycle" if not cycle-->
                <?php if(is_true_array($banners)){ foreach ($banners as $banner){ ?>
                    <li>
                        <?php if(trim( $banner['url'] )): ?>
                            <a href="<?php echo site_url ( $banner['url'] ); ?>"><img data-original="<?php echo $banner['photo']?>" src="<?php if(isset($THEME)){ echo $THEME; } ?>images/blank.gif" alt="<?php ShopCore::encode( $banner['name'] ) ?>"/></a>
                            <?php else:?>
                            <span><img data-original="<?php echo $banner['photo']?>" src="<?php if(isset($THEME)){ echo $THEME; } ?>images/blank.gif" alt="<?php ShopCore::encode( $banner['name'] ) ?>"/></span>
                            <?php endif; ?>
                    </li>
                <?php }} ?>
            </ul>
            <div class="preloader"></div>
            <div class="pager"></div>
        </div>
        <div class="group-button-carousel">
            <button type="button" class="prev arrow">
                <span class="icon_arrow_p"></span>
            </button>
            <button type="button" class="next arrow">
                <span class="icon_arrow_n"></span>
            </button>
        </div>
    </section>
</div>
<?php $mabilis_ttl=1432201435; $mabilis_last_modified=1426010500; //templates/light/banners/main_slider.tpl ?>