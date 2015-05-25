<?php $opi_widget = $opi_widget != false && $opi_widget != NULL?>
<?php $opi_wishlist = $opi_wishlist != false && $opi_wishlist != NULL?>
<?php $opi_compare = $opi_compare != false && $opi_compare != NULL?>
<?php $opi_codeArticle = $opi_codeArticle != false && $opi_codeArticle != NULL?>
<?php $opi_defaultItem = $opi_defaultItem != false && $opi_defaultItem != NULL?>
<?php $opi_vertical = $opi_vertical != false && $opi_vertical != NULL?>
<?php $opi_wishListPage = $opi_wishListPage != false && $opi_wishListPage != NULL?>

<?php $condlimit = $opi_limit != false && $opi_limit != NULL?>
<?php if(is_true_array($products)){ foreach ($products as $key => $p){ ?>

    <?php if(is_array($p) &&  $p['id']): ?>
        <?php $pArray = $p;?>
        <?php $variants = array()?>
        <?php $p = getProduct( $p['id'] ) ?>
        <?php $p->firstVariant = getVariant( $pArray['id'] , $pArray['variant_id'] )  ?>
        <?php $variants[] = $p->firstVariant?>
    <?php else:?>
        <?php $variants = $p->getProductVariants()?>
    <?php endif; ?>

    <?php $hasDiscounts = $p->hasDiscounts()?>

    <?php if($key >= $opi_limit && $condlimit): ?>
        <?php break?>
    <?php endif; ?>
    <?php $Comments = $CI->load->module('comments')->init($p)?>
    <?php $inCartFV = getAmountInCart('SProducts', $p->firstVariant->getId())?>
    <li  class="globalFrameProduct<?php if($p->firstVariant->getStock() == 0): ?> not-avail<?php else:?><?php if($inCartFV): ?> in-cart<?php else:?> to-cart<?php endif; ?><?php endif; ?>" data-pos="top">
        <!-- Start. Photo & Name product -->
        <a href="<?php echo shop_url ('product/' . $p->getUrl()); ?>" class="frame-photo-title" title="<?php echo ShopCore::encode($p->getName())?>">
            <span class="photo-block">
                <span class="helper"></span>
                <?php $photo = $p->firstVariant->getMediumPhoto()?>
                <img src="<?php echo $photo?>"
                     alt="<?php echo ShopCore::encode($p->firstVariant->getName())?>"
                     class="vImg"/>
                <?php $discount = 0?>
                <?php if($hasDiscounts): ?>
                    <?php $discount = $p->firstVariant->getvirtual('numDiscount') / $p->firstVariant->toCurrency('origprice') * 100?>
                <?php endif; ?>
                <?php echo promoLabel ($p->getAction(), $p->getHot(), $p->getHit(), $discount); ?>
            </span>
            <span class="title"><?php echo ShopCore::encode($p->getName())?></span>
        </a>
        <!-- End. Photo & Name product -->
        <div class="description">
            <!-- Start. article & variant name & brand name -->
            <?php if($opi_codeArticle): ?>
                <div class="frame-variant-name-code">
                    <?php $hasCode = $p->firstVariant->getNumber() == ''?>
                    <span class="frame-variant-code frameVariantCode" <?php if($hasCode): ?>style="display:none;"<?php endif; ?>><?php echo lang ('Артикул','light'); ?>:
                        <span class="code js-code">
                            <?php if(!$hasCode): ?>
                                <?php echo trim ($p->firstVariant->getNumber()); ?>
                            <?php endif; ?>
                        </span>
                    </span>
                    <?php if(count($variants) > 1): ?>
                        <?php $hasVariant = $p->firstVariant->getName() == ''?>
                        <span class="frame-variant-name frameVariantName" <?php if($hasVariant): ?>style="display:none;"<?php endif; ?>><?php echo lang ('Вариант','light'); ?>:
                            <span class="code js-code">
                                <?php if(!$hasVariant): ?>
                                    <?php echo trim ($p->firstVariant->getName()); ?>
                                <?php endif; ?>
                            </span>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="frame-prices-btns">
                <!-- Start. Prices-->
                <div class="frame-prices f-s_0">
                    <!-- Start. Check for discount-->
                    <?php $oldoprice = $p->getOldPrice() && $p->getOldPrice() != 0 && $p->getOldPrice() > $p->firstVariant->toCurrency()?>
                    <?php if($hasDiscounts): ?>
                        <span class="price-discount">
                            <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $p->firstVariant->toCurrency('OrigPrice'),'span', 'curr', '',  'span', 'price priceOrigVariant', '');?>

                            </span>
                        </span>
                    <?php endif; ?>
                    <!-- End. Check for discount-->
                    <!-- Start. Check old price-->
                    <?php if($oldoprice && !$hasDiscounts): ?>
                        <span class="price-discount">
                            <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), intval($p->toCurrency('OldPrice')),'span', 'curr', '',  'span', 'price priceOrigVariant', '');?>

                            </span>
                        </span>
                    <?php endif; ?>
                    <!-- End. Check old price-->
                    <!-- Start. Product price-->
<?php if(is_numeric($p->firstVariant->toCurrency())): ?>
                        <span class="current-prices f-s_0">
                            <span class="price-new">
                                <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $p->firstVariant->toCurrency(),'span', 'curr', '',  'span', 'price priceVariant', '');?>

                                </span>
                            </span>
                            <?php if($NextCS != null): ?>
                                <span class="price-add">
                                    <span>
(<?php echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $p->firstVariant->toCurrency('Price',$NextCSId),'span', 'curr-add', '',  'span', 'price addCurrPrice', '');?>)

                                    </span>
                                </span>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                    <!-- End. Product price-->
                </div>
                <!-- End. Prices-->
                <!-- End. Check variant-->
                <?php if(!$opi_widget && !$opi_defaultItem): ?>
                    <div class="funcs-buttons">
                        <!-- Start. Collect information about Variants, for future processing -->
                        <?php if(is_true_array($variants)){ foreach ($variants as $key => $pv){ ?>
                            <?php $discount = 0?>
                            <?php if($hasDiscounts): ?>
                                <?php $discount = $pv->getvirtual('numDiscount')/$pv->toCurrency()*100?>
                            <?php endif; ?>
                            <?php if($pv->getStock() > 0): ?>
                                <?php $inCart = getAmountInCart('SProducts', $pv->getId())?>
                                <div class="frame-count-buy js-variant-<?php echo $pv->getId()?> js-variant" <?php if($key != 0): ?>style="display:none"<?php endif; ?>>
                                    <form method="POST" action="/shop/cart/addProductByVariantId/<?php echo $pv->getId()?>">
                                        <div class="btn-buy btn-cart<?php if(!$inCart): ?> d_n<?php endif; ?>">
                                            <button 
                                                type="button"
                                                data-id="<?php echo $pv->getId()?>"

                                                class="btnBuy"
                                                >
                                                <span class="icon_cleaner icon_cleaner_buy"></span>
                                                <span class="text-el"><?php echo lang ('В корзине', 'light'); ?></span>
                                            </button>
                                        </div>
                                        <div class="btn-buy<?php if($inCart): ?> d_n<?php endif; ?>">
                                            <button
                                                type="button"

                                                onclick='Shop.Cart.add($(this).closest("form").serialize(), "<?php echo $pv->getId()?>")'
                                                class="btnBuy infoBut"

                                                data-id="<?php echo $pv->getId()?>"
                                                data-name="<?php echo ShopCore::encode($p->getName())?>"
                                                data-vname="<?php echo ShopCore::encode($pv->getName())?>"
                                                data-number="<?php echo $pv->getNumber()?>"
                                                data-price="<?php echo $pv->toCurrency('Price',null,true)?>"
                                                data-add-price="<?php if($NextCS != null): ?><?php echo $pv->toCurrency('Price',$NextCSId,true)?><?php endif; ?>"
                                                data-orig-price="<?php if($hasDiscounts): ?><?php echo $pv->toCurrency('OrigPrice',null,true)?><?php endif; ?>"
                                                data-medium-image="
                                                <?php if(preg_match('/nophoto/', $pv->getMediumPhoto()) > 0): ?>
                                                    <?php echo $p->firstVariant->getMediumPhoto()?>
                                                <?php else:?>
                                                    <?php echo $pv->getMediumPhoto()?>
                                                <?php endif; ?>"
                                                data-img="
                                                <?php if(preg_match('/nophoto/', $pv->getSmallPhoto()) > 0): ?>
                                                    <?php echo $p->firstVariant->getSmallPhoto()?>
                                                <?php else:?>
                                                    <?php echo $pv->getSmallPhoto()?>
                                                <?php endif; ?>"
                                                data-url="<?php echo shop_url('product/'.$p->getUrl())?>"
                                                data-maxcount="<?php echo $pv->getstock()?>"
                                                >
                                                <span class="icon_cleaner icon_cleaner_buy"></span>
                                                <span class="text-el"><?php echo lang ('Купить', 'light'); ?></span>
                                            </button>
                                        </div>
                                        <?php echo form_csrf (); ?>
                                    </form>
                                </div>
                            <?php else:?>
                                <div class="js-variant-<?php echo $pv->getId()?> js-variant" <?php if($key != 0): ?>style="display:none"<?php endif; ?>>
                                    <div class="c_b f-s_12 f-w_b"><?php echo lang ('Нет в наличии', 'light'); ?></div>
                                    <div class="btn-not-avail">
                                        <button
                                            class="infoBut"
                                            type="button"
                                            data-drop=".drop-report"
                                            data-source="/shop/ajax/getNotifyingRequest"

                                            data-id="<?php echo $pv->getId()?>"
                                            data-product-id="<?php echo $p->getId()?>"
                                            data-name="<?php echo ShopCore::encode($p->getName())?>"
                                            data-vname="<?php echo ShopCore::encode($pv->getName())?>"
                                            data-number="<?php echo $pv->getNumber()?>"
                                            data-price="<?php echo $pv->toCurrency('Price',null,true)?>"
                                            data-add-price="<?php if($NextCS != null): ?><?php echo $pv->toCurrency('Price',$NextCSId,true)?><?php endif; ?>"
                                            data-orig-price="<?php if($hasDiscounts): ?><?php echo $pv->toCurrency('OrigPrice',null,true)?><?php endif; ?>"
                                            data-templateprice ="<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $pv->toCurrency('Price',null,true))?>"
                                            data-templatepriceadd ="<?php if($NextCS): ?><?php echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $pv->toCurrency('Price',$NextCSId,true))?><?php endif; ?>"
                                            data-templatepricedisc ="<?php if($hasDiscounts): ?><?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $pv->toCurrency('OrigPrice',null,true))?><?php endif; ?>"
                                            data-medium-image="
                                            <?php if(preg_match('/nophoto/', $pv->getMediumPhoto()) > 0): ?>
                                                <?php echo $p->firstVariant->getMediumPhoto()?>
                                            <?php else:?>
                                                <?php echo $pv->getMediumPhoto()?>
                                            <?php endif; ?>"
                                            data-img="
                                            <?php if(preg_match('/nophoto/', $pv->getSmallPhoto()) > 0): ?>
                                                <?php echo $p->firstVariant->getSmallPhoto()?>
                                            <?php else:?>
                                                <?php echo $pv->getSmallPhoto()?>
                                            <?php endif; ?>"
                                            data-maxcount="<?php echo $pv->getstock()?>"
                                            data-url="<?php echo shop_url('product/'.$p->getUrl())?>"
                                            >
                                            <span class="icon-but"></span>
                                            <span class="text-el d_l_1"><?php echo lang ('Сообщить о появлении','light'); ?></span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php }} ?>
                    </div>
                <?php endif; ?>
                <!-- End. Collect information about Variants, for future processing -->
            </div>
            <!-- Start. Check variant-->
            <div class="left-product-catalog">
                <?php if(!$opi_widget && !$opi_defaultItem && !$opi_compare && !$opi_wishListPage): ?>
                    <?php if(count($variants) > 1): ?>
                        <div class="check-variant-catalog">
                            <span class="s-t"><?php echo lang ('Вариант', 'light'); ?>:</span>
                            <div class="lineForm">
                                <select id="сVariantSwitcher_<?php echo $p->firstVariant->getId()?>" name="variant">
                                    <?php if(is_true_array($variants)){ foreach ($variants as $key => $pv){ ?>
                                        <?php if($pv->getName()): ?>
                                            <?php $name = ShopCore::encode($pv->getName())?>
                                        <?php else:?>
                                            <?php $name = ShopCore::encode($p->getName())?>
                                        <?php endif; ?>
                                        <option value="<?php echo $pv->getId()?>" title="<?php echo $name?>">
                                            <?php echo $name?>
                                        </option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- End. article & variant name & brand name -->
                <?php if(!$opi_vertical): ?>
                    <?php if($p->enable_comments && intval($Comments[$p->getId()]) !== 0): ?>
                        <div class="frame-star f-s_0">
                            <?php $CI->load->module('star_rating')->show_star_rating($p, false)?>
                            <a href="<?php echo shop_url ('product/'.$p->url.'#comment'); ?>" class="count-response">
                                <?php echo lang ("Отзывы",'light'); ?>
                                <?php echo intval ($Comments[$p->getId()]); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(!$opi_widget && !$opi_defaultItem): ?>
                    <div class="frame-without-top">
                        <!-- Wish List & Compare List buttons -->
                        <div class="frame-wish-compare-list no-vis-table">
                            <?php if(!$opi_compare): ?>
                                <div class="frame-btn-comp">
                                    <!-- Start. Compare List button -->
                                    <div class="btn-compare">
                                        <button class="toCompare"
                                                data-id="<?php echo $p->getId()?>"
                                                type="button"
                                                data-title="<?php echo lang ('В список сравнений','light'); ?>"
                                                data-firtitle="<?php echo lang ('В список сравнений','light'); ?>"
                                                data-sectitle="<?php echo lang ('В списке сравнений','light'); ?>"
                                                data-rel="tooltip">
                                            <span class="icon_compare"></span>
                                            <span class="text-el d_l"><?php echo lang ('В список сравнений','light'); ?></span>
                                        </button>
                                    </div>
                                    <!-- End. Compare List button -->
                                </div>
                            <?php endif; ?>
                            <?php if($opi_wishlist): ?>
                                <!-- Start. Wish list buttons -->
                                <?php if(is_true_array($variants)){ foreach ($variants as $key => $pv){ ?>
                                    <div class="frame-btn-wish js-variant-<?php echo $pv->getId()?> js-variant d_i-b_" <?php if($key != 0): ?>style="display:none"<?php endif; ?>>
                                        <?php $CI->load->module('wishlist')->renderWLButton($pv->getId())?>
                                    </div>
                                <?php }} ?>
                                <!-- End. wish list buttons -->
                            <?php endif; ?>
                        </div>
                        <!-- End. Wish List & Compare List buttons -->
                    </div>
                <?php endif; ?>
                <!-- End. Collect information about Variants, for future processing -->
                <?php if(!$opi_widget && !$opi_compare && !$opi_defaultItem && !$opi_wishListPage): ?>
                    <div class="frame-without-top">
                        <div class="no-vis-table">
                            <!--Start. Description-->
                            <?php if($props = ShopCore::app()->SPropertiesRenderer->renderPropertiesInlineNew($p->getId())): ?>
                                <div class="short-desc">
                                    <p><?php echo $props?></p>
                                </div>
                            <?php elseif (trim($p->getShortDescription()) != ''): ?>
                                <div class="short-desc">
                                    <?php echo strip_tags($p->getShortDescription())?>
                                </div>
                            <?php endif; ?>
                            <!-- End. Description-->
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Start. Remove buttons if compare-->
        <?php if($opi_compare && !$opi_widget && !$opi_wishListPage): ?>
            <button type="button" class="icon_times deleteFromCompare" onclick="Shop.CompareList.rm(<?php echo  $p->getId()?>, this)"></button>
        <?php endif; ?>
        <!-- End. Remove buttons if compare-->

        <!-- Start. For wishlist page-->
        <?php if($opi_wishListPage && !$opi_widget): ?>
            <?php $p = $pArray?>
            <?php if(trim($p[comment]) != ''): ?>
                <p>
                    <?php echo $p[comment]; ?>
                </p>
            <?php endif; ?>
            <?php if(!$opi_otherlist): ?>
                <div class="funcs-buttons-WL-item">
                    <div class="btn-remove-item-wl">
                        <button
                            type="button"
                            data-id="<?php echo  $p['variant_id']  ?>"
                            class="btnRemoveItem"

                            data-modal="true"

                            data-drop="#notification"
                            data-effect-on="fadeIn"
                            data-effect-off="fadeOut"
                            data-source="<?php echo site_url ('/wishlist/wishlistApi/deleteItem/'.$p[variant_id].'/'.$p[wish_list_id]); ?>"
                            data-after="WishListFront.removeItem"
                            ><span class="icon_remove"></span><span class="text-el d_l_1"><?php echo lang ('Удалить', 'light'); ?></span></button>
                    </div>
                    <div class="btn-move-item-wl">
                        <button
                            type="button"
                            data-drop="#wishListPopup"
                            data-source="<?php echo site_url ('/wishlist/renderPopup/'.$p[variant_id].'/'.$p[wish_list_id]); ?>"
                            data-always="true"
                            ><span class="icon_move"></span><span class="text-el d_l_1"><?php echo lang ('Переместить', 'light'); ?></span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <!-- End. For wishlist page-->
        <div class="decor-element"></div>
    </li>
<?php }} ?><?php $mabilis_ttl=1432201435; $mabilis_last_modified=1426010500; ///var/www/templates/light/components/TOpi/assets/one_product_item.tpl ?>