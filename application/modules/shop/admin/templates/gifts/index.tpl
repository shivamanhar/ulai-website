<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->    
<div class="modal hide fade modal_del">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Removing Gift Certificate','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('Remove selected gift certificates?','admin')}</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}gifts/delete')" >{lang('Delete','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>


<div id="delete_dialog" title="{lang('Removing Gift Certificate','admin')}" style="display: none">
    {lang('Remove a gift certificate?','admin')}
</div>
<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Gift certificate list','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/gifts/create" ><i class="icon-plus-sign icon-white"></i>{lang('Create gift certificate','admin')}</a>
                <a class="btn btn-small pjax" href="/admin/components/run/shop/gifts/settings" >{lang('Settings','admin')}</a>
                <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()" id="del_sel_cert"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
            </div>
        </div>  
    </div>
    {if count($model)>0}
        <form method="post" action="#" class="form-horizontal">
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
                        <th class="span1">{lang('ID','admin')}</th>
                        <th>{lang('Unique key','admin')}</th>
                        <th>{lang('Price','admin')}</th>
                        <th>{lang('Has been created','admin')}</th>
                        <th>{lang('Valid to','admin')}</th>
                        <th>{lang('Active','admin')}</th>
                    </tr>    
                </thead>
                <tbody class="sortable">
                    {foreach $model as $c}
                        <tr data-id="{echo $c->getId()}">
                            <td class="t-a_c">
                                <span class="frame_label">
                                    <span class="niceCheck b_n">
                                        <input type="checkbox" name="ids" value="{echo $c->getId()}"/>
                                    </span>
                                </span>
                            </td>
                            <td>{echo $c->getId()}</td>
                            <td><a class="pjax" href="{$ADMIN_URL}gifts/edit/{echo $c->getId()}">{echo $c->getKey()}</td>
                            <td>{echo $c->getPrice()}</td>
                            <td>{echo date('Y-m-d', $c->getCreated())}</td>
                            <td>{echo date('Y-m-d', $c->getEspDate())}</td>
                            <td>
                                <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('switch on','admin')}"  data-off="{lang('switch off','admin')}">
                                    <span class="prod-on_off ch_active {if date('U')>$c->getEspDate() || $c->getActive() == 0}disable_tovar{/if}" data-cid="{echo $c->getId()}"></span>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </form>
    {else:}
        <div class="alert alert-info m-t_20">
            {lang('Gift certificate list is empty.','admin')}
        </div>
    {/if}
</section>