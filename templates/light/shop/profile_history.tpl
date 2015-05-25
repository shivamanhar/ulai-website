<div class="inside-padd">
    {if count($orders) == 0}
        <div class="msg layout-highlight layout-highlight-msg">
            <div class="info">
                <span class="icon_info"></span>
                <span class="text-el">{lang('Вы еще не совершали покупки','light')}</span>
            </div>
        </div>
    {else:}
        <table class="table-profile">
            <thead>
                <tr>
                    <th>{lang('Заказ #','light')}</th>
                    <th>{lang('Время покупки','light')}</th>
                    <th>{lang('Сумма покупки','light')}</th>
                    <th>{lang('Статус заказа','light')}</th>
                    <th>{lang('Статус платежа','light')}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $orders as $order}
                    <tr>
                        <td><a rel="nofollow" href="{shop_url('order/view/' . $order->getKey())}">{lang('Заказ #','light')}{echo $order->getId()}</a></td>
                        <td>{date("d-m-Y H:i", $order->getDateCreated())}</td>
                        <td>
                            <div class="frame-prices">
                                <span class="current-prices">
                                    <span class="price-new">
                                        <span>
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($order->getTotalPrice()),'span', 'curr', '',  'span', 'price', '')}

                                        </span>
                                    </span>
                                </span>
                            </div>
                        </td>
                        </span>
                        <td>{echo $order->getSOrderStatuses()->getName()}</td>
                        <td>{if $order->getPaid()} {lang('Оплачиваемый','light')} {else:} {lang('Не оплачен','light')}{/if}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {/if}
</div>