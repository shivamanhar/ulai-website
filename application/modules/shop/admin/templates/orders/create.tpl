<script type="text/javascript">
    var curr = '{$CS}';
</script>
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
                <button type="button" class="btn btn-small btn-success action_on formSubmit" data-action="edit" data-form="#add_order_form" data-submit id="createOrder"><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-action="close" data-form="#add_order_form" id="createOrderAndExit"><i class="icon-check"></i>{lang('Create and exit','admin')}</button>
            </div>
        </div>
    </div>        
    <form method="post" action="{$ADMIN_URL}orders/create"  class="form-horizontal" id="add_order_form">
        <div class="row-fluid m-t_20">
            <div class="span6">
                <div class="btn-group myTab" data-toggle="buttons-radio">
                    <a href="#quicksearch" class="btn btn-small active">{lang("Quick product search", "admin")}</a>
                    <a href="#advancedsearch" class="btn btn-small">{lang("Advanced search product", "admin")}</a>
                </div>
                <div class="tab-content m-t_15">
                    <div class="tab-pane active" id="quicksearch">
                        <div class="frame-input-w100">
                            <div class="control-group">
                                <label class="control-label">
                                    {lang("Product search", "admin")}:
                                </label>
                                <div class="controls">
                                    <input id="productNameForOrders" type="text" value="">
                                    <span class="help-inline">{lang('ID','admin')} / {lang('Title', 'admin')} / {lang('Article', 'admin')}</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang("Search results", "admin")}:
                                </label>
                                <div class="controls">
                                    <select  multiple="multiple" class="productsForOrders notchosen" style="height:250px !important;"></select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Variant','admin')}:
                                </label>
                                <div class="controls">
                                    <select class="variantsForOrders"></select>
                                    <div class="variantInfoBlock" style="display:none;">
                                        <div class="clearfix m-t_15">
                                            <div class="pull-left m-r_10">
                                                <a href="#" target="_blank">
                                                    <img class="imageSrc img-polaroid" style="width: 55px;">
                                                </a>
                                            </div>
                                            <div class="o_h">
                                                <div class="productText"></div>
                                                <div>
                                                    <span class="productStock"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-t_10">
                                            <button type="button" class="addVariantToCart btn btn-small">
                                                {lang('Add to Cart','admin')}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="advancedsearch">
                        <div class="frame-input-w100">
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Category','admin')}:  
                                </label>
                                <div class="controls">
                                    <select id="categoryForOrders" >
                                        <option disabled='disabled' selected='selected'>{lang('Select a category', 'admin')}</option>
                                        {foreach $categories as $category}
                                            <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang("Search results", "admin")}:
                                </label>
                                <div class="controls">
                                    <select  multiple="multiple" class="productsForOrders notchosen" style="height:250px !important;"></select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Variant','admin')}:
                                </label>
                                <div class="controls">
                                    <select class="variantsForOrders"></select>
                                    <div class="variantInfoBlock" style="display:none;">
                                        <div class="clearfix m-t_15">
                                            <div class="pull-left m-r_10">
                                                <a href="#" target="_blank">
                                                    <img class="imageSrc img-polaroid" style="width: 55px;">
                                                </a>
                                            </div>
                                            <div class="o_h">
                                                <div class="productText"></div>
                                                <div>
                                                    <span class="productStock"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-t_10">
                                            <button type="button" class="addVariantToCart btn btn-small">
                                                {lang('Add to Cart','admin')}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="btn-group myTab" data-toggle="buttons-radio">
                    <a href="#newuser" class="btn btn-small active">{lang("New user", "admin")}</a>
                    <a href="#searchuser" class="btn btn-small">{lang("Find a user", "admin")}</a>
                </div>
                <div class="tab-content m-t_15">
                    <div class="tab-pane active" id="newuser">
                        <div class="frame-input-w100">
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Full Name','admin')}:
                                    <span class="required">*</span>
                                </label>
                                <div class="controls">
                                    <input id="createUserName" type="text" value=""/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    E-mail:
                                    <span class="required">*</span>
                                </label>
                                <div class="controls">
                                    <input id="createUserEmail" type="text" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Phone','admin')}:
                                </label>
                                <div class="controls">
                                    <input id="createUserPhone" type="text" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Address','admin')}:
                                </label>
                                <div class="controls">
                                    <input id="createUserAddress" type="text" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Delivery method','admin')}:
                                </label>
                                <div class="controls">
                                    <select class="shopOrdersdeliveryMethod" value="" data-rel="#newUserPayment" data-rel2='[name="shop_orders[delivery_method]"]'>
                                        <option value="0">{lang('Not selected','admin')}</option>
                                        {foreach $deliveryMethods as $dm}
                                            <option value="{echo $dm->getId()}">{echo $dm->getName()}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Payment method','admin')}:
                                </label>
                                <div class="controls">
                                    <select class="shopOrdersPaymentMethod" value="" id="newUserPayment" data-rel='[name="shop_orders[payment_method]"]'>
                                        <option value="0">{lang('Not selected','admin')}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="searchuser">
                        <div class="frame-input-w100">
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Buyer','admin')}:
                                </label>
                                <div class="controls">
                                    <input id="usersForOrders" type="text" value=""/>
                                    <spna class="help-inline">{lang('ID / Full Name / Email','admin')}</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang("Search results", "admin")}:
                                </label>
                                <div class="controls">
                                    <select  multiple="multiple" class="notchosen" id="listUsersForOrder" style="height:250px !important;"></select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    E-mail:
                                </label>
                                <div class="controls">
                                    <input id="userEmail" type="text" value="" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Phone','admin')}:
                                </label>
                                <div class="controls">
                                    <input id="userPhone" type="text" value="" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Address','admin')}:
                                </label>
                                <div class="controls">
                                    <input id="userAddress" type="text" value="" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Delivery method','admin')}:
                                </label>
                                <div class="controls">
                                    <select class="shopOrdersdeliveryMethod" value="" data-rel="#userPayment" data-rel2='[name="shop_orders[delivery_method]"]'>
                                        <option value="0">{lang('Not selected','admin')}</option>
                                        {foreach $deliveryMethods as $dm}
                                            <option value="{echo $dm->getId()}">{echo $dm->getName()}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Payment method','admin')}:
                                </label>
                                <div class="controls">
                                    <select class="shopOrdersPaymentMethod" value="" id="userPayment" data-rel='[name="shop_orders[payment_method]"]'>
                                        <option value="0">{lang('Not selected','admin')}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="shop_orders[delivery_method]" value=""/>
                        <input type="hidden" name="shop_orders[payment_method]" value=""/>
                        <input id="shopOrdersUserid" type="hidden" name="shop_orders[user_id]" value="">
                        <input id="shopOrdersGiftCertKey" type="hidden" name="shop_orders[gift_cert_key]" value="">
                        <input id="shopOrdersGiftCertPrice" type="hidden" name="shop_orders[gift_cert_price]" value="">

                        <input id="shopOrdersUserFullName" type="hidden" name="shop_orders[user_full_name]" value="">
                        <input id="shopOrdersUserEmail" type="hidden" name="shop_orders[user_email]" value="">
                        <input id="shopOrdersUserPhone" type="hidden" name="shop_orders[user_phone]" value="">
                        <input id="shopOrdersUserAddress" type="hidden" name="shop_orders[user_delivery_to]" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="title-default">{lang("Cart", "admin")}</div>
        <table class="table  table-bordered table-hover table-condensed t-l_a" id="productsInCart">
            <thead>
                <tr>
                    <th style="width: 44px;"></th>
                    <th class="span6">{lang('Product','admin')}</th>
                    <th style="width: 100px;">{lang('Article','admin')}</th>
                    <th class="span2">{lang('Variant','admin')}</th>
                    <th class="span2">{lang('Price','admin')}</th>
                    <th style="width: 70px;">{lang('Quantity','admin')}</th>
                    <th class="span2">{lang('Total price','admin')}</th>
                </tr>
            </thead>
            <tbody id="insertHere">

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="t-a_r">
                        <div class="inside_padd clearfix">
                            <div class="pull-right">
                                <span class="v-a_m">
                                    <label for="shopOrdersCheckGiftCert" class="d_i">{lang('Gift Certificate','admin')}:</label>
                                    <input id="shopOrdersCheckGiftCert" type="text" name="gift" value="">
                                </span>
                                <span class="gen_sum d-i_b v-a_m">
                                    {lang('Total','admin')}: 
                                    <b>
                                        <span id="totalCartSum">0</span>
                                        <span class="productCartPriceSymbol">{$CS}</span>
                                    </b>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</section>

<!--Start. Add product block-->
<table style='display:none'>
    <tr class="addNewProductBlock">
        <td class="t-a_c">
            <button class="btn my_btn_s btn-small" data-rel="tooltip" data-title="{lang('Remove', 'admin')}" type="button" onclick="orders.deleteCartProduct(this)"><i class="icon-trash"></i></button>
        </td>
        <td>
            <span class="productCartName"></span>
            <input class="inputProductId" type="hidden" name="shop_orders_products[product_id][]" value="">
            <input class="inputProductName" type="hidden" name="shop_orders_products[product_name][]" value="">
        </td>
        <td>
            <span class="variantCartNumber">-</span>
        </td>
        <td>
            <input class="inputVariantId" type="hidden" name="shop_orders_products[variant_id][]" value="">
            <input class="inputVariantName" type="hidden" name="shop_orders_products[variant_name][]" value="">
            <span class="variantCartName">-</span>
        </td>
        <td>
            <input class="inputPrice" type="hidden" name="shop_orders_products[price][]" value="">
            <span class="productCartPrice"></span>
            <span class="productCartPriceSymbol"></span>
        </td>
        <td>
            <div class="p_r frame_price number">
                <input onkeyup="orders.updateQuantityAdmin(this)" type="text" name="shop_orders_products[quantity][]" value="1" class="js_price productCartQuantity inputQuantity input-mini" data-placement="top" data-original-title="{lang('Digits only','admin')}">
            </div>
        </td>
        <td>
            <span class="productCartTotal"></span>
            <span class="productCartPriceSymbol"></span>
        </td>
    </tr>
</table>
<!--End. Add product block-->
<!-- php vars to js -->
<script type="text/javascript">
    var pricePrecision = parseInt('{echo ShopCore::app()->SSettings->pricePrecision}');
    var checkProdStock = "{echo ShopCore::app()->SSettings->ordersCheckStocks}";
</script>