<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Editing','admin')} {lang('Privileges','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/rbac/privilege_list" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#priv_ed_form" data-action="close" data-submit><i class="icon-ok"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#priv_ed_form" data-action="exit"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>               
            </div>
        </div>

    </div>
    <form method="post" action="{$ADMIN_URL}rbac/privilege_edit/{echo $model->getId()}" class="form-horizontal" id="priv_ed_form">
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
                                    <div class="control-group m-t_10">
                                        <label class="control-label" for="Name">{echo $model->getLabel('Name')}:</label>
                                        <div class="controls">
                                            <input type="text" name="Name" id="Name" value="{echo $model->getName()}" required/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="Description">{echo $model->getLabel('Description')}:</label>
                                        <div class="controls">
                                            <input type="text" name="Description" id="Description" value="{echo $model->getDescription()}"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="GroupId">{echo $model->getLabel('GroupId')}</label>
                                        <div class="controls">
                                            <select name="GroupId" id="GroupId">
                                                {foreach $groups as $group}
                                                    <option {if $model->getGroupId() == $group->getId()} selected="selected" {/if} value="{echo $group->getId()}">{echo ShopCore::encode($group->getName())}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>    
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {form_csrf()}
    </form>
</section>