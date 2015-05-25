<div class="container">

    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->    
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Removal of payment methods','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Delete the selected payment methods?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}paymentmethods/deleteAll')">{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>


    <div id="delete_dialog" title="{lang('Removal of payment methods','admin')}" style="display: none">
        {lang('Delete method of payment?','admin')}
    </div>
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Payment methods list','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/paymentmethods/create"><i class="icon-plus-sign icon-white"></i>{lang('Create a payment method','admin')}</a>
                    <button type="button" class="btn btn-small btn-danger disabled action_on" id="del_sel_pm" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
                </div>
            </div>                            
        </div>
        <div class="tab-content">
            {if count($model) > 0}
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
                            <th>{lang('Method name','admin')}</th>
                            <th>{lang('Currency name','admin')}</th>
                            <th>{lang('Currency symbol','admin')}</th>
<!--                                <th>{lang('Position','admin')}</th>-->
                            <th class="span2 t-a_c">{lang('Active','admin')}</th>
                        </tr>
                    </thead>
                    <tbody class="sortable save_positions" data-url="/admin/components/run/shop/paymentmethods/savePositions">
                        {foreach $model as $c}
                            {//setDefaultLanguage($c)}
                            <tr>
                                <td class="t-a_c">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox" name="ids" value="{echo $c->getId()}"/>
                                        </span>
                                    </span>
                                </td>
                                <td><p>{echo $c->getId()}</p></td>
                                <td>
                                    <a class="pjax" href="{$ADMIN_URL}paymentmethods/edit/{echo $c->getId()}" data-rel="tooltip" data-title="{lang('Edit','admin')}">{echo ShopCore::encode($c->getName())}</a>
                                </td>
                                <td><p>{echo ShopCore::encode($c->getCurrency()->getName())}</p></td>
                                <td><p>{echo ShopCore::encode($c->getCurrency()->getSymbol())}</p></td>
<!--                                    <td><input type="text" value="{echo $c->getPosition()}" style="width:26px;" rel="{echo $c->getId()}" name="PaymentPos[{echo $c->getId()}]"  /></td>-->
                                <td class="t-a_c">

                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('Active','admin')}" onclick="change_status('{$ADMIN_URL}paymentmethods/change_payment_status/{echo $c->getId()}');" >
                                        <span class="prod-on_off {if $c->getActive() == NULL}disable_tovar{/if}"></span>
                                    </div>
                                </td>
                            </tr>
                        {/foreach}

                    </tbody>
                </table>
            {else:}
                <div class="alert alert-info" style="margin-bottom: 18px; margin-top: 18px;">
                    {lang('Payment methods list is empty','admin')}
                </div>
            {/if}
        </div>
    </section>
</div>