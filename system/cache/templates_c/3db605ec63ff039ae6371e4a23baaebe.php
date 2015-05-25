<?php /***
* @file Render shop product;
* @partof main.tpl;
* @updated 26 February 2013;
* Variables
*  $model : PropelObjectCollection of (object) instance of SProducts
*   $model->hasDiscounts() : Check whether the discount on the product.
*   $model->firstVariant : variable which contains the first variant of product;
*   $model->firstVariant->toCurrency() : variable which contains price of product;
*
*/?>
<?php $Comments = $CI->load->module('comments')->init($model)?>
<?php $NextCSIdCond = $NextCS != null?>
<?php $variants = $model->getProductVariants()?>
<?php $sizeAddImg = sizeof($productImages = $model->getSProductImagess())?>
<?php $hasDiscounts = $model->hasDiscounts()?>
<div class="frame-crumbs">
    <!-- Making bread crumbs -->
    <?php echo widget ('path'); ?>
</div>
<div class="frame-inside page-product">
    <div class="container">
        <?php $inCartFV = getAmountInCart('SProducts', $model->firstVariant->getId())?>
        <?php $CI->load->module('banners')->render($model->getId())?>
        <div class="clearfix">
            <div class="frame-left-product">
                <div class="clearfix">
                    <div class="item-product globalFrameProduct<?php if($model->firstVariant->getStock() == 0): ?> not-avail<?php else:?><?php if($inCartFV): ?> in-cart<?php else:?> to-cart<?php endif; ?><?php endif; ?>">
                        <div class="left-product leftProduct">
                            <!-- Start. Photo block-->
                            <a rel="position: 'xBlock'" onclick="return false;" href="<?php echo $model->firstVariant->getLargePhoto()?>" class="frame-photo-title photoProduct cloud-zoom" id="photoProduct" title="<?php echo ShopCore::encode($model->getName())?>" data-drop="#photo" data-start="Product.initDrop" data-scroll-content="false">
                                    <span class="photo-block">
                                        <span class="helper"></span>
                                        <img src="<?php echo $model->firstVariant->getMainPhoto()?>" alt="<?php echo ShopCore::encode($model->getName())?>" title="<?php echo ShopCore::encode($model->getName())?> - <?php echo $model->getId()?>" class="vImgPr"/>
                                        <?php $discount = 0?>
                                        <?php if($hasDiscounts): ?>
                                            <?php $discount = $model->firstVariant->getvirtual('numDiscount')/$model->firstVariant->toCurrency('origprice')*100?>
                                        <?php endif; ?>
                                        <?php echo promoLabel ($model->getAction(), $model->getHot(), $model->getHit(), $discount); ?>
                                    </span>
                            </a>
                            <!-- End. Photo block-->
                            <?php if($sizeAddImg > 0): ?>
                                <!-- Start. additional images-->
                                <div class="horizontal-carousel">
                                    <div class="frame-thumbs carousel-js-css">
                                        <?php /*carousel-js-css*/?>
                                        <div class="content-carousel">
                                            <ul class="items-thumbs items">
                                                <!-- Start. main image-->
                                                <li class="active">
                                                    <a onclick="return false;" rel="useZoom: 'photoProduct'" href="<?php echo $model->firstVariant->getLargePhoto()?>" title="<?php echo ShopCore::encode($model->getName())?>" class="cloud-zoom-gallery" id="mainThumb">
                                                        <span class="photo-block">
                                                            <span class="helper"></span>
                                                            <img src="<?php echo $model->firstVariant->getSmallPhoto()?>" alt="<?php echo ShopCore::encode($model->getName())?>" title="<?php echo ShopCore::encode($model->getName())?>" class="vImgPr"/>
                                                        </span>
                                                    </a>
                                                </li>
                                                <!-- End. main image-->
                                                <?php if(is_true_array($productImages)){ foreach ($productImages as $key => $image){ ?>
                                                    <li>
                                                        <a onclick="return false;" rel="useZoom: 'photoProduct'" href="<?php echo productImageUrl ('products/additional/'.$image->getImageName()); ?>" title="<?php echo ShopCore::encode($model->getName())?>" class="cloud-zoom-gallery">
                                                        <span class="photo-block">
                                                            <span class="helper"></span>
                                                            <img src="<?php echo productImageUrl('products/additional/thumb_'.$image->getImageName())?>" alt="<?php echo ShopCore::encode($model->getName())?> - <?php echo ++$key?>" title="<?php echo ShopCore::encode($model->getName())?> - <?php echo ++$key?>"/>
                                                        </span>
                                                        </a>
                                                    </li>
                                                <?php }} ?>
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
                                <!-- End. additional images-->
                            <?php endif; ?>
                        </div>
                        <div class="right-product-left">
                            <!-- Start. frame for cloudzoom -->
                            <div id="xBlock"></div>
                            <!-- End. frame for cloudzoom -->
                            <div class="f-s_0 title-product">
                                <!-- Start. Name product -->
                                <div class="frame-title">
                                    <h1 class="d_i title"><?php echo  ShopCore::encode($model->getName())?></h1>
                                </div>
                                <!-- End. Name product -->
                            </div>
                            <div class="clearfix">
                                <!-- Start. article & variant name & brand name -->
                                    <span class="frame-variant-name-code f_l">
                                        <span class="frame-variant-code frameVariantCode" <?php if(!$model->firstVariant->getNumber()): ?>style="display:none;"<?php endif; ?>>
                                            <?php echo lang ('Артикул','light'); ?>:
                                            <span class="code js-code">
                                                <?php if($model->firstVariant->getNumber()): ?>
                                                    <?php echo trim ($model->firstVariant->getNumber()); ?>
                                                <?php endif; ?>
                                            </span>
                                        </span>
                                        <span class="frame-variant-name frameVariantName" <?php if(!$model->firstVariant->getName()): ?>style="display:none;"<?php endif; ?>>
                                            <?php echo lang ('Вариант','light'); ?>:
                                            <span class="code js-code">
                                                <?php if($model->firstVariant->getName()): ?>
                                                    <?php echo trim ($model->firstVariant->getName()); ?>
                                                <?php endif; ?>
                                            </span>
                                        </span>
                                    </span>
                                <!-- End. article & variant name & brand name -->
                                <!-- Start. Star rating -->
                                <div class="f_r">
                                    <?php if($model->enable_comments): ?>
                                        <?php if(intval($Comments[$model->getId()]) !== 0): ?>
                                            <div class="frame-star w-s_n-w">
                                                <?php $CI->load->module('star_rating')->show_star_rating($model, false)?>
                                                <div class="d_i-b">
                                                    <button data-trigger="[data-href='#comment']" data-scroll="true" class="count-response d_l_1">
                                                        <?php echo lang ("Отзывы",'light'); ?>
                                                        <?php echo intval ($Comments[$model->getId()]); ?>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php else:?>
                                            <div class="frame-star">
                                                <div class="d_i-b">
                                                    <button data-trigger="[data-href='#comment']" data-scroll="true" class="count-null-response d_l_1"><?php echo lang ('Оставить отзыв','light'); ?></button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <!-- End. Star rating-->
                            </div>
                            <div class="f-s_0 buy-block">
                                <!-- Start. Check variant-->
                                <?php if(count($variants) > 1): ?>
                                    <div class="check-variant-product horizontal-form">
                                        <div class="title"><?php echo lang ('Вариант','light'); ?>:</div>
                                        <div class="lineForm">
                                            <select name="variant" id="variantSwitcher">
                                                <?php if(is_true_array($variants)){ foreach ($variants as $key => $productVariant){ ?>
                                                    <option value="<?php echo $productVariant->getId()?>">
                                                        <?php if($productVariant->getName()): ?>
                                                            <?php echo ShopCore::encode($productVariant->getName())?>
                                                        <?php else:?>
                                                            <?php echo ShopCore::encode($model->getName())?>
                                                        <?php endif; ?>
                                                    </option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <!-- End. Check variant-->
                                <div class="frame-prices-buy-wish-compare">
                                    <div class="frame-prices-buy f-s_0">
                                        <!-- Start. Prices-->
                                        <div class="frame-prices f-s_0">
                                            <!-- Start. Check for discount-->
                                            <?php $oldoprice = $model->getOldPrice() && $model->getOldPrice() != 0 && $model->getOldPrice() > $model->firstVariant->toCurrency()?>
                                            <?php if($hasDiscounts): ?>
                                                <span class="price-discount">
                                                    <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $model->firstVariant->toCurrency('OrigPrice'),'span', 'curr', '',  'span', 'price priceOrigVariant', '')?>

                                                    </span>
                                                </span>
                                            <?php endif; ?>
                                            <!-- End. Check for discount-->
                                            <!-- Start. Check old price-->
                                            <?php if($oldoprice && !$hasDiscounts): ?>
                                                <span class="price-discount">
                                                    <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), intval($model->toCurrency('OldPrice')),'span', 'curr', '',  'span', 'price priceOrigVariant', '')?>

                                                    </span>
                                                </span>
                                            <?php endif; ?>
                                            <!-- End. Check old price-->
                                            <!-- Start. Product price-->
                                            <?php if(is_numeric($model->firstVariant->toCurrency())): ?>
                                                <span class="current-prices f-s_0">
                                                    <span class="price-new">
                                                        <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $model->firstVariant->toCurrency(),'span', 'curr', '',  'span', 'price priceVariant', '')?>

                                                        </span>
                                                    </span>
                                                    <?php if($NextCSIdCond): ?>
                                                        <span class="price-add">
                                                        <span>
(<?php echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $model->firstVariant->toCurrency('Price',$NextCSId),'span', 'curr-add', '',  'span', 'price addCurrPrice', '')?>)

                                                        </span>
                                                    </span>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                            <!-- End. Product price-->
                                        </div>
                                        <!-- End. Prices-->
                                        <div>
                                            <div class="funcs-buttons">
                                                <!-- Start. Collect information about Variants, for future processing -->
                                                <?php if(is_true_array($variants)){ foreach ($variants as $key => $productVariant){ ?>
                                                    <?php $discount = 0?>
                                                    <?php if($hasDiscounts): ?>
                                                        <?php $discount = $productVariant->getvirtual('numDiscount')/$productVariant->toCurrency()*100?>
                                                    <?php endif; ?>
                                                    <?php if($productVariant->getStock() > 0): ?>
                                                        <?php $inCart = getAmountInCart('SProducts', $productVariant->getId())?>
                                                        <div class="frame-count-buy js-variant-<?php echo $productVariant->getId()?> js-variant" <?php if($key != 0): ?>style="display:none"<?php endif; ?>>
                                                            <form method="POST" action="/shop/cart/addProductByVariantId/<?php echo $productVariant->getId()?>">
                                                                <div class="btn-buy-p btn-cart<?php if(!$inCart): ?> d_n<?php endif; ?>">
                                                                    <button
                                                                            type="button"
                                                                            data-id="<?php echo $productVariant->getId()?>"

                                                                            class="btnBuy"
                                                                            >
                                                                        <span class="icon_cleaner icon_cleaner_buy"></span>
                                                                        <span class="text-el"><?php echo lang ('В корзине', 'light'); ?></span>
                                                                    </button>
                                                                </div>
                                                                <div class="btn-buy-p btn-buy<?php if($inCart): ?> d_n<?php endif; ?>">
                                                                    <button
                                                                            type="button"

                                                                            onclick='Shop.Cart.add($(this).closest("form").serialize(), "<?php echo $productVariant->getId()?>")'
                                                                            class="btnBuy infoBut"

                                                                            data-id="<?php echo $productVariant->getId()?>"
                                                                            data-vname="<?php echo ShopCore::encode($productVariant->getName())?>"
                                                                            data-number="<?php echo $productVariant->getNumber()?>"
                                                                            data-price="<?php echo $productVariant->toCurrency('Price',null,true)?>"
                                                                            data-add-price="<?php if($NextCSIdCond): ?><?php echo $productVariant->toCurrency('Price',$NextCSId,true)?><?php endif; ?>"
                                                                            data-orig-price="<?php if($hasDiscounts): ?><?php echo $productVariant->toCurrency('OrigPrice',null,true)?><?php endif; ?>"
                                                                            data-large-image="
                                                            <?php if(preg_match('/nophoto/', $productVariant->getlargePhoto()) > 0): ?>
                                                            <?php echo $model->firstVariant->getlargePhoto()?>
                                                            <?php else:?>
                                                            <?php echo $productVariant->getlargePhoto()?>
                                                            <?php endif; ?>"
                                                                            data-main-image="
                                                            <?php if(preg_match('/nophoto/', $productVariant->getMainPhoto()) > 0): ?>
                                                            <?php echo $model->firstVariant->getMainPhoto()?>
                                                            <?php else:?>
                                                            <?php echo $productVariant->getMainPhoto()?>
                                                            <?php endif; ?>"
                                                                            data-img="
                                                            <?php if(preg_match('/nophoto/', $productVariant->getSmallPhoto()) > 0): ?>
                                                            <?php echo $model->firstVariant->getSmallPhoto()?>
                                                            <?php else:?>
                                                            <?php echo $productVariant->getSmallPhoto()?>
                                                            <?php endif; ?>"
                                                                            data-maxcount="<?php echo $productVariant->getstock()?>"
                                                                            >
                                                                        <span class="icon_cleaner icon_cleaner_buy"></span>
                                                                        <span class="text-el"><?php echo lang ('Купить', 'light'); ?></span>
                                                                    </button>
                                                                </div>
                                                                <?php echo form_csrf (); ?>
                                                            </form>
                                                        </div>
                                                    <?php else:?>
                                                        <div class="d_i-b v-a_m">
                                                            <div class="js-variant-<?php echo $productVariant->getId()?> js-variant" <?php if($key != 0): ?>style="display:none"<?php endif; ?>>
                                                                <div class="c_b f-s_12 f-w_b"><?php echo lang ('Нет в наличии', 'light'); ?></div>
                                                                <div class="btn-not-avail">
                                                                    <button
                                                                            type="button"
                                                                            class="infoBut"
                                                                            data-drop=".drop-report"
                                                                            data-source="/shop/ajax/getNotifyingRequest"

                                                                            data-id="<?php echo $productVariant->getId()?>"
                                                                            data-product-id="<?php echo $model->getId()?>"
                                                                            data-name="<?php echo ShopCore::encode($model->getName())?>"
                                                                            data-vname="<?php echo ShopCore::encode($productVariant->getName())?>"
                                                                            data-number="<?php echo $productVariant->getNumber()?>"
                                                                            data-price="<?php echo $productVariant->toCurrency('Price',null,true)?>"
                                                                            data-add-price="<?php if($NextCSIdCond): ?><?php echo $productVariant->toCurrency('Price',$NextCSId,true)?><?php endif; ?>"
                                                                            data-orig-price="<?php if($hasDiscounts): ?><?php echo $productVariant->toCurrency('OrigPrice',null,true)?><?php endif; ?>"
                                                                            data-templateprice ="<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $productVariant->toCurrency('Price',null,true))?>"
                                                                            data-templatepriceadd ="<?php if($NextCSIdCond): ?><?php echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $productVariant->toCurrency('Price',$NextCSId,true))?><?php endif; ?>"
                                                                            data-templatepricedisc ="<?php if($hasDiscounts): ?><?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $productVariant->toCurrency('OrigPrice',null,true))?><?php endif; ?>"
                                                                            data-large-image="
                                                        <?php if(preg_match('/nophoto/', $productVariant->getlargePhoto()) > 0): ?>
                                                        <?php echo $model->firstVariant->getlargePhoto()?>
                                                        <?php else:?>
                                                        <?php echo $productVariant->getlargePhoto()?>
                                                        <?php endif; ?>"
                                                                            data-main-image="
                                                        <?php if(preg_match('/nophoto/', $productVariant->getMainPhoto()) > 0): ?>
                                                        <?php echo $model->firstVariant->getMainPhoto()?>
                                                        <?php else:?>
                                                        <?php echo $productVariant->getMainPhoto()?>
                                                        <?php endif; ?>"
                                                                            data-img="
                                                        <?php if(preg_match('/nophoto/', $productVariant->getSmallPhoto()) > 0): ?>
                                                        <?php echo $model->firstVariant->getSmallPhoto()?>
                                                        <?php else:?>
                                                        <?php echo $productVariant->getSmallPhoto()?>
                                                        <?php endif; ?>"
                                                                            data-maxcount="<?php echo $productVariant->getstock()?>"
                                                                            data-url="<?php echo shop_url('product/'.$model->getUrl())?>"
                                                                            >
                                                                        <span class="icon-but"></span>
                                                                        <span class="text-el d_l_1"><?php echo lang ('Сообщить о появлении','light'); ?></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php }} ?>
                                            </div>
                                            <!-- End. Collect information about Variants, for future processing -->
                                        </div>
                                    </div>
                                    <!-- Start. Wish List & Compare List buttons -->
                                    <div class="frame-wish-compare-list f-s_0">
                                        <div class="frame-btn-comp">
                                            <div class="btn-compare">
                                                <button class="toCompare"
                                                        data-id="<?php echo $model->getId()?>"
                                                        type="button"
                                                        data-title="<?php echo lang ('К сравнению','light'); ?>"
                                                        data-firtitle="<?php echo lang ('К сравнению','light'); ?>"
                                                        data-sectitle="<?php echo lang ('В сравнении','light'); ?>"
                                                        data-rel="tooltip">
                                                    <span class="icon_compare"></span>
                                                    <span class="text-el d_l"><?php echo lang ('К сравнению','light'); ?></span>
                                                </button>
                                            </div>
                                        </div>
                                        <?php if(is_true_array($variants)){ foreach ($variants as $key => $pv){ ?>
                                            <div class="frame-btn-wish js-variant-<?php echo $pv->getId()?> js-variant" <?php if($key != 0): ?>style="display:none"<?php endif; ?> data-id="<?php echo $pv->getId()?>">
                                                <?php $CI->load->module('wishlist')->renderWLButton($pv->getId())?>
                                            </div>
                                        <?php }} ?>
                                    </div>
                                    <!-- End. Wish List & Compare List buttons -->
                                </div>
                            </div>
                            <!-- Start. Description -->
                            <?php if(trim($model->getShortDescription()) != ''): ?>
                                <div class="short-desc">
                                    <?php echo $model->getShortDescription()?>
                                </div>
                            <?php elseif ($props = ShopCore::app()->SPropertiesRenderer->renderPropertiesInlineNew($model->getId())): ?>
                                <div class="short-desc">
                                    <p><?php echo $props?></p>
                                </div>
                            <?php endif; ?>
                            <!--  End. Description -->
                        </div>
                    </div>
                </div>
                <!-- Start. Kit-->
                <?php if($model->getShopKits()): ?>
                    <div class="horizontal-carousel">
                        <section class="frame-complect special-proposition">
                            <div class="frame-title">
                                <div class="title"><?php echo lang ('В комплекте дешевле','light'); ?></div>
                            </div>
                            <div class="carousel-js-css items-carousel complects-carousel">
                                <div class="content-carousel">
                                    <ul class="items-complect items">
                                        <?php if(is_true_array($model->getShopKitsLoggedUsersCheck($CI->dx_auth->is_logged_in()))){ foreach ($model->getShopKitsLoggedUsersCheck($CI->dx_auth->is_logged_in()) as $key => $kitProducts){ ?>
                                            <?php $inCart = getAmountInCart('ShopKit', $kitProducts->getId())?>
                                            <li class="globalFrameProduct<?php if($inCart): ?> in-cart<?php else:?> to-cart<?php endif; ?>">
                                                <ul class="items items-bask row-kits rowKits">
                                                    <!-- main product -->
                                                    <li>
                                                        <div class="frame-kit main-product">
                                                            <div class="frame-photo-title">
                                            <span class="photo-block">
                                                <span class="helper"></span>
                                                <img src="<?php echo $kitProducts->getMainProduct()->firstVariant->getSmallPhoto()?>" alt="<?php echo ShopCore::encode($kitProducts->getMainProduct()->getName())?>" title="<?php echo ShopCore::encode($kitProducts->getMainProduct()->getName())?>"/>
                                                <?php echo promoLabel ($kitProducts->getSProducts()->getAction(), $kitProducts->getSProducts()->getHot(), $kitProducts->getSProducts()->getHit(), 0); ?>
                                            </span>
                                                                <span class="title"><?php echo ShopCore::encode($model->getName())?></span>
                                                            </div>
                                                            <div class="description">
                                                                <div class="frame-prices f-s_0">
                                                                    <!-- Start. Product price-->
                                                <span class="current-prices f-s_0">
                                                    <span class="price-new">
                                                        <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $kitProducts->getMainProductPrice(),'span', 'curr', '',  'span', 'price priceVariant', '')?>

                                                        </span>
                                                    </span>
                                                    <?php if($NextCSIdCond): ?>
                                                        <span class="price-add">
                                                        <span>

(<?php echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $kitProducts->getMainProductPrice($NextCSId),'span', 'curr-add', '',  'span', 'price addCurrPrice', '')?>)

                                                            <span class="curr-add"><?php if(isset($NextCS)){ echo $NextCS; } ?></span>)
                                                        </span>
                                                    </span>
                                                    <?php endif; ?>
                                                </span>
                                                                    <!-- End. Product price-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- /end main product -->
                                                    <?php if(is_true_array($kitProducts->getShopKitProducts())){ foreach ($kitProducts->getShopKitProducts() as $key => $kitProduct){ ?>
                                                        <!-- additional product -->
                                                        <li>
                                                            <div class="next-kit">+</div>
                                                            <div class="frame-kit">
                                                                <a href="<?php echo shop_url ('product/' . $kitProduct->getSProducts()->getUrl()); ?>" class="frame-photo-title">
                                            <span class="photo-block">
                                                <span class="helper"></span>
                                                <img src="<?php echo $kitProduct->getSProducts()->firstVariant->getSmallPhoto()?>" alt="<?php echo ShopCore::encode($kitProduct->getSProducts()->getName())?>" title="<?php echo ShopCore::encode($kitProduct->getSProducts()->getName())?>"/>

                                                <?php $discount = $kitProduct->getDiscount()?>

                                                <?php echo promoLabel ($kitProduct->getSProducts()->getAction(), $kitProduct->getSProducts()->getHot(), $kitProduct->getSProducts()->getHit(), $discount); ?>
                                            </span>
                                                                    <span class="title"><?php echo ShopCore::encode($kitProduct->getSProducts()->getName())?></span>
                                                                </a>
                                                                <div class="description">
                                                                    <div class="frame-prices f-s_0">
                                                                        <!-- Check for discount-->
                                                                        <?php if($kitProduct->getDiscount()): ?>
                                                                            <span class="price-discount">
                                                    <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $kitProduct->getKitProductPrice(),'span', 'curr', '',  'span', 'price priceOrigVariant', '')?>

                                                    </span>
                                                </span>
                                                                        <?php endif; ?>
                                                                        <!-- Start. Product price-->

                                                <span class="current-prices f-s_0">
                                                    <span class="price-new">
                                                        <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $kitProduct->getKitNewPrice(),'span', 'curr', '',  'span', 'price priceVariant', '')?>

                                                        </span>
                                                    </span>
                                                    <?php if($NextCSIdCond): ?>
                                                        <span class="price-add">
                                                        <span>
(<?php echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $kitProduct->getKitNewPrice($NextCSId),'span', 'curr-add', '',  'span', 'price addCurrPrice', '')?>)

                                                        </span>
                                                    </span>
                                                    <?php endif; ?>
                                                </span>

                                                                        <!-- End. Product price-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <!-- /additional product -->
                                                    <?php }} ?>
                                                </ul>
                                                <!-- total -->
                                                <div class="complect-gen-sum">
                                                    <div class="gen-sum-kit">=</div>
                                                    <div class="frame-gen-price-buy-complect">
                                                        <div class="frame-prices f-s_0">
                                        <span class="price-discount">
                                            <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $kitProducts->getTotalPriceOld(),'span', 'curr', '',  'span', 'price', '')?>

                                            </span>
                                        </span>
                                        <span class="current-prices f-s_0">
                                            <span class="price-new">
                                                <span>
<?php echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $kitProducts->getTotalPrice(),'span', 'curr', '',  'span', 'price', '')?>

                                                </span>
                                            </span>
                                            <?php if($NextCSIdCond): ?>
                                                <span class="price-add">
                                                <span>
(<?php echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $kitProducts->getTotalPrice($NextCSId),'span', 'curr-add', '',  'span', 'price ', '')?>)

                                                </span>
                                            </span>
                                            <?php endif; ?>
                                        </span>
                                                        </div>
                                                        <form method="POST" action="/shop/cart/addKit/<?php echo $kitProducts->getId()?>">
                                                            <div class="btn-buy-p btn-cart<?php if(!$inCart): ?> d_n<?php endif; ?>">
                                                                <button
                                                                        type="button"
                                                                        data-id="<?php echo $kitProducts->getId()?>"

                                                                        class="btnBuy infoBut btnBuyKit"
                                                                        >
                                                                    <span class="icon_cleaner icon_cleaner_buy"></span>
                                                                    <span class="text-el"><?php echo lang ('В корзине', 'light'); ?></span>
                                                                </button>
                                                            </div>
                                                            <div class="btn-buy-p btn-buy<?php if($inCart): ?> d_n<?php endif; ?>">
                                                                <button
                                                                        type="button"
                                                                        data-id="<?php echo $kitProducts->getId()?>"

                                                                        onclick='Shop.Cart.add($(this).closest("form").serialize(), "<?php echo $kitProducts->getId()?>", true)'
                                                                        class="btnBuy infoBut btnBuyKit"
                                                                        >
                                                                    <span class="icon_cleaner icon_cleaner_buy"></span>
                                                                    <span class="text-el"><?php echo lang ('Купить', 'light'); ?></span>
                                                                </button>
                                                            </div>
                                                            <?php echo form_csrf (); ?>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /total -->
                                            </li>
                                        <?php }} ?>
                                    </ul>
                                </div>
                                <!-- Start. Buttons for next/prev kit-->
                                <div class="group-button-carousel">
                                    <button type="button" class="prev arrow">
                                        <span class="icon_arrow_p"></span>
                                    </button>
                                    <button type="button" class="next arrow">
                                        <span class="icon_arrow_n"></span>
                                    </button>
                                </div>
                                <!-- Start. Buttons for next/prev kit-->
                            </div>
                        </section>
                    </div>
                <?php endif; ?>
                <!-- End. Kits-->
                <!-- Start. Tabs block-->
                <div class="f-s_0">
                    <ul class="tabs tabs-data tabs-product">
                        <?php $dl_properties = ShopCore::app()->SPropertiesRenderer->renderPropertiesTableNew($model->getId())?>
                        <?php $fullDescription = $model->getFullDescription()?>
                        <?php if($dl_properties && $fullDescription != '' && $accessories): ?>
                            <li class="active">
                                <button data-href="#view"><?php echo lang ('Обзор','light'); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if($dl_properties): ?>
                            <li><button data-href="#first" data-source="<?php echo shop_url ('product_api/renderProperties'); ?>" data-data='{"product_id": <?php echo $model->getId()?>}' data-selector=".characteristic"><?php echo lang ('Свойства','light'); ?></button></li>
                        <?php endif; ?>
                        <?php if($fullDescription): ?>
                            <li><button data-href="#second" data-source="<?php echo shop_url ('product_api/renderFullDescription'); ?>" data-data='{"product_id": <?php echo $model->getId()?>}' data-selector=".inside-padd > .text"><?php echo lang ('Полное описание','light'); ?></button></li>
                        <?php endif; ?>
                        <?php if($accessories): ?>
                            <li><button data-href="#fourth" data-source="<?php echo shop_url ('product_api/getAccessories'); ?>" data-data='{"product_id": <?php echo $model->getId()?>, "arrayVars": <?php echo json_encode (array('opi_defaultItem'=>true)); ?>}' data-selector=".inside-padd > .items"><?php echo lang ('Аксессуары','light'); ?></button></li>
                        <?php endif; ?>
                        <!--Output of the block comments-->
                        <?php if($Comments && $model->enable_comments): ?>
                            <li>
                                <button type="button" data-href="#comment" onclick="Comments.renderPosts($('#comment .inside-padd'),{'visibleMainForm': '1'})">
                                    <span class="icon_comment-tab"></span>
                <span class="text-el">
                    <?php echo lang ("Отзывы",'light'); ?>
                    <span id="cc">
                        (<?php echo intval($Comments[$model->getId()])?>)
                    </span>
                </span>
                                </button>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="frame-tabs-ref frame-tabs-product">
                        <?php if($dl_properties && $fullDescription != '' && $accessories): ?>
                            <div id="view">
                                <?php if($dl_properties): ?>
                                    <div class="inside-padd">
                                        <h2><?php echo lang ('Характеристики','light'); ?></h2>
                                        <div class="characteristic">
                                            <div class="product-charac patch-product-view">
                                                <?php echo $dl_properties?>
                                            </div>
                                            <button class="f-s_0 d_n_ d_l_1" data-trigger="[data-href='#first']" data-scroll="true">
                                                <span class="text-el"><?php echo lang ('Просмотреть все спецификации','light'); ?></span>
                                            </button>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <?php if($fullDescription != ''): ?>
                                    <div class="inside-padd">
                                        <!--                        Start. Description block-->
                                        <div class="product-descr patch-product-view">
                                            <div class="text">
                                                <div class="title-h2"><?php echo lang ('Описание' , 'light'); ?></div>
                                                <h2><?php echo  ShopCore::encode($model->getName())?></h2>
                                                <?php echo $fullDescription?>
                                            </div>
                                        </div>
                                        <button class="f-s_0 d_n_ d_l_1" data-trigger="[data-href='#second']" data-scroll="true">
                                            <span class="text-el"><?php echo lang ('Полное описание','light'); ?></span>
                                        </button>
                                        <!--                        End. Description block-->
                                    </div>

                                <?php endif; ?>

                                <?php if($accessories): ?>
                                    <div class="accessories">
                                        <div class="title-default">
                                            <div class="title">
                                                <h2 class="d_i"><?php echo lang ('С этим товаром покупают','light'); ?></h2>
                                                <?php if(count($accessories) > 3): ?>
                                                    <button class="f-s_0 ref s-all-marg d_l_1" data-trigger="[data-href='#fourth']" data-scroll="true">
                                                        <span class="text-el"><?php echo lang ('Все аксессуары','light'); ?></span>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="inside-padd">
                                            <ul class="items items-default">
                                                <?php echo getOPI ($accessories, array('opi_defaultItem'=>true, 'opi_limit'=>3)); ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="inside-padd">
                                    <!--Start. Comments block-->
                                    <div class="frame-form-comment">
                                        <?php $c=$CI->load->module('comments/commentsapi')->renderAsArray($CI->uri->uri_string())?>
                                        <div class="forComments p_r">
                                            <?php if(intval($c['commentsCount']) > 0): ?>
                                                <?php echo $c['comments']?>
                                            <?php endif; ?>
                                        </div>
                                        <!--End. Comments block-->
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($dl_properties): ?>
                            <!--             Start. Characteristic-->
                            <div id="first">
                                <div class="inside-padd">
                                    <div class="title-h2"><?php echo lang ('Свойства', 'light'); ?></div>
                                    <div class="characteristic">
                                        <div class="preloader"></div>
                                    </div>
                                </div>
                            </div>
                            <!--                    End. Characteristic-->
                        <?php endif; ?>
                        <?php if($fullDescription): ?>
                            <div id="second">
                                <div class="inside-padd">
                                    <div class="title-h2"><?php echo lang ('Описание' , 'light'); ?></div>
                                    <div class="text">
                                        <div class="preloader"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div id="comment">
                            <div class="inside-padd forComments p_r">
                                <div class="preloader"></div>
                            </div>
                        </div>
                        <!--Block Accessories Start-->
                        <?php if($accessories): ?>
                            <div id="fourth" class="accessories">
                                <div class="inside-padd">
                                    <h2 class="m-b_30"><?php echo lang ('С этим товаром покупают','light'); ?></h2>
                                    <ul class="items items-default">
                                        <div class="preloader"></div>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--End. Block Accessories-->
                    </div>
                </div>
                <!-- End. Tabs block-->
            </div>
            <div class="right-product">
                <div class="right-product-right">
                    <?php echo widget ('payments_delivery_methods_info'); ?>
                    <div class="right-social">
                        <div class="vertical-carousel similar-product">
                            <section class="special-proposition">
                                <div class="frame-title">
                                    <div class="title">
                                        <span class="text-el text-proposition-v"><?php echo lang ('Понравился товар?','light'); ?></span>
                                    </div>
                                </div>
                                <div class="inside-padd">
                                    <!--Start .Share-->
                                    <dl class="social-product">
                                        <dd class="social-like">
                                            <?php echo $CI->load->module('share')->_make_like_buttons()?>
                                        </dd>
                                        <dd class="social-tell d_i-b">
                                            <span class="text-el d_i-b v-a_m"><?php echo lang ('Поделитесь','light'); ?></span>
                                            <div class="d_i-b v-a_m">
                                                <?php echo $CI->load->module('share')->_make_share_form()?>
                                            </div>
                                        </dd>
                                    </dl>
                                    <!-- End. Share -->
                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- Start. Similar Products-->
                    <?php echo widget ('similar'); ?>
                    <!-- End. Similar Products-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!-- Start. News-->
    <?php echo widget ('latest_news'); ?>
    <!-- End. News-->
</div>

<!-- Start. Photo Popup Frame-->
<div class="drop drop-style globalFrameProduct" id="photo"></div>
<script type="text/template" id="framePhotoProduct">
        <button type="button" class="icon_times_drop" data-closed="closed-js"></button>
        <div class="drop-header">
            <div class="title"><%- obj.title %></div>
            <div class="horizontal-carousel">
                <div class="frame-fancy-gallery frame-thumbs">
                    <div class="fancy-gallery carousel-js-css">
                        <div class="content-carousel">
                            <ul class="items-thumbs items">
                                <%= obj.frame.find(obj.galleryContent).html() %>
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
            </div>
        </div>
        <div class="drop-content">
            <div class="inside-padd p_r">
                <span class="helper"></span>
                <img src="<%- obj.mainPhoto %>" alt="<%- obj.title %>"/>
            </div>
            <div class="horizontal-carousel">
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
        <div class="drop-footer">
            <div class="inside-padd">
                <%= obj.frame.find(obj.footerContent).html()%>
            </div>
        </div>
    
</script>
<!-- End. Photo Popup Frame-->

<!-- Start. JS vars-->
<script type="text/javascript">
    var hrefCategoryProduct = "<?php if(isset($category_url)){ echo $category_url; } ?>";
</script>
    <script type="text/javascript">
        var productPhotoDrop = true;
        if (!isTouch)
            var productPhotoCZoom = true;
    </script>

<!-- End. JS vars-->

<script type="text/javascript">
    initDownloadScripts(['cusel-min-2.5', 'cloud-zoom.1.0.3.min', 'product'], 'initPhotoTrEv', 'initPhotoTrEv');
</script>
<div style="display: none;">
    <img src="<?php echo $model->firstVariant->getLargePhoto()?>" alt="<?php echo ShopCore::encode($model->getName())?>" class="vImgPr"/>
    <?php if(is_true_array($productImages)){ foreach ($productImages as $key => $image){ ?>
        <img src="<?php echo productImageUrl ('products/additional/'.$image->getImageName()); ?>" alt="<?php echo ShopCore::encode($model->getName())?> - <?php echo ++$key?>"/>
    <?php }} ?>
</div><?php $mabilis_ttl=1432206593; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/product.tpl ?>