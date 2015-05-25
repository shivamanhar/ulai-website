<script type="text/javascript">
    totalItemsBask = {if $totalItems}{echo $totalItems}{else:}0{/if};
</script>
<div class="frame-bask frameBask p_r">
    <button type="button" class="icon_times_drop" data-closed="closed-js"></button>
    {if $totalItems > 0}
        <div class="drop-header">
            <div class="title bask">{lang('Мой заказ','light')}</div>
        </div>
        <div class="drop-content">
            <div class="inside-padd">
                <table class="table-order">
                    <thead>
                        <tr>
                            <th colspan="2">{lang('Товар', 'light')}</th>
                            <th>{lang('Кол-во', 'light')}</th>
                            <th>{lang('Cумма', 'light')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $items as $item}
                            <!-- for single product -->
                            {if $item->instance === "SProducts"}
                                <tr data-id="{echo $item->getId()}" class="items items-bask cart-product">
                                    <td class="frame-remove-bask-btn">
                                        <button type="button" class="icon_times_cart" onclick="Shop.Cart.remove({echo $item->getId()})"></button>
                                    </td>
                                    <td class="frame-items">
                                        <a href="{echo shop_url('product/'.$item->getSProducts()->getUrl())}" title="{echo $item->getName()}" class="frame-photo-title">
                                            <span class="photo-block">
                                                <span class="helper"></span>
                                                <img src="{echo $item->getSmallPhoto()}" alt="{echo $item->getName()}"/>
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
                                    <td class="frame-count frameCount">
                                        <div class="number js-number" data-title="{lang('Количество на складе','light')} {echo $item->getStock()}">
                                            <input type="text" value="{echo $item->quantity}" class="plusMinus plus-minus" id="inputChange{echo $item->getId()}" data-id="{echo $item->getId()}" data-title="{lang('Только цифры','light')}" data-min="1" data-max="{echo $item->getStock()}"/>
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
                                <tr class="row-kits" data-id="{echo $item->getId()}">
                                    <td class="frame-remove-bask-btn">
                                        <button type="button" class="icon_times_cart" onclick="Shop.Cart.remove({echo $item->getId()}, true)"></button></button>
                                    </td>
                                    <td class="frame-items frame-items-kit">
                                        <ul class="items items-bask">
                                            {foreach $item->items as $k => $kitItem}
                                                <li>
                                                    {if $k != 0}
                                                        <div class="next-kit">+</div>
                                                    {/if}
                                                    <div class="frame-kit{if $k === 0} main-product{/if}">
                                                        <a class="frame-photo-title" href="{echo shop_url('product/'.$kitItem->getSProducts()->getUrl())}">
                                                            <span class="photo-block">
                                                                <span class="helper"></span>
                                                                <img src="{echo $kitItem->getSmallPhoto()}">
                                                            </span>
                                                            <span class="title">{echo $kitItem->getSProducts()->getName()}</span>
                                                        </a>
                                                        <div class="description">
                                                            {if $item->getName() && trim($kitItem->getName()) != trim($kitItem->getSProducts()->getName())}
                                                                <span class="frame-variant-name">
                                                                    <span class="text-el">{lang('Вариант','light')}</span>
                                                                    <span class="code">({echo $kitItem->getName()})</span>
                                                                </span>
                                                            {/if}
                                                            {if $kitItem->getSProducts()->getNumber()}
                                                                <span class="frame-variant-code">
                                                                    <span class="text-el">{lang('Артикул','light')}</span>
                                                                    <span class="code">({echo $kitItem->getSProducts()->getNumber()})</span>
                                                                </span>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </td>
                                    <td class="frame-count">
                                        <div class="number js-number" data-title="{lang('Количество на складе','light')} {echo $item->getStock()}">
                                            <input type="text" value="{echo $item->quantity}" class="plusMinus plus-minus" id="inputChange{echo $item->getId()}" data-id="{echo $item->getId()}" data-kit="1" data-title="{lang('Только цифры','light')}" data-min="1" data-max="{echo $item->getStock()}"/>
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
                            {/if}
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer-bask drop-footer">
            <div class="inside-padd">
                <div class="clearfix">
                    {if $discount_val}
                        <span class="frame-discount">
                            <span class="s-t">{lang('Ваша текущая скидка','light')}:</span>
 <span class="text-discount current-discount">{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($discount_val),'span', 'curr', '',  'span', 'text-el', '');}</span> 
                        </span>
                    {/if}
                    <div class="btn-form f_l isCart">
                        <button type="button" data-closed="closed-js">
                            <span class="text-el"><span class="f-s_14">←</span> {lang('Вернуться к оформлению','light')}</span>
                        </button>
                    </div>
                    <span class="s-t">{lang('Всего','light')}:</span>
                    <span class="frame-cur-sum-price">
                        <span class="frame-prices f-s_0">
                            {if $discount_val}
                                <span class="price-discount">
                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($cartOriginPrice),'span', 'curr', '',  'span', 'price', '');}

                                    </span>
                                </span>
                            {/if}
                            <span class="current-prices f-s_0">
                                <span class="price-new">
                                    <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($cartPrice),'span', 'curr', '',  'span', 'price', '');}

                                    </span>
                                </span>
                                {if $NextCSId}
                                    <span class="price-add">
                                        <span>
({echo \Currency\Currency::create()->getCurrencyToFormat($NextCSId, ShopCore::app()->SCurrencyHelper->convert($cartPrice, $NextCSId),'span', 'curr-add', '',  'span', 'price', '');})

                                        </span>
                                    </span>
                                {/if}
                            </span>
                        </span>
                    </span>
                </div>
            </div>
            <div class="content-frame-foot notCart">
                <div class="clearfix inside-padd">
                    <div class="btn-form f_l">
                        <button type="button" data-closed="closed-js">

                            <span class="text-el"><span class="f-s_14">←</span> {lang('Вернуться к покупкам','light')}</span>
                        </button>
                    </div>
                    <div class="btn-buy btn-buy-p f_r">
                        <a href="{shop_url('cart')}">
                            <span class="icon_cart_p"></span>
                            <span class="text-el">{lang('Оформить заказ','light')}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    {else:}
        <div class="drop-header">
            <div class="title">{lang('Ваша корзина','light')} <span class="add-info">{lang('пуста','light')}</span></div>
        </div>
        <div class="drop-content is-empty">
            <div class="inside-padd">
                <div class="msg f-s_0">
                    <div class="success"><span class="icon_info"></span><span class="text-el">{lang('Вы удалили все элементы из корзины','light')}</span></div>
                </div>
                <div class="btn-form notCart">
                    <button type="button" data-closed="closed-js">
                        <span class="text-el"><span class="f-s_14">←</span> {lang('Вернуться к покупкам','light')}</span>
                    </button>
                </div>
            </div>
        </div>
    {/if}
    <div class="preloader" style="display: none;"></div>
</div>
