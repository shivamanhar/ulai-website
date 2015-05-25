<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
<div class="modal hide fade" id="first">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Remove currency','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('Remove the selected currency?','admin')}</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="delete_currency_function.deleteFunctionConfirm('{$ADMIN_URL}currencies/delete')" >{lang('Delete','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>

<div class="modal hide fade" id="recount">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Recalculation','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('The currency is in use in the products. Recalculate?','admin')}</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="delete_currency_function.ajaxRecount('{$ADMIN_URL}currencies/recount')" >{lang('Recalculate','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>


<div id="delete_dialog" title="{lang('Removing properties','admin')}" style="display: none">
    {lang('Remove currency?','admin')}
</div>
<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Currencies list','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                {/*}<button class="btn" name="checkPrices">{lang('Check prices','admin')}</button>{ */}
                <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/currencies/create" ><i class="icon-plus-sign icon-white"></i>{lang('Create currency','admin')}</a>
            </div>
        </div>
    </div>
    <div class="tab-content">
        {if count($model)>0}
            <div class="row-fluid">
                <form method="post" action="#" class="form-horizontal">
                    <table class="table  table-bordered table-hover table-condensed t-l_a">
                        <thead>
                            <tr>
                                <th class="span1">{lang('ID','admin')}</th>
                                <th>{lang('Title','admin')}</th>
                                <th>{lang('ISO','admin')} {lang('Code','admin')}</th>
                                <th>{lang('Character','admin')}</th>
                                <th>{lang('Main','admin')}</th>
                                <th>{lang('Additional currency','admin')}</th>
                                <th>{lang('Delete','admin')}</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            {foreach $model as $item}
                                <tr id="currency_tr{echo $item->getId()}">
                                    <td>{echo $item->getId()}</td>
                                    <td>
                                        <a class="pjax" href="/admin/components/run/shop/currencies/edit/{echo $item->getId()}" data-rel="tooltip" data-title="{lang('Editing','admin')}">{echo ShopCore::encode($item->getName())}</a>
                                    </td>
                                    <td>
                                        {echo ShopCore::encode($item->getCode())}
                                    </td>
                                    <td>{echo ShopCore::encode($item->getSymbol())}</td>
                                    <td>
                                        <input type=radio name="is_main" class="mainCurrency" {if $item->getmain() == 1}checked="checked"{/if} value="{echo $item->getid()}" onclick="changeMainValute({echo $item->getid()}, $(this))"/>
                                    </td>
                                    <td>
                                        <div class="frame_prod-on_off {if $item->getmain() == 1}d_n{/if}" data-rel="tooltip" data-placement="top" data-original-title="{lang('show','admin')}">
                                           <span data-itemid="{echo $item->getId()}" class="prod-on_off {if ShopCore::encode($item->getShowOnSite()) == 0}disable_tovar{/if}" style="{if ShopCore::encode($item->getShowOnSite()) == 0}left: -28px;{/if}" rel="{echo ShopCore::encode($item->getShowOnSite())}" onclick="showOnSite({echo $item->getId()}, $(this))"></span>
                                        </div>
                                    </td>

                                    <td>
                                        <button data-title-new="{lang('Delete','admin')}" type="button" class="btn btn-small btn-danger currencies-value" {if $item->getmain() == 1}disabled="disabled"{/if} onclick="delete_currency_function.deleteFunction({echo $item->getId()}, $(this))">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </form>
            </div>
        {else:}
            </br>
            <div class="alert alert-info">
                {lang('There are no currencies','admin')}
            </div>
        {/if}
    </div>
</section>
