<table border="0" width="550">
    <tr>	
        <td align="center"><font size="18px">{lang('Order','admin')} № {echo $model->getId()} {$pageNumber}</font></td>
    </tr>	
</table>
<br/>
<br/>
<table border="0" width="550">
    <tr>	
        <td>{lang('User name','admin')}:
            {echo $model->getUserFullName()}
            <br/>
            E-Mail:
            {echo $model->UserEmail}
            <br/>
            {if $model->UserPhone}
                {lang('Phone','admin')}:
                {echo $model->UserPhone}
                <br/>
            {/if}
            {$s_field = ShopCore::app()->CustomFieldsHelper->getOneCustomFieldsByNameArray('city','order', $model->getId())}
            {if $s_field.field_data && $s_field.field_data !== ''}
                {lang('City','admin')}:
                {echo $s_field.field_data}
                <br/>
            {/if}
            {if $model->user_deliver_to}
                {lang('Delivery Address','admin')}:
                {echo $model->user_deliver_to}
                <br/>
            {/if}
            {lang('Order date','admin')}:
            {date('d.m.Y, H:i:s.',$model->getDateCreated())}
            <br/>
            {if $model->getDeliveryMethod()}
                {lang('Delivery method','admin')}:
                {if $model->getDeliveryMethod() > 0}
                    {echo $model->getSDeliveryMethods()->getName()}
                {/if}
                <br/>
            {/if}
            {if $paymentMethod}
                {lang('Payment method','admin')}:
                {if $paymentMethod->getName()}
                    {echo ShopCore::t($paymentMethod->getName())}
                {/if}
                <br/>
            {/if}
            <br/>
            {if $model->userComment}
                {lang('Comment','admin')}:
                {echo $model->userComment}
                <br/>
            {/if}
        </td>
        {/* отключено, не хватает библиотек на premmerce}
        <td align="right">{if $logo = siteinfo('logo') != ""}<img src="{echo siteinfo('siteinfo_logo_url')}" width="150" alt="logo"/>{/if}</td>
        { */}
    </tr>	
</table>	        
<br/>
<table border="1" cellpadding="5">
    <tbody>
        <tr>	
            <td width="20">№</td>
            <td width="185">{lang('Product name','admin')}</td>
            <td width="80">{lang('Measurement unit','admin')}</td>
            <td width="70">{lang('Quantity','admin')}</td>
            <td width="80">{lang('Price','admin')}<br />({lang('Discount','admin')})</td>
            <td width="100">{lang('Total price','admin')}<br />({lang('Discount','admin')})</td>
        </tr>	
        {$n=1}
        {foreach $products as $p}
            <tr>
                <td>{$n}</td>
                <td>{echo trim(encode($p->getProductName()))} {echo encode($p->getVariantName())}</td>
                <td>{lang('Pieces.','admin')}</td>
                <td>{echo $p->getQuantity()}</td>
                <td>{echo $p->getOriginPrice(true)}{if $p->getOriginPrice(true) > $p->getPrice(true) && $model->getDiscountInfo() != 'user'}<br />(- {($p->getOriginPrice(true) - $p->getPrice(true))}){/if}</td>
                <td>{echo money_format('%!n',$p->getOriginPrice(true) * $p->getQuantity())} {echo ShopCore::app()->SCurrencyHelper->getSymbol()}{if $p->getOriginPrice(true) != $p->getPrice(true) && $model->getDiscountInfo() != 'user'}<br />{$diff = ($p->getOriginPrice(true) - $p->getPrice(true)) * $p->getQuantity()}{$diff = ($diff > 0 ? 0 - abs($diff) : abs($diff))}({if $diff > 0}+{/if}{$diff} {echo ShopCore::app()->SCurrencyHelper->getSymbol()}){/if}</td>        
            </tr>
            {$n++;}
        {/foreach}
        {$discount = $model->getDiscount()}
        {if $discount > 0}
            {if $discount > 0}
                <tr>
                    <td>{$n}</td>
                    <td>{lang('Discount','admin')}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>- {echo money_format('%!n', $discount)} {echo ShopCore::app()->SCurrencyHelper->getSymbol()}</td>        
                </tr>
                {$n++;}
            {/if}
        {/if}
        {if $model->getGiftCertPrice() > 0}
            <tr>
                <td>{$n}</td>
                <td>{lang('Gift certificate','admin')}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>- {echo money_format('%!n', $model->getGiftCertPrice())} {echo ShopCore::app()->SCurrencyHelper->getSymbol()}</td>        
            </tr>
        {/if}
    </tbody>
</table>
<div align="right">{$discountInfo = $model->getDiscountInfo();}{lang('In total','admin')}: {echo money_format('%!n', $totalPrice)} {echo ShopCore::app()->SCurrencyHelper->getSymbol()}</div>