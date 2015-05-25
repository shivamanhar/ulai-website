<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Product creation','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <!-- $_SESSION['ref_url'] is session variable to save filter results to go back to it -->
                <a href="{$ADMIN_URL}search/index{$_SESSION['ref_url']}" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary action_on formSubmit" data-form="#image_upload_form"><i class="icon-ok"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-form="#image_upload_form" data-action="close"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>
            </div>
        </div>
    </div>
    <form  action="{$ADMIN_URL}products/create" method="post" enctype="multipart/form-data"  id="image_upload_form">
        <div class="clearfix">
            <div class="btn-group myTab m-t_10 pull-left" data-toggle="buttons-radio">
                <a href="#parameters" class="btn btn-small active">{lang('Product','admin')}</a>
                <!--<a href="#parameters_article" class="btn btn-small">{lang('Properties','admin')}</a>-->
                <!--<a href="#additionalPics" class="btn btn-small">{lang('Images','admin')}</a>
                <a href="#kits" class="btn btn-small">{lang('Kits','admin')}</a>-->
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="parameters">
                <table class="table  table-bordered table-hover table-condensed content_big_td">
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
                                <div class="inside_padd">
                                    <div class="form-horizontal">
                                        <div data-frame>
                                            <div class="control-group">
                                                <label class="control-label" for="Name">{echo $translatable} {lang('Product name','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" id="Name" name="Name" value="" class="required">
                                                </div>
                                            </div>
                                            <table class="table table-bordered t-l_a">
                                                <thead>
                                                    <tr>
                                                        <th width="17px"></th>
                                                        <th>{echo $translatable_w} {lang('Product variant name','admin')}</th>
                                                        <th>{echo ShopCore::encode($model->getLabel('Price'))} <span class="required">*</span></th>
                                                        {if count($currencies)>0}
                                                        <th>{lang('Currency','admin')}</th>
                                                        {/if}
                                                        <th>{echo ShopCore::encode($model->getLabel('Number'))}</th>
                                                        <th>{echo ShopCore::encode($model->getLabel('Stock'))}</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    <tr class="head_body">
                                                    </tr>
                                                </thead>
                                                <tbody class="sortable" id="variantHolder">
                                                    <tr id="ProductVariantRow_0">
                                                        <td><img src="{$SHOP_THEME}images/drag_arrow.png" class="drager" /></td>
                                                        <td>
                                                            <input type="hidden" name="variants[RandomId][]"  class="random_id" value="45456465"/>
                                                            <input type="text" name="variants[Name][]" value=""/>
                                                        </td>
                                                        <td><input type="text" name="variants[PriceInMain][]" value="" class="required"/></td>
                                                        {if count($currencies)>0}
                                                        <td>
                                                            <select name="variants[currency][]">
                                                                {foreach $currencies as $c}
                                                                <option value="{echo $c->getId()}">{echo $c->getCode()}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                        {/if}
                                                        <td><input type="text" name="variants[Number][]" value="" class="textbox_short" /></td>
                                                        <td><input type="text" name="variants[Stock][]" value="" class="textbox_short" /></td>
                                                        <td class="variantImage">

                                                            <button class="btn btn-small delete_image" type="button" data-title="{lang('Delete','admin')}">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                            <div class="control-group">
                                                                <label class="control-label" style="display: none;">
                                                                    <span class="btn btn-small p_r" data-url="file" >
                                                                        <i class="icon-camera"></i>
                                                                        <input type="file" name="variants[mainPhoto][45456465]" title="{lang('Main image','admin')}"/>
                                                                        <!--<input type="hidden" name="variants[MainImageForDel][]" value="0"/>    -->
                                                                    </span>
                                                                </label>
                                                                <div class="controls">
                                                                    <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="variantImage">
                                                            <button class="btn btn-small delete_image" type="button" data-title="{lang('Delete','admin')}">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                            <div class="control-group">
                                                                <label class="control-label" style="display: none;">
                                                                    <span class="btn btn-small p_r" data-url="file">
                                                                        <i class="icon-camera"></i>
                                                                        <input type="file" name="variants[smallPhoto][45456465]" title="{lang('Main image','admin')}"/>
                                                                        <!--<input type="hidden" name="variants[SmallImageForDel][]" value="0"/>    -->
                                                                    </span>
                                                                </label>
                                                                <div class="controls">
                                                                    <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {if $i>0}
                                                            <button class="btn my_btn_s btn-small" type="button" data-remove data-rel="tooltip" data-title="{lang('Delete','admin')}"><i class="icon-trash"></i></button>
                                                            {/if}
                                                        </td>
                                                    </tr>
                                                    {$i++}
                                                </tbody>
                                            </table>
                                            <button class="btn my_btn_s btn-small d_n" type="button" data-remove="example" data-rel="tooltip" data-title="{lang('Delete','admin')}"><i class="icon-trash"></i></button>
                                            <div class="clearfix">
                                                <!--<button type="button" class="pull-right btn btn-small btn-success" data-rel="add_new_clone" href=""><i class="icon-plus-sign icon-white"></i>{lang('Add a variant','admin')}</button>-->
                                                <button type="button" class="pull-right btn btn-small btn-success" id="addVariant"><i class="icon-plus-sign icon-white"></i>{lang('Add a variant','admin')}</button>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label"></label>
                                            <div class="controls">
                                                <span class="frame_label no_connection">
                                                    <span class="niceCheck" style="background-position: -46px 0px; ">
                                                        <input type="checkbox" name="Active" value="1" checked="checked">
                                                    </span>
                                                    {lang('Active','admin')}
                                                </span>
                                                <span class="frame_label no_connection m-l_15">
                                                    <span class="niceCheck" style="background-position: -46px 0px; ">
                                                        <input type="checkbox" name="Hit" value="1">
                                                    </span>
                                                    {lang('Hit','admin')}
                                                </span>
                                                <span class="frame_label no_connection m-l_15">
                                                    <span class="niceCheck" style="background-position: -46px 0px; ">
                                                        <input type="checkbox" name="Hot" value="1">
                                                    </span>
                                                    {lang('New','admin')}
                                                </span>
                                                <span class="frame_label no_connection m-l_15">
                                                    <span class="niceCheck" style="background-position: -46px 0px; ">
                                                        <input type="checkbox"  name="Action"  value="1" >
                                                    </span>
                                                    {lang('Promotion','admin')}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span5">
                                                <div class="control-group">
                                                    <label class="control-label" for="inputParent">{lang('Brand name','admin')}:</label>
                                                    <div class="controls">
                                                        <select id="inputParent" name="BrandId">
                                                            <option value="">{lang('Not specified','admin')}</option>
                                                            {foreach SBrandsQuery::create()->find() as $brand}
                                                            <option value="{echo $brand->getId()}">{echo ShopCore::encode($brand->getName())}</option>
                                                            {/foreach}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="comment">{lang('Category','admin')}:</label>
                                                    <div class="controls">
                                                        <select name="CategoryId" id="comment">
                                                            {foreach $categories as $category}
                                                            <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())}{echo ShopCore::encode($category->getName())}</option>
                                                            {/foreach}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="iddCategory">{lang('Additional categories', 'admin')}:</label>
                                                    <div class="controls">
                                                        <select name="Categories[]" multiple="multiple" id="iddCategory">
                                                            {foreach $categories as $category}
                                                            <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                                                            {/foreach}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span7" id="productsPhoto">
                                                <div class="row">
                                                    <div class="control-group span6">
                                                        <label class="control-label" for="inputImg">{lang('Main image','admin')}:
                                                            <span class="btn btn-small p_r" data-url="file">
                                                                <i class="icon-camera"></i>&nbsp;&nbsp;{lang('Select a file','admin')}
                                                                <input type="file" class="btn-small btn" id="inputImg" name="mainPhoto">
                                                            </span>
                                                            <span class="frame_label no_connection active d_b m-t_10">
                                                                <button class="btn btn-small deleteMainImages" type="button" data-rel="tooltip" data-title="{lang('Delete','admin')}">
                                                                    <i class="icon-trash"></i>
                                                                </button>
                                                            </span>
                                                            <span class="frame_label no_connection active d_b m-t_10">
                                                                <span class="niceCheck" style="background-position: -46px -17px; ">
                                                                    <input type="checkbox" checked="checked" value="1" name="autoCreateSmallImage" />
                                                                </span>
                                                                {lang('Create small image','admin')}
                                                            </span>
                                                        </label>
                                                        <div class="controls">
                                                            {if file_exists("uploads/shop/". $model->getId() ."_main.jpg")}
                                                            <img src="/uploads/shop/{echo $model->getMainImage()}?{rand(1,9999)}" class="img-polaroid" style="width: 100px;">
                                                            {else:}
                                                            <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                            {/if}
                                                        </div>
                                                    </div>
                                                    <div class="control-group span6">
                                                        <label class="control-label" for="inputSImg">{lang('Small image','admin')}:
                                                            <span class="btn btn-small p_r" data-url="file">
                                                                <i class="icon-camera"></i>&nbsp;&nbsp;{lang('Select file','admin')}
                                                                <input type="file" class="btn-small btn" id="inputSImg" name="smallPhoto">
                                                            </span>
                                                            <span class="frame_label no_connection active d_b m-t_10">
                                                                <button class="btn btn-small deleteMainImages" type="button">
                                                                    <i class="icon-trash"></i>
                                                                </button>
                                                            </span>
                                                        </label>
                                                        <div class="controls">
                                                            <div class="photo-block">
                                                                <span class="helper"></span>
                                                                {if file_exists("uploads/shop/". $model->getId() ."_small.jpg")}
                                                                <img src="/uploads/shop/{echo $model->getId()}_small.jpg?{rand(1,9999)}" class="img-polaroid" style="width: 100px;">
                                                                {else:}
                                                                <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                                {/if}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="control-group span6">
                                                        <label class="control-label" for="inputMMod">{lang('Another main image variant','admin')}:
                                                            <span class="btn btn-small p_r" data-url="file">
                                                                <i class="icon-camera"></i>&nbsp;&nbsp;{lang('Select a file','admin')}
                                                                <input type="file" class="btn-small btn" id="inputMMod" name="mainModPhoto">
                                                            </span>
                                                            <span class="frame_label no_connection active d_b m-t_10">
                                                                <button class="btn btn-small deleteMainImages" data-rel="tooltip" data-title="{lang('Delete','admin')}" type="button">
                                                                    <i class="icon-trash"></i>
                                                                </button>
                                                            </span>
                                                        </label>
                                                        <div class="controls">
                                                            {if file_exists("uploads/shop/". $model->getId() ."_mainMod.jpg")}
                                                            <img src="/uploads/shop/{echo $model->getId()}_mainMod.jpg?{rand(1,9999)}" class="img-polaroid" style="width: 100px;">
                                                            {else:}
                                                            <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                            {/if}
                                                        </div>
                                                    </div>
                                                    <div class="control-group span6">
                                                        <label class="control-label" for="inputSMod">{lang('Another small image variant','admin')}:
                                                            <span class="btn btn-small p_r" data-url="file">
                                                                <i class="icon-camera"></i>&nbsp;&nbsp;Выбрать файл
                                                                <input type="file" class="btn-small btn" id="inputSMod" name="smallModPhoto">
                                                            </span>
                                                            <span class="frame_label no_connection active d_b m-t_10">
                                                                <button class="btn btn-small deleteMainImages" type="button">
                                                                    <i class="icon-trash"></i>
                                                                </button>
                                                            </span>
                                                        </label>
                                                        <div class="controls">
                                                            {if file_exists("uploads/shop/". $model->getId() ."_smallMod.jpg")}
                                                            <img src="/uploads/shop/{echo $model->getId()}_smallMod.jpg?{rand(1,9999)}" class="img-polaroid" style="width: 100px;">
                                                            {else:}
                                                            <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="ShortDescriptions">{echo $translatable} {lang('Short description','admin')}:</label>
                                            <div class="controls">
                                                <textarea class="elRTE focusOnClick" id="ShortDescriptions" name="ShortDescription">{echo ShopCore::encode($model->getShortDescription())}</textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="FullDescriptions">{echo $translatable} {lang('Full description','admin')}:</label>
                                            <div class="controls">
                                                <textarea class="elRTE focusOnClick" id="FullDescriptions" name="FullDescription">{echo ShopCore::encode($model->getFullDescription())}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {lang('Settings','admin')}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd">
                                    <div class="form-horizontal">
                                        <div class="row-fluid">
                                            <div class="control-group">
                                                <label class="control-label" for="pName">{lang('Warehouses','admin')}:
                                                    <button type="button" data-clone="wares" class="btn btn-small"><i class="icon-plus"></i></button><br/>
                                                </label>
                                                <div class="controls">
                                                    <div id="warehouses_container">
                                                        <div>
                                                            {foreach $model->getSWarehouseDatas() as $w_data}
                                                            <div id="warehouse_line">
                                                                <select name="warehouses[]" class="input-medium">
                                                                    <option value="">---</option>
                                                                    {foreach $warehouses as $w}
                                                                    <option {if $w->getId() == $w_data->getWarehouseId()}selected{/if} value="{echo $w->getId()}">{echo encode($w->getName())}</option>
                                                                    {/foreach}
                                                                </select>
                                                                <input type="text" name="warehouses_c[]"  value=""   class="input-medium"/>
                                                                <a data-del="wares" class="btn btn-small"><i class="icon-trash"></i></a>
                                                            </div>
                                                            {/foreach}
                                                        </div>
                                                        <div class="warehouses_container">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="comments">{lang('Comment permission','admin')}:</label>
                                                <div class="controls">
                                                    <select id="comments" class="input-mini">
                                                        <option {if $model->getEnableComments()} selected {/if} value="1">{lang('Yes','admin')}</option>
                                                        <option {if !$model->getEnableComments()} selected {/if}value="0">{lang('No','admin')}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="dCreate">{lang('Date of creation','admin')}:</label>
                                                <div class="controls">
                                                    <div class="o_h">
                                                        <input type="text" id="dCreate" name="Created" value="{echo date('Y-m-d', time())}" class="datepicker input-medium"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="oldP">{lang('Old price','admin')}</label>
                                                <div class="controls">
                                                    <div class="o_h">
                                                        <input type="text" id="oldP" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="RelatedProducts">{lang('Related products','admin')}:</label>
                                                <div class="controls">
                                                    <div class="o_h">
                                                        <input type="text" id="RelatedProducts"/>
                                                        <div id="relatedProductsNames" style="margin-top: 10px;">
                                                            {foreach $model->getRelatedProductsModels() as $shopKitProduct}
                                                            <div id="tpm_row{echo $shopKitProduct->getId()}" class="item-accessories">
                                                                <span class="pull-left">
                                                                    <input type="text" value=""/>
                                                                    <input type="hidden" name="RelatedProducts[]" value="">
                                                                </span>
                                                                <span style="margin-left: 1%;" class="pull-left">
                                                                    <button class="btn btn-small del_tmp_row" data-rel="tooltip" data-title="{lang('Delete','admin')}" data-kid="{echo $shopKitProduct->getId()}"><i class="icon-trash"></i></button>
                                                                </span>
                                                            </div>
                                                            {/foreach}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="templateGH">{lang('Main template','admin')}:</label>
                                                <div class="controls">
                                                    <div class="o_h" >
                                                        <input type="text" id="templateGH" name="tpl" value="{echo ShopCore::encode($model->tpl)}"/>
                                                    </div>
                                                    <p class="help-block">{lang('Product main template. By default product.tpl','admin')}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {lang('Meta data','admin')}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd">
                                    <div class="form-horizontal">
                                        <div class="row-fluid">
                                            <div class="control-group">
                                                <label class="control-label" for="Url">URL:</label>
                                                <div class="controls">
                                                    <input type="text" id="Url" value=""/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="Mtag">{echo $translatable} {lang('Meta Title','admin')}</label>
                                                <div class="controls">
                                                    <input type="text" name="MetaTitle" id="Mtag" value=""/>
                                                </div>
                                            </div>
                                            <!--<div class="control-group">
                                                <label class="control-label" for="mDesc">{echo $translatable} {lang('Meta Description','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" name="MetaDescription" id="mDesc" value=""/>
                                                </div>
                                            </div>-->
                                            <div class="control-group">
                                                <label class="control-label" for="mKey">{echo $translatable} {lang('Meta Keywords','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" name="MetaKeywords" id="mKey" value=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</section>
<div style="display:none;">
    <div class="warehouse_line">
        <select name="warehouses[]" class="input-medium">
            <option value="">---</option>
            {foreach $warehouses as $w}
            <option value="{echo $w->getId()}">{echo encode($w->getName())}</option>
            {/foreach}
        </select>
        <input type="text" name="warehouses_c[]"  value="" class="textbox_short input-medium"/>
        <a data-del="wares" class="btn btn-small"><i class="icon-trash"></i></a>
    </div>
</div>
<!-- ---------------------------------------------------Блок для додавання варыантів-------------------------------------- -->
<div style="display: none;" class="variantRowSample">
    <table>
        <tbody>
            <tr id="ProductVariantRow_">
                <td><img src="{$SHOP_THEME}images/drag_arrow.png" class="drager" /></td>
                <td>
                    <input type="hidden" name="variants[RandomId][]"  class="random_id" value=""/>
                    <input type="hidden" name="variants[CurrentId][]" value="" />
                    <input type="text" name="variants[Name][]" value=""/>
                </td>
                <td><input type="text" name="variants[PriceInMain][]" value=""/></td>
                {if count($currencies)>0}
                <td>
                    <select name="variants[currency][]">
                        {foreach $currencies as $c}
                        <option value="{echo $c->getId()}">{echo $c->getCode()}</option>
                        {/foreach}
                    </select>
                </td>
                {/if}
                <td><input type="text" name="variants[Number][]" value="" class="textbox_short" /></td>
                <td><input type="text" name="variants[Stock][]" value="" class="textbox_short" /></td>
                <td class="variantImage">
                    <button class="btn btn-small delete_image" type="button" data-title="{lang('Delete','admin')}">
                        <i class="icon-trash"></i>
                    </button>
                    <div class="control-group">
                        <label class="control-label" style="display: none;">
                            <span class="btn btn-small p_r" data-url="file" >
                                <i class="icon-camera"></i>
                                <input type="file" name="variants[mainPhoto][]" title="{lang('Main image','admin')}"/>
                                <input type="hidden" name="variants[MainImageForDel][]" value="0"/>
                            </span>
                        </label>
                        <div class="controls">
                            <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                        </div>
                    </div>
                </td>
                <td class="variantImage">
                    <button class="btn btn-small delete_image" type="button" data-title="{lang('Delete','admin')}">
                        <i class="icon-trash"></i>
                    </button>
                    <div class="control-group">
                        <label class="control-label" style="display: none;">
                            <span class="btn btn-small p_r" data-url="file">
                                <i class="icon-camera"></i>
                                <input type="file" name="variants[smallPhoto][]" title="{lang('Main image','admin')}"/>
                                <input type="hidden" name="variants[SmallImageForDel][]" value="0"/>
                            </span>
                        </label>
                        <div class="controls">
                            <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn my_btn_s btn-small" type="button" data-remove data-rel="tooltip" data-title="{lang('Delete','admin')}"><i class="icon-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- ---------------------------------------------------Блок для додавання варыантів-------------------------------------- -->