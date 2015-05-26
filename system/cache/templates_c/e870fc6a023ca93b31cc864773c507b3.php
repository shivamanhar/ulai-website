<div class="page-main container">
    <div class="left-start-page">
        <?php $CI->load->module('banners')->render()?>
        <div id="action_products">
            <?php echo widget ('action_products', TRUE); ?>
        </div>
        <div id="popular_products">
            <?php echo widget ('popular_products', TRUE); ?>
        </div>
        <div id="new_products">
            <?php echo widget ('new_products', TRUE); ?>
        </div>
        <div class="frame-seo-text">
            <div class="text seo-text">
                <?php echo widget ('start_page_seo_text'); ?>
            </div>
        </div>
    </div>
    <div class="right-start-page">
        <div class="frame-little-banner">
            <?php if(is_true_array($CI->load->module('banners')->getByGroup('right-main'))){ foreach ($CI->load->module('banners')->getByGroup('right-main') as $banner){ ?>
                <p>
                    <?php if(trim( $banner['url'] )): ?>
                        <a href="<?php echo site_url ( $banner['url'] ); ?>"><img data-original="<?php echo $banner['photo']?>" src="<?php if(isset($THEME)){ echo $THEME; } ?>images/blank.gif" alt="<?php ShopCore::encode( $banner['name'] ) ?>" class="lazy"/></a>
                        <?php else:?>
                        <span><img data-original="<?php echo $banner['photo']?>" src="<?php if(isset($THEME)){ echo $THEME; } ?>images/blank.gif" alt="<?php ShopCore::encode( $banner['name'] ) ?>" class="lazy"/></span>
                        <?php endif; ?>
                </p>
            <?php }} ?>
        </div>
        <div class="frame-benefits <?php if($CI->load->module('banners') && $CI->load->module('banners')->getByGroup('right-main')): ?><?php else:?>no-baner<?php endif; ?>">
            <?php echo widget ('benefits'); ?>
        </div>
        <?php echo widget ('brands'); ?>
        <div class="frame-seotext-news">
            <?php echo widget ('latest_news', TRUE); ?>
        </div>
    </div>
</div><?php $mabilis_ttl=1432714920; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/start_page.tpl ?>