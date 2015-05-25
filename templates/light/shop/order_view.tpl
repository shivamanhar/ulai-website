{#
    /**
    * @file Template. Displaying order view page;
    * @partof main.tpl;
    * Variables
    *   $model : (object) instance of SOrders;
    *    $model->getId() : return Order ID;
    *    $model->getPaid() : return Order paid status;
    *    $model->getSDeliveryMethods()->getName() : get Delivery method name;
    *    $model->getOrderProducts() : return Ordered products list;
    *    $model->getOrderKits() : return Ordered Kits list;
    *    $model->getTotalPrice() : get aggregate ordered Products Price;
    *    $model->getDeliveryPrice() : return delivery Price;
    *    $model->getTotalPriceWithDelivery() : sum of Product and Delivery Prices;
    *    $model->getTotalPriceWithGift() : difference of previous price (getTotalPriceWithDelivery) and gift certificate price;
    * @updated 27 January 2013;
    */
    #}
    {$NextCSIdCond = $NextCS != null}
    <div class="frame-inside page-order">
        <div class="container">
            {if $CI->session->flashdata('makeOrderForTpl') === TRUE}
            <div class="f-s_0 without-crumbs">
                <div class="frame-title">
                    {echo $answerNotification }
                </div>
            </div>
            {/if}
            <div class="f-s_0 title-order-view without-crumbs">
                <div class="frame-title">
                    <h1 class="title">{lang('Заказ №','light')}:<span class="number-order">{echo $model->getId()}</span></h1>
                </div>
            </div>

            <!-- Start. Displays a information block about Order -->
            <div class="left-order">
                <!--                Start. User info block-->
                <table class="table-info-order">
                    <colgroup>
                    <col width="120"/>
                </colgroup>
                <tr>
                    <th>{lang('Имя получателя','light')}:</th>
                    <td>{echo $model->getUserFullName()}</td>
                </tr>
                {if $model->getUserPhone()}
                <tr>
                    <th>{lang('Телефон','light')}:</th>
                    <td>{echo $model->getUserPhone()}</td>
                </tr>
                {/if}
                <tr>
                    <th>E-mail:</th>
                    <td>{echo $model->getUserEmail()}</td>
                </tr>
                {if $model->getDeliveryMethod()}
                <tr>
                    <td colspan="2">
                        <hr/>
                    </td>
                </tr>
                <!-- Start. Delivery Method name -->
                <tr>
                    <th>{lang('Способ доставки','light')}:</th>
                    <td>
                        {if $model->getDeliveryMethod() > 0}
                        {echo $model->getSDeliveryMethods()->getName()}
                        {/if}
                    </td>
                </tr>
                {/if}
                <!-- End. Delivery Method name -->

                {if $model->getUserDeliverTo()}
                <tr>
                    <th>{lang('Адрес','light')}:</th>
                    <td>{echo $model->getUserDeliverTo()}</td>
                </tr>
                {/if}
                {if $model->getUserComment()}
                <tr>
                    <th>{lang('Комментарий','light')}:</th>
                    <td>{echo $model->getUserComment()}</td>
                </tr>
                {/if}

                {foreach ShopCore::app()->CustomFieldsHelper->getCustomFielsdAsArray('order', $model->getId()) as $cf}
                <tr>
                    <th>{$cf.field_label}:</th>
                    <td>{$cf.field_data}</td>
                </tr>
                {/foreach}

                {$fields = ShopCore::app()->CustomFieldsHelper->getCustomFielsdAsArray('order',$profile.id,'user')}
                <!--                End. User info block-->
                <tr>
                    <td colspan="2">
                        <hr/>
                    </td>
                </tr>
                <tr>
                    <th>{lang('Дата заказа','light')}:</th>
                    <td>{date('d.m.Y, H:i:s.',$model->getDateCreated())} </td>
                </tr>

                <!-- Start. Render payment button and payment description -->
                {if $paymentMethod}
                <tr>
                    <th>{lang('Способ оплаты','light')}:</th>
                    <td>
                        {if $paymentMethod->getName()}
                        {echo ShopCore::t($paymentMethod->getName())}
                        {/if}
                    </td>
                </tr>
                {/if}
                <!--                Start. Order status-->
                <tr>
                    <th>{lang('Статус оплаты','light')}:</th>
                    <td>
                        {if $model->getPaid() == true}
                        <span class="status-pay paid">{lang('Оплачен','light')}</span>
                        {else:}
                        <span class="status-pay not-paid">{lang('Не оплачен','light')}</span>
                        {/if}
                    </td>
                </tr>
                <!--                End. Order status-->
                {if $paymentMethod && $model->getPaid() != true}
                <tr>
                    <td></td>
                    <td>
                        <div class="frame-payment">
                            {$locale = \MY_Controller::getCurrentLocale();}
                            {/*$notif = $CI->db->where('locale', $locale)->where('name','callback')->get('answer_notifications')->row()*/}
                            {/*echo $notif->message*/}
                            {echo $paymentMethod->getPaymentForm($model)}
                        </div>
                    </td>
                </tr>
                {/if}
                <!-- End. Render payment button and payment description -->
            </table>
        </div>
        <!-- End. Displays a information block about Order -->
        <div class="right-order">
            <div class="frame-bask frame-bask-order">
                <div class="frame-bask-scroll">
                    <div class="inside-padd">
                        <div class="frame-title clearfix">
                            <div class="title f_l">{lang('Мой заказ', 'light')}</div>
                        </div>
                        <table class="table-order table-order-view">
                            <colgroup>
                            <col/>
                            <col width="120"/>
                        </colgroup>
                        <thead>
                            <tr>
                                <th>{lang('Товар', 'light')}</th>
                                <th>{lang('Кол-во', 'light')}</th>
                                <th>{lang('Cумма', 'light')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- for single product -->
                            {foreach $model->getOrderProducts() as $orderProduct}
                            {foreach $orderProduct->getSProducts()->getProductVariants() as $v}
                            {if $v->getid() == $orderProduct->variant_id}
                            {$Variant = $v}
                            {break;}
                            {/if}
                            {/foreach}
                            <tr class="items items-bask items-order cart-product">
                                <td class="frame-items">
                                    <!-- Start. Render Ordered Products -->
                                    <a href="{shop_url('product/'.$orderProduct->getSProducts()->getUrl())}" class="frame-photo-title">
                                        <span class="photo-block">
                                            <span class="helper"></span>
                                            <img alt="{echo ShopCore::encode($orderProduct->product_name)}" src="{echo $Variant->getSmallPhoto()}">
                                        </span>
                                        <span class="title">{echo ShopCore::encode($orderProduct->product_name)}</span>
                                    </a>
                                    <div class="description">
                                        <span class="frame-variant-name-code">
                                            {if trim(ShopCore::encode($orderProduct->variant_name) != '')}<span class="frame-variant-name frameVariantName">{lang("Вариант",'light')}: <span class="code js-code">{echo ShopCore::encode($orderProduct->variant_name)}</span></span>{/if}
                                            {if trim(ShopCore::encode($Variant->getNumber()) != '')}<span class="frame-variant-code frameVariantCode">{lang("Артикул",'light')}: <span class="code js-code">{echo ShopCore::encode($Variant->getNumber())}</span></span>{/if}
                                        </span>
                                        {/*}
                                        <span class="frame-prices">
                                            <span class="current-prices f-s_0">
                                                <span class="price-new">
                                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $orderProduct->getPrice(),'span', 'curr', '',  'span', 'price', '');}

                                                    </span>
                                                </span>
                                                {if $NextCSIdCond}
                                                <span class="price-add">
                                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, ShopCore::app()->SCurrencyHelper->convert($orderProduct->getPrice(), $NextCSId),'span', 'curr-add', '',  'span', 'price', '');}

                                                    </span>
                                                </span>
                                                {/if}
                                            </span>
                                        </span>
                                        { */}
                                    </div>
                                </td>
                                <td>
                                    <span class="plus-minus">{echo $orderProduct->getQuantity()}</span>
                                    <span class="text-el">{lang('шт','light')}.</span>
                                </td>
                                <td class="frame-cur-sum-price">
                                    <span class="frame-prices">
                                        <span class="current-prices f-s_0">
                                            <span class="price-new">
                                                <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $orderProduct->getPrice()*$orderProduct->getQuantity(),'span', 'curr', '',  'span', 'price', '');}

                                                </span>
                                            </span>
                                            {/*}
                                            {if $NextCSIdCond}
                                            <span class="price-add">
                                                <span>
{echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, ShopCore::app()->SCurrencyHelper->convert($orderProduct->getPrice(), $NextCSId)*$orderProduct->getQuantity($NextCSId),'span', 'curr-add', '',  'span', 'price', '');}

                                                </span>
                                            </span>
                                            {/if}
                                            { */}
                                        </span>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        {/foreach}
                        <!-- end for single product -->
                        <!-- Start. Render Ordered kit products  -->
                        {foreach $model->getOrderKits() as $orderProduct}
                        <tr class="row-kits rowKits items-order row">
                            <td class="frame-items frame-items-kit">
                                <div class="title-h3 c_9">{lang('Комплект товаров', 'light')}</div>
                                <ul class="items items-bask">
                                    <li>
                                        <div class="frame-kit main-product">
                                            <a href="{shop_url('product/' . $orderProduct->getKit()->getMainProduct()->getUrl())}" class="frame-photo-title">
                                                <span class="photo-block">
                                                    <span class="helper"></span>
                                                    <img src="{echo $orderProduct->getKit()->getMainProduct()->firstVariant->getSmallPhoto()}"
                                                    alt="{echo ShopCore::encode($orderProduct->getKit()->getMainProduct()->getName())}"/>
                                                </span>
                                                <span class="title">{echo ShopCore::encode($orderProduct->getKit()->getMainProduct()->getName())}</span>
                                            </a>
                                            <div class="description">
                                                {/*}
                                                <div class="frame-prices">
                                                    <span class="current-prices">
                                                        <span class="price-new">
                                                            <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $orderProduct->getKit()->getMainProductPrice(),'span', 'curr', '',  'span', 'price', '');}

                                                            </span>
                                                        </span>
                                                        {if $NextCSIdCond}
                                                        <span class="price-add">
                                                            <span>
{echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $orderProduct->getKit()->getMainProductPrice($NextCSId),'span', 'curr', '',  'span', 'price', '');}

                                                            </span>
                                                        </span>
                                                        {/if}
                                                    </span>
                                                </div>
                                                { */}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                {foreach $orderProduct->getKit()->getShopKitProducts() as $key => $kitProducts}
                                <li>
                                    <div class="next-kit">+</div>
                                    <div class="frame-kit">
                                        <a href="{shop_url('product/' . $kitProducts->getSProducts()->getUrl())}" class="frame-photo-title">
                                            <span class="photo-block">
                                                <span class="helper"></span>
                                                <img src="{echo $kitProducts->getSProducts()->firstVariant->getSmallPhoto()}"
                                                alt="{echo ShopCore::encode($kitProducts->getSProducts()->getName())}"/>
                                            </span>
                                            <span class="title">{echo ShopCore::encode($kitProducts->getSProducts()->getName())}</span>
                                        </a>
                                        <div class="description">
                                            {/*}
                                            <div class="frame-prices">
                                                {if $kitProducts->getDiscount()}
                                                <span class="price-discount">
                                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $kitProducts->getKitProductPrice(),'span', 'curr', '',  'span', 'price priceOrigVariant', '');}

                                                    </span>
                                                </span>
                                                {/if}
                                                <span class="current-prices">
                                                    <span class="price-new">
                                                        <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $kitProducts->getKitNewPrice(),'span', 'curr', '',  'span', 'price', '');}

                                                        </span>
                                                    </span>
                                                    {if $NextCSIdCond}
                                                    <span class="price-add">
                                                        <span>
{echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $kitProducts->getKitNewPrice($NextCSId),'span', 'curr', '',  'span', 'price', '');}

                                                        </span>
                                                    </span>
                                                    {/if}
                                                </span>
                                            </div>
                                            { */}
                                        </div>
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
                        </td>
                        <td>
                            <span class="plus-minus">{echo $orderProduct->getQuantity()}</span>
                            <span class="text-el">{lang('шт','light')}.</span>
                        </td>
                        <td class="frame-cur-sum-price">
                            <span class="frame-prices">
                                <span class="price-discount">
                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $orderProduct->getKit()->getTotalPriceOld()*$orderProduct->getQuantity(),'span', 'curr', '',  'span', 'price', '');}

                                    </span>
                                </span>
                                <span class="current-prices f-s_0">
                                    <span class="price-new">
                                        <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $orderProduct->getKit()->getTotalPrice()*$orderProduct->getQuantity(),'span', 'curr', '',  'span', 'price', '');}

                                        </span>
                                    </span>
                                    {/*}
                                    {if $NextCSIdCond}
                                    <span class="price-add">
                                        <span>
{echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $orderProduct->getKit()->getTotalPrice($NextCSId)*$orderProduct->getQuantity($NextCSId),'span', 'curr-add', '',  'span', 'price', '');}

                                        </span>
                                    </span>
                                    {/if}
                                    { */}
                                </span>
                            </span>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
                <tfoot class="gen-info-price">
                    {$cartPrice = $model->gettotalprice()}
                    {$discount = ShopCore::app()->SCurrencyHelper->convert($model->getdiscount())}

                    {if $discount}
                    <tr>
                        <td colspan="3">
                            <span class="s-t f_l">{lang('Начальная стоимость товаров','light')}</span>
                            <span class="price-new f_r">
                                <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($model->getOriginPrice()),'span', 'curr f-s_12', '',  'span', 'price f-s_12', '');}

                                </span>
                            </span>
                        </td>
                    </tr>
                    {/if}
                    <tr>
                        <td colspan="3">
                            <span class="s-t f_l">{lang('Cтоимость товаров','light')}</span>
                            <div class="frame-cur-sum-price f_r">
                                <span class="price-new">
                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($model->gettotalprice()),'span', 'curr', '',  'span', 'price', '');}

                                    </span>
                                </span>
                            </div>
                        </td>
                    </tr>
                    {$deliveryMethod = $model->getSDeliveryMethods()}
                    {if $deliveryMethod}
                    <tr>
                        <td colspan="3">
                            <span class="s-t f_l">{lang('Доставка','light')}:</span>
                            <div class="f_r">
                                {if !$deliveryMethod->getDeliverySumSpecified()}
                                {$priceDel = $deliveryMethod->getPrice()}
                                {$priceDelAdd = ShopCore::app()->SCurrencyHelper->convert($deliveryMethod->getPrice(), $NextCSId)}
                                {$priceDelFreeFrom = ceil($deliveryMethod->getFreeFrom())}

                                {if $cartPrice < $priceDelFreeFrom}
                                {$cartPrice += $priceDel}
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $priceDel,'span', 'curr', '',  'span', 'price f-w_b', '');}

                                {if $NextCSId}
({echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, $priceDelAdd,'span', 'curr-add', '',  'span', 'price f-w_b', '');})

                                {/if}
                                {else:}
                                <span class="text-el s-t">{lang('Бесплатно', 'light')}</span>
                                {/if}
                                {else:}
                                <span class="text-el s-t">{echo $deliveryMethod->getDeliverySumSpecifiedMessage()}</span>
                                {/if}
                            </div>
                        </td>
                    </tr>
                    {/if}
                    {if $discount}
                    <tr>
                        <td colspan="3">
                            <span class="s-t f_l">{lang('Ваша текущая скидка','light')}:</span>
                            <span class="price-item f_r">
                                <span>
                                    <span class="text-discount current-discount">
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $discount,'span', 'curr', '',  'span', 'price f-w_b', '')}

                                    </span>
                                </span>
                            </span>
                        </td>
                    </tr>
                    {/if}
                    {if $model->getGiftCertPrice() > 0}
                    <tr>
                        <td colspan="3">
                            <span class="s-t">{lang('Подарочный сертификат','light')}:</span>
                            <span class="price-item f_r">
                                <span class="text-discount">
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($model->getGiftCertPrice()),'span', 'curr', '',  'span', 'price', '')}

                                </span>
                            </span>
                        </td>
                    </tr>
                    {/if}
                </tfoot>

                <!-- End. Render Ordered kit products  -->
            </tbody>
        </table>
    </div>
</div>
<div class="footer-bask">
    <div class="inside-padd">
        <!-- Start. Price block-->
        <div class="gen-sum-order clearfix">
            <span class="title f_l">{lang('К оплате','light')}:</span>
            <span class="frame-prices f-s_0 f_r">
                <span class="current-prices f-s_0">
                    <span class="price-new">
                        <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $cartPrice,'span', 'curr', '',  'span', 'price')}

                        </span>
                    </span>
                    {if $NextCSIdCond}
                    <span class="price-add">
                        <span>
({echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, ShopCore::app()->SCurrencyHelper->convert($cartPrice,$NextCSId),'span', 'curr-add', '',  'span', 'price', 'totalPriceAdd')})

                        </span>
                    </span>
                    {/if}
                </span>
            </span>
        </div>
        <!-- End. Price block-->
    </div>
</div>
</div>
</div>
</div>
</div>