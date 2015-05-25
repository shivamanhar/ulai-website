<h3>{lang('Orders','admin')} {lang('in','admin')} {lang('Cart','admin')}</h3>

<table border="0" align="top" class="ordersTable" width="100%" style="font-size: 13px;">
    {$total = 0}
    {foreach $model->getSOrderProductss() as $p }
    <tr valign="top" class="{counter('row_dark','row_lite')} hover">
        <td style="width:50%">
            <a href="#">{echo ShopCore::encode($p->getProductName())}</a><br/>
    {echo ShopCore::encode($p->getVariantName())}
        </td>
        <td align="left" style="width:40%">
    {echo $p->getQuantity()} {lang('Pieces.','admin')} × {echo $p->getPrice()} {$CS}
    {$total = $total + $p->getQuantity() * $p->getPrice()}
        </td>
        <td style="width:5%"><a onclick="shopOrderCartEdit_showEditWindow({echo $p->getId()})">{lang('Change','admin')}</a></td>
        <td style="width:5%"><a onclick="confirm_delete_ordered_product({echo $p->getId()}, {echo $model->getId()})">X</a></td>
    </tr>
    {/foreach}
    <tr style="height:40px;">
        <td></td>
        <td colspan="3" style="text-align: right;"><a onclick="shopOrderCartEditAddToCart_showEditWindow({echo $model->getId()})">{lang('Add','admin')} {lang('New','admin')} {lang('Product','admin')} {lang('to','admin')} {lang('Orders','admin')}</a></td>
    </tr>

    <tr valign="middle" class="row_dark">
        <td>
        {if sizeof($deliveryMethods) > 0}
            {$freeDeliveryMethods=array()}
            <div class="form_text" style="width: 120px;">{lang('Me','admin')} {lang('Delivery','admin')}:</div>
            <div class="form_input">
                <select name="DeliveryMethod" id="DeliveryMethod-select" style="width:200px;" onchange="changeTotalPriceByDeliveryPrice(this.value)">
                    <option value="0">- none -</option>
            {foreach $deliveryMethods as $dm}

                {if $dm->getId() == $model->getDeliveryMethod()}
                    {$selected='selected="selected"'}
                {else:}
                    {$selected=''}
                {/if}

                {if $dm->getFreeFrom() == 0 && $dm->getPrice() > 0}
                    {//$free = $dm->getPrice()}
                {elseif($total >= $dm->getFreeFrom()):}
                    {$freeDeliveryMethods[] = $dm->getId()}
                {elseif($dm->getFreeFrom() > 0 && $dm->getPrice() > 0):}
                    {//$free = $dm->getPrice()}
                {/if}

                {if $dm->getId() == $model->getDeliveryMethod()}
                    {$deliveryPrice = $model->getDeliveryPrice()}
                {/if}

                        <option {$selected} value="{echo $dm->getId()}" class="{counter('row_dark','row_lite')} hover">{echo ShopCore::encode($dm->getName())}</option>
            {/foreach}
                </select>
            </div>
        {/if}
        </td>
        <td align="left" id="deliveryMethodPriceText">
        {echo $model->getDeliveryPrice()} {$CS}
        </td>
    </tr>

    <tr valign="middle" class="row_lite">
        <td>
            <div class="form_text" style="width: 120px;">{lang('Option','admin')} {lang('Payments','admin')}:</div>
        {if sizeof($paymentMethods) > 0}
            <div class="form_input">
                <select name="PaymentMethod" style="width:200px;">
                    <option value="0">- none -</option>
            {foreach $paymentMethods as $pm}

                {if $pm->getId() == $model->getPaymentMethod()}
                    {$selected='selected="selected"'}
                {else:}
                    {$selected=''}
                {/if}

                        <option {$selected} value="{echo $pm->getId()}" class="{counter('row_dark','row_lite')} hover">{echo ShopCore::encode($pm->getName())}</option>
            {/foreach}
                </select>
            </div>
        {/if}
        </td>
    </tr>

    <tr valign="top" class="row_dark summary">
        <td align="right">
            <b>{lang('Result','admin')}:</b>
        </td>
        <td align="left" id="totalPriceText">
        {echo $total + $deliveryPrice} {$CS}
        </td>
    </tr>
</table>

<script type="text/javascript">
    var totalPrice = {echo $total};
    var currencySymbol = '{$CS}';

    var deliveryMethods_prices = new Array;
    var freeDeliveryMethods = new Array;

        {foreach $freeDeliveryMethods as $freeMethod}
        freeDeliveryMethods[{$freeMethod}] = {$freeMethod};
        {/foreach}

        {foreach $deliveryMethods as $d}
            {if $d->getIsPriceInPercent() == true}
        deliveryMethods_prices[{echo $d->getId()}] = '{echo $d->getPrice() * $total / 100}';
            {else:}
        deliveryMethods_prices[{echo $d->getId()}] = '{echo $d->getPrice()}';
            {/if}
        {/foreach}
    var deliveryMethodId = $('DeliveryMethod-select').getElement(':selected').get('value');
    changeTotalPriceByDeliveryPrice(deliveryMethodId);
</script>