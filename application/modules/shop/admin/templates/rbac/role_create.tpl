<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Role create','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/rbac/role_list" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#role_cr_form" data-action="new" data-submit><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#role_cr_form" data-action="exit"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>
            </div>
        </div>

    </div>
    <div class="row-fluid">
        <div class="span3 m-t_10">
            <ul class="nav myTab nav-tabs nav-stacked">
                <li class="active">                        <a href="#params">{lang('Options','admin')}</a></li>
                {foreach $groups as $group}
                {if $group->getShopRbacPrivilegess()->count() > 0}
                <li >         <a href="#mod{echo $group->Id}">{echo $group->getName()}</a></li>
                {/if}
                {/foreach}
            </ul>
        </div>
        <div class="span9">
            <form method="post" action="{$ADMIN_URL}rbac/role_create" class="form-horizontal" id="role_cr_form">
                <div class="tab-content">
                    <div class="tab-pane active" id="params">
                        <table class="table  table-bordered table-hover table-condensed content_big_td">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        {lang('Properties','admin')}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">
                                        <div class="inside_padd span9">
                                            <div class="row-fluid">
                                                <div class="control-group m-t_10">
                                                    <label class="control-label" for="Name">{echo $model->getLabel('Name')}:</label>
                                                    <div class="controls">
                                                        <input type="text" name="Name" id="Name" value="" required/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="Description">{echo $model->getLabel('Description')}:</label>
                                                    <div class="controls">
                                                        <input type="text" name="Description" id="Description" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {foreach $groups as $group}                            
                    {if $group->getShopRbacPrivilegess()->count() > 0}
                    <div class="tab-pane" id="mod{echo $group->Id}">                     
                        <table class="table  table-bordered table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th class="span1">
                                        <span class="frame_label">
                                            <span class="niceCheck">
                                                <input type="checkbox" name="group_{echo $group->Id}"/>
                                            </span>
                                        </span>
                                    </th>
                                    <th>{echo $group->getName()}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $group->getShopRbacPrivilegess() as $privilege}
                                <tr class="simple_tr">
                                    <td>
                                        <span class="frame_label">
                                            <span class="niceCheck">
                                                <input type="checkbox" value="{echo $privilege->Id}" name="Privileges[]"/>
                                            </span>
                                        </span>
                                    </td>
                                    <td>{echo $privilege->getDescription()}</td>
                                </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                    {/if}
                    {/foreach}            
                    <!--                    <div class="tab-pane"></div>-->
                </div>
                {form_csrf()}
            </form>
        </div>
    </div>
</div>
</section>
