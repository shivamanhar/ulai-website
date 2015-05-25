<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->    
<div class="modal hide fade modal_del">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" title="{lang('Close','admin')}" aria-hidden="true">&times;</button>
        <h3>{lang('Remove fields','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('Remove the selected field?','admin')}</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}customfields/deleteAll')" >{lang('Delete','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>


<div id="delete_dialog" title="{lang('Remove fields','admin')}" style="display: none">
    {lang('Remove the field?','admin')}
</div>
<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Additional fields list','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/customfields/create" ><i class="icon-plus-sign icon-white"></i>{lang('Create Field','admin')}</a>
                <button type="button" class="btn btn-small disabled action_on btn-danger" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
            </div>
        </div>                            
    </div>

    {if count($customFields) > 0}
        {$entities = array('user'=>'<i class="icon-user"></i> '.lang('One user','admin'), 'order'=>'<i class="icon-shopping-cart"></i> '.lang('Order','admin'), 'product'=> lang('Product','admin'))}
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
                    <th>{lang('Name','admin')}</th>
                    <th>{lang('Related entity','admin')}</th>
                    <th>{lang('Description','admin')}</th>                                       
                    <th>{lang('Field active','admin')}</th>
                    <th>{lang('Field required','admin')}</th>
                   <!--<th class="span2">{lang('Field','admin')} {lang('Private','admin')}</th>-->
                </tr>

            </thead>
            <tbody class="sortable save_positions" data-url="/admin/components/run/shop/customfields/save_positions">
                {foreach $customFields as $c}
                    <tr>
                        <td class="t-a_c">
                            <span class="frame_label">
                                <span class="niceCheck b_n">
                                    <input type="checkbox" name="ids" value="{echo $c->getId()}"/>
                                </span>
                            </span>
                        </td>
                        <td><span>{echo $c->getId()}</span></td>
                        <td>
                            <a href="{$ADMIN_URL}customfields/edit/{echo $c->getId()}" class="pjax" data-rel="tooltip" data-title="{lang('Editing','admin')}">{truncate(ShopCore::encode($c->getName()),100)}</a>
                        </td>
                        <td>{echo $entities[$c->getEntity()]}</td>
                        <td><span>{echo $c->getFieldDescription()}</span></td>
                        <td>
                            <div class="frame_prod-on_off" 
                                 data-rel="tooltip" 
                                 data-placement="top" 
                                 data-original-title="{lang('Active','admin')}" 
                                 onclick="change_status('{$ADMIN_URL}customfields/change_status_activ/{echo $c->getId()}');">
                                <span class="prod-on_off {if $c->getIsActive() != 1}disable_tovar{/if}" ></span>
                            </div>
                        </td>
                        <td>
                            <div class="frame_prod-on_off" 
                                 data-rel="tooltip" 
                                 data-placement="top" 
                                 data-original-title="{lang('Required','admin')}" 
                                 onclick="change_status('{$ADMIN_URL}customfields/change_status_required/{echo $c->getId()}');">
                                <span class="prod-on_off {if $c->getIsRequired() != 1}disable_tovar{/if}"></span>
                            </div>
                        </td>

                        {/*}
                        <td>
                            <div class="frame_prod-on_off" 
                                 data-rel="tooltip" 
                                 data-placement="top" 
                                 data-original-title="{lang('Private','admin')}" 
                                 onclick="change_status('{$ADMIN_URL}customfields/change_status_private/{echo $c->getId()}');">
                                <span class="prod-on_off {if $c->getIsPrivate() != 1}disable_tovar{/if}"></span>
                            </div>
                        </td>
                        { */}
                    </tr>
                {/foreach}

            </tbody>
        </table>
    {else:}
        <div class="alert alert-info" style="margin-bottom: 18px; margin-top: 18px;">
            {lang('List is empty.','admin')}
        </div>
    {/if}
</section>