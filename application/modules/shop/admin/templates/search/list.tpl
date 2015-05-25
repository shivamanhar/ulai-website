<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
<div class="modal hide fade modal_del">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Delete products','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('Really delete selected products?','admin')}</p>
        <!--<p>{lang(a_products_del_body_warning)}</p>-->
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}products/ajaxDeleteProducts')" >{lang('Delete','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>
<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<div class="modal hide fade modal_move_to_cat">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Move products','admin')}</h3>
    </div>
    <div class="modal-body">
        <select name="" id="moveCategoryId" style="width:285px;">
            {foreach $categories as $category}
                <option {if $category->getId() == $categoryId}selected{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
            {/foreach}
        </select>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary move_to_cat">{lang('Move','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal_move_to_cat').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>

<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<form action="{$ADMIN_URL}search/index/" id="filter_form" method="get" class="listFilterForm">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{if isset($_GET['WithoutImages']) AND $_GET['WithoutImages'] == 1}{lang('Products without images','admin')}{else:}{lang('Products list','admin')}{/if}{if $totalProducts!=null} ({echo $totalProducts}){/if}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <button title="{lang('Filter','admin')}" type="submit" class="d_n btn btn-small action_on disabled listFilterSubmitButton">
                        <i class="icon-filter"></i>{lang('Filter','admin')}
                    </button>
                    <button title="{lang('Reset filter','admin')}"
                            onclick="if (!$(this).hasClass('disabled'))
                                    location.href = '/admin/components/run/shop/search/index{if $_GET['WithoutImages'] == 1}?WithoutImages=1{/if}'"
                            type="button" class="btn btn-small action_on {if $_GET['_pjax'] && count($_GET)==1 || $_GET == null || ($_GET['WithoutImages'] == 1 && count($_GET)==1)}disabled{/if}">
                        <i class="icon-refresh"></i>{lang('Cancel filter','admin')}
                    </button>
                    <div class="dropdown d-i_b">
                        <button type="button" class="btn btn-small dropdown-toggle disabled action_on" data-toggle="dropdown">
                            <i class="icon-tag"></i>
                            {lang('Change status','admin')}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="" href="#" onclick="product.changeActive()" >{lang('Active','admin')}</a></li>
                            <li class="divider"></li>
                            <li><a class="to_hit" href="#" onclick="product.toHit()" >{lang('Hit','admin')}</a></li>
                            <li><a href="#" class="tonew" onclick="product.toNew()">{lang('New','admin')}</a></li>
                            <li><a href="#" class="toaction" onclick="product.toAction()">{lang('Promotion','admin')}</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="clone pjax" onclick="product.cloneTo()">{lang('Create copy','admin')}</a></li>
                            <li><a href="#" class="tocategory" onclick="product.toCategory()">{lang('Move to category','admin')}</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-small CreateFastT"  ><i class="icon-plus-sign"></i>{lang('Open fast create','admin')}</button>
                    <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/products/create" ><i class="icon-plus-sign icon-white"></i>{lang('Create product','admin')}</a>
                    <a class="btn btn-small btn-danger disabled action_on" id="del_in_search" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i>{lang('Delete','admin')}</a>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <table class="table  table-bordered table-hover table-condensed products_table">
                <thead>
                    <tr style="cursor: pointer;">
                        <th class="t-a_c span1">
                            <span class="frame_label">
                                <span class="niceCheck b_n">
                                    <input type="checkbox"/>
                                </span>
                            </span>
                        </th>
                        <th class="span1 product_list_order" data-column="Id">
                            <span class="thead_name">
                                {lang('ID','admin')}
                            </span>
                            {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'Id'}
                                {if $_GET.order == 'ASC'}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                            {/if}
                        </th>
                        <th class="span3 product_list_order" data-column="Name">
                            <span class="thead_name">
                                {lang('Product','admin')}
                            </span>
                            {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'Name'}
                                {if $_GET.order == 'ASC'}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                            {/if}

                        </th>
                        <th class="span2 product_list_order" data-column="CategoryName">
                            <span class="thead_name">
                                {lang('Categories','admin')}
                            </span>
                            {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'CategoryName'}
                                {if $_GET.order == 'ASC'}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                            {/if}
                        </th>
                        <th class="product_list_order span1" data-column="Reference">
                            <span class="thead_name">
                                {lang('Article', 'admin')}
                            </span>
                            {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'Reference'}
                                {if $_GET.order == 'ASC'}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                            {/if}
                        </th>
                        <th class="product_list_order span1" data-column="Active">
                            <span class="thead_name">
                                {lang('Active','admin')}
                            </span>
                            {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'Active'}
                                {if $_GET.order == 'ASC'}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                            {/if}
                        </th>
                        <th class="span2">{lang('Status','admin')}</th>
                        <th class="span2 product_list_order" data-column="Price">
                            <span class="thead_name">
                                {lang('Price','admin')}
                            </span>
                            {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'Price'}
                                {if $_GET.order == 'ASC'}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                {else:}
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                {/if}
                            {/if}
                        </th>
                    </tr>
                    <tr class="head_body">
                <input type="hidden" name="WithoutImages" value="{$_GET.WithoutImages}"/>
                <input type="hidden" name="orderMethod" value="{$_GET.orderMethod}"/>
                <input type="hidden" name="order" value="{$_GET.order}"/>
                <td class="t-a_c">

                </td>
                <td class="">
                    <div>
                        <input id="filterID" name="filterID" onkeypress='validateN(event)' type="text" value="{$_GET.filterID}"/>
                    </div>
                </td>
                <td>
                    <input type="text" name="text" value="{$_GET.text}" maxlength="500"/>
                </td>
                <td>
                    <select class="prodFilterSelect" name="CategoryId">
                        <option value="0">{lang('All','admin')}</option>
                        {foreach $categories as $category}
                            {$selected = ''}
                            {if $category->getId() == (int)$_GET.CategoryId}
                                {$selected='selected="selected"'}
                            {/if}
                            <option value="{echo $category->getId()}" {$selected} >{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                        {/foreach}
                    </select>
                </td>
                <td>
                    <input type="text" name="sku" value="{$_GET.sku}" maxlength="255"/>
                </td>
                <td>
                    <select class="prodFilterSelect" name="Active">
                        <option value="">{lang('All','admin')}</option>
                        <option value="true" {if $_GET['Active'] == 'true'}selected="selected"{/if}>{lang('Active','admin')}</option>
                        <option value="false" {if $_GET['Active'] == 'false'}selected="selected"{/if}>{lang('Not active','admin')}</option>
                    </select>
                </td>
                <td>
                    <select class="prodFilterSelect" name="s">
                        <option value="">{lang('All','admin')}</option>
                        <option value="Hit" {if $_GET['s'] == 'Hit'}selected="selected"{/if}>{lang('Hit','admin')}</option>
                        <option value="Hot" {if $_GET['s'] == 'Hot'}selected="selected"{/if}>{lang('New','admin')}</option>
                        <option value="Action" {if $_GET['s'] == 'Action'}selected="selected"{/if}>{lang('Promotion','admin')}</option>
                    </select>
                </td>
                <td class="number f-s_0">
                    <label class="v-a_m" style="width:47%;margin-right:6%; display: inline-block;margin-bootom:0px;">
                        <span class="o_h d_b"><input id="min-price" placeholder="{lang('From','admin')}" onkeyup="checkLenghtStr('min-price', 11, 5, event.keyCode);" type="text" name="min_price" value="{$_GET.min_price}" maxlength="21"/></span>
                    </label>
                    <label class="v-a_m" style="width:47%;display: inline-block;margin-bootom:0px;">
                        <span class="o_h d_b"><input id="max-price" placeholder="{lang('To','admin')}" onkeyup="checkLenghtStr('max-price', 11, 5, event.keyCode);" type="text" name="max_price" value="{$_GET.max_price}" maxlength="21"/></span>
                    </label>
                </td>
                {form_csrf()}
                </form>
                </tr>

                {include_tpl('../products/fastCreateForm.tpl')}

                <tr class="fast-create-btn">
                    <td colspan="8">
                        <div class="t-a_c">
                            <button type="button" onclick="fastCreateProduct();
                                return false;" class="btn btn-success" ><i class="icon-plus-sign icon-white"></i>{lang('Create fast product','admin')}</button>
                            <button type="button" class="btn closeFast">{lang('Close fast create','admin')}</button>
                        </div>
                    </td>
                </tr>
                {if $_GET['fast_create']}
                    {literal}
                        <script type="text/javascript">
                            $(document).ready(function () {
                                setTimeout(function () {
                                    $('.CreateFastT').click();
                                }, 1000)

                            })

                        </script>
                    {/literal}
                {/if}

                </thead>
                <tbody>
                    {foreach $products as $p}
                        {$variants = $p->getProductVariants()}
                        {if sizeof($variants) == 1}
                            <tr data-id="{echo $p->getId()}" class="simple_tr">
                                <td class="t-a_c">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox" name="ids" value="{echo $p->getId()}" data-id="{echo $p->getId()}"/>
                                        </span>
                                    </span>
                                </td>
                                <td><p>{echo $p->getId()}</p></td>
                                <td class="share_alt">
                                    <a href="/shop/product/{echo $p->getUrl()}"
                                       target="_blank"
                                       class="go_to_site pull-right btn btn-small"
                                       data-rel="tooltip"
                                       data-placement="top"
                                       data-original-title="{lang('Show on site','admin')}">
                                        <i class="icon-share-alt"></i>
                                    </a>
                                    <div class="a-photo-out">
                                        <a href="/admin/components/run/shop/products/edit/{echo $p->getId()}{$_SESSION['ref_url']}"
                                           class="pjax title"
                                           data-rel="tooltip"
                                           data-title="{lang('Edit product','admin')}">
                                            <span class="photo-block">
                                                <span class="helper"></span>
                                                {if $p->getfirstvariant()->getSmallPhoto()}
                                                    <img src="{site_url($p->getfirstvariant()->getSmallPhoto())}">
                                                {else:}
                                                    <img src="{$THEME}images/select-picture.png" class="img-polaroid">
                                                {/if}
                                            </span>
                                            <span class="text-el">{truncate(ShopCore::encode($p->getName()),100)}</span>
                                        </a>
                                        {if $p->getBrand()}
                                            <div class="category-list-brand">
                                                <a href="/admin/components/run/shop/brands/edit/{echo $p->getBrand()->getId()}"
                                                   class="pjax title t-d_n"
                                                   data-rel="tooltip"
                                                   data-title="{lang('Edit brand','admin')}">
                                                    <span class="">{echo $p->getBrand()->getName()}</span>
                                                </a>
                                            </div>
                                        {/if}
                                    </div>
                                </td>
                                <td class="share_alt">
                                    <a href="/shop/category/{echo $p->getMainCategory()->getFullPath()}"
                                       target="_blank"
                                       class="go_to_site pull-right btn btn-small"
                                       data-rel="tooltip"
                                       data-placement="top"
                                       data-original-title="{lang('Show on site','admin')}">
                                        <i class="icon-share-alt"></i>
                                    </a>
                                    <div class="o_h">
                                        <a href="{$ADMIN_URL}categories/edit/{echo $p->getMainCategory()->getId()}"
                                           class="pjax"
                                           data-rel="tooltip"
                                           data-title="{lang('Edit category','admin')}">
                                            {echo $p->getMainCategory()->getName()}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <p>{echo $variants[0]->getNumber()}</p>
                                </td>
                                <td>
                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('show','admin')}">
                                        {if $p->getActive() == true}
                                            <span class="prod-on_off" data-id="{echo $p->getId()}"></span>
                                        {else:}
                                            <span class="prod-on_off disable_tovar" data-id="{echo $p->getId()}"></span>
                                        {/if}
                                    </div>
                                </td>
                                <td>
                                    {if $p->getHit() == true}
                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small hits-value btn-primary active {if $p->getActive() != true} disabled{/if} setHit" data-title-new="{lang('Hit','admin')}"><i class="icon-fire"></i></button>
                                        {else:}
                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small hits-value {if $p->getActive() != true} disabled{/if} setHit" data-title-new="{lang('Hit','admin')}"><i class="icon-fire"></i></button>
                                        {/if}

                                    {if $p->getHot() == true}
                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small noveltys-value btn-primary active {if $p->getActive() != true} disabled{/if} setHot" data-title-new="{lang('Novelty','admin')}"><i class="icon-gift"></i></button>
                                        {else:}
                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small noveltys-value {if $p->getActive() != true} disabled{/if} setHot" data-title-new="{lang('Novelty','admin')}"><i class="icon-gift"></i></button>
                                        {/if}

                                    {if $p->getAction() == true}
                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small actions-value btn-primary active {if $p->getActive() != true} disabled{/if} setAction" data-title-new="{lang('Promotion','admin')}"><i class="icon-star"></i></button>
                                        {else:}
                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small actions-value {if $p->getActive() != true} disabled{/if} setAction" data-title-new="{lang('Promotion','admin')}"><i class="icon-star"></i></button>
                                        {/if}
                                </td>
                                <td>
                                    <span class="pull-right"><span class="neigh_form_field help-inline"></span>&nbsp;&nbsp;{echo ShopCore::app()->SCurrencyHelper->getSymbolById($variants[0]->getCurrency())}</span>
                                    <div class="p_r o_h frame_price number">
                                        <input type="text"
                                               value="{echo preg_replace('/\.?0*$/','',number_format($variants[0]->getPriceInMain(), 5, ".", ""))}"
                                               {/*        value="{echo \Currency\Currency::create()->decimalPointsFormat($variants[0]->getPriceInMain(), $variants[0]->getCurrency())}"*/}
                                               class="js_price"
                                               data-value="{echo number_format($variants[0]->getPriceInMain(), 5, ".", "")}">
                                        <button class="btn btn-small refresh_price"
                                                data-id="{echo $p->getId()}"
                                                type="button">
                                            <i class="icon-refresh"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        {else:}
                            <tr data-id="{echo $p->getId()}" class="simple_tr">
                                <td colspan="8">
                                    <table>
                                        <thead class="no_vis">
                                            <tr>
                                                <td class="span1"></td>
                                                <td class="span1"></td>
                                                <td class="span3"></td>
                                                <td class="span2"></td>
                                                <td class="span1"></td>
                                                <td class="span1"></td>
                                                <td class="span2"></td>
                                                <td class="span2"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="t-a_c">
                                                    <span class="frame_label">
                                                        <span class="niceCheck b_n">
                                                            <input type="checkbox" name="ids" value="{echo $p->getId()}" data-id="{echo $p->getId()}"/>
                                                        </span>
                                                    </span>
                                                </td>
                                                <td>
                                                    <p>{echo $p->getId()}</p>
                                                </td>
                                                <td class="share_alt">
                                                    <a href="/shop/product/{echo $p->getUrl()}"
                                                       target="_blank"
                                                       class="go_to_site pull-right btn btn-small"
                                                       data-rel="tooltip"
                                                       data-placement="top"
                                                       data-original-title="{lang('Show on site','admin')}">
                                                        <i class="icon-share-alt"></i>
                                                    </a>
                                                    <div class="a-photo-out">
                                                        <a href="/admin/components/run/shop/products/edit/{echo $p->getId()}{$_SESSION['ref_url']}"
                                                           class="pjax title"
                                                           data-rel="tooltip"
                                                           data-title="{lang('Edit product','admin')}">
                                                            <span class="photo-block">
                                                                <span class="helper"></span>
                                                                {if $p->getfirstvariant()->getSmallPhoto()}
                                                                    <img src="{site_url($p->getfirstvariant()->getSmallPhoto())}">
                                                                {else:}
                                                                    <img src="{$THEME}images/select-picture.png" class="img-polaroid">
                                                                {/if}
                                                            </span>
                                                            <span class="text-el">{truncate(ShopCore::encode($p->getName()),100)}</span>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="share_alt">
                                                    <a href="/shop/category/{echo $p->getMainCategory()->getFullPath()}"
                                                       target="_blank"
                                                       class="go_to_site pull-right btn btn-small"
                                                       data-rel="tooltip"
                                                       data-placement="top"
                                                       data-original-title="{lang('Show on site','admin')}">
                                                        <i class="icon-share-alt"></i>
                                                    </a>
                                                    <div class="o_h">
                                                        <a href="{$ADMIN_URL}categories/edit/{echo $p->getMainCategory()->getId()}"
                                                           class="pjax"
                                                           data-rel="tooltip"
                                                           data-title="{lang('Edit category','admin')}">
                                                            {echo $p->getMainCategory()->getName()}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('show','admin')}">
                                                        {if $p->getActive() == true}
                                                            <span class="prod-on_off" data-id="{echo $p->getId()}"></span>
                                                        {else:}
                                                            <span class="prod-on_off disable_tovar" data-id="{echo $p->getId()}"></span>
                                                        {/if}
                                                    </div>
                                                </td>
                                                <td>
                                                    {if $p->getHit() == true}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('Hit','admin')}"><i class="icon-fire"></i></button>
                                                        {else:}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('Hit','admin')}"><i class="icon-fire"></i></button>
                                                        {/if}

                                                    {if $p->getHot() == true}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('Novelty','admin')}"><i class="icon-gift"></i></button>
                                                        {else:}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('Novelty','admin')}"><i class="icon-gift"></i></button>
                                                        {/if}

                                                    {if $p->getAction() == true}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('Promotion','admin')}"><i class="icon-star"></i></button>
                                                        {else:}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('Promotion','admin')}"><i class="icon-star"></i></button>
                                                        {/if}
                                                </td>
                                                <td>
                                                    <a href="#" class="t-d_n variants"><span class="js">{lang('Variants','admin')}</span> <span class="f-s_14">↓</span></a>
                                                </td>
                                            </tr>
                                            <tr style="display: none;">
                                                <td colspan="8">
                                                    <table>
                                                        <thead class="no_vis">
                                                            <tr>
                                                                <td class="span1"></td>
                                                                <td class="span1"></td>
                                                                <td class="span3"></td>
                                                                <td class="span2"></td>
                                                                <td class="span1"></td>
                                                                <td class="span1"></td>
                                                                <td class="span2"></td>
                                                                <td class="span2"></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="sortable save_positions_variant" data-url="/admin/components/run/shop/search/save_positions_variant">

                                                            {foreach $variants as $v}

                                                                <tr data-title="{lang('Drag product variant','admin')}">
                                                                    <td class="t-a_c">
                                                                        <input name="idv" type="hidden" value="{echo $v->id}"/>
                                                                    </td>
                                                                    <td></td>
                                                                    <td class="variants-items-in">
                                                                        <div class="a-photo-out">
                                                                            <span class="simple_tree">↳</span>
                                                                            <span class="photo-block">
                                                                                <span class="helper"></span>
                                                                                {if $v->getSmallPhoto()}
                                                                                    <img src="{site_url($v->getSmallPhoto())}">
                                                                                {else:}
                                                                                    <img src="{$THEME}images/select-picture.png" class="img-polaroid">
                                                                                {/if}
                                                                            </span>
                                                                            {if $v->getName() != ''}
                                                                                <span>{echo $v->getName()}</span>
                                                                            {else:}
                                                                                <span>{echo $p->getName()}</span>
                                                                            {/if}
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                    <td><p>{echo $v->getNumber()}</p></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>
                                                                        <span class="pull-right">
                                                                            <span class="neigh_form_field help-inline"></span>&nbsp;&nbsp;{echo ShopCore::app()->SCurrencyHelper->getSymbolById($v->getCurrency())}</span>
                                                                        <div class="p_r o_h frame_price number">
                                                                            <input type="text"
                                                                                   value="{echo preg_replace('/\.?0*$/','',number_format($v->getPriceInMain(), 5, ".", ""))}"
                                                                                   {/*                                value="{echo \Currency\Currency::create()->decimalPointsFormat($v->getPriceInMain(), $v->getCurrency())}"*/}
                                                                                   class="js_price"
                                                                                   data-value="{echo number_format($v->getPriceInMain(), 5, ".", "")}">
                                                                            <button class="btn btn-small refresh_price"
                                                                                    data-id="{echo $v->getProductId()}"
                                                                                    variant-id="{echo $v->getId()}"
                                                                                    type="button">
                                                                                <i class="icon-refresh"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            {/foreach}
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        {/if}
                    {/foreach}
                </tbody>
            </table>
            {if $totalProducts == 0}
                <div class="row-fluid news">
                    <div class="span12">
                        <div class="alert alert-info">
                            <p>{lang('Product list is empty','admin')}.</p>
                        </div>
                    </div>
                </div>
            </div>

        {/if}

        <div class="clearfix">
            {if $pagination > ''}
                {$pagination}
            {/if}
            <div class="pagination pull-right">
                <select style="max-width:60px;" onchange="change_per_page(this);
                    return false;">
                    {if $_COOKIE['per_page'] == ShopCore::app()->SSettings->adminProductsPerPage}<option selected="selected" value="{echo $_COOKIE['per_page']}">{echo $_COOKIE['per_page']}</option>{/if}
                    <option {if $_COOKIE['per_page'] == 10}selected="selected"{/if} value="10">10</option>
                    <option {if $_COOKIE['per_page'] == 20}selected="selected"{/if} value="20">20</option>
                    <option {if $_COOKIE['per_page'] == 30}selected="selected"{/if} value="30">30</option>
                    <option {if $_COOKIE['per_page'] == 40}selected="selected"{/if} value="40">40</option>
                    <option {if $_COOKIE['per_page'] == 50}selected="selected"{/if} value="50">50</option>
                    <option {if $_COOKIE['per_page'] == 60}selected="selected"{/if} value="60">60</option>
                    <option {if $_COOKIE['per_page'] == 70}selected="selected"{/if} value="70">70</option>
                    <option {if $_COOKIE['per_page'] == 80}selected="selected"{/if} value="80">80</option>
                    <option {if $_COOKIE['per_page'] == 90}selected="selected"{/if} value="90">90</option>
                    <option {if $_COOKIE['per_page'] == 100}selected="selected"{/if} value="100">100</option>
                </select>
            </div>
            <div class="pagination pull-right" style="margin-right: 10px; margin-top: 24px;">{lang('At the products page','admin')}:</div>
        </div>
        </div>

    </section>
