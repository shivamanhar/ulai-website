{$allStatuses = SOrders::getStatuses()}
<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title w-s_n">{lang('Editing','admin')}
                {lang('Order','admin')} #{echo $model->getId()}
            </span>
        </div>
        <div class="pull-right">
            <span class="help-inline"></span>
            <div class="d-i_b">
                <a href="{$ADMIN_URL}orders" class="pjax t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    {if $model->getTotalPrice()}
                    <a class="btn btn-small" target="_blank" href="/admin/components/run/shop/orders/createPdf/{echo $model->getId()}">
                        {lang('Print receipt','admin')}
                    </a>
                {/if}
                <button type="button" class="btn btn-small action_on formSubmit btn-primary" data-action="edit" data-form="#add_order_form" data-submit><i class="icon-ok"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-action="close" data-form="#add_order_form"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>
            </div>
        </div>
    </div>
    <form method="post" action="{$ADMIN_URL}orders/edit/{echo $model->getId()}" class="form-horizontal" id="add_order_form">
        <div class="row-fluid m-t_20">
            <div class="span6">
                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {lang("Order details", "admin")}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd">
                                    <div class="frame-input-w100">
                                        <div class="control-group">
                                            <label class="control-label">
                                                {lang('Date of order','admin')}:
                                            </label>
                                            <div class="controls ctext">
                                                {date("Y-m-d, H:i", $model->getDateCreated())}
                                            </div>
                                        </div>
                                        {if $model->getDateCreated() != $model->getDateUpdated()}
                                            <div class="control-group">
                                                <label class="control-label">
                                                    {lang('Date of change','admin')}:
                                                </label>
                                                <div class="controls ctext">
                                                    {date("Y-m-d, H:i", $model->getDateUpdated())}
                                                </div>
                                            </div>
                                        {/if}
                                        <div class="control-group">
                                            <label class="control-label" for="status">
                                                {lang('Status','admin')}:
                                            </label>
                                            <div class="controls">
                                                {form_dropdown('Status', $allStatuses[1], $model->getStatus(), '', 'status')}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
                                                {lang('Paid','admin')}:
                                            </label>
                                            <div class="controls">
                                                <span class="frame_label m-r_20">
                                                    <span class="niceRadio b_n">
                                                        <input type="radio" name="Paid" value="1" {if $model->getPaid()==1} checked='checked' {/if}/>
                                                    </span>
                                                    {lang('Yes','admin')}
                                                </span>
                                                <span class="frame_label">
                                                    <span class="niceRadio b_n">
                                                        <input type="radio" name="Paid" value="0" {if $model->getPaid()==0} checked='checked' {/if}/>
                                                    </span>
                                                    {lang('No','admin')}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
                                                {lang('Order amount','admin')}:
                                            </label>
                                            <div class="controls ctext">
                                                <b>{echo $model->getTotalPrice()}</b> {$CS}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="Comment" class="control-label">
                                                {lang('Comment','admin')}:
                                            </label>
                                            <div class="controls">
												{if count($statusHistory)}
													{foreach $statusHistory as $sh}                        
														{if $sh->getComment() != null}{$LastComment=$sh->getComment()}{else:}{/if}                               
													{/foreach}
												{/if}  
                                                <textarea name="Comment" id="Comment" maxlength="1000">{echo $LastComment}</textarea>
                                                <span class="help-inline">{lang('Commentary to change the status','admin')}</span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label"></label>
                                            <div class="controls">
                                                <span class="frame_label no_connection">
                                                    <span class="niceCheck b_n">
                                                        <input name="Notify" type="checkbox"/>
                                                    </span>
                                                    {lang('Info buyer about change status','admin')}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="span6">
                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {lang("Check out", "admin")}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd">
                                    <div class="frame-input-w100">
                                        <div class="control-group">
                                            <label class="control-label" for="UserFullName">
                                                {lang('Buyer','admin')}:
                                                <span class="must">*</span>
                                            </label>
                                            <div class="controls">
                                                <div class="pull-right m-l_10">
                                                    {if $model->getUserId()}
                                                        <a href="/admin/components/run/shop/users/edit/{echo $model->getUserId()}" class="btn btn-small" {if $model->getUserId()}data-title="{lang('Edit user','admin')}" data-rel="tooltip"{/if}>
                                                            <i class="icon-user"></i>
                                                            {lang('Profile','admin')}
                                                        </a>
                                                    {else:}
                                                        {/*lang('User name','admin')*/}
                                                    {/if}
                                                </div>
                                                <div class="o_h">
                                                    <input type="text" name="UserFullName" id="UserFullName"
                                                           value="{echo ShopCore::encode($model->getUserFullName())}"
                                                           class="required"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="UserEmail"> {lang('E-mail','admin')}:
                                                <span class="must">*</span>
                                            </label>
                                            <div class="controls">
                                                <input type="text" name="UserEmail" id="UserEmail"
                                                       value="{echo ShopCore::encode($model->getUserEmail())}"
                                                       class="email required input-large" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="UserPhone"> {lang('Telephone','admin')}: </label>
                                            <div class="controls">
                                                <input type="text" name="UserPhone" id="UserPhone"
                                                       value="{echo ShopCore::encode($model->getUserPhone())}"
                                                       class="textbox_long" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="postAddress">
                                                {lang('Delivery Address','admin')}: 
                                            </label>
                                            <div class="controls">
                                                <a onclick="orders.fixAddressA()" id="postAddressBtn" class="btn btn-small pull-right" href="http://maps.google.com/?q={echo ShopCore::encode($model->getUserDeliverTo())}"
                                                   target="_blank"
                                                   data-rel="tooltip"
                                                   data-title="{lang('Show on map','admin')}">
                                                    <i class="icon-globe"></i>
                                                </a>
                                                <div class="o_h">
                                                    <input type="text" name="UserDeliverTo" id="postAddress" value="{echo ShopCore::encode($model->getUserDeliverTo())}"/>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">{lang('Delivery method','admin')}:</label>
                                            <div class="controls">
                                                <select class="shopOrdersdeliveryMethod" type="text"  value="" data-rel=".shopOrdersPaymentMethod" data-rel2='[name="shop_orders[delivery_method]"]'>
                                                    <option>{lang('none','admin')}</option>
                                                    {$chooseDeliv = false}
                                                    {foreach $deliveryMethods as $dm}
                                                        <option {if $dm->getId() == $model->getDeliveryMethod()}{$chooseDeliv = true}selected="selected"{/if}value="{echo $dm->getId()}">{echo $dm->getName()}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">{lang('Payment method','admin')}:</label>
                                            <div class="controls">
                                                <select class="shopOrdersPaymentMethod" type="text" value="" {if !$chooseDeliv}disabled="disabled"{/if} data-rel='[name="shop_orders[payment_method]"]'>
                                                    {foreach $paymentMethods as $pm}
                                                        <option value="{echo $pm->getId()}"{if $pm->getId() == $model->getPaymentMethod()}selected="selected"{/if}>{echo $pm->getName()}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="shop_orders[delivery_method]" value="{echo $model->getDeliveryMethod()}"/>
                                        <input type="hidden" name="shop_orders[payment_method]" value="{echo $model->getPaymentMethod()}"/>
                                        <div class="control-group">
                                            <label class="control-label" for="UserComment"> {lang('Comments buyer','admin')}: </label>
                                            <div class="controls">
                                                <textarea name="UserComment" id="UserComment" maxlength="1000">{echo ShopCore::encode($model->getUserComment())}</textarea>
                                            </div>
                                        </div>
                                        {$addField = ShopCore::app()->CustomFieldsHelper->getCustomFields('order', $model->getId())->asAdminHtml()}
                                        {if !empty($addField)}
                                            {$addField}
                                            <div id="elFinder"> </div>
                                        {/if}
                                    </div>
                                </div>
                                </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="title-default">{lang("Ordered products", "admin")}</div>
        <table class="table  table-bordered table-hover table-condensed t-l_a" id="productsInCart">
            <thead>
                <tr>
                    <th class="span1"></th>
                    <th class="span6">{lang('Items in Cart','admin')}</th>
                    <th class="span1">{lang('Article','admin')}</th>
                    <th class="span2">{lang('Price','admin')}</th>
                    <th class="span2">{lang('Quantity','admin')}</th>
                    <th class="span2">{lang('Total price','admin')}</th>
                </tr>
            </thead>
            <tbody>
                {$total = 0}
                {foreach $model->getSOrderProductss() as $item}
                    {if $item->getKitId() > 0}
                        <tr>
                            {$kitId == 0}
                            {if $item->getIsMain()}
                                <td class="t-a_c">
                                    <button class="btn my_btn_s btn-small" type="button" onclick="orders.deleteProduct({echo $item->getId()})" data-rel="tooltip" data-title="{lang('Remove', 'admin')}"><i class="icon-trash"></i></button>
                                </td>
                                {$kitId = $item->getKitId()}
                                <td>
                                    {foreach $model->getSOrderProductss() as $kititem}
                                        {if $kititem->getKitId() == $kitId}
                                            <a data-title="{lang('Edit product', 'admin')}" data-rel="tooltip" href="{base_url()}admin/components/run/shop/products/edit/{echo $item->getProductID()}" class="pjax">
                                                {echo ShopCore::encode($kititem->getProductName())}
                                            </a><br />
                                            {if ShopCore::encode($kititem->getVariantName()) && ShopCore::encode($kititem->getVariantName()) !== ShopCore::encode($kititem->getProductName())}
                                                {echo ShopCore::encode($kititem->getVariantName())}<br />
                                            {/if}

                                            {echo ShopCore::app()->SCurrencyHelper->convert($kititem->getPrice())} {$CS} 

                                            <br /><br />
                                            {$total +=  $kititem->getQuantity() * $kititem->getPrice();}
                                            {$totalOrig += $kititem->getQuantity() * $kititem->getOriginPrice();}
                                            {$priceKit += $kititem->getPrice();}
                                            {$priceKitOrig += $kititem->getOriginPrice();}
                                        {/if}
                                    {/foreach}
                                </td>
                                <td>-</td>
                                <td>
                                    {echo ShopCore::app()->SCurrencyHelper->convert($priceKit)}
                                    {$CS}
                                </td>
                                <td>
                                    <div class="p_r o_h frame_price number">
                                        <input type="text" value="{echo $item->getQuantity()}" class="js_price" data-value="{echo $item->getQuantity()}" data-placement="top" data-original-title="{lang('Digits only','admin')}">
                                        <button data-update="count" onclick="orders.updateOrderItem({echo $item->getId()}, this)" class="btn btn-small" type="button" style="display: none; "><i class="icon-refresh"></i></button>
                                    </div>
                                </td>
                                <td>
                                    {echo ShopCore::app()->SCurrencyHelper->convert($total)}
                                    {$CS}
                                </td>
                            {/if}
                        </tr>
                    {else:}
                        <tr>
                            <td class="t-a_c">
                                <button class="btn my_btn_s btn-small" type="button" onclick="orders.deleteProduct({echo $item->getId()})" data-rel="tooltip" data-title="{lang('Remove', 'admin')}"><i class="icon-trash"></i></button>
                            </td>
                            <td>
                                <a data-title="{lang('Edit product', 'admin')}" data-rel="tooltip" href="{base_url()}admin/components/run/shop/products/edit/{echo $item->getProductID()}" class="pjax">
                                    {echo ShopCore::encode($item->getProductName())}
                                </a>
                                {if ShopCore::encode($item->getVariantName()) && ShopCore::encode($item->getVariantName()) !== ShopCore::encode($item->getProductName())}
                                    <br />
                                    {echo ShopCore::encode($item->getVariantName())}
                                {/if}
                            </td>
                            <td>
                                <div class="p_r o_h frame_price number">
                                    <!--<input type="text" value="{echo $item->getNumber()}" class="js_price" data-value="{echo $item->getPrice()}" data-placement="top" data-original-title="{lang('Digits only','admin')}">-->
                                    {echo $item->getNumber()}
                                </div>
                            </td>
                            <td>
                                <span class="pull-right">
                                    <span class="neigh_form_field help-inline"></span>&nbsp;&nbsp;{$CS}
                                </span>
                                <div class="p_r o_h frame_price number">
                                    {if $discountInfo == 'product'}
                                        <input type="text" value="{echo ShopCore::app()->SCurrencyHelper->convert($item->getPrice())}" class="js_price" data-value="{echo ShopCore::app()->SCurrencyHelper->convert($item->getPrice())}" data-placement="top" data-original-title="{lang('Digits only','admin')}">
                                    {else:}
                                        <input type="text" value="{echo ShopCore::app()->SCurrencyHelper->convert($item->getPrice())}" class="js_price" data-value="{echo ShopCore::app()->SCurrencyHelper->convert($item->getPrice())}" data-placement="top" data-original-title="{lang('Digits only','admin')}">
                                    {/if}
                                    <button data-update="price" onclick="orders.updateOrderItem({echo $item->getId()}, this)"  class=" btn btn-small" type="button" style="display: none; "><i class="icon-refresh"></i></button>
                                </div>
                            </td>
                            <td>
                                <div class="p_r o_h frame_price number">
                                    <input type="text" value="{echo $item->getQuantity()}" class="js_price" data-value="{echo $item->getQuantity()}" data-placement="top" data-original-title="{lang('Digits only','admin')}">
                                    <button data-update="count" onclick="orders.updateOrderItem({echo $item->getId()}, this)" class="btn btn-small" type="button" style="display: none; "><i class="icon-refresh"></i></button>
                                </div>
                            </td>
                            <td>
                                {echo ShopCore::app()->SCurrencyHelper->convert($item->getQuantity() * $item->getPrice())}&nbsp;{$CS}
                            </td>
                        </tr>
                    {/if}
                {/foreach}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd clearfix">
                            <a href="#" class="btn btn-small pull-left" onclick="orders.addProduct({echo $model->getId()});">
                                <i class="icon-plus-sign"></i>&nbsp;{lang('Add a new product to the order','admin')}
                            </a>
                            <div class="pull-right t-a_r">
                                <div>
                                    {lang('The initial value of the goods','admin')}:
                                    <b>
                                        {echo $model->getOriginPrice()} {$CS}
                                    </b>
                                </div>
                                {if $model->getDeliveryPrice() > 0 AND $model->getTotalPrice() < $freeFrom || $freeFrom == 0}
                                    <div>
                                        {lang('Delivery','admin')}:
                                        <b>
                                            +{echo ShopCore::app()->SCurrencyHelper->convert($model->getDeliveryPrice())} {$CS}
                                        </b>
                                    </div>
                                {/if}
                                {if $discount > 0}
                                    <div>
                                        {lang('Discount','admin')}:
                                        <b>
                                            -{echo ShopCore::app()->SCurrencyHelper->convert($discount)} {$CS}
                                        </b>
                                    </div>

                                {/if}
                                {if $model->getGiftCertPrice() > 0}
                                    <div>
                                        {lang('Gift Certificate','admin')}:
                                        <b>
                                            -{echo ShopCore::app()->SCurrencyHelper->convert($model->getGiftCertPrice())} {$CS}
                                        </b>
                                    </div>
                                {/if}
                                <div class="clearfix">
                                    <div class="gen_sum pull-right">
                                        {lang('In total','admin')}:
                                        <b>
                                            {if $model->getTotalPrice() >= $freeFrom  && $freeFrom != 0}
                                                {$delivery = 0}
                                            {else:}
                                                {$delivery = ShopCore::app()->SCurrencyHelper->convert($model->getDeliveryPrice())}
                                            {/if}
                                            {echo $model->getTotalPrice() +  $delivery} {$CS}
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="title-default">{lang("Order status and history", "admin")}</div>
        {if count($statusHistory)}
            {$counter = 1}
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="span2">{lang('Status','admin')}</th>
                        <th class="span2">{lang('Modify date','admin')}</th>
                        <th class="span6">{lang('Comment','admin')}</th>
                        <th class="span2">{lang('Manager','admin')}</th>
                        <th class="span2">{lang('Payment status','admin')}</th>
                    </tr>
                </thead>
                <tbody>
                    {if count($statusHistory)}
                        {$counter = 1}
                        {foreach $statusHistory as $sh}
                            <tr>
                                <td>
                                    <span class="badge"  style="color: {echo $sh->getSOrderStatuses()->getFontcolor()}; background-color: {echo $sh->getSOrderStatuses()->getColor()};">{echo $sh->getSOrderStatuses()->getName()}</span>
                                </td>
                                <td>{date("d-m-Y H:i:s", $sh->getDateCreated())}</td>
                                <td>{if $sh->getComment() != null}{echo $sh->getComment()}{else:}-{/if}</td>
                                <td>
                                    {if $usersName[$sh->getId()] && $usersName[$sh->getId()]['role']}
                                        {echo $usersName[$sh->getId()]['name']}
                                    {else:}
                                        -
                                    {/if}
                                </td>
                                <td>
                                    {if $model->getPaid()}
                                        <span class="badge badge-success">{lang('Paid','admin')}</span>
                                    {else:}
                                        <span class="badge"> {lang('Unpaid','admin')} </span>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                </tbody>
            </table>
        {/if}
        <input type="hidden" name="OrderId" value="{echo $model->getId()}"/>
        {form_csrf()}
    </form>
</section>
<script type="text/javascript">
    var productsAmount = "{echo $model->getTotalPrice()}";
    var deliveryPrice = "{echo $model->getDeliveryPrice()}";
    var giftPrice = "{echo $model->getGiftCertPrice()}";
    productsAmount = parseFloat(productsAmount);
    deliveryPrice = parseFloat(deliveryPrice);
    giftPrice = parseFloat(giftPrice);
    if (isNaN(giftPrice))
        giftPrice = 0;
    var deliveryPrices = new Object;
    {foreach $deliveryMethods as $dm}
    deliveryPrices["{echo $dm->getId()}"] = parseFloat("{echo $dm->getPrice()}");
    {/foreach}
</script>
<!--  dialog  -->
<div class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Add product to order','admin')}</h3>
    </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        <input type="submit" class="btn btn-primary formSubmit" data-form="#addToCartForm" id="addToCartConfirm" value="{lang('Add','admin')}"/>
    </div>
</div>