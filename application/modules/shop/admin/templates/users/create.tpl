<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Creating user','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="/admin/components/run/shop/users/index" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    <button type="button" class="btn btn-small btn-success formSubmit" data-form="#userCreate" data-action="close" data-submit><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                    <button type="button" class="btn btn-small action_on formSubmit" data-form="#userCreate" data-action="exit"><i class="icon-check"></i>{lang('Create and exit','admin')}</button>
                </div>
            </div>                            
        </div>
        <div class="tab-pane">

            <form id="userCreate" method="post" action="{$ADMIN_URL}users/create">
                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {lang('Data','admin')}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd span9">
                                    <div class="form-horizontal">
                                        <div class="control-group">
                                            <label class="control-label" for="UserEmail">{lang('E-mail','admin')}: <span class="must">*</span></label>
                                            <div class="controls">
                                                <input type="text" name="UserEmail" id="UserEmail" class="email required"/> 
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="Password">{lang('Password','admin')}: <span class="must">*</span></label>
                                            <div class="controls">
                                                <input type="text" name="Password" id="Password" class="required"/>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="Role">{lang('Role','admin')}:</label>
                                            <div class="controls">
                                                <select name="Role" id="Role">
                                                    <option value=""> - </option>
                                                    {foreach $roles as $role}
                                                        <option value="{echo $role->id}">{echo $role->alt_name}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="Name">{lang('Full name','admin')}: <span class="must">*</span></label>
                                            <div class="controls">
                                                <input type="text" name="Name" id="Name" required/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="Phone">{lang('Telephone','admin')}:</label>
                                            <div class="controls">
                                                <input type="text" name="Phone" id="Phone"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="Address">{lang('Address','admin')}:</label>
                                            <div class="controls">
                                                <input type="text" name="Address" id="Address"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>


                {//$addField = ShopCore::app()->CustomFieldsHelper->getCustomFields('user', -1)->asAdminHtml()}

                {if !empty($addField)}
                    <table class="table  table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Additional data','admin')}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd span9">
                                        <div class="form-horizontal">
                                            {$addField}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                {/if}

            </form>
        </div>




</div>
</section>
</div>