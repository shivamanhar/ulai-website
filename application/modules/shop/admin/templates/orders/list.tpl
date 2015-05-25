<div class="container">
    <div class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Order removal','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang(' Delete selected orders?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="orders.deleteOrdersConfirm()" >{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>

    <form method="get" action="/admin/components/run/shop/orders/index" id="ordersListFilter" class="listFilterForm">
        <section class="mini-layout">
            <div class="frame_title clearfix">
                <div class="pull-left">
                    <span class="help-inline"></span>
                    <span class="title">{lang('Orders list','admin')} { /* }({$totalOrders}){ */ }</span>
                </div>
                <div class="pull-right">
                    <div class="d-i_b">
                        <a title="{lang('Reset filter','admin')}" type="button" {if !$_GET || (count($_GET)==1 && $_GET['_pjax'])}disabled="disabled"{else:}href="{$ADMIN_URL}orders/index"{/if} class="btn btn-small"><i class="icon-refresh"></i>{lang('Cancel filter','admin')}</a>
                        <div class="dropdown d-i_b">
                            <button type="submit" class="d_n btn btn-small disabled action_on listFilterSubmitButton" disabled="disabled"><i class="icon-filter"></i>{lang('Filter','admin')}</button>
                            <button type="button" class="btn btn-small dropdown-toggle disabled action_on" data-toggle="dropdown">
                                <i class="icon-bookmark"></i>
                                {lang('Change status','admin')}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="nav-header">{lang('Order status','admin')}</li>
                                {foreach $orderStatuses as $os}
                                <li><a onclick="orders.chOrderStatus({echo $os->getId()})" href="#" class="chOrderStatus" >{echo $os->getName()}</a></li>
                                {/foreach}
                                <li class="nav-header">{lang('Payment status','admin')}</li>
                                <li><a onclick="orders.chOrderPaid(1)" href="#" id="chOrderStatusNew" >{lang('Paid','admin')}</a></li>
                                <li><a onclick="orders.chOrderPaid(0)" href="#" id="chOrderStatusDelivered" >{lang('Not paid','admin')}</a></li>
                            </ul>
                        </div>
                        <button onclick="orders.deleteOrders()" type="button" class="btn btn-small btn-danger disabled action_on"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
                        <a href="/admin/components/run/shop/orders/create" class="btn btn-small btn-success pjax"><i class="icon-plus-sign icon-white"></i>{lang('Create order','admin')}</a>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <table class="table  table-bordered table-hover table-condensed t-l_a">
                    <thead>
                        <tr>
                            <th class="t-a_c span1">
                                <span class="frame_label">
                                    <span class="niceCheck" style="background-position: -46px 0px; ">
                                        <input type="checkbox">
                                    </span>
                                </span>
                            </th>
                            <th class="span1" id="orderId">
                                <a href="#" class="order_list_order" data-method="Id" data-criteria="{if $orderField == 'Id'}{$nextOrderCriteria}{else:}ASC{/if}">{lang('ID','admin')}</a>
                                {if isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'Id' AND ShopCore::$_GET['orderCriteria']}
                                {if ShopCore::$_GET['orderCriteria'] == 'ASC'}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                                {/if}
                            </th>
                            <th id="orderStatus" class="span1" style="width:12%;">
                                <a class="order_list_order" href="#" data-method="Status" data-criteria="{if $orderField == 'Status'}{$nextOrderCriteria}{else:}ASC{/if}">{lang('Status','admin')}</a>
                                {if isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'Status'}
                                {if ShopCore::$_GET['orderCriteria'] == 'ASC'}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                                {/if}
                            </th>
                            <th id="orderDateCreated" class="span3">
                                <a href="#" class="order_list_order" data-method="DateCreated" data-criteria="{if $orderField == 'DateCreated'}{$nextOrderCriteria}{else:}ASC{/if}">{lang('Date','admin')}</a>
                                {if isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'DateCreated'}
                                {if ShopCore::$_GET['orderCriteria'] == 'ASC'}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                                {/if}
                            </th>
                            <th class="span2">{lang('Customer','admin')}</th>
                            <th class="span1">{lang('Products','admin')}</th>
                            <th id="orderTotalPrice" style="width: 15%">
                                <a href="#" class="order_list_order" data-method="TotalPrice" data-criteria="{if $orderField == 'TotalPrice'}{$nextOrderCriteria}{else:}ASC{/if}">{lang('Total price','admin')} {lang('no delivery','admin')}</a>
                                {if isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'TotalPrice'}
                                {if ShopCore::$_GET['orderCriteria'] == 'ASC'}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                                {/if}
                            </th>
                            <th id="orderPaid" class="span2">
                                <a href="#" class="order_list_order" data-method="Paid" data-criteria="{if $orderField == 'Paid'}{$nextOrderCriteria}{else:}ASC{/if}">{lang('Payment status','admin')}</a>

                                {if isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'Paid'}
                                {if ShopCore::$_GET['orderCriteria'] == 'ASC'}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                                {/if}
                                <input type="hidden" name="orderMethod" value="{if isset(ShopCore::$_GET['orderMethod'])}{echo ShopCore::$_GET['orderMethod']}{else:}Id{/if}"/>
                                <!--<input type="hidden" name="orderCriteria" value="{if ShopCore::$_GET['orderCriteria'] != ''}{ShopCore::$_GET['orderCriteria']}{else:}DESC{/if}"/>-->
                                <input type="hidden" name="orderCriteria" value="{echo ShopCore::$_GET['orderCriteria']}"/>
                            </th>
                        </tr>
                        <tr class="head_body">
                            <td>
                            </td>
                            <td class="number">
                                <div>
                                    <input type="text" name="order_id" data-placement="top" data-original-title="{lang('numbers only','admin')}" value="{$_GET['order_id']}">
                                </div>
                            </td>
                            <td>
                                <select name="status_id" onchange="$(this).closest('form').submit();">
                                    <option {if !$_GET['status_id']} selected="selected" {/if} >-- {lang('All', 'admin')} --</option>
                                    {foreach $orderStatuses as $orderStatus}
                                    <option {if $orderStatus->getId() == $_GET['status_id']} selected="selected" {/if} value="{echo $orderStatus->getId()}">{echo $orderStatus->getName()}</option>
                                    {/foreach}
                                </select>
                            </td>
                            <td class="f-s_0">
                                <label class="v-a_m" style="width:47%;margin-right:6%; display: inline-block;margin-bootom:0px;">
                                    <span class="o_h d_b p_r">
                                        <input type="text" placeholder="{lang('from','admin')}" data-placement="top" data-original-title="{lang('choose a date','admin')}" data-rel="tooltip" class="datepicker "  name="created_from" value="{$_GET['created_from']}" >
                                        <i class="icon-calendar"></i>
                                    </span>
                                </label>
                                <label class="v-a_m" style="width:47%; display: inline-block;margin-bootom:0px;">
                                    <span class="o_h d_b p_r">
                                        <input type="text" placeholder="{lang('to','admin')}" data-placement="top" data-original-title="{lang('choose a date','admin')}" data-rel="tooltip" class="datepicker "  name="created_to" value="{$_GET['created_to']}">
                                        <i class="icon-calendar"></i>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <input  type="text" name="customer" id="usersDatas" value="{$_GET['customer']}">
                            </td>
                            <td>
                                <input type="text" name="product" value="{$_GET['product']}" id="ordersFilterProduct">
                                <input name="product_id" type="hidden" value="{$_GET['product_id']}" id="ordersFilterProdId">
                            </td>
                            <td class="number f-s_0">
                             <label class="v-a_m" style="width:47%;margin-right:6%; display: inline-block;margin-bootom:0px;">
                                <span class="o_h d_b"><input value="{echo ShopCore::$_GET['amount_from']}" placeholder="{lang('from','admin')}" type="text" data-placement="top" data-original-title="{lang('numbers only','admin')}" name="amount_from"></span>
                            </label>
                            <label class="v-a_m" style="width:47%;display: inline-block;margin-bootom:0px;">
                                <span class="o_h d_b"><input value="{echo ShopCore::$_GET['amount_to']}" placeholder="{lang('to','admin')}" type="text" data-placement="top" data-original-title="{lang('numbers only','admin')}" name="amount_to"></span>
                            </label>
                        </td>
                        <td>
                            <select name="paid" onchange="$(this).closest('form').submit();">
                                <option {if !ShopCore::$_GET['paid']} selected="selected" {/if} value="">-- {lang('All', 'admin')} --</option>
                                <option {if "0" === ShopCore::$_GET['paid']} selected="selected" {/if} value="0">{echo lang('Not paid','admin')}</option>
                                <option {if "1" == ShopCore::$_GET['paid']} selected="selected" {/if} value="1">{echo lang('Paid','admin')}</option>
                            </select>
                        </td>
                    </tr>
                </thead>
                <tbody >
                    {$total_price_all=0}{$total_products=0}{$total_paid=0}
                    {foreach $model as $o}
                    <tr data-original-title="" class="simple_tr">
                        <td class="t-a_c">
                            <span class="frame_label">
                                <span class="niceCheck" style="background-position: -46px 0px; ">
                                    <input type="checkbox" name="ids" value="{echo $o->getId()}">
                                </span>
                            </span>
                        </td>
                        <td><a class="pjax" href="{$ADMIN_URL}orders/edit/{echo $o->getId()}" data-title="{lang('Edit order','admin')}" data-rel="tooltip">{echo $o->getId()}</a></td>
                        <td>
                            {foreach $orderStatuses as $orderStatus}
                            {if $orderStatus->getId() == $o->getStatus()}
                            <span class="badge" style="background-color: {echo $orderStatus->getColor()}; color: {echo $orderStatus->getFontcolor()};">
                                {echo $orderStatus->getName()}
                                {/if}
                                {/foreach}
                            </span></td>
                            <td>{date("d-m-Y, H:i:s", $o->getDateCreated())}</td>
                            <td>
                                {if $o->getUserId()}<a class="pjax" href="{$ADMIN_URL}users/edit/{echo $o->getUserId()}" data-title="{lang('Edit user','admin')}" data-rel="tooltip">{echo ShopCore::encode($o->getUserFullName())}</a>
                                {else:} {echo ShopCore::encode($o->getUserFullName())} {/if}
                            </td>
                            <td>
                                <div class="buy_prod" data-title="{lang('Purchased Product','admin')}" data-original-title="">
                                    {$count = 0}
                                    {foreach $o->getSOrderProductss() as $i}
                                    {$count += $i->getQuantity()}
                                    {/foreach}
                                    <span>{echo $count}</span>
                                    <i class="icon-info-sign"></i>
                                </div>
                                <div class="d_n">
                                    {foreach $o->getSOrderProductss() as $p}
                                    <div class="check_product">
                                        {$productUrl = '#'}
                                        {$productModel = $p->getSProducts()}
                                        {if $productModel}
                                        <div class="">
                                            {$productUrl = '/shop/product/'.$productModel->getUrl()}
                                            <a target="_blank" href="{$productUrl}">{echo $p->getProductName()}</a>
                                        </div>
                                        {else:}
                                        {echo $p->getProductName()}
                                        {/if}
                                        <div class="">{echo $p->getVariantName()}</div>
                                        {if $p->getQuantity() != 1}
                                        {echo $p->getQuantity()} {lang('pcs','admin')}. ×
                                        {/if}
                                        {echo $p->getPrice(true)} {$CS}
                                    </div>
                                    {/foreach}
                                </div>
                            </td>

                            <td>

                                {//$total = 0}

                                {foreach $o->getSOrderProductss() as $p}
                                {//$total = $total + $p->getQuantity() *  $p->getPrice()}
                                {$total_products += $p->getQuantity()}
                                {/foreach}
                                {$total_price_all+=$o->getTotalPrice()}

                                {//$total} {//$CS}


                                {echo \Currency\Currency::create()->decimalPointsFormat($o->getTotalPrice())} {$CS}

                            </td>
                            <td> {$count_orders++}
                                {if $o->getPaid() == true}
                                <span class="label label-success">{lang('Paid','admin')}</span>{$total_paid++}
                                {else:}
                                <span class="label">{lang('Not paid','admin')}</span>
                                {/if}
                            </td>
                        </tr>
                        {/foreach}
                        <tr style="font-weight:bold;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                {if $total_products == 0}
                                    {echo "-"}
                                {else:}
                                    {echo $total_products++}
                                {/if}    
                            </td>
                            <td>
                                {if $total_price_all == 0}
                                    {echo "-"}
                                {else:}    
                                    {echo \Currency\Currency::create()->decimalPointsFormat($total_price_all)} {$CS} 
                                {/if}    
                            </td>
                            <td> 
                                {if $total_paid == 0 && $count_orders == NULL}
                                    {echo "-"} / {echo "-"}
                                {else:}
                                    {echo $total_paid++} / {$count_orders} 
                                {/if}    
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix">

                {$pagination}


                <div class="pagination pull-right">

                    <select title="{lang('Orders on the page','admin')}" onchange="change_status('{$ADMIN_URL}orders/paginationVariant/' + this.value + '/1');" class="input-mini">
                        <option {if $paginationVariant == 12} selected="selected" {/if}>12</option>
                        <option {if $paginationVariant == 24} selected="selected" {/if}>24</option>
                        <option {if $paginationVariant == 36} selected="selected" {/if}>36</option>
                        <option {if $paginationVariant == 48} selected="selected" {/if}>48</option>
                        <option {if $paginationVariant == 60} selected="selected" {/if}>60</option>
                        <option {if $paginationVariant == 78} selected="selected" {/if}>78</option>
                        <option {if $paginationVariant == 100} selected="selected" {/if}>100</option>
                    </select>
                </div>
                <div class="pagination pull-right" style="margin-right: 10px; margin-top: 24px;">{lang('Orders on the page','admin')}</div>
            </div>
        </section>
    </form>
</div>
<script type="text/javascript"> var usersDatas = {echo json_encode(array_values($usersDatas))};
var productsDatas = {echo json_encode($productsDatas)};
var orderField = "{$orderField}";
var noc = "{$nextOrderCriteria}";
var oldest_date = '{echo $oldest_order_date->oldest_date}';
var newest_date = '{echo $oldest_order_date->newest_date}';
</script>
