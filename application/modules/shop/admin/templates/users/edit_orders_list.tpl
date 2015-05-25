<!-- Bottom orders history list -->
<div id="shopEditUserOrders" style="float:left;width:98%;position:relative;padding-top:8px;margin:0 15px">
    {literal}
        <script type="text/javascript">
            $$(".h").each(function(el) {
                el.addEvents({
                    'mouseenter': function(e) {
                        el.getNext().setStyle("display", "block");
                    }
                    //'mouseleave': function(e) {
                    //   $$(".pList").setStyle("display", "none");
                    //}
                });
            });

            $$(".pList").each(function(el) {
                el.addEvents({
                    'mouseleave': function(e) {
                        el.setStyle("display", "none");
                    }
                });
            });
        </script>
    {/literal}
    <h2>{lang('Orders history','admin')}</h2>
    <table id="OrdersTable" style="width:100%;position:relative;white-space:nowrap">
        <thead class="row_dark" >
        <th style="width:40%">{lang('Order','admin')} №</th>
        <th>{lang('Time of the order','admin')}</th>
        <th>{lang('Payment method','admin')}</th>
        <th>{lang('Delivery method','admin')}</th>
        <th>{lang('Cart','admin')}</th>
        <th>{lang('Delivery price','admin')}</th>
        <th>{lang('Total','admin')}</th>
        <th>{lang('Payment status','admin')}</th>
        <th width="1px"></th>
        <th width="1px"></th>
        </thead>
        <tbody>
            {foreach $ordersModel as $o}
                <tr id="productRow{echo $o->getId()}" class="{if $counter == 1}row_dark hover{$counter = 0}{else:}row_lite hover{$counter = 1}{/if}">
                    <td><a onclick="ajaxShop('orders/edit/{echo $o->getId()}');
                return false;">{lang('Order','admin')} #{echo $o->getId()}</a></td>
                    <td>{date("d-m-Y H:i:s", $o->getDateCreated())}</td>
                    <td>
                        {if $o->getSPaymentMethods()}
                            {echo $o->getSPaymentMethods()->getName()}
                        {/if}
                    </td>
                    <td>
                        {if $o->getSDeliveryMethods()}
                            {echo $o->getSDeliveryMethods()->getName()}
                        {/if}
                    </td>
                    <td>
                        <div class="h" style="width:24px;height:24px;background-image: url('/application/modules/shop/admin/templates/assets/images/shopping-basket.png');">&nbsp;</div>
                        <div class="pList" style="position:absolute;z-index:9999;background-color:#fff;border:1px solid silver;padding:3px;display:none;margin-top:-30px;margin-left: -10px">
                            {foreach $orderStatuses as $orderStatus}
                                {if $orderStatus->getId() == $o->getStatus()}
                                    {echo $orderStatus->getName()}<br/>
                                {/if}
                            {/foreach}
                            {foreach $o->getSOrderProductss() as $p}
                                <div class="{counter('row_dark','row_lite')} hover">
                                    {$productUrl = '#'}
                                    {$productModel = $p->getSProducts()}
                                    {if $productModel}
                                        {$productUrl = '/shop/product/'.$productModel->getUrl()}
                                        <a target="_blank" href="{$productUrl}">{echo $p->getProductName()}</a>
                                    {else:}
                                        {echo $p->getProductName()}
                                    {/if}

                                    {echo $p->getVariantName()}
                                    {echo $p->getQuantity()} {lang('pcs','admin')}. × {echo $p->getPrice(true)} {$CS}
                                    <br/>
                                </div>
                            {/foreach}
                        </div>
                    </td>
                    <td>
                        <b>{$deliveryMethod = SDeliveryMethodsQuery::create()->filterById($o->getDeliveryMethod())->findOne()}{if $o->getTotalPrice() >= $deliveryMethod->getFreeFrom() && $deliveryMethod->getFreeFrom() != 0}0.00{else:}{echo $o->getDeliveryPrice()}{/if} {$CS}</b>
                    </td>
                    <td><b>
                            {$total = 0}
                            {foreach $o->getSOrderProductss() as $p}
                                {$total = $total + $p->getQuantity() *  $p->getPrice()}
                            {/foreach}
                            {$total} {$CS}</b>
                    </td>
                    <td>
                        {foreach $orderStatuses as $orderStatus}
                            {if $orderStatus->getId() == $o->getStatus()}
                                {echo $orderStatus->getName()}<br/>
                            {/if}
                        {/foreach}
                    <td>
                        <div class="actions" style="float:right;">
                            {if $o->getPaid() == true}
                                <img src="/application/modules/shop/admin/templates/assets/images/credit-card.png" class="proccessOrderButton" 
                                     onclick="changePaid(this, {echo $o->getId()});" title="{lang('Paid','admin')}"/>
                            {else:}
                                <img src="/application/modules/shop/admin/templates/assets/images/credit-card-silver.png" class="proccessOrderButton" 
                                     onclick="changePaid(this, {echo $o->getId()})" title="{lang('Paid','admin')}"/>
                            {/if}                                        
                        </div>
                    </td>
                    <td>
                        <img src="/application/modules/shop/admin/templates/assets/images/delete.png" class="deleteOrderButton" title="{lang('Delete order','admin')}" onclick="confirm_delete_order_from_user_edit({echo $o->getId()});"/>
                    </td>
                </tr>
            {/foreach}
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <div id="gopages" class="navigation">
        {$pagination}
    </div>
</div>