<script type="text/javascript">
    totalItemsBask = {echo $totalItems && $totalItems != 0 ? $totalItems : 0}
</script>
{if $gift_key}
    <input type="hidden" name="gift" value="{echo $gift_key}"/>
    <input type="hidden" name="gift_ord" value="1"/>
{/if}
<table class="table-order table-order-view">
    <thead>
        <tr>
            <th>{lang('Товар', 'light')}</th>
            <th>{lang('Кол-во', 'light')}</th>
            <th>{lang('Cумма', 'light')}</th>
        </tr>
    </thead>
    <tbody>
        {foreach $items as $item}
            <!-- Start. For single product -->
            {if  $item->instance == 'SProducts'}
                <tr class="items items-bask cart-product">
                    <td class="frame-items">
                        <a href="{echo shop_url('product/'.$item->getSProducts()->getUrl())}" class="frame-photo-title">
                            <span class="photo-block">
                                <span class="helper"></span>
                                <img src="{echo $item->getSmallPhoto()}" alt="">
                            </span>
                            <span class="title">{echo $item->getSProducts()->getName()}</span>
                        </a>
                        <div class="description">
                            {if $item->getName() && trim($item->getName()) != trim($item->getSProducts()->getName())}
                                <span class="frame-variant-name">
                                    <span class="text-el">{lang('Вариант','light')}</span>
                                    <span class="code">({echo trim($item->getName())})</span>
                                </span>
                            {/if}
                            {if $item->getNumber()}
                                <span class="frame-variant-code">{lang('Артикул','light')}  
                                    <span class="code">({echo $item->getNumber()})
                                    </span>
                                </span> 
                            {/if}
                        </div>
                    </td>
                    <td>
                        <div class="frame-frame-count">
                            <div class="frame-count">
                                <span class="plus-minus">{echo $item->quantity}</span>
                            </div>
                        </div>
                    </td>
                    <td class="frame-cur-sum-price">
                        <div class="frame-prices f-s_0">
                            {if ShopCore::app()->SCurrencyHelper->convert($item->originPrice) != ShopCore::app()->SCurrencyHelper->convert($item->price)}
                                <span class="price-discount">
                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($item->originPrice) * $item->quantity,'span', 'curr', '',  'span', 'price', '');}

                                    </span>
                                </span>
                            {/if}
                            <span class="current-prices f-s_0">
                                <span class="price-new">
                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($item->price * $item->quantity),'span', 'curr', '',  'span', 'price', '');}

                                    </span>
                                </span>
                                {/*}
                                {if $NextCSId}
                                    <span class="price-add">
                                        <span>
{echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, ShopCore::app()->SCurrencyHelper->convert($item->price * $item->quantity, $NextCSId),'span', 'curr', '',  'span', 'price', '');}

                                        </span>
                                    </span>
                                {/if}
                                { */}
                            </span>
                        </div>
                    </td>
                </tr>
            {else:}
                <!-- Start. Shop kit -->
                <tr class="row row-kits">
                    <td class="frame-items frame-items-kit">
                        <div class="title-h3 c_9">{lang('Комплект товаров', 'light')}</div>
                        <ul class="items items-bask">
                            {foreach $item->items as $k => $kitItem}
                                <li>
                                    {if $k != 0}
                                        <div class="next-kit">+</div>
                                    {/if}
                                    <div class="frame-kit">
                                        <a class="frame-photo-title" href="{echo shop_url('product/'.$kitItem->getSProducts()->getUrl())}">
                                            <span class="photo-block">
                                                <span class="helper"></span>
                                                <img src="{echo $kitItem->getSmallPhoto()}">
                                            </span>
                                            <span class="title">{echo $kitItem->getSProducts()->getName()}</span>
                                        </a>
                                        <div class="description">
                                            {if $kitItem->getName() && trim($kitItem->getName()) != trim($kitItem->getSProducts()->getName())}
                                                <span class="frame-variant-name">
                                                    <span class="text-el">{lang('Вариант','light')}</span>
                                                    <span class="code">({echo $kitItem->getName()})</span>
                                                </span>
                                            {/if}
                                            {if $kitItem->getSProducts()->getNumber()}
                                                <span class="frame-variant-code">{lang('Артикул','light')}  
                                                    <span class="code">({echo $kitItem->getSProducts()->getNumber()})
                                                    </span>
                                                </span> 
                                            {/if}
                                        </div>
                                    </div>
                                </li>
                            {/foreach}
                        </ul>
                    </td>
                    <td>
                        <div class="frame-frame-count">
                            <div class="frame-count">
                                <span class="plus-minus">{echo $item->quantity}</span>
                            </div>
                        </div>
                    </td>
                    <td class="frame-cur-sum-price">
                        <div class="frame-prices f-s_0">
                            {if ShopCore::app()->SCurrencyHelper->convert($item->originPrice) != ShopCore::app()->SCurrencyHelper->convert($item->price)}
                                <span class="price-discount">
                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($item->originPrice * $item->quantity),'span', 'curr', '',  'span', 'price', '');}

                                    </span>
                                </span>
                            {/if}
                            <span class="current-prices f-s_0">
                                <span class="price-new">
                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($item->price),'span', 'curr', '',  'span', 'price', '');}

                                    </span>
                                </span>
                                {/*}
                                {if $NextCSId}
                                    <span class="price-add">
                                        <span>
{echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, ShopCore::app()->SCurrencyHelper->convert($item->price * $item->quantity, $NextCSId),'span', 'curr', '',  'span', 'price', '');}

                                        </span>
                                    </span>
                                {/if}
                                { */}
                            </span>
                        </div>
                    </td>
                </tr>
                <!-- End. Shop kit -->
            {/if}
        {/foreach}   
    </tbody>
    <tfoot class="gen-info-price">
        {if $discount_val}
            <tr>
                <td colspan="3">
                    <span class="s-t f_l">{lang('Начальная стоимость товаров','light')}:</span>
                    <div class="f_r">                
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($cartOriginPrice),'span', 'curr', '',  'span', 'price f-w_b', '');}

                    </div>
                </td>
            </tr>
        {/if}
        <tr>
            <td colspan="3">
                <span class="s-t f_l">{lang('Cтоимость товаров','light')}:</span>
                <div class="f_r">
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($cartPrice),'span', 'curr', '',  'span', 'price f-w_b', '');}

                </div>
            </td>
        </tr>
        {if $deliveryMethod && $deliveryMethod->getPrice() != 0 || $deliveryMethod && $deliveryMethod->getDeliverySumSpecifiedMessage() != ''}
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
        {if $discount_val}
            <tr>
                <td colspan="3">
                    <span class="s-t f_l">{lang('Ваша текущая скидка','light')}:</span>
                    <div class="text-discount current-discount f_r">
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($discount_val),'span', 'curr', '',  'span', 'price f-w_b', '');}

                    </div>
                </td>
            </tr>
        {/if}
        {if $gift_val}
            <tr>
                <td colspan="3">
                    <span class="s-t f_l">{lang('Подарочный сертификат','light')}:</span>
                    <div class="text-discount f_r">
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($gift_val),'span', 'curr', '',  'span', 'price f-w_b', '');}

                    </div>
                </td>
            </tr>
        {elseif $CI->load->module('mod_discount/discount_api')->isGiftCertificat()}
            <tr>
                <td colspan="3">
                    <div class="clearfix">
                        <span class="s-t f_l">{lang('Подарочный сертификат','light')}:</span>
                        <div class="frame-gift f_r">
                            {if $gift_error}
                                <div class="msg">
                                    <div class="error">
                                        <span class="icon_error"></span>
                                        <span class="text-el">{lang('Неверный код подарочного сертификата', 'light')}</span>
                                    </div>
                                </div>
                            {else:}
                                <div class="btn-toggle-gift">
                                    <button type="button" class="d_l_1" data-drop="#gift" data-place="inherit" data-overlay-opacity="0">
                                        <span class="text-el">{lang('Ввести промо-код', 'light')}</span>
                                    </button>
                                </div>
                            {/if}
                            <div id="gift" class="{if !$gift_error}drop{/if} o_h">
                                <div class="btn-def f_r">
                                    <button type="button" id="giftButton">
                                        <span class="text-el">{lang('Применить', 'light')}</span>
                                    </button>
                                </div>
                                <div class="o_h">
                                    <input type="text" name="gift"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        {/if}
    </tfoot>
</table>
<div class="gen-sum-order footer-bask">
    <div class="inside-padd clearfix">
        <span class="title f_l">{lang('К оплате','light')}:</span>
        <span class="frame-prices f_r">
            <span class="current-prices f-s_0">
                <span class="price-new">
                    <span>

{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($cartPrice),'span', 'curr', '',  'span', 'price', 'finalAmount');}


                    </span>
                </span>
                {if $NextCS != null}
                    <span class="price-add">
                        <span>
({echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, ShopCore::app()->SCurrencyHelper->convert($cartPrice, $NextCSId),'span', 'curr-add', '',  'span', 'price', 'finalAmountAdd');})

                        </span>
                    {/if}
                </span>
            </span>
        </span>
    </div>
</div>
<div class="preloader" style="display: none;"></div>