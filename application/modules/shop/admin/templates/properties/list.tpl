<div class="container">
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Delete a property','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Remove selected properties?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary"
               onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}properties/delete')">{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>

    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
    {if $filterCategory}
        {$category_id = $filterCategory->getId();}
    {else:}
        {$category_id = '';}
    {/if}
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Properties list review','admin')}</span>
            </div>
            <div class="pull-right">
                <span class="help-inline"></span>

                <div class="d-i_b">
                    <button title="{lang('Filter','admin')}" onclick="$('#filter_form').submit();"
                            class="d_n btn btn-small action_on disabled listFilterSubmitButton"><i
                                class="icon-filter"></i>{lang('Filter','admin')}</button>
                    <button title="{lang('Reset filter','admin')}" onclick="if (!$(this).hasClass('disabled'))
                            location.href = '/admin/components/run/shop/properties/index/{echo $category_id}'"
                            type="button" class="btn btn-small action_on {if count($_GET)<=1}disabled{/if}"><i
                                class="icon-refresh"></i>{lang('Cancel filter','admin')}</button>
                    <button {if $_GET['fastcreate']}style="display:none"{/if} type="button"
                            class="btn btn-small CreateFastT"><i
                                class="icon-plus-sign"></i>{lang('Open fast create','admin')}</button>
                    <a {if $_GET['fastcreate']}style="display:none"{/if} class="btn btn-small btn-success pjax"
                       href="/admin/components/run/shop/properties/create"><i
                                class="icon-plus-sign icon-white"></i>{lang('Create a property','admin')}</a>
                    <button type="button" class="btn btn-small btn-danger disabled action_on"
                            onclick="delete_function.deleteFunction()" id="del_sel_property"><i
                                class="icon-trash"></i>{lang('Delete','admin')}</button>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="row-fluid">
                <form action="{$ADMIN_URL}properties/index/{echo $category_id}" id="filter_form" method="get"
                      class="listFilterForm">
                    <input type="hidden" name="orderMethod" value="{$_GET.orderMethod}"/>
                    <input type="hidden" name="order" value="{$_GET.order}"/>
                    <table class="table  table-bordered table-hover table-condensed t-l_a properties_table">
                        <thead>

                        <tr style="cursor: pointer;">
                            <th class="t-a_c span1">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox"/>
                                        </span>
                                    </span>
                            </th>
                            <th class="span1 property_list_order" data-column="Id">
                                    <span class="thead_name">
                                        {lang('ID','admin')}
                                    </span>
                                {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'Id'}
                                    {if $_GET.order == 'ASC'}
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="f-s_14">↑</span>
                                    {else:}
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="f-s_14">↓</span>
                                    {/if}
                                {/if}
                            </th>
                            <th class="span3 property_list_order" data-column="Property">
                                    <span class="thead_name">
                                        {lang('Property','admin')}
                                    </span>
                                {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'Property'}
                                    {if $_GET.order == 'ASC'}
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="f-s_14">↑</span>
                                    {else:}
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="f-s_14">↓</span>
                                    {/if}
                                {/if}

                            </th>
                            <th class="span3 property_list_order" data-column="CategoryName">
                                <span class="thead_name"> {lang('Show in category','admin')} </span>
                            </th>
                            <th class="span2 property_list_order" data-column="CSVName">
                                    <span class="thead_name">
                                        CSV {lang('Name','admin')}
                                    </span>
                                {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'CSVName'}
                                    {if $_GET.order == 'ASC'}
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="f-s_14">↑</span>
                                    {else:}
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="f-s_14">↓</span>
                                    {/if}
                                {/if}
                            </th>
                            <th class="property_list_order span1" data-column="Status">
                                    <span class="thead_name">
                                        {lang('Status','admin')}
                                    </span>
                                {if isset($_GET.orderMethod) AND $_GET.orderMethod == 'Status'}
                                    {if $_GET.order == 'ASC'}
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="f-s_14">↑</span>
                                    {else:}
                                        &nbsp;&nbsp;&nbsp;
                                        <span class="f-s_14">↓</span>
                                    {/if}
                                {/if}
                            </th>
                        </tr>

                        {include_tpl('fastPropertyCreate.tpl')}

                        <tr class="fast-create-btn" {if $_GET['fastcreate']}style="display: table-row;"{/if}>
                            <td colspan="6">
                                <div class="t-a_c">
                                    <button type="button" class="btn btn-success"
                                            onclick="fastParopCreate($('[name=Name]').val(), $('[name=inCat]').val(), $('[name=CsvName]').val(), $('.fast-create .prod-on_off'));
                                        return false;">
                                        <i class="icon-plus-sign icon-white"></i>{lang('Create fast property','admin')}
                                    </button>
                                    <button type="button"
                                            class="btn closeFast">{lang('Close fast create','admin')}</button>
                                </div>
                            </td>
                        </tr>


                        <tr class="head_body properties_filter_inputs"
                            {if $_GET['fastcreate']}style="display: none"{/if}>
                            <td class="t-a_c">

                            </td>
                            <td class="number">
                                <div>
                                    <input name="filterID" type="text" value="{$_GET.filterID}"/>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="Property" value="{$_GET.Property}" maxlength="500"/>
                            </td>
                            <td>
                                <div class="d-i_b">
                                    <select name="CategoryId" class="catfilter"
                                            style="margin-bottom: 0px;width: 230px;">
                                        <option value="0">- {lang('All','admin')} {lang('Categories','admin')}-
                                        </option>
                                        {foreach $categories as $category}
                                            {$selected = ''}
                                            {if $filterCategory instanceof SCategory && $category->getId() == $filterCategory->getId()}
                                                {$selected='selected="selected"'}
                                            {/if}
                                            <option value="{echo $category->getId()}" {$selected} >{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="CSVName" value="{$_GET.CSVName}"/>
                            </td>

                            <td>
                                <select class="propFilterSelect" name="Active">
                                    <option value="">{lang('All','admin')}</option>
                                    <option value="true"
                                            {if $_GET['Active'] == 'true'}selected="selected"{/if}>{lang('Active','admin')}</option>
                                    <option value="false"
                                            {if $_GET['Active'] == 'false'}selected="selected"{/if}>{lang('Not active','admin')}</option>
                                </select>
                            </td>

                        </tr>


                        </thead>
                        <tbody class="sortable save_positions"
                               data-url="/admin/components/run/shop/properties/save_positions">
                        {if count($model)>0}
                            {foreach $model as $p}
                                <tr data-id="{echo $p->getId()}">
                                    <td class="t-a_c">
                                <span class="frame_label">
                                    <span class="niceCheck b_n">
                                        <input type="checkbox" name="ids" value="{echo $p->getId()}"/>
                                    </span>
                                </span>
                                    </td>
                                    <td>{echo $p->getId()}</td>
                                    <td>
                                        <a class="pjax"
                                           href="{$ADMIN_URL}properties/edit/{echo $p->getId()}/{echo $locale}"
                                           data-rel="tooltip"
                                           data-title="{lang('Edit property','admin')}">{truncate(ShopCore::encode($p->getName()),100)}</a>
                                    </td>
                                    <td>
                                        {foreach $p_cat[$p->getId()] as $k=>$categ_name}
                                            {if trim($categ_name)}
                                                {echo $categ_name}{if count($p_cat[$p->getId()]) != $k+1 },{/if}
                                            {/if}
                                        {/foreach}
                                    </td>
                                    <td>{echo $p->getCSVName()}</td>
                                    <td class="span1">
                                        <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top"
                                             data-original-title="{lang('switch on','admin')}"
                                             data-off="{lang('switch off','admin')}">
                                            <span class="prod-on_off prop_active {if $p->getActive() != 1}disable_tovar{/if}"
                                                  data-id="{echo $p->getId()}"></span>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                </form>
            </div>
            {if count($model)<=0}
                <div class="alert alert-info">
                    {lang('Empty property list','admin')}
                </div>
            {/if}

            <div class="clearfix">
                {if $pagination > ''}
                    {$pagination}
                {/if}
                <div class="pagination pull-right">
                    <select style="max-width:60px;" onchange="change_per_page(this);
                return false;">
                        {if $_COOKIE['per_page'] == ShopCore::app()->SSettings->adminProductsPerPage}
                            <option selected="selected"
                                    value="{echo $_COOKIE['per_page']}">{echo $_COOKIE['per_page']}</option>{/if}
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
                <div class="pagination pull-right"
                     style="margin-right: 10px; margin-top: 24px;">{lang('At the properties page','admin')}:
                </div>
            </div>


        </div>
    </section>
</div>