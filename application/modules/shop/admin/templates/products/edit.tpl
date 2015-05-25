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
                {echo create_language_select($languages, $locale, "/admin/components/run/shop/products/edit/".$model->getId(), FALSE)}
            </div>
        </div>
    </div>
    <form  action="{$ADMIN_URL}products/edit/{echo $model->getId()}/{$locale}" method="post" enctype="multipart/form-data"  id="image_upload_form">
        <div class="clearfix">
            <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
                <a href="#parameters" class="btn btn-small active">{lang('Product','admin')}</a>
                <a href="#parameters_article" class="btn btn-small">{lang('Properties','admin')}</a>
                {$addField = ShopCore::app()->CustomFieldsHelper->getCustomFields('product', $model->getId())->asAdminHtml()}

                <a href="#additionalPics" class="btn btn-small">{lang('Additional images','admin')}</a>
                <a href="#kits" class="btn btn-small">{lang('Kits','admin')}</a>
                <a href="#accessories" class="btn btn-small">{lang('Accessories','admin')}</a>
                <a href="#settings" class="btn btn-small">{lang('Settings','admin')}</a>
                {if $addField}
                <a href="#customFields" class="btn btn-small">{lang('Additional data','admin')}</a>
                {/if}
                {if $moduleAdditions}
                <a href="#modules_additions" class="btn btn-small">{lang('Modules additions', 'admin')}</a>
                {/if}
            </div>
            <div class="pull-right m-t_5 f-s_0">
                <div class="pagination pagination-small d-i_b m-r_15">
                    <ul>
                        <li>
                            {if $defaultLocale == $locale}
                            <a href="/shop/product/{echo $model->getUrl()}" target="_blank" class="action_on v-a_m" data-form="#image_upload_form" data-action="close" data-rel="tooltip" data-title="{lang('View page','admin')}">
                                <i class="icon-share-alt"></i>
                            </a>
                            {else:}
                            <a href="/{echo $locale}/shop/product/{echo $model->getUrl()}" target="_blank" class="action_on v-a_m" data-form="#image_upload_form" data-action="close" data-rel="tooltip" data-title="{lang('View page','admin')}">
                                <i class="icon-share-alt"></i>
                            </a>
                            {/if}
                        </li>
                    </ul>
                </div>
                <div class="pagination pagination-small d-i_b">
                    <ul>
                        <li {if !$prev_id}class="disabled"{/if}>
                            {if $prev_id}
                            <a href="/admin/components/run/shop/products/edit/{echo $prev_id}{if \MY_Controller::getCurrentLocale() != \MY_Controller::defaultLocale()}/{echo \MY_Controller::getCurrentLocale()}{/if}{echo $_SESSION['ref_url']}" class="pjax" data-rel="tooltip" data-title="{lang('Previous','admin')}"><span class="icon-chevron-left"></span></a>
                            {else:}
                            <span><span class="icon-chevron-left"></span></span>
                            {/if}
                        </li>
                        <li {if !$next_id}class="disabled"{/if}>
                            {if $next_id}
                            <a href="/admin/components/run/shop/products/edit/{echo $next_id}{if \MY_Controller::getCurrentLocale() != \MY_Controller::defaultLocale()}/{echo \MY_Controller::getCurrentLocale()}{/if}{echo $_SESSION['ref_url']}" class="pjax" data-rel="tooltip" data-title="{lang('Next','admin')}"><span class="icon-chevron-right"></span></a>
                            {else:}
                            <span><span class="icon-chevron-right"></span></span>
                            {/if}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content m-t_10">

            {include_tpl('default_edit')}

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
        <input type="text" name="warehouses_c[]"  value=""/>
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
        <p>{lang('Do you really want to delete this kit','admin')}?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary kit_del_ok">{lang('Delete','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>
<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<!-- ---------------------------------------------------Блок для додавання варыантів-------------------------------------- -->
<div style="display: none;" class="variantRowSample">
    {$v = $model->getFirstVariant()}
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
                            <img src="{$THEME}images/select-picture.png" class="img-polaroid ">
                            {/if}
                        </div>
                    </div>






                </div>











    </td>

    <td class="number"><input type="text" name="variants[PriceInMain][]" value="{echo \Currency\Currency::create()->decimalPointsFormat(0)}"/></td>
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

        <form action="/admin/components/run/shop/products/fastBrandCreate" method="post" id="fast_add_form_brand" class="form-horizontal">
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