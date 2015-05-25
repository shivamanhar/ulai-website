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
                                        <input type="text" id="Name" name="Name" value="{echo ShopCore::encode($model->getName())}" class="span5 d-i_b m-r_20 required">
                                        <div class="span3 d-i_b">
                                            <span class="v-a_m m-r_5">{lang('Active','admin')}:</span>
                                            {if $model->getActive() == true}
                                            {$checked = 'checked="checked"';$checkedP = '';$disableClass='';}
                                            {else:}
                                            {$checkedP = 'disable_tovar';$checked = '';$disableClass='disabled';}
                                            {/if}
                                            <div class="frame_prod-on_off v-a_m" data-rel="tooltip" data-placement="top" data-original-title="{lang('show','admin')}">
                                                <span data-page = "tovar" class="prod-on_off {echo $checkedP;}" data-id="{echo $model->getId()}" ></span>
                                                <input type="checkbox" name="Active" value="1" {echo $checked;} style="display: none;" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{lang('Status','admin')}:</label>
                                    <div class="controls">
                                        {if $model->getHit() == true}
                                        <button type="button" data-id="{echo $model->getId()}" class="btn btn-small {echo $disableClass;} btn-primary active setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('hit','admin')}"><i class="icon-fire"></i> {lang('Hit','admin')}</button>
                                        {else:}
                                        <button type="button" data-id="{echo $model->getId()}" class="btn btn-small {echo $disableClass;} setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('hit','admin')}"><i class="icon-fire"></i> {lang('Hit','admin')}</button>
                                        {/if}

                                        {if $model->getHot() == true}
                                        <button type="button" data-id="{echo $model->getId()}" class="btn btn-small {echo $disableClass;} btn-primary active setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('novelty','admin')}"><i class="icon-gift"></i> {lang('Novelty','admin')}</button>
                                        {else:}
                                        <button type="button" data-id="{echo $model->getId()}" class="btn btn-small {echo $disableClass;} setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('novelty','admin')}"><i class="icon-gift"></i> {lang('Novelty','admin')}</button>
                                        {/if}

                                        {if $model->getAction() == true}
                                        <button type="button" data-id="{echo $model->getId()}" class="btn btn-small {echo $disableClass;} btn-primary active setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('promotion','admin')}"><i class="icon-star"></i> {lang('Promotion','admin')}</button>
                                        {else:}
                                        <button type="button" data-id="{echo $model->getId()}" class="btn btn-small {echo $disableClass;} setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('promotion','admin')}"><i class="icon-star"></i> {lang('Promotion','admin')}</button>
                                        {/if}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{lang('Product','admin')}:</label>
                                    <div class="controls">
                                        <div class="variantsProduct">
                                            <table class="table table-bordered content_small_td">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 130px;">{lang('Image','admin')} </th>
                                                        <th style="width: 95px;">{echo lang('Price', 'admin')} <span class="required">*</span></th>
                                                        {if count($currencies)>0}
                                                        <th style="width: 100px;">{lang('Currency','admin')}</th>
                                                        {/if}
                                                        <th style="width: 115px;">{echo lang('Number', 'admin')}</th>
                                                        <th style="width: 90px;">{echo lang('Quantity', 'admin')}</th>
                                                        <th style="width: 220px;">{echo $translatable_w} {lang('Product variant name','admin')} </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="sortable save_positions_variant" data-url="/admin/components/run/shop/search/save_positions_variant"  id="variantHolder">
                                                    {if $model->countProductVariants() > 0}
                                                    {$i=0}
                                                    {foreach $model->getProductVariants(null,null, TRUE, $locale) as $v}
                                                    <tr id="ProductVariantRow_{$i}">
                                                        <td class="variantImage">
                                                            {if $i>0}
                                                            <button class="btn my_btn_s btn-small pull-right m-r_5" type="button" data-remove data-rel="tooltip" data-title="{lang('Delete','admin')}">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                            {/if}
                                                            <div class="control-group">
                                                                <label class="control-label" style="display: none;">
                                                                    <span class="btn btn-small p_r" data-url="file" >
                                                                        <i class="icon-camera"></i>
                                                                        <input type="file" name="image{$i}" title="{lang('Main image','admin')}"/>
                                                                        <input type="hidden" name="variants[mainImageName][]" value="{echo $v->getMainimage()}" class="mainImageName" />
                                                                        <input type="hidden" name="changeImage[]" value="" class="changeImage" />
                                                                        <input type="hidden" name="variants[inetImage][]" value="" class="inetImage" />
                                                                        <input type="hidden" name="variants[MainImageForDel][]" class="deleteImage" value="0"/>
                                                                    </span>
                                                                </label>
                                                                <div class="controls photo_album photo_album-v" style="width:102px;">
                                                                    <div class="fon"></div>
                                                                    <div class="btn-group f-s_0">
                                                                        <button type="button" class="btn change_image btn-small" data-rel="tooltip" data-title="{lang('Edit','admin')}" data-original-title=""><i class="icon-edit"></i></button>
                                                                        <button type="button" class="btn images_modal btn-small" data-rel="tooltip" data-title="{lang('Load from internet', 'admin')}" data-original-title=""><i class="icon-search"></i></button>
                                                                        <button type="button" class="btn delete_image btn-small" data-rel="tooltip" data-title="{lang('Remove','admin')}"><i class="icon-trash"></i></button>
                                                                    </div>
                                                                    <div class="photo-block">
                                                                        <span class="helper"></span>
                                                                        {if $v->getSmallPhoto()}
                                                                        <img  src="{echo $v->getSmallPhoto()}" class="img-polaroid">
                                                                        {else:}
                                                                        <img src="{$THEME}images/select-picture.png" class="img-polaroid selectPictureNew">
                                                                        {/if}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="number">
                                                            <input type="text" id="price-product-{$i}"
                                                            onkeyup="checkLenghtStr('price-product-{$i}', 11, 5, event.keyCode);"
                                                            name="variants[PriceInMain][]"
{/*                                                            value="{echo \Currency\Currency::create()->decimalPointsFormat($v->getPriceInMain(), $v->getCurrency())}"*/}
                                                            value="{echo preg_replace('/\.?0*$/','',number_format($v->getPriceInMain(), 5, ".", ""))}"
                                                            class="input-medium required" />
                                                        </td>
                                                        {if count($currencies)>0}
                                                        <td>
                                                            <select name="variants[currency][]" class="input-medium">
                                                                {foreach $currencies as $c}
                                                                <option value="{echo $c->getId()}" {if $c->getId() == $v->getCurrency()}selected="selected"{/if}>
                                                                    {echo $c->getCode()}
                                                                </option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                        {/if}

                                                        <td>
                                                            <input type="text" name="variants[Number][]" value="{echo ShopCore::encode($v->getNumber())}"/>
                                                        </td>
                                                        <td class="number">
                                                            <input type="text" id="stock-len-{$i}" onkeyup="checkLenghtStr('stock-len-{$i}', 9, 0, event.keyCode);" name="variants[Stock][]" value="{echo ShopCore::encode($v->getStock())}"/>
                                                        </td>
                                                        <td>
                                                            <input name="idv" type="hidden" value="{echo $v->id}"/>
                                                            <input type="hidden" name="variants[RandomId][]"  class="random_id" value=""/>
                                                            <input type="hidden" name="variants[CurrentId][]"  value="{echo $v->getId()}" />
                                                            <input  type="text" class="name-var-def" name="variants[Name][]" value="{echo ShopCore::encode($v->getName())}" {if $model->countProductVariants() == 1}{if !ShopCore::encode($v->getName())}disabled="disabled"{/if}{/if}/>
                                                        </td>
                                                    </tr>
                                                    {$i++}
                                                    {/foreach}
                                                    {/if}
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6">
                                                            <div class="inside_padd">
                                                                <button type="button"
                                                                class="btn"
                                                                id="addVariant">
                                                                <i class="icon-plus-sign m-r_5"></i>{lang('Add a variant','admin')}
                                                            </button>
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
                                <input type="text" id="oldP" onkeyup="checkLenghtStr('oldP', 8, 2, event.keyCode);" value="{echo $model->getOldPrice()}" name="OldPrice" class="span2"/>
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
                                return false;" class="btn" href="#" style="margin-left:15px;"><i class="icon-plus-sign"></i> {lang("Create a brand","admin")}</a>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="comment">{lang('Category','admin')}:</label>
                            <div class="controls">

                                <select name="CategoryId" id="comment" class="span5">
                                    {foreach $categories as $category}
                                    <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} {if $model->getCategoryId() == $category->getId()}selected="selected"{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())}{echo ShopCore::encode($category->getName())}</option>
                                    {/foreach}
                                </select>
                                <a onclick="$('.addCategoryModal').modal();
                                return false;" class="btn " href="#" style="margin-left:15px;"><i class="icon-plus-sign"></i> {lang("Create a category","admin")}</a>

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="iddCategory">{lang('Additional categories', 'admin')}:</label>
                            <div class="controls">
                                <select name="Categories[]" multiple="multiple" id="iddCategory" class="chosen span5" data-placeholder="{lang('Chose additional categories', 'admin')}">
                                    {foreach $categories as $category}
                                    {if $category->getName()}
                                    {$selected=""}
                                    {if in_array($category->getId(), $productCategories) && $category->getId() != $model->getCategoryId()}
                                    {$selected="selected='selected'"}
                                    {/if}
                                    <option {if $category->getLevel() == 0}style="font-weight: bold;"{/if} {$selected} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                                    {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="control-group m-t_20">
                            <label class="control-label"
                            for="ShortDescriptions">{echo $translatable} {lang('Short description','admin')}:
                        </label>
                        <div class="controls">
                            <textarea class="elRTE" id="ShortDescriptions" name="ShortDescription">{echo ShopCore::encode($model->getShortDescription())}</textarea>
                        </div>
                    </div>
                    <div class="control-group m-t_20">
                        <label class="control-label"
                        for="FullDescription">{echo $translatable} {lang('Full description','admin')}:
                    </label>
                    <div class="controls">
                        <textarea class="elRTE" id="FullDescription" name="FullDescription">{echo ShopCore::encode($model->getFullDescription())}</textarea>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</tbody>
</table>
</div>
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
                            {for $i=0; $i<16; $i++}
                            {if $i % 8 == 0}
                            <div class="o_h" style="margin-left: -24px;">
                                {/if}
                                <div class="pull-left photo_album" style="width: 102px;height: 102px;margin-left: 24px;margin-bottom: 15px;">
                                    <div class="fon"></div>
                                    <input type="hidden" class='additional_image_url' id="additionalImages_{$i}" name="additionalImages{echo $i}">
                                    {if isset($additionalImagePositions[$i])}
                                    <div id="frame_for_img_{$i}" class="photo-block">
                                        <span class="helper"></span>
                                        <img src="/uploads/shop/products/origin/additional/{echo $additionalImagePositions[$i]->getImageName()}"
                                        class="img-polaroid"
                                        style="max-width: 90px; max-height: 90px;"
                                        >
                                    </div>
                                    <div class="btn-group f-s_0">
                                        <button class="btn btn-small rmAddPic"
                                        data-rel="tooltip"
                                        data-title="{lang('Remove','admin')}"
                                        data-i="{echo $i}"
                                        onclick="change_status('{$ADMIN_URL}products/deleteAddImage/{echo $model->getId()}/{echo $i}');">
                                        <i class="icon-trash"></i>
                                    </button>
                                    <label class="btn btn-small" for="fileImg_{$i}"
                                    data-rel="tooltip"
                                    data-title="{lang('Edit','admin')}"
                                    >
                                    <i class="icon-edit"></i>
                                    <input type="file" class="btn-small btn fileImgNew" id="fileImg_{$i}" name="additionalImages_{$i}" data-url="file2" data-rel="#frame_for_img_{$i}" data-width="90">
                                    <input type="hidden" class='additional_image_url' id='add_img_urls_{$i}' name='add_img_urls_{$i}'>
                                </label>
                            </div>
                            {else:}
                            <div id="frame_for_img_{$i}" class="photo-block">
                                <span class="helper"></span>
                                <img src="{$THEME}images/select-picture.png"
                                class="img-polaroid selectPictureNew"
                                style="max-width: 90px;max-height: 90px;"
                                >
                            </div>
                            <div class="btn-group f-s_0">
                              <label class="btn btn-small" for="fileImg_{$i}"
                              data-rel="tooltip"
                              data-title="{lang('Add','admin')}"
                              >
                              <i class="icon-edit"></i>
                              <input type="file" class="btn-small btn fileImgNew" id="fileImg_{$i}" name="additionalImages_{$i}" data-url="file2" data-rel="#frame_for_img_{$i}" data-width="90">
                              <input type="hidden" class='additional_image_url' id='add_img_urls_{$i}' name='add_img_urls_{$i}'>
                          </label>
                      </div>
                      {/if}
                  </div>
                  {if $i % 8 == 7}
              </div>
              {/if}
              {/for}
          </div>
      </div>
  </td>
</tr>
</tbody>
</table>
</div>
{$addField = ShopCore::app()->CustomFieldsHelper->getCustomFields('product', $model->getId())->asAdminHtml()}
{if !empty($addField)}
<div class="tab-pane" id="customFields">
    <table class="table  table-bordered table-hover table-condensed content_big_td">
        <thead>
            <tr>
                <th colspan="6">
                    {lang('Additional data','admin')}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="inside_padd">
                        <div class="form-horizontal span8">
                            {$addField}
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="elFinder"></div>
</div>
{/if}

<div class="tab-pane" id="kits">
    <a class="btn btn-small btn-success pjax"
    href="/admin/components/run/shop/kits/kit_create/{echo $model->getId()}" >
    <i class="icon-plus-sign icon-white m-r_5"></i>{lang('Create a set','admin')}
</a>

{$criteria = 'ASC'}
{if count($model->getKits($criteria))}
<div class="title-default">{lang('Current kits','admin')}</div>
<table class="table  table-bordered table-hover table-condensed">
    <thead>
        <tr>
            <th class="span1"></th>
            <th class="span1">ID</th>
            <th class="span3">{lang('Main product', 'admin')}</th>
            <th class="span5">{lang('Products in kit', 'admin')}</th>
            <th class="span2">{lang('Cost of kit', 'admin')}</th>
            <th class="span2">{lang('Quantity', 'admin')}</th>
            <th class="span2">{lang('Active', 'admin')}</th>
        </tr>
    </thead>
    <tbody class="sortable">
        {foreach $model->getKits($criteria) as $kit}
        {$stock = $model->firstVariant->getStock()}
        {$price = $model->firstVariant->getPrice()}
        <tr>
            <td class="t-a_c">
                <button type="button" class="btn btn-mini kit_del" data-kid="{echo $kit->getId()}" data-rel="tooltip" data-title="{lang('Remove', 'admin')}">
                    <i title="{lang('Delete set','admin')}" class="icon-trash"></i>
                </button>
            </td>
            <td>
                <a class="pjax" href="{$ADMIN_URL}kits/kit_edit/{echo $kit->getId()}" data-rel="tooltip" data-title="{lang('Edit kit','admin')}">{echo $kit->getId()}</a>

            </td>
            <td>
                {echo $model->getName()}
            </td>
            <td>

                {foreach $kit->getShopKitProducts() as $shopKitProduct}
                {$ap = $shopKitProduct->getSProducts()}
                {$ap->setLocale($model->getLocale())}
                <div>
                    <a href="{echo $ADMIN_URL .'products/edit/'.$ap->getId()}" data-rel="tooltip" data-title="{lang('Edit product', 'admin')}">{echo ShopCore::encode($ap->getName())}</a>
                    <span>(-{echo $shopKitProduct->getDiscount()}%)</span>
                </div>
                {$stock = $stock > $ap->firstVariant->getStock() ? $ap->firstVariant->getStock() : $stock}
                {$price += round($ap->firstVariant->getPrice()*(1-$shopKitProduct->getDiscount()/100))}
                {/foreach}
            </td>
            <td>
                <b>{$price} {$CS}</b>
            </td>
            <td>
                {$stock}
            </td>
            <td>
                <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('switch on','admin')}"  data-off="{lang('switch off','admin')}">
                    <span class="prod-on_off kit_change_active {if $kit->getActive() != 1}disable_tovar{/if}" data-kid="{echo $kit->getId()}">></span>
                </div>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{else:}
<div class="alert alert-info m-t_20">
    {lang('Kit List products are empty','admin')}
</div>
{/if}
</div>
<div class="tab-pane" id="accessories">
    <table class="table  table-bordered table-hover table-condensed content_big_td">
        <thead>
            <tr>
                <th colspan="6">
                    {lang('Adding accessories','admin')}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="inside_padd">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">{lang('Selecting a product','admin')}:</label>
                                <div class="controls">
                                    <input type="text" id="RelatedProducts"/>
                                    <span class="help-block">{lang('ID', 'admin')} / {lang('Product name', 'admin')} / {lang('Article', 'admin')}</span>
                                </div>
                            </div>
                            <div id="relatedProductsNames" style="margin-top: 10px;display: none;">
                                <div class="control-group">
                                    <label class="control-label">{lang('Visualization','admin')}:</label>
                                    <div class="controls">
                                        <table class="table table-bordered content_small_td t-l_a w_auto">
                                            <thead>
                                                <tr>
                                                    <th>{lang('Selected products', 'admin')}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    {if $model->getRelatedProductsModels()}
    <div class="title-default">{lang('Current accessories','admin')}</div>
    <table class="table  table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th class="span1"></th>
                <th class="span6">{lang('Products', 'admin')}</th>
                <th class="span2">{lang('Article', 'admin')}</th>
                <th class="span2">{lang('Price', 'admin')}</th>
                <th class="span2">{lang('Quantity', 'admin')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $model->getRelatedProductsModels() as $shopKitProduct}
            <tr id="tpm_row{echo $shopKitProduct->getId()}" class="item-accessories">
                <td class="t-a_c">
                    <button class="btn btn-small del_tmp_row my_btn_s"
                    data-rel="tooltip"
                    data-title="{lang('Delete','admin')}"
                    data-kid="{echo $shopKitProduct->getId()}">
                    <i class="icon-trash"></i>
                </button>
            </td>
            <td>
                <a href="{echo $ADMIN_URL .'products/edit/'.$shopKitProduct->getId()}" >
                    {echo ShopCore::encode($shopKitProduct->getId() . ' - ' . $shopKitProduct->getName())}
                </a>
            </td>
            <td>
                {echo $shopKitProduct->firstVariant->getNumber()}
            </td>
            <td>
                <b>{echo $shopKitProduct->firstVariant->getPrice()} {$CS}</b>
                <input type="hidden"
                name="RelatedProducts[]"
                value="{echo $shopKitProduct->getId()}">
            </div>
        </td>
        <td>
            {echo $shopKitProduct->firstVariant->getStock()}
        </td>
    </tr>
    {/foreach}
</tbody>
</table>
{/if}
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
                                            value="{echo date('Y-m-d H:i:s',$model->getCreated())}"
                                            class="datepickerTime input-medium"/>
                                            <p class="help-block">{lang('Format date: yyyy-mm-dd h:mm:ss','admin')}</p>
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