<div class="container">
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->    
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Removing status','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Remove your status?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}notificationstatuses/deleteAll')" >{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>


    <div id="delete_dialog" title="{lang('Removing status','admin')}" style="display: none">
        {lang('Remove status?','admin')}
    </div>
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
    <div method="post" action="#">
        <section class="mini-layout">
            <div class="frame_title clearfix">
                <div class="pull-left">
                    <span class="help-inline"></span>
                    <span class="title">{lang('View the status of appearance','admin')}</span>
                </div>
                <div class="pull-right">
                    <div class="d-i_b">
                        <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/notificationstatuses/create"><i class="icon-plus-sign icon-white"></i>{lang('Create status','admin')}</a>
                        <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
                    </div>
                </div>                            
            </div>
            <div class="row-fluid">
                {if count($model) > 0}
                    <table class="table  table-bordered table-hover table-condensed t-l_a">
                        <thead>
                            <tr>
                                <th class="t-a_c span1">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox" />
                                        </span>
                                    </span>
                                </th>
                                <th>{lang('ID','admin')}</th>
                                <th>{lang('Name','admin')}</th>
                                <th>{lang('Position','admin')}</th>
                            </tr>
                        </thead>
                        <tbody class="sortable  save_positions" data-url="/admin/components/run/shop/notificationstatuses/savePositions">
                            {foreach $model as $c}
                                <tr>
                                    <td class="t-a_c">
                                        <span class="frame_label">
                                            <span class="niceCheck b_n">
                                                <input type="checkbox" name="ids" value="{echo $c->getId()}"/>
                                            </span>
                                        </span>
                                    </td>
                                    <td><span>{echo $c->getId()}</span></td>
                                    <td class="share_alt">
                                        <a href="{$ADMIN_URL}notificationstatuses/edit/{echo $c->getId()}" class="title d_i" data-rel="tooltip" data-placement="top" data-original-title="{lang('Edit status notification','admin')}">{echo ShopCore::encode($c->getName())}</a>
                                    </td>
                                    <td><span>{echo $c->getPosition()}</span></td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                {else:}
                    <div class="alert alert-info" style="margin-bottom: 18px; margin-top: 18px;">
                        {lang('Empty status list.','admin')}
                    </div>
                {/if}
            </div>
            <div class="clearfix">
            </div>
        </section>
    </div>
</div>