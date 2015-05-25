<!-- Edit product form -->
<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{echo ShopCore::encode($model->getName())}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <!-- $_SESSION['ref_url'] is session variable to save filter results to go back to it -->
                <a href="{$ADMIN_URL}search/index{$_SESSION['ref_url']}" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small action_on formSubmit btn-primary" data-form="#image_upload_form" data-submit><i class="icon-ok"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-form="#image_upload_form" data-action="close"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>
                {echo create_language_select($languages, $locale, "/admin/components/run/shop/products/edit/".$model->getId())}
            </div>
        </div>
    </div>
    <form  action="{$ADMIN_URL}products/edit/{echo $model->getId()}/{$locale}" method="post" enctype="multipart/form-data"  id="image_upload_form">
        {if $prev_id} <span  style="color:blue;">←</span><a href="/admin/components/run/shop/products/edit/{echo $prev_id}{echo $_SESSION['ref_url']}"> {lang('Previous','admin')}</a> {/if}
        {if $next_id} <a href="/admin/components/run/shop/products/edit/{echo $next_id}{echo $_SESSION['ref_url']}" style="padding-left:15px;">{lang('Next','admin')}</a> <span style="color:blue;"> →</span> {/if}
        <div class="clearfix">
            <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
                <a href="#parameters" class="btn btn-small active">{lang('Product','admin')}</a>
                <a href="#parameters_article" class="btn btn-small">{lang('Properties','admin')}</a>
                <a href="#additionalPics" class="btn btn-small">{lang('Images','admin')}</a>
                <a href="#kits" class="btn btn-small">{lang('Kits','admin')}</a>
            </div>
            <div class="pull-right m-t_20">
                <a href="/{echo $locale}/shop/product/{echo $model->getUrl()}" target="_blank">{lang('View page','admin')}<span class="f-s_14">→</span></a>
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
                                                <label class="control-label" for="Name">{echo $translatable} {lang('Product name','admin')}:<span class="required">*</span></label>
                                                <div class="controls">
                                                    <input type="text" id="Name" name="Name" value="{echo ShopCore::encode($model->getName())}">
                                                </div>
                                            </div>
                                            <table class="table table-bordered t-l_a">
                                                <thead>
                                                    <tr>
                                                        <th width="17px"></th>
                                                        <th>{echo $translatable_w} {lang('Product variant name','admin')} </th>
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
                                                <tbody class="sortable save_positions_variant" data-url="/admin/components/run/shop/search/save_positions_variant"  id="variantHolder">
                                                    {if $model->countProductVariants() > 0}
                                                    {$i=0}
                                                    {foreach $model->getProductVariants() as $v}
                                                    <tr id="ProductVariantRow_{$i}">
                                                        <input name="idv" type="hidden" value="{echo $v->id}"/>
                                                        <td>
                                                            <img src="{$SHOP_THEME}images/drag_arrow.png" class="drager" /></td>
                                                            <td>
                                                                <input type="hidden" name="variants[RandomId][]"  class="random_id" value=""/>
                                                                <input type="hidden" name="variants[CurrentId][]" value="{echo $v->getId()}" />
                                                                <input type="text" name="variants[Name][]" value="{echo ShopCore::encode($v->getName())}"/>
                                                            </td>
                                                            <td><input type="text" name="variants[PriceInMain][]" value="{echo ShopCore::encode($v->getPriceInMain())}"/></td>
                                                            {if count($currencies)>0}
                                                            <td>
                                                                <select name="variants[currency][]">
                                                                    {foreach $currencies as $c}
                                                                    <option value="{echo $c->getId()}" {if $c->getId() == $v->getCurrency()}selected="selected"{/if}>{echo $c->getCode()}</option>
                                                                    {/foreach}
                                                                </select>
                                                            </td>
                                                            {/if}
                                                            <td><input type="text" name="variants[Number][]" value="{echo ShopCore::encode($v->getNumber())}" class="textbox_short" /></td>
                                                            <td><input type="text" name="variants[Stock][]" value="{echo ShopCore::encode($v->getStock())}" class="textbox_short" /></td>
                                                            <td class="variantImage">
                                                                {if $v->getMainImage()}
                                                                <button class="btn btn-small delete_image" type="button" data-title="{lang('Delete','admin')}">
                                                                    <i class="icon-trash"></i>
                                                                </button>
                                                                {/if}
                                                                <div class="control-group">
                                                                    <label class="control-label" style="display: none;">
                                                                        <span class="btn btn-small p_r" data-url="file" >
                                                                            <i class="icon-camera"></i>
                                                                            <input type="file" name="variants[mainPhoto][{echo $v->getId()}]" title="{lang('Main image','admin')}"/>
                                                                            <input type="hidden" name="variants[MainImageForDel][]" value="0"/>
                                                                        </span>
                                                                    </label>
                                                                    <div class="controls">
                                                                        {if file_exists('uploads/shop/'.$model->getId().'_vM'.$v->getId().'.jpg')}
                                                                        <img src="{echo productImageUrl($model->getId().'_vM'.$v->getId().'.jpg')}" class="img-polaroid" style="width: 100px;">
                                                                        {else:}
                                                                        <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                                        {/if}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="variantImage">

                                                                {if $v->getSmallImage()}
                                                                <button class="btn btn-small delete_image" type="button" data-title="{lang('Delete','admin')}">
                                                                    <i class="icon-trash"></i>
                                                                </button>
                                                                {/if}
                                                                <div class="control-group">
                                                                    <label class="control-label" style="display: none;">
                                                                        <span class="btn btn-small p_r" data-url="file">
                                                                            <i class="icon-camera"></i>
                                                                            <input type="file" name="variants[smallPhoto][{echo $v->getId()}]" title="{lang('Main image','admin')}"/>
                                                                            <input type="hidden" name="variants[SmallImageForDel][]" value="0"/>
                                                                        </span>
                                                                    </label>
                                                                    <div class="controls">
                                                                        {if file_exists('uploads/shop/'.$model->getId().'_vS'.$v->getId().'.jpg')}
                                                                        <img src="{echo productImageUrl($model->getId().'_vS'.$v->getId().'.jpg')}" class="img-polaroid" style="width: 100px;">
                                                                        {else:}
                                                                        <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                                        {/if}
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
                                                        {/foreach}
                                                        {/if}
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
                                                    <span class="frame_label no_connection m-r_15">
                                                        <span class="niceCheck" style="background-position: -46px 0px; ">
                                                            <input type="checkbox" name="Active" value="1" {if $model->getActive() == true}checked="checked"{/if}>
                                                        </span>
                                                        {lang('Active','admin')}
                                                    </span>
                                                    <span class="frame_label no_connection m-r_15">
                                                        <span class="niceCheck" style="background-position: -46px 0px; ">
                                                            <input type="checkbox" name="Hit" value="1" {if $model->getHit() == true}checked="checked"{/if}>
                                                        </span>
                                                        {lang('Hit','admin')}
                                                    </span>
                                                    <span class="frame_label no_connection m-r_15">
                                                        <span class="niceCheck" style="background-position: -46px 0px; ">
                                                            <input type="checkbox" name="Hot" value="1" {if $model->getHot() == true}checked="checked"{/if}>
                                                        </span>
                                                        {lang('New','admin')}
                                                    </span>
                                                    <span class="frame_label no_connection">
                                                        <span class="niceCheck" style="background-position: -46px 0px; ">
                                                            <input type="checkbox"  name="Action" value="1" {if $model->getAction() == true}checked="checked"{/if}>
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
                                                                <option {if $model->getBrandId() == $brand->getId()} selected="selected" {/if} value="{echo $brand->getId()}">{echo ShopCore::encode($brand->getName())}</option>
                                                                {/foreach}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="comment">{lang('Category','admin')}:</label>
                                                        <div class="controls">
                                                            <select name="CategoryId" id="comment">
                                                                {foreach $categories as $category}
                                                                <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} {if $model->getCategoryId() == $category->getId()}selected="selected"{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())}{echo ShopCore::encode($category->getName())}</option>
                                                                {/foreach}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="iddCategory">{lang('Additional categories', 'admin')}:</label>
                                                        <div class="controls">
                                                            <select name="Categories[]" multiple="multiple" id="iddCategory">
                                                                {foreach $categories as $category}
                                                                {$selected=""}
                                                                {if in_array($category->getId(), $productCategories) && $category->getId() != $model->getCategoryId()}
                                                                {$selected="selected='selected'"}
                                                                {/if}
                                                                <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} {$selected} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
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
                                                                    <input type="hidden" name="deleteMainImage" value="0"/>
                                                                </span>
                                                                <span class="frame_label no_connection active d_b m-t_10">
                                                                    {if $model->getMainImage()}
                                                                    <button class="btn btn-small deleteMainImages" type="button" data-title="{lang('Delete','admin')}">
                                                                        <i class="icon-trash"></i>
                                                                    </button>
                                                                    {/if}
                                                                </span>
                                                                <span class="frame_label no_connection active d_b m-t_10">
                                                                    <span class="niceCheck" style="background-position: -46px -17px; ">
                                                                        <input type="checkbox" checked="checked" value="1" name="autoCreateSmallImage" />
                                                                    </span>
                                                                    {lang('Create small image','admin')}
                                                                </span>
                                                            </label>
                                                            <div class="controls">
                                                                {if file_exists("uploads/shop/". $model->getId() ."_main.jpg") && $model->getMainImage()}
                                                                <img src="/uploads/shop/{echo $model->getMainImage()}?{rand(1,9999)}" class="img-polaroid" style="width: 100px;">
                                                                {else:}
                                                                <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="control-group span6">
                                                            <label class="control-label" for="inputSImg">{lang('Small image','admin')}:
                                                                <span class="btn btn-small p_r" data-url="file">
                                                                    <i class="icon-camera"></i>&nbsp;&nbsp;{lang('Select the file','admin')}
                                                                    <input type="file" class="btn-small btn" id="inputSImg" name="smallPhoto">
                                                                    <input type="hidden" name="deleteSmallImage" value="0"/>
                                                                </span>
                                                                <span class="frame_label no_connection active d_b m-t_10">
                                                                    {if $model->getSmallImage()}
                                                                    <button class="btn btn-small deleteMainImages" type="button" data-title="{lang('Delete','admin')}">
                                                                        <i class="icon-trash"></i>
                                                                    </button>
                                                                    {/if}
                                                                </span>
                                                            </label>
                                                            <div class="controls">
                                                                <div class="photo-block">
                                                                    <span class="helper"></span>
                                                                    {if file_exists("uploads/shop/". $model->getId() ."_small.jpg") && $model->getSmallImage()}
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
                                                                    <input type="hidden" name="deleteMainModImage" value="0"/>
                                                                </span>
                                                                <span class="frame_label no_connection active d_b m-t_10">
                                                                    {if $model->getMainModImage()}
                                                                    <button class="btn btn-small deleteMainImages" data-rel="tooltip" data-title="{lang('Delete','admin')}" type="button">
                                                                        <i class="icon-trash"></i>
                                                                    </button>
                                                                    {/if}
                                                                </span>
                                                            </label>
                                                            <div class="controls">
                                                                {if file_exists("uploads/shop/". $model->getMainModImage()) && $model->getMainModImage()}
                                                                <img src="/uploads/shop/{echo $model->getMainModImage()}?{rand(1,9999)}" class="img-polaroid" style="width: 100px;">
                                                                {else:}
                                                                <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                                {/if}
                                                            </div>
                                                        </div>

                                                        <div class="control-group span6">
                                                            <label class="control-label" for="inputSMod">{lang('Another small image variant','admin')}:
                                                                <span class="btn btn-small p_r" data-url="file">
                                                                    <i class="icon-camera"></i>&nbsp;&nbsp;{lang('Select the file','admin')}
                                                                    <input type="file" class="btn-small btn" id="inputSMod" name="smallModPhoto">
                                                                    <input type="hidden" name="deleteSmallModImage" value="0"/>
                                                                </span>
                                                                <span class="frame_label no_connection active d_b m-t_10">

                                                                    {if $model->getSmallModImage()}
                                                                    <button class="btn btn-small deleteMainImages" type="button">
                                                                        <i class="icon-trash"></i>
                                                                    </button>
                                                                    {/if}
                                                                </span>
                                                            </label>
                                                            <div class="controls">
                                                                {if file_exists("uploads/shop/". $model->getSmallModImage()) && $model->getSmallModImage()}
                                                                <img src="/uploads/shop/{echo $model->getSmallModImage()}?{rand(1,9999)}" class="img-polaroid" style="width: 100px;">
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
                                                    <textarea class="focusOnClick elRTE" id="ShortDescriptions" name="ShortDescription">{echo ShopCore::encode($model->getShortDescription())}</textarea>
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
                                                                <input type="text" name="warehouses_c[]"  value="{echo $w_data->getCount()}"   class="input-medium"/>
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
                                                    <select id="comments" class="input-mini" name="EnableComments">
                                                        <option {if $model->getEnableComments()} selected {/if} value="1">{lang('Yes','admin')}</option>
                                                        <option {if !$model->getEnableComments()} selected {/if}value="0">{lang('No','admin')}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="dCreate">{lang('Date of creation','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" id="dCreate" name="Created" value="{echo date('Y-m-d H:i:s',$model->getCreated())}" class="datepicker input-medium"/>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="oldP">{lang('Old price','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" id="oldP" value="{echo $model->getOldPrice()}" name="OldPrice"/>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="RelatedProducts">{lang('Related products','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" id="RelatedProducts"/>
                                                    <div id="relatedProductsNames" style="margin-top: 10px;">
                                                        {foreach $model->getRelatedProductsModels() as $shopKitProduct}
                                                        <div id="tpm_row{echo $shopKitProduct->getId()}" class="item-accessories">
                                                            <span class="pull-left">
                                                                <a href="{echo $ADMIN_URL .'products/edit/'.$shopKitProduct->getUrl()}" >{echo ShopCore::encode($shopKitProduct->getName())}</a>
                                                                <input type="hidden" name="RelatedProducts[]" value="{echo $shopKitProduct->getId()}">
                                                            </span>
                                                            <span style="margin-left: 1%;" class="pull-left">
                                                                <button class="btn btn-small del_tmp_row" data-rel="tooltip" data-title="{lang('Delete','admin')}" data-kid="{echo $shopKitProduct->getId()}"><i class="icon-trash"></i></button>
                                                            </span>
                                                        </div>

                                                        {/foreach}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="templateGH">{lang('Main template','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" id="templateGH" name="tpl" value="{echo ShopCore::encode($model->tpl)}"/>
                                                    <p class="help-block">{lang('Product main template. By default product.tpl','admin')}</p>
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
                                            <div class="control-group">
                                                <label class="control-label" for="Url">URL:</label>
                                                <div class="controls">
                                                    <input type="text" id="Url" value="{echo $model->getUrl()}" name="Url"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="Mtag">{echo $translatable} {lang('Meta Title','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" name="MetaTitle" id="Mtag" value="{echo $model->getMetaTitle()}"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="mDesc">{echo $translatable} {lang('Meta Description','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" name="MetaDescription" id="mDesc" value="{echo $model->getMetaDescription()}"/>
                                                    <!--    <input type="text" name="MetaDescription" id="mDesc" value="{echo $model->getId()} - {echo $model->getName()} - {echo $model->getMainCategory()->getName()}"/>-->
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="mKey">{echo $translatable} {lang('Meta Keywords','admin')}:</label>
                                                <div class="controls">
                                                    <input type="text" name="MetaKeywords" id="mKey" value="{echo $model->getMetaKeywords()}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="parameters_article">
                    <table class="table  table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Properties','admin')}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd">
                                        <div class="form-horizontal">
                                            <div class="span9">
                                                {echo ShopCore::app()->SPropertiesRenderer->renderAdmin($model->getCategoryId(), $model, $locale)}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="additionalPics">
                    <table class="table  table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Images','admin')}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd">
                                        <div class="form-horizontal">
                                            <div class="span9 offset3">

                                                {for $i=0; $i<12; $i++}

                                                {if ($i+1) % 2}
                                                <div class="row">
                                                    {/if}
                                                    <div class="control-group span6">
                                                        <label class="control-label" for="additionalImage_{$i}">
                                                            <span class="btn btn-small p_r" data-url="file">
                                                                <i class="icon-camera"></i>&nbsp;&nbsp;{lang('Select a file','admin')}
                                                                <input type="file" class="btn-small btn" id="additionalImage_{$i}" name="additionalImage_{$i}">
                                                            </span>

                                                            <input type="hidden" name="imagesForDelete[]" value="-1">
                                                        </label>
                                                        <div class="controls">
                                                            {if file_exists("uploads/shop/". $model->getId() . "_" .$i .'.jpg')}
                                                            <button class="btn btn-small rmAddPic" data-i="{echo $i}" onclick="change_status('{$ADMIN_URL}products/deleteAddImage/{echo $model->getId() . "_" .$i .'.jpg'}');">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                            {/if}
                                                            {if file_exists("uploads/shop/". $model->getId() . "_" .$i .'.jpg')}
                                                            <img src="/uploads/shop/{echo $model->getId()}_{$i}.jpg?{rand(1,9999)}" class="img-polaroid" style="width: 100px;">
                                                            {else:}
                                                            <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 100px; ">
                                                            {/if}
                                                        </div>
                                                    </div>

                                                    {if $i % 2}
                                                </div>
                                                {/if}

                                                {/for}



                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="kits">
                    <a style="float: right;" class="btn btn-mini btn-success pjax" href="/admin/components/run/shop/kits/kit_create/{echo $model->getId()}" ><i class="icon-plus-sign icon-white"></i>{lang('Create a set','admin')}</a>

                    {if count($model->getKits($criteria))}
                    <table class="table  table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Kits','admin')}

                                </th>
                            </tr>
                        </thead>
                        <tbody class="sortable">
                            <tr>
                                <td colspan="6">
                                    {$criteria = 'ASC'}
                                    {if $model->getKits($criteria)->count() > 0}
                                    {foreach $model->getKits($criteria) as $kit}
                                    <table class="table  table-bordered table-hover table-condensed t-l_a">
                                        <thead>
                                            <tr>
                                                <th>
                                                    ID:{echo $kit->getId()}
                                                </th>
                                                <th>
                                                    <a class="pjax" href="{$ADMIN_URL}kits/kit_edit/{echo $kit->getId()}">{lang('Editing','admin')}</a>
                                                </th>
                                                <th>
                                                    {lang('Position','admin')}: {echo $kit->getPosition()}
                                                    <button type="button" style="float: right" class="btn btn-mini kit_del" data-kid="{echo $kit->getId()}">
                                                        <i title="{lang('Delete set','admin')}" class="icon-trash"></i>
                                                    </button>
                                                    <button type="button" style="float: right; margin-right: 2px;" class="btn btn-mini kit_change_active {if $kit->getActive() == 1} active{/if}" data-kid="{echo $kit->getId()}">
                                                        <i title="{lang('Active','admin')}" class="icon-ok"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <b>{echo $kit->getLabel('Id')}</b>
                                                </td>
                                                <td>
                                                    <b>{echo $kit->getLabel('Name')}</b>
                                                </td>
                                                <td>
                                                    <b>{echo $kit->getLabel('Discount')}</b>
                                                </td>

                                            </tr>
                                            {foreach $kit->getShopKitProducts() as $shopKitProduct}
                                            {$ap = $shopKitProduct->getSProducts()}
                                            {$ap->setLocale($model->getLocale())}
                                            <tr class="{counter('even','odd')}">
                                                <td>{echo $ap->getId()}</td>
                                                <td>{echo ShopCore::encode($ap->getName())}</td>
                                                <td>{echo $shopKitProduct->getDiscount()}%</td>
                                            </tr>
                                            {/foreach}
                                        </tbody>
                                    </table>
                                    {/foreach}
                                    {/if}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {else:}
                    <div class="alert alert-info" style="margin-bottom: 18px; margin-top: 18px;">
                        {lang('Kit List products are empty','admin')}
                    </div>
                    {/if}
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
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
    <div class="modal hide fade modal_del_kit">
        <div class="modal-header">
            <button type="button" class="close f-s_26" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Kit removal','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Kits del body','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary kit_del_ok">{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

    <!-- ---------------------------------------------------Блок для додавання варыантів-------------------------------------- -->
    <div style="display: none;" class="variantRowSample">
        <table>
            <tbody>
                <tr id="ProductVariantRow_">

                    <td>
                        <img src="{$SHOP_THEME}images/drag_arrow.png" class="drager" />
                    </td>
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
                        {if $v->getMainImage()}
                        <button class="btn btn-small delete_image" type="button" data-title="{lang('Delete','admin')}">
                            <i class="icon-trash"></i>
                        </button>
                        {/if}
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
                        {if $v->getSmallImage()}
                        <button class="btn btn-small delete_image" type="button" data-title="{lang('Delete','admin')}">
                            <i class="icon-trash"></i>
                        </button>
                        {/if}
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