<div class="container">
    <section class="mini-layout">       
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title w-s_n">{lang('Order create','admin')}</span>
            </div>
            <div class="pull-right">
                <span class="help-inline"></span>
                <div class="d-i_b">
                    <a href="{$ADMIN_URL}orders" class="pjax t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    <button type="button" class="btn btn-small btn-primary action_on formSubmit" data-action="edit" data-form="#add_order_form" data-submit><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                    <button type="button" class="btn btn-small action_on formSubmit" data-action="close" data-form="#add_order_form"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>
                </div>
            </div>
        </div>        

        <div class="clearfix">
            <!-- 
<div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
<a href="#main_data" class="btn btn-small active">Основные сведения</a>
<a href="#other_data" class="btn btn-small ">Other data</a>
</div>
            -->
            <!-- 
            <div class="pull-right m-t_20">
                <a href="#">Просмотр страницы <span class="f-s_14">→</span></a>
            </div>
            -->
        </div>                     	
        <form method="post" action="{$ADMIN_URL}orders/create"  class="form-horizontal" id="add_order_form">
            <div class="tab-content">
                <div class="tab-pane active" id="main_data">
                    <table class="table table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Information','admin')}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd span9">

<!--<input type="hidden" name="OrderId" value="{//echo $model->getId()}"/>-->


                                        <div class="control-group">
                                            <label class="control-label">
                                                {lang('Status','admin')}:
                                            </label>
                                            <div class="controls">
                                                {form_dropdown('Status',SOrders::getStatuses())}
                                            </div>
                                        </div>

                                        <div class="control-group" style="display: none;">
                                            <label class="control-label" for="Comment">
                                                {echo $model->getLabel('StatusComment')}:
                                            </label>
                                            <div class="controls">
                                                <textarea name="Comment" id="Comment"></textarea>
                                            </div>
                                        </div>

                                        <div class="control-group" style="display: none;">
                                            <div class="control-label"></div>
                                            <div class="controls">
                                                <span class="frame_label no_connection">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox" id="Notify" value="1"/>
                                                    </span>
                                                    {lang('Notify a buyer about the status change','admin')}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label"></div>
                                            <div class="controls">
                                                <span class="frame_label no_connection">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox" name="Paid" value="1" id="Paid" {if $model->getPaid()==1} checked="checked" {/if}/> 
                                                    </span>
                                                    {lang('Paid','admin')}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="UserFullName">
                                                {lang('Complete','admin')} {lang('User name','admin')}:
                                            </label>
                                            <div class="controls">
                                                <input type="text" name="UserFullName" id="UserFullName" value="{echo ShopCore::encode($model->getUserFullName())}" class="required" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="UserEmail">
                                                {lang('E-mail','admin')}:
                                            </label>
                                            <div class="controls">
                                                <input type="text" name="UserEmail" id="UserEmail" value="{echo ShopCore::encode($model->getUserEmail())}" class="email required" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="UserPhone">
                                                {lang('Telephone','admin')}:
                                            </label>
                                            <div class="controls">
                                                <input type="text" name="UserPhone" id="UserPhone" value="{echo ShopCore::encode($model->getUserPhone())}" class="textbox_long" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="postAddress">
                                                {lang('Delivery Address','admin')}:
                                            </label>
                                            <div class="controls">
                                                <a onclick="orders.fixAddressA()" id="postAddressBtn" class="btn btn-small pull-right" href="http://maps.google.com/?q={echo ShopCore::encode($model->getUserDeliverTo())}"
                                                   target="_blank"
                                                   title="{lang('View','admin')} {lang('on','admin')} {lang('map','admin')}.">
                                                    <i class="icon-globe"></i> {lang('Show on map','admin')}
                                                </a>
                                                <div class="o_h">
                                                    <input type="text" name="UserDeliverTo" id="postAddress" value="{echo ShopCore::encode($model->getUserDeliverTo())}" "/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="UserComment">
                                                {lang('Comment','admin')}:
                                            </label>
                                            <div class="controls">
                                                <textarea name="UserComment" id="UserComment">{echo ShopCore::encode($model->getUserComment())}</textarea>
                                            </div>
                                        </div>

                                        {$addField = ShopCore::app()->CustomFieldsHelper->getCustomFields('order', -1)->asAdminHtml()}
                                        {if !empty($addField)}
                                            <fieldset title="{lang('Additional data','admin')}">
                                                {$addField}
                                            </fieldset>
                                        {/if}

                                        <div class="control-group">
                                            <label class="control-label">

                                            </label>
                                            <div class="controls">

                                            </div>
                                        </div>

                                        {form_csrf()}   
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                    <table class="table  table-bordered table-hover table-condensed content_big_td">

                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Delivery and payment','admin')}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd span9">
                                        {if sizeof($deliveryMethods) > 0}
                                            {$freeDeliveryMethods=array()}

                                            <div class="control-group">
                                                <label class="control-label" for="DeliveryMethod-select">
                                                    {lang('Delivery Method','admin')}:
                                                </label>
                                                <div class="controls">
                                                    <select name="DeliveryMethod" id="DeliveryMethod-select">
                                                        <option value="0">- none -</option>
                                                        {if $deliveryMethods}
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
                                                        {/if}
                                                    </select>
                                                </div>
                                            </div>

                                        {/if}

                                        {if sizeof($paymentMethods) > 0}
                                            <div class="control-group">
                                                <label class="control-label" for="PaymentMethod">
                                                    {lang('Payment method','admin')}:
                                                </label>
                                                <div class="controls">
                                                    <select name="PaymentMethod" id="PaymentMethod">
                                                        <option value="0">- none -</option>
                                                        {if $paymentMethods}
                                                            {foreach $paymentMethods as $pm}

                                                                {if $pm->getId() == $model->getPaymentMethod()}
                                                                    {$selected='selected="selected"'}
                                                                {else:}
                                                                    {$selected=''}
                                                                {/if}

                                                                <option {$selected} value="{echo $pm->getId()}" class="{counter('row_dark','row_lite')} hover">{echo ShopCore::encode($pm->getName())}</option>
                                                            {/foreach}
                                                        {/if}
                                                    </select>					
                                                </div>
                                            </div>
                                        {/if}                             
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- Right column with products list -->
                <div class="tab-pane " id="other_data">

                    <table class="table  table-bordered table-hover table-condensed content_big_td">

                        <thead>
                            <tr>
                                <th colspan="6">
                                    Title
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">

                                    <div class="inside_padd span9">
                                        <div class="span9">

                                            Content

                                        </div>
                                    </div>  
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <script type="text/javascript">
                        var totalPrice = '{$total}';

                        var currencySymbol = '{$CS}';

                        var deliveryMethods_prices = new Array;
                        var freeDeliveryMethods = new Array;
                        {if is_array($freeDeliveryMethods)}
                            {foreach $freeDeliveryMethods as $freeMethod}
                        freeDeliveryMethods[{$freeMethod}] = {$freeMethod};
                            {/foreach}
                        {/if}
                        {if is_array($deliveryMethods)}
                            {foreach $deliveryMethods as $d}
                                {if $d->getIsPriceInPercent() == true}
                        deliveryMethods_prices[{echo $d->getId()}] = '{echo $d->getPrice() * $total / 100}';
                                {else:}
                        deliveryMethods_prices[{echo $d->getId()}] = '{echo $d->getPrice()}';
                                {/if}
                            {/foreach}
                        {/if}
                    </script>
                </div>
            </div>
        </form>

        <div style="clear:both;"></div>

        <script type="text/javascript">
            {literal}
                function changeTotalPriceByDeliveryPrice(id)
                {
                    var deliveryPrice = deliveryMethods_prices[id];

                    if (!deliveryPrice)
                    {
                        document.getElementById('totalPriceText').innerHTML = totalPrice + ' ' + currencySymbol;
                        document.getElementById('deliveryMethodPriceText').innerHTML = '0.00 ' + currencySymbol;
                        return true;
                    }

                    if (freeDeliveryMethods[id])
                    {
                        deliveryPrice = '0.00';
                    }

                    document.getElementById('deliveryMethodPriceText').innerHTML = deliveryPrice + ' ' + currencySymbol;

                    if (deliveryPrice == '0.00')
                    {
                        document.getElementById('totalPriceText').innerHTML = totalPrice + ' ' + currencySymbol;
                    }
                    else
                    {
                        var result = parseFloat(deliveryPrice) + parseFloat(totalPrice);
                        document.getElementById('totalPriceText').innerHTML = result.toFixed(2).toString() + ' ' + currencySymbol;
                    }
                }

            {/literal}
        </script>

    </section>
</div>