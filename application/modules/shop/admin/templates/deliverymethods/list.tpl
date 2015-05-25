<div class="container">

    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->    
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Removing the shipping methods','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Delete Selected methods of delivery?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}deliverymethods/deleteAll')" >{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>


    <div id="delete_dialog" title="{lang('Removing the shipping methods','admin')}" style="display: none">
        {lang('Delete method of delivery?','admin')}
    </div>
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Delivery methods list','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="/admin/components/run/shop/deliverymethods/create" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i>{lang('Create a way to deliver','admin')}</a>
                    <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
                </div>
            </div>                            
        </div> {if count($model) > 0}
        <div class="tab-content">
            <div class="row-fluid">
                <table class="table  table-bordered table-hover table-condensed t-l_a">
                    <thead>
                        <tr>
                            <th class="t-a_c span1">
                                <span class="frame_label">
                                    <span class="niceCheck b_n">
                                        <input type="checkbox"/>
                                    </span>
                                </span>
                            </th>
                            <th>{lang('ID','admin')}</th>
                            <th class="span7">{lang('Method name','admin')}</th>
                            <th>{lang('Price','admin')}</th>
                            <th>{lang('Free','admin')} {lang('from','admin')}</th>
                            <th class="t-a_c">{lang('Active','admin')}</th>
                        </tr>
                    </thead>
                    <tbody class="sortable save_positions" data-url="/admin/components/run/shop/deliverymethods/save_positions">
                        {foreach $model as $c}
                            {//setDefaultLanguage($c)}
                            <tr >
                                <td class="t-a_c">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox" name="ids" value="{echo $c->getId()}"/>
                                        </span>
                                    </span>
                                </td>
                                <td><p>{echo $c->getId()}</p></td>
                                <td>
                                    <a class="pjax" href="{$ADMIN_URL}deliverymethods/edit/{echo $c->getId()}" data-rel="tooltip" data-title="{lang('Edit','admin')}">{echo ShopCore::encode($c->getName())}</a>
                                </td>
                                <td><p>{echo \Currency\Currency::create()->decimalPointsFormat($c->getPrice())} {if $c->getIsPriceInPercent()}%{else:}{$CS}{/if}</p></td>
                                <td><p>{echo \Currency\Currency::create()->decimalPointsFormat($c->getFreeFrom())} {$CS}</p></td>                                            
                                <td class="t-a_c">
                                    <div class="frame_prod-on_off" 
                                         data-rel="tooltip" 
                                         data-placement="top"
                                         data-title="{if $c->getEnabled() == NULL}{lang("don't show", 'admin')}{else:}{lang('show', 'admin')}{/if}"
                                         onclick="change_status('{$ADMIN_URL}deliverymethods/change_delivery_status/{echo $c->getId()}');" >
                                        <span class="prod-on_off {if $c->getEnabled() == NULL}disable_tovar{/if}" 
                                              style="{if $c->getEnabled() == NULL}left: -28px;{/if}">
                                        </span>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        {/foreach}

                    </tbody>
                </table>
            </div>
        </div>
        {else:}    </br>
            <div class="alert alert-info">
                {lang('Delivery methods list is empty','admin')}
            </div>
            {/if}
            </section>
        </div>
