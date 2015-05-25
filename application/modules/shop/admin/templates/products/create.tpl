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
                <button type="button" class="btn btn-small btn-success action_on formSubmit" data-form="#image_upload_form" data-submit><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-form="#image_upload_form" data-action="close"><i class="icon-check"></i>{lang('Create and exit','admin')}</button>
            </div>
        </div>
    </div>
    <form  action="{$ADMIN_URL}products/create" method="post" enctype="multipart/form-data"  id="image_upload_form">
        <div class="clearfix">
            <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
                <a href="#parameters" class="btn btn-small active">{lang('Product','admin')}</a>
                <a href="#settings" class="btn btn-small">{lang('Settings','admin')}</a>
                {if $moduleAdditions}
                <a href="#modules_additions" class="btn btn-small">{lang('Modules additions', 'admin')}</a>
                {/if}
            </div>
        </div>
        <div class="tab-content m-t_10">
            <div class="tab-pane active" id="parameters">
                <div class="form-horizontal">
                    <table class="table  table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Basic settings','admin')}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd">
                                        <div data-frame>
                                            <div class="control-group">
                                                <label class="control-label" for="Name">{echo $translatable} {lang('Product name','admin')}:<span class="required">*</span></label>
                                                <div class="controls">
                                                    <input type="text" id="Name" name="Name" value="{echo ShopCore::encode($model->getName())}"  class="required span5 d-i_b m-r_20">
                                                    <div class="span5 d-i_b">
                                                        <span class="v-a_m m-r_5">{lang('Active','admin')}:</span>
                                                        <div class="frame_prod-on_off v-a_m" data-rel="tooltip" data-placement="top" data-original-title="{lang('show','admin')}">
                                                            <span class="prod-on_off" data-page="true"></span>
                                                            <input type="checkbox" name="Active" value="1" checked="checked" style="display: none;"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">{lang('Status','admin')}:</label>
                                                <div class="controls">
                                                    <button onclick="if (!$(this).hasClass('active'))
                                                    $('#hit').val(1);
                                                    else
                                                    $('#hit').val(0);" type="button" class="btn btn-small setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('hit','admin')}"><i class="icon-fire"></i> {lang('Hit','admin')}</button>
                                                    <button onclick="if (!$(this).hasClass('active'))
                                                    $('#hot').val(1);
                                                    else
                                                    $('#hot').val(0);" type="button" class="btn btn-small setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('novelty','admin')}"><i class="icon-gift"></i> {lang('Novelty','admin')}</button>
                                                    <button onclick="if (!$(this).hasClass('active'))
                                                    $('#action').val(1);
                                                    else
                                                    $('#action').val(0);" type="button" class="btn btn-small setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('promotion','admin')}"><i class="icon-star"></i> {lang('Promotion','admin')}</button>
                                                    <input type="hidden" name="hit" id="hit"/>
                                                    <input type="hidden" name="hot" id="hot"/>
                                                    <input type="hidden" name="actions" id="action"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">{lang('Product','admin')}:</label>
                                                <div class="controls">
                                                    <div class="variantsProduct">
                                                        <table class="table table-bordered content_small_td frame-input-w100">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 130px;">{lang('Image','admin')} </th>
                                                                    <th style="width: 95px;">{echo lang('Price', 'admin')} <span class="required">*</span></th>
                                                                    {if count($currencies)>0}
                                                                    <th style="width: 100px;">{lang('Currency','admin')}</th>
                                                                    {/if}
                                                                    {/*<th style="widht: 60px;">{echo ShopCore::encode($model->getLabel('Number'))}</th>*/}
                                                                    <th style="width: 115px;">{lang('Number', 'admin')}</th>
                                                                    <th style="width: 90px;">{echo lang('Quantity', 'admin')}</th>
                                                                    <th style="width: 220px;">{echo $translatable_w} {lang('Product variant name','admin')} </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="sortable save_positions_variant" data-url="/admin/components/run/shop/search/save_positions_variant"  id="variantHolder">
                                                                <tr id="ProductVariantRow_0">
                                                                    <td class="variantImage">
                                                                        <div class="control-group">
                                                                            <label class="control-label" style="display: none;">
                                                                                <span class="btn btn-small p_r" data-url="file" >
                                                                                    <i class="icon-camera"></i>
                                                                                    <input type="file" name="image0" title="{lang('Main image','admin')}" accept="image/jpeg,image/png,image/gif"/>
                                                                                    <input type="hidden" name="changeImage[]" value="" class="changeImage" />
                                                                                    <input type="hidden" name="variants[inetImage][]" value="" class="inetImage" />
                                                                                </span>
                                                                            </label>
                                                                            <div class="controls photo_album photo_album-v">
                                                                                <div class="fon"></div>
                                                                                <div class="btn-group f-s_0">
                                                                                    <button type="button"  class="btn change_image btn-small" data-rel="tooltip" data-title="{lang('Edit','admin')}" data-original-title=""><i class="icon-edit"></i></button>
                                                                                    <button type="button" class="btn images_modal btn-small" data-rel="tooltip" data-title="{lang('Load from internet','admin')}" data-original-title=""><i class="icon-search"></i></button>
                                                                                </div>
                                                                                <div class="photo-block">
                                                                                    <span class="helper"></span>
                                                                                    <img src="{$THEME}images/select-picture.png" class="img-polaroid ">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="number"><input id="price-product" onkeyup="checkLenghtStr('price-product', 11, 5, event.keyCode);" type="text" name="variants[PriceInMain][]" value="{echo \Currency\Currency::create()->decimalPointsFormat(0)}" class="required input-medium"/></td>
                                                                    {if count($currencies)>0}
                                                                    <td>
                                                                        <select name="variants[currency][]" class="input-medium">
                                                                            {foreach $currencies as $c}
                                                                            <option value="{echo $c->getId()}" {if $c->getMain()}selected="selected"{/if}>{echo $c->getCode()}</option>
                                                                            {/foreach}
                                                                        </select>
                                                                    </td>
                                                                    {/if}
                                                                    <td><input type="text" name="variants[Number][]" value="" class="input-medium" /></td>
                                                                    <td class="number"><input id="stock-len" onkeyup="checkLenghtStr('stock-len', 9, 0, event.keyCode);" type="text" name="variants[Stock][]" value="1" class="input-medium" /></td>
                                                                    <td>
                                                                        <input type="hidden" name="variants[RandomId][]"  class="random_id" value="45456465"/>
                                                                        <input type="text" class="name-var-def" name="variants[Name][]" value="" disabled="disabled"/>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <div class="inside_padd">
                                                                            <button type="button" class="btn" id="addVariant"><i class="icon-plus-sign m-r_5"></i>{lang('Add a variant','admin')}</button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="oldP">{lang('Old price','admin')}:</label>
                                            <div class="controls number">
                                                <input type="text" onkeyup="checkLenghtStr('oldP', 8, 2, event.keyCode);" id="oldP" value="{echo $model->getOldPrice()}" name="OldPrice" class="span2"/>
                                                <b>{$CS}</b>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputParent">{lang('Brand name','admin')}:</label>
                                            <div class="controls">
                                                <select id="inputParent" name="BrandId" class="span5">
                                                    <option value="">{lang('Not specified','admin')}</option>
                                                    {foreach $brands as $brand}
                                                    <option {if $model->getBrandId() == $brand->getId()} selected="selected" {/if} value="{echo $brand->getId()}">{echo ShopCore::encode($brand->getName())}</option>
                                                    {/foreach}
                                                </select>
                                                <a onclick="$('.addBrandModal').modal();
                                                return false;" class="btn" style="margin-left:15px;" href="#"><i class="icon-plus-sign"></i> {lang("Create a brand","admin")}</a>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="comment">{lang('Category','admin')}:</label>
                                            <div class="controls">
                                                <select name="CategoryId" id="comment" class="span5">
                                                    {foreach $categories as $category}
                                                    <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if}  value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())}{echo ShopCore::encode($category->getName())}</option>
                                                    {/foreach}
                                                </select>
                                                <a onclick="$('.addCategoryModal').modal();
                                                return false;" class="btn" href="#" style="margin-left:15px;"><i class="icon-plus-sign"></i> {lang("Create a category","admin")}</a>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="iddCategory" >{lang('Additional categories', 'admin')}:</label>
                                            <div class="controls">
                                                <select name="Categories[]" multiple="multiple" id="iddCategory" class="span5" data-placeholder="{lang('Chose additional categories', 'admin')}">
                                                    {foreach $categories as $category}
                                                    <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group m-t_20">
                                            <label class="control-label" for="ShortDescriptions">{echo $translatable} {lang('Short description','admin')}:</label>
                                            <div class="controls">
                                                <textarea class="elRTE" id="ShortDescriptions" name="ShortDescription"></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group m-t_20">
                                            <label class="control-label" for="FullDescription">{echo $translatable} {lang('Full description','admin')}:</label>
                                            <div class="controls">
                                                <textarea class="elRTE" id="FullDescription" name="FullDescription"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="settings">
                <div class="row-fluid form-horizontal">
                    <div class="span6">
                        <table class="table  table-bordered table-hover table-condensed content_big_td">
                            <thead>
                                <tr>
                                    <th colspan="6">{lang('Meta data','admin')}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">
                                        <div class="inside_padd">
                                            <div class="frame-input-w100">
                                                <div class="control-group">
                                                    <label class="control-label" for="Url">URL:</label>
                                                    <div class="controls">
                                                        <div class="group_icon pull-right">
                                                            <button type="button"
                                                            data-rel="tooltip"
                                                            data-title="{lang('Autoselection','admin')}"
                                                            class="btn btn-small"
                                                            id="translateProductUrl">
                                                            <i class="icon-refresh"></i>
                                                        </button>
                                                    </div>
                                                    <span class="o_h d_b">
                                                        <input type="text"
                                                        name="Url"
                                                        id="Url"
                                                        value="{echo $model->getUrl()}"/>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="Mtag">{echo $translatable} {lang('Meta Title','admin')}:</label>
                                                <div class="controls">
                                                    <textarea name="MetaTitle" id="Mtag">{echo $model->getMetaTitle()}</textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="mDesc">{echo $translatable} {lang('Meta Description','admin')}:</label>
                                                <div class="controls">
                                                    <textarea name="MetaDescription" id="mDesc">{echo $model->getMetaDescription()}</textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="mKey">{echo $translatable} {lang('Meta Keywords','admin')}:</label>
                                                <div class="controls">
                                                    <textarea name="MetaKeywords" id="mKey">{echo $model->getMetaKeywords()}</textarea>
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
                                <th colspan="6">{lang('Advanced settings','admin')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd">
                                        <div class="frame-input-w100">
                                            <div class="control-group">
                                                <div class="control-group">
                                                    <label class="control-label" for="comments">{lang('Comment permission','admin')}:</label>
                                                    <div class="controls">
                                                        <span class="frame_label m-r_20">
                                                            <span class="niceRadio b_n">
                                                                <input type="radio" name="EnableComments" value="1" {if $model->getEnableComments()} checked='checked' {/if}/>
                                                            </span>
                                                            {lang('Yes','admin')}
                                                        </span>
                                                        <span class="frame_label">
                                                            <span class="niceRadio b_n">
                                                                <input type="radio" name="EnableComments" value="0" {if !$model->getEnableComments()} checked='checked' {/if}/>
                                                            </span>
                                                            {lang('No','admin')}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="dCreate">{lang('Date of creation','admin')}:</label>
                                                    <div class="controls">
                                                        <input type="text"
                                                        id="dCreate"
                                                        name="Created"
                                                        value="{date('Y-m-d H:i:s',time())}"
                                                        class="datepickerTime input-medium"/>
                                                        <p class="help-block">{lang('Format date: yyyy-mm-dd','admin')}</p>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="templateGH">{lang('Main template','admin')}:</label>
                                                    <div class="controls">
                                                        <input type="text" id="templateGH" name="tpl" value="{echo ShopCore::encode($model->tpl)}"/>
                                                        <p class="help-block">{lang('Main product template. By default product.tpl','admin')}</p>
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
        </div>
        {include_tpl('../modules_additions')}
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
        <input type="text" name="warehouses_c[]"  value="" class="input-medium"/>
        <a data-del="wares" class="btn btn-small"><i class="icon-trash"></i></a>
    </div>
</div>
<!-- ---------------------------------------------------Блок для додавання варыантів-------------------------------------- -->
<div style="display: none;" class="variantRowSample">
    <table>
        <tbody>
            <tr id="ProductVariantRow_">
                <td class="variantImage">
                    <button class="btn my_btn_s btn-small pull-right m-r_5"
                    type="button"
                    data-remove data-rel="tooltip"
                    data-title="{lang('Delete','admin')}">
                    <i class="icon-trash"></i>
                </button>
                <div class="control-group">
                    <label class="control-label" style="display: none;">
                        <span class="btn btn-small p_r" data-url="file" >
                            <i class="icon-camera"></i>
                            <input type="file" class="newImage" name="image" title="{lang('Main image','admin')}" accept="image/jpeg,image/png,image/gif"/>
                            <input type="hidden" name="changeImage[]" value="" class="changeImage" />
                            <input type="hidden" name="variants[inetImage][]" value="" class="inetImage" />
                        </span>
                    </label>
                    <div class="controls photo_album photo_album-v">
                        <div class="fon"></div>
                        <div class="btn-group f-s_0">
                            <button type="button"
                            class="btn change_image btn-small"
                            data-rel="tooltip"
                            data-title="{lang('Edit','admin')}"
                            data-original-title="">
                            <i class="icon-edit"></i>
                        </button>
                        <button type="button"  class="btn images_modal btn-small" data-rel="tooltip" data-title="{lang('Load from internet','admin')}" data-original-title=""><i class="icon-search"></i></button>
                    </div>
                    <div class="photo-block">
                        <span class="helper"></span>
                        <img src="{$THEME}images/select-picture.png" class="img-polaroid ">
                    </div>


                </div>
            </div>
        </td>
        <td class="number">
            <input type="text" id="price-product"  name="variants[PriceInMain][]" value="{echo \Currency\Currency::create()->decimalPointsFormat(0)}"/>
        </td>
        {if count($currencies)>0}
        <td>
            <select name="variants[currency][]">
                {foreach $currencies as $c}
                <option value="{echo $c->getId()}" {if $c->getMain()}selected="selected"{/if}>{echo $c->getCode()}</option>
                {/foreach}
            </select>
        </td>
        {/if}
        <td>
            <input type="text" name="variants[Number][]" value/>
        </td>
        <td class="number">
            <input type="text" name="variants[Stock][]" value="1" />
        </td>
        <td class="span3">
            <input type="hidden" name="variants[RandomId][]"  class="random_id" value=""/>
            <input type="hidden" name="variants[CurrentId][]" value="" />
            <input type="text" name="variants[Name][]" value=""/>
        </td>
    </tr>
</tbody>
</table>
</div>
{$imagesPopup}

<div class="addCategoryModal  modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>{lang("Create a category","admin")}</h3>
    </div>
    <div class="modal-body">

        <form action="/admin/components/run/shop/products/fastCategoryCreate" method="post" id="fast_add_form" class="form-horizontal">
            <div class="control-group">
                <label class="control-label">
                    {lang("Name","admin")}
                </label>
                <div class="controls">
                    <input type="text" name="name" value="" class="required">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">
                    {lang("Parent","admin")}
                </label>
                <div class="controls">
                    <select name="parent_id">
                        <option value="0" selected="selected">{lang("No","admin")}</option>
                        {foreach $categories as $category}
                        <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if}  value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())}{echo ShopCore::encode($category->getName())}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        <a href="#" class="btn btn-primary" onclick="fastCategoryCreate()">{lang('Create','admin')}</a>
    </div>
</div>

<div class="addBrandModal modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>{lang("Create a brand","admin")}</h3>
    </div>
    <div class="modal-body">

        <form action="/admin/components/run/shop/products/fastBrandCreate" method="post" id="fast_add_form_brand" class="form-vetical">
            <div class="control-group">
                <label class="control-label">
                    {lang("Name","admin")}
                </label>
                <div class="controls">
                    <input type="text" name="name" value="" class="required">
                </div>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        <a href="#" class="btn btn-primary" onclick="fastBrandCreate()">{lang('Create','admin')}</a>
    </div>
</div>