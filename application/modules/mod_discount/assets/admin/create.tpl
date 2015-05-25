<!--Start. Global js variables -->
<script type="text/javascript">
var currencySymbolJS = '{echo $CS}';
</script>
<!--End. Global js variables -->
<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Discount creating', 'mod_discount')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="/admin/components/init_window/mod_discount{echo $filterQuery}" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Back', 'mod_discount')}</span></a>
                <button onclick="" type="button" class="btn btn-small btn-success formSubmit submitButton" data-form="#createDiscountForm" data-submit>
                    <i class="icon-plus-sign icon-white"></i>{lang('Create', 'mod_discount')}
                </button>
                <button onclick="" type="button" class="btn btn-small formSubmit submitButton" data-form="#createDiscountForm" data-submit data-action="tomain">
                    <i class="icon-check"></i>{lang('Create and exit', 'mod_discount')}
                </button>
            </div>
        </div>
    </div>
    <form method="post" action="/admin/components/init_window/mod_discount/create" enctype="multipart/form-data" id="createDiscountForm" class="m-t_10">
        <table class="table  table-bordered table-condensed content_big_td module-cheep">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('Discount details', 'mod_discount')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd discount-out">
                            <div class="form-horizontal">
                                <label class="">
                                    <span class="span4">{lang('Discount name', 'mod_discount')}:</span>
                                    <span class="span8 discount-name"><input type="text" name='name' /></span>
                                </label>
                                <label class="">
                                    <span class="span4">{lang('Discount code', 'mod_discount')}:</span>
                                    <span class="span8">
                                        <div class="pull-right" style="margin-left: 5px;">
                                            <button class="btn" type="button" id="generateDiscountKey">
                                                <i class="icon-refresh"></i>
                                            </button>
                                        </div>
                                        <div class="o_h">
                                            <input readonly id="discountKey" type="text" name="key" value="" autocomplete="off"/>
                                        </div>
                                    </span>
                                </label>
                                <div class="noLimitC">
                                    <div class="span4">{lang('Count of usage', 'mod_discount')}:</div>
                                    <div class="span8">
                                        <span class="d-i_b m-r_10">
                                            <input class="input-small onlyNumbersInput " id="how-much" type="text" name="max_apply"  disabled='disabled' maxlength="7"/>
                                        </span>
                                        <span class="d-i_b v-a_m">
                                            <span class="frame_label no_connection m-r_15 spanForNoLimit spanForNoLimitCheckbox" >
                                                <span class="niceCheck" style="background-position: -46px 0px; ">
                                                    <input type="checkbox" checked="checked" class="noLimitCountCheck">
                                                </span>
                                                {lang('Unlimit', 'mod_discount')}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table  table-bordered table-condensed content_big_td module-cheep">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('Method of calculation', 'mod_discount')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd discount-out">
                            <div class="form-horizontal">
                                <div class="">
                                    <div class="span4">{lang('Choose method', 'mod_discount')}: <span class="must">*</span></div>
                                    <div class="span8">
                                        <div class="d-i_b m-r_15">
                                            <select name="type_value" id="selectTypeValue">
                                                <option value="1">{lang('Percents', 'mod_discount')}</option>
                                                <option value="2">{lang('Fixed', 'mod_discount')}</option>
                                            </select>
                                        </div>
                                        <div class="d-i_b w-s_n-w">
                                            <input id="valueInput" class="input-small required" required="required" type="text" name="value" maxlength="9" />
                                            <span  id="typeValue">
                                                %
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table  table-bordered table-condensed content_big_td module-cheep">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('Discount type', 'mod_discount')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd discount-out">
                            <div class="form-horizontal">
                                <!-- Start. Choose type discount -->
                                <div class="m-b_15">
                                    <div class="span4">{lang('Choose type', 'mod_discount')}:</div>
                                    <div class="span4">
                                        <select name="type_discount" id="selectDiscountType" class="required no_color">
                                            <option  value="">{lang('No', 'mod_discount')}</option>
                                            <option value="certificate">{lang('Gift Certificate', 'mod_discount')}</option>
                                            <option value="all_order">{lang('Order amount of more than', 'mod_discount')}</option>
                                            <option value="comulativ">{lang('Cumulative discount', 'mod_discount')}</option>
                                            <option value="user">{lang('User', 'mod_discount')}</option>
                                            <option value="group_user">{lang('Users group', 'mod_discount')}</option>
                                            <option value="category">{lang('Category', 'mod_discount')}</option>
                                            <option value="product">{lang('Product', 'mod_discount')}</option>
                                            <option value="brand">{lang('Brand', 'mod_discount')}</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- End. Choose type discount -->

                                <div class="">
                                    <div class="span4"></div>
                                    <div class="span6">
                                        <div class="">
                                            <!--Start. Show if discount type is all_orders -->
                                            <div id="certificateBlock" class="forHide" style="display: none;">
                                                <span class="d_b m-b_10">
                                                    <span class="d-i_b sum-of-order"><input type="hidden" name="certificate[begin_value]" value="0" maxlength="9" /></span>
                                                    <input type="hidden" id="gift_checkbox" name="certificate[is_gift]" value="0">
                                                </span>
                                            </div>
                                            <!-- End. Show if discount type is all_orders -->
                                        </div>
                                        <div class="">
                                            <!--Start. Show if discount type is all_orders -->
                                            <div id="all_orderBlock" class="forHide" style="display: none;">
                                                <span class="d_b m-b_10">
                                                    <span class="d-i_b sum-of-order"><input class="input-small onlyNumbersInput" type="text" name="all_order[begin_value]" value="0" maxlength="9" /></span>
                                                    <span class="d-i_b">{echo $CS}</span>
                                                </span>
                                                <div class="m-b_5">
                                                    <span class="frame_label no_connection m-r_15 spanForNoLimit noLimitChecker" >
                                                        <span class="niceCheck" style="background-position: -46px 0px; ">
                                                            <input type="checkbox" name="all_order[for_autorized]" value="1" class="noLimitCountCheck">
                                                        </span>
                                                        {lang('Only for registered', 'mod_discount')}
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- End. Show if discount type is all_orders -->
                                        </div>
                                        <div class="">
                                            <!--Start. Show if discount type is comulativ -->
                                            <div id="comulativBlock" class="forHide" style="display: none;">
                                                <span class="d-i_b m-r_5">{lang('from', 'mod_discount')} <span class="must">*</span></span>
                                                <span class="d-i_b">
                                                    <input class="input-small onlyNumbersInput required" required="required" type="text" name="comulativ[begin_value]" value="" maxlength="9" />
                                                </span>
                                                <div class="noLimitC d-i_b">
                                                    <span class="d-i_b m-r_5">{lang('to', 'mod_discount')}</span>
                                                    <span class="d-i_b">
                                                        <input class="input-small onlyNumbersInput" type="text" name="comulativ[end_value]" value="" maxlength="9"/>
                                                    </span>
                                                    <span class="d-i_b">{echo $CS}</span>
                                                    <span class="d-i_b m-l_20">
                                                        <span class="frame_label no_connection m-r_15 spanForNoLimit d-i_b v-a_m" >
                                                            <span class="niceCheck" style="background-position: -46px 0px; ">
                                                                <input type="checkbox" class="noLimitCountCheck">
                                                            </span>
                                                            {lang('Maximum', 'mod_discount')}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- End. Show if discount type is comulativ -->
                                        </div>
                                        <div class="">
                                            <!--Start. Show if discount type is user -->
                                            <div id="userBlock" class="forHide" style="display: none;">
                                                <div>
                                                    <div>
                                                        <label> {lang('ID / Name / E-mail', 'mod_discount')} : <span class="must">*</span></label>
                                                        <input id="usersForDiscount" required="required" style="border-color: coral;" type="text" value="" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                                                        <input id="discountUserId" type="hidden" name="user[user_id]" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End. Show if discount type is user -->
                                        </div>
                                        <div class="">
                                            <!--Start. Show if discount type is group of users-->
                                            <div id="group_userBlock" class="forHide" style="display: none;">
                                                {$checked=TRUE}
                                                {foreach $userGroups as $group}
                                                <label>
                                                    <input type="radio" name="group_user[group_id]"  value="{echo $group[id]}" {if $checked}checked="checked" {/if}>{echo $group['alt_name']}<br/>
                                                </label>
                                                {$checked=FALSE}
                                                {/foreach}
                                            </div>
                                            <!-- End. Show if discount type is group of users-->
                                        </div>
                                        <div class="">
                                            <!--Start. Show if discount type is category of products-->
                                            <div id="categoryBlock" class="forHide" style="display: none;">
                                                <select name="category[category_id]">
                                                    {foreach $categories as $category}
                                                    <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())}{echo ShopCore::encode($category->getName())}</option>
                                                    {/foreach}
                                                </select></br>
                                                <input type="checkbox" name="category[child]" value="1"/>  {lang('Change child category', 'mod_discount')}

                                            </div>
                                            <!-- End. Show if discount type is category of products-->
                                        </div>
                                        <div class="">
                                            <!--Start. Show if discount type is product-->
                                            <div id="productBlock" class="forHide" style="display: none;">
                                                <div>
                                                    <label> {lang('ID / Name / Number', 'mod_discount')} : <span class="must">*</span></label>
                                                    <input id="productForDiscount" required="required" style="border-color: coral;" type="text" value="" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                                                    <input id="discountProductId" type="hidden" name="product[product_id]" value=""/>
                                                </div>
                                            </div>
                                            <!-- End. Show if discount type is product-->
                                        </div>
                                        <div class="">
                                            <!--Start. Show if discount type is brand-->
                                            <div id="brandBlock" class="forHide" style="display: none;">
                                                <select id="selectBrand" name="brand[brand_id]">
                                                    {foreach SBrandsQuery::create()->orderByID()->find() as $brand}
                                                    <option value="{echo $brand->getId()}">{echo ShopCore::encode($brand->getName())}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                            <!-- End. Show if discount type is vrand-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table  table-bordered table-condensed content_big_td module-cheep">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('Allowed time for discounts', 'mod_discount')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd discount-out">
                            <div class="form-horizontal">
                                <div class="">
                                    <div class="span4">{lang('Period of the discount from', 'mod_discount')}: <span class="must">*</span></div>
                                    <div class="span8">
                                        <div class="">
                                            <span class="d-i_b">
                                                <label class="p_r">
                                                    <input class="required discountDate beginDateDiscount" required="required" type="text" value="" name="date_begin" onkeypress="return false;" onkeyup="return false;" onkeydown="return false;" autocomplete="off" />
                                                    <span class="icon-calendar"></span>
                                                </label>
                                            </span>
                                            <span class="d-i_b m-r_10 m-l_10">{lang('to', 'mod_discount')} </span>
                                            <span class="d-i_b">
                                                <div class="noLimitC">

                                                    <label class="d-i_b p_r">
                                                        <input class="discountDate endDateDiscount" type="text"  value=""  disabled="disabled" name="date_end" onkeypress="return false;" onkeyup="return false;" onkeydown="return false;" autocomplete="off"/>
                                                        <span class="icon-calendar"></span>
                                                    </label>
                                                    <div class="d-i_b m-l_10 v-a_m">
                                                        <span class="frame_label no_connection m-r_15 spanForNoLimit" >
                                                            <span class="niceCheck" style="background-position: -46px 0px; ">
                                                                <input type="checkbox"  checked class="noLimitCountCheck">
                                                            </span>
                                                            {lang('Constant discount', 'mod_discount')}
                                                        </span>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div id="elFinder"></div>
</section>