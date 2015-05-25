<?php if(count($products) > 0): ?>
    <div class="horizontal-carousel">
        <section class="special-proposition frame-view-products">
            <div class="big-container">
                <div class="carousel-js-css items-carousel">
                    <?php /*frame-scroll-pane || carousel-js-css*/?>
                    <div class="content-carousel container">
                        <ul class="items items-catalog items-h-carousel">
                            <?php echo getOPI ($products, array('opi_widget'=>true)); ?>
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
<?php else:?>
    <div class="inside-padd">
        <div class="msg f-s_0">
            <div class="info"><span class="icon_info"></span><span class="text-el"><?php echo lang ('Нет просмотренных товаров','light'); ?></span></div>
        </div>
    </div>
<?php endif; ?><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/widgets/ViewedProducts.tpl ?>