<div class="container">
    
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->    
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Role remove','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Remove selected roles?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}rbac/role_delete')" >{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>


    <div id="delete_dialog" style="display: none">
        {lang('Remove roles?','admin')}
    </div>
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
    
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Roles list','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()" id="del_sel_role"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
                    <a class="btn btn-small pjax btn-success" href="/admin/components/run/shop/rbac/role_create" ><i class="icon-plus-sign icon-white"></i>{lang('New Role','admin')}</a>
                </div>
            </div>  
        </div>
        <div class="tab-content">
            {if count($model)>0}
                <div class="row-fluid">
                    <form method="post" action="#" class="form-horizontal">
                        <table class="table  table-bordered table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th class="span1">
                                        <span class="frame_label">
                                            <span class="niceCheck b_n">
                                                <input type="checkbox"/>
                                            </span>
                                        </span>
                                    </th>
                                    <th class="span1">{echo $model[0]->getLabel('Id')}</th>
                                    <th>{echo $model[0]->getLabel('Name')}</th>
                                    <th>{echo $model[0]->getLabel('Description')}</th>
                                    <!--                                <th class="span1">{echo $model[0]->getLabel('Importance')}
                                                                    </th>-->
                                </tr>    
                            </thead>
                            <tbody class="sortable save_positions" data-url="/admin/components/run/shop/rbac/role_save_positions">
                                {foreach $model as $item}
                                    <tr data-id="{echo $item->getId()}" data-imp={echo $item->getImportance()}>
                                        <td>
                                            <span class="frame_label">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" value="{echo $item->getId()}" name="ids"/>
                                                </span>
                                            </span>
                                        </td>
                                        <td>{echo $item->getId()}</td>
                                        <td>
                                            <a class="pjax" href="/admin/components/run/shop/rbac/role_edit/{echo $item->getId()}">{echo ShopCore::encode($item->getName())}</a>
                                        </td>
                                        <td>
                                            {echo $item->getDescription()}
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
                    {lang('List','admin')} {lang('Role','admin')} {lang('Empty.','admin')}
                </div>
            {/if}
        </div>
    </section>
</div>