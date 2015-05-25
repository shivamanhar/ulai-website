<?php if(count($simProduct = getSimilarProduct($model, $settings[productsCount])) > 0): ?>
    <div class="vertical-carousel similar-product">
        <section class="special-proposition">
            <div class="frame-title">
                <div class="title">
                    <span class="text-el text-proposition-v"><?php if(isset($title)){ echo $title; } ?></span>
                </div>
            </div>
            <div class="big-container">
                <div class="items-carousel carousel-js-css">
                    <?php /*frame-scroll-pane || carousel-js-css || ''*/?>
                    <div class="content-carousel container">
                        <ul class="items items-catalog items-v-carousel">
                            <?php echo getOPI ($simProduct, array('opi_widget'=>true, 'opi_vertical' => true, 'opi_defaultItem'=> true, 'opi_limit'=>false)); ?>
                        </ul>
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
        </section>
    </div>
<?php endif; ?><?php $mabilis_ttl=1432206593; $mabilis_last_modified=1426010500; ///var/www/templates/light/widgets/similar.tpl ?>