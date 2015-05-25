<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
<div class="modal hide fade modal_del">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Removing brand','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('Remove selected brands?','admin')}</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}brands/delete')" >{lang('Delete','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>


<div id="delete_dialog" title="{lang('Removing brand','admin')}" style="display: none">
    {lang('Remove brands?','admin')}
</div>
<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('List of brands','admin')} ({echo $total})</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
               <button class="d_n btn btn-small action_on listFilterSubmitButton" onclick="$('#brands_filter').submit();"><i class="icon-filter"></i>{lang('Filter','admin')}</button>
               <button type="button" class="btn btn-small CreateFastT"  ><i class="icon-plus-sign"></i>{lang('Open fast create','admin')}</button>
               <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/brands/create" ><i class="icon-plus-sign icon-white"></i>{lang('Create a brand','admin')}</a>
               <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()" id="del_sel_brand"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
           </div>
       </div>
   </div>
   <div class="tab-content">

    <div class="row-fluid">
        <form method="post" action="{$BASE_URL}admin/components/run/shop/brands/create" class="form-horizontal" id="brands_filter" enctype="multipart/form-data">
            <table class="table  table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th class="t-a_c span1">
                            <span class="frame_label">
                                <span class="niceCheck b_n">
                                    <input type="checkbox"/>
                                </span>
                            </span>
                        </th>
                        <th class="span1">{lang('ID','admin')}</th>
                        <th>{lang('Brand','admin')}</th>
                        <th>{lang('URL','admin')}</th>
                        <!--<th class="span1"></th>-->
                    </tr>
                    <tr class="head_body" {if !$_GET['fast_create']}style="display: table-row;"{else:}style="display: none;"{/if}>
                        <td class="t-a_c span1"></td>
                        <td class="span1">
                            <input type="text" class="searchInp" name="brand_id" {if !empty($_GET['brand_id'])}value="{$_GET['brand_id']}"{/if}>
                        </td>
                        <td>
                            <input type="text" class="searchInp" name="brand_name" {if !empty($_GET['brand_name'])}value="{$_GET['brand_name']}"{/if}>
                        </td>
                        <td>
                            <!--input type="text"-->
                        </td>
                        <!--<th class="span1"></th>-->
                    </tr>

                    {include_tpl('fastCreateBrand.tpl')}

                    <tr class="fast-create-btn" {if $_GET['fast_create']}style="display: table-row;"{/if}>
                        <td colspan="4">
                            <div class="t-a_c">
                                <button type="button" class="btn btn-success formSubmit fast-create-btn-brand" data-form="#brands_filter" data-action="fast_brand_create"><i class="icon-plus-sign icon-white"></i>{lang('Create fast brand','admin')}</button>
                                <button type="button" class="btn closeFast">{lang('Close fast create','admin')}</button>
                            </div>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    {if count($model)>0}

                    {foreach $model as $item}
                    {//setDefaultLanguage($item)}
                    <tr class="simple_tr">
                        <td class="t-a_c">
                            <span class="frame_label">
                                <span class="niceCheck b_n">
                                    <input type="checkbox" name="ids" value="{echo $item->getId()}"/>
                                </span>
                            </span>
                        </td>
                        <td>{echo $item->getId()}</td>
                        <td>
                            <div class="a-photo-out">
                                <a class="pjax clearfix" href="/admin/components/run/shop/brands/edit/{echo $item->getId()}" data-rel="tooltip" data-title="{lang('Edit brand','admin')}">

                                    <span class="photo-block">
                                        <span class="helper"></span>
                                        {if $item->getImage()}
                                        <img src="/uploads/shop/brands/{echo $item->getImage()}">
                                        {else:}
                                        <img src="{$THEME}images/select-picture.png" class="img-polaroid">
                                        {/if}
                                    </span>

                                    <span class="text-el">{echo ShopCore::encode($item->getName())}</span>
                                </a>
                            </div>
                        </td>
                        <td>
                            <a href="{echo shop_url('brand/'.$item->getUrl())}" target="_blank" data-rel="tooltip" data-title="{lang('Show on site','admin')}">{echo shop_url('brand/'.$item->getUrl())}</a>
                        </td>
                    </tr>
                    {/foreach}

                    {else:}
                    <tr>
                        <td colspan="4">
                            <div style="text-align: center; padding: 5px;">
                                {lang('Brands list is empty.','admin')}
                            </div>
                        </td>
                    </tr>
                    {/if}
                </tbody>
            </table>
            <div class="clearfix">
                {echo $pagination}
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
            <div class="pagination pull-right" style="margin-right: 10px; margin-top: 24px;">{lang('At the brands page','admin')}:</div>
        </div>
    </form>
</div>
</div>
<div id="setMessage"></div>
</section>
