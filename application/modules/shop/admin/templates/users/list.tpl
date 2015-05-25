<div class="container">

    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Deleting a user','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Remove selected users?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}users/deleteAll')" >{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>


    <div id="delete_dialog" title="{lang('Deleting a user','admin')}" style="display: none">
        {lang('Deleting a user','admin')}
    </div>
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Users list','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <button type="button" class="d_n btn btn-small action_on disabled listFilterSubmitButton"><i class="icon-filter"></i>{lang('Filter','admin')}</button>
                    <button title="{lang('Cancel filter','admin')}" onclick="if (!$(this).hasClass('disabled'))
                    location.href = '/admin/components/run/shop/users/index'" type="button" class="btn btn-small action_on {if $_GET == null || ($_GET['_pjax']!=null && count($_GET ==1))}disabled {/if}"><i class="icon-refresh"></i>{lang('Cancel filter','admin')}</button>
                    <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/users/create"><i class="icon-plus-sign icon-white"></i>{lang('Create user','admin')}</a>
                    <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="clearfix">
                <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
                    <a href="#users" class="btn btn-small active">{lang('User','admin')}</a>
                    <a href="#export" class="btn btn-small">{lang('Export','admin')}</a>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="users">
                    <form method="get" action="/admin/components/run/shop/users/index" id="ordersListFilter" class="listFilterForm">
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
                                    <th style="width: 20px">{lang('ID','admin')}</th>
                                    <th>{lang('E-mail','admin')}</th>
                                    <th>{lang('User','admin')}</th>
                                    <th>{lang('Role','admin')}</th>
                                    <th>{lang('Time of registration','admin')}</th>
                                    <th>{lang('Purchase price','admin')}</th>
                                </tr>
                                <tr class="head_body">
                                    <td></td>
                                    <td></td>
                                    <td><input type="text" data-provide="typeahead" data-items="5" id="shopEmailAutoC" value="{$_GET['email']}" name="email"/></td>
                                    <td><input type="text" data-provide="typeahead" data-items="5" id="shopNameAutoC" value="{$_GET['name']}" name="name"/></td>
                                    <td>
                                        <select id="shopRoleAutoC" name="role" onchange="submit()">
                                            {foreach $roles as $key => $role}
                                            <option {if $key == $_GET['role']} selected {/if}value="{echo $key}">{echo $role}</option>
                                            {/foreach}
                                            <option {if !$_GET['role']}selected{/if} value="0">{lang('Simple user', 'admin')}</option>
                                        </select>
                                    </td>
                                    <td class="f-s_0">
                                        <label class="v-a_m" style="width:115px;margin-right:10px; display: inline-block;margin-bottom:0px;">
                                            <span class="o_h d_b p_r">
                                                <input type="text" data-placement="top" data-original-title="{lang('choose a date','admin')}" data-rel="tooltip" class="datepicker "  name="dateCreated_f" value="{$_GET['dateCreated_f']}" placeholder="{lang('from','admin')}">
                                                <i class="icon-calendar"></i>
                                            </span>
                                        </label>
                                        <label class="v-a_m" style="width:115px; display: inline-block;margin-bottom:0px;">
                                            <span class="o_h d_b p_r">
                                                <input type="text" data-placement="top" data-original-title="{lang('choose a date','admin')}" data-rel="tooltip" class="datepicker "  name="dateCreated_t" value="{$_GET['dateCreated_t']}" placeholder="{lang('to','admin')}">
                                                <i class="icon-calendar"></i>
                                            </span>
                                        </label>
                                    </td>
                                    <td class="number f-s_0">
                                        <label class="v-a_m" style="width:115px;margin-right:10px; display: inline-block;margin-bottom:0px;">
                                            <span class="o_h d_b p_r">
                                                <input type="text" data-placement="top" data-original-title="{lang('numbers only','admin')}" data-rel="tooltip"   name="amout_f" value="{$_GET['amout_f']}" placeholder="{lang('from','admin')}">
                                            </span>
                                        </label>
                                        <label class="v-a_m" style="width:115px; display: inline-block;margin-bottom:0px;">
                                            <span class="o_h d_b p_r">
                                                <input type="text" data-placement="top" data-original-title="{lang('numbers only','admin')}" data-rel="tooltip"  name="amout_t" value="{$_GET['amout_t']}" placeholder="{lang('to','admin')}">
                                            </span>
                                        </label>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $model as $u}
                                <tr class="simple_tr">
                                    <td class="t-a_c">
                                        {if $u->getId() != $CI->dx_auth->get_user_id()}
                                        <span class="frame_label">
                                            <span class="niceCheck b_n">
                                                <input type="checkbox" name="ids" value="{echo $u->getId()}"/>
                                            </span>
                                        </span>
                                        {/if}
                                    </td>
                                    <td><a href="{$ADMIN_URL}users/edit/{echo $u->getId()}" class="pjax">{echo $u->getId()}</a></td>
                                    <td>
                                        <span>{echo ShopCore::encode($u->getUserEmail())}</span>
                                    </td>
                                    <td>
                                        <a href="{$ADMIN_URL}users/edit/{echo $u->getId()}"  class="pjax" data-title="{lang('Edit','admin')}" data-rel="tooltip">{echo ShopCore::encode($u->getFullName())}</a>
                                    </td>
                                    <td>
                                        {/*<span>{if $roles[$u->getRoleId()]}{echo $roles[$u->getRoleId()]}{else:}{lang('Simple user', 'admin')}{/if}</span>*/}
                                        <span>{if $roles[$u->getRoleId()]}{echo $roles[$u->getRoleId()]}{else:} - {/if}</span>
                                    </td>
                                    <td><p>{date("Y-m-d", $u->getDateCreated())}</p></td>
                                    <td><p>{echo $amountPurchases[$u->getId()]} {$CS}</p></td>
                                    {/*                                        <td><p>{echo $u->getAmout()} {$CS}</p></td>*/}

                                </tr>

                                {/foreach}

                            </tbody>
                        </table>
                        <div class="clearfix">
                            {if $paginator}
                            {$paginator}
                            {/if}
                            <div class="pagination pull-right">
                                <select style="max-width:60px;" onchange="change_per_page(this);
                                return false;">
                                {if $_COOKIE['per_page'] == ShopCore::app()->SSettings->adminProductsPerPage}<option selected="selected" value="{echo $_COOKIE['per_page']}">{echo $_COOKIE['per_page']}</option>{/if}
                                <option {if $_COOKIE['per_page'] == 10}selected="selected"{/if} value="10">10</option>
                                <option {if $_COOKIE['per_page'] == 20}selected="selected"{/if} value="20">20</option>
                                <option {if $_COOKIE['per_page'] == 30}selected="selected"{/if} value="30">30</option>
                                <option {if $_COOKIE['per_page'] == 40}selected="selected"{/if} value="40">40</option>
                                <option {if $_COOKIE['per_page'] == 50}selected="selected"{/if} value="50">50</option>
                                <option {if $_COOKIE['per_page'] == 60}selected="selected"{/if} value="60">60</option>
                                <option {if $_COOKIE['per_page'] == 70}selected="selected"{/if} value="70">70</option>
                                <option {if $_COOKIE['per_page'] == 80}selected="selected"{/if} value="80">80</option>
                                <option {if $_COOKIE['per_page'] == 90}selected="selected"{/if} value="90">90</option>
                                <option {if $_COOKIE['per_page'] == 100}selected="selected"{/if} value="100">100</option>
                            </select>
                        </div>
                        <div class="pagination pull-right" style="margin-right: 10px; margin-top: 24px;">{lang('At the users page','admin')}:</div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="export">
                <form id="exportUsers" method="post" action="{$ADMIN_URL}system/exportUsers">
                    <table class="table  table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Export','admin')}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd span9">
                                        <div class="form-horizontal">
                                            <div class="row-fluid">

                                                <div class="control-group">
                                                    <label class="control-label"> Способ экспорта: </label>
                                                    <div class="controls">
                                                        <div style="margin-top: 3px;">
                                                            <input type="radio" name="export" id="csv" value="csv" checked="checked" style="top: 2px; position: relative;"/>
                                                            <span>CSV (" ";):</span>
                                                            <span class="popover_ref" data-title="<b>CSV</b>">
                                                                <i class="icon-info-sign"></i>
                                                            </span>
                                                            <div class="d_n">
                                                                {lang('Export CSV gives <br />jumps file with <br />a list of all<br /> users.','admin')}
                                                            </div>
                                                        </div>
                                                        <div  class="m-t_5">
                                                            <input type="radio" name="export" id="monkey" value="monkey" style="top: 2px; position: relative;"/>
                                                            <span>MailChimp:</span>
                                                            <span class="popover_ref" data-title="<b>MailChimp</b>">
                                                                <i class="icon-info-sign"></i>
                                                            </span>
                                                            <div class="d_n">
                                                                {lang('Export Mailchimp sent <br />to all users on their<br /> email subscription<br /> form on your<br /> news rassilku.','admin')}
                                                            </div>
                                                        </div>
                                                        <div  class="m-t_10">
                                                            <button type="submit" class="btn btn-small action_on formSubmit export"  data-form="#exportUsers" >
                                                                <i class="icon-plus-sign"></i>{lang('Export','admin')}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mailChimpSettings" style="display: none">
                                                <hr style="border-top: 2px solid #eee">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <span class="popover_ref" data-title="<b>{lang('API Key for Mail Chimp','admin')}</b>">
                                                            <i class="icon-info-sign"></i>
                                                        </span>
                                                        <div class="d_n">
                                                            {lang('The key to your account <br />on the mail Mailchimp','admin')}
                                                        </div>
                                                        <span>{lang('API Key for Mail Chimp','admin')}:</span>
                                                    </label>
                                                </label>
                                                <div class="controls">
                                                    <input type="text" value="{echo ShopCore::app()->SSettings->adminMessageMonkey}" name="messages[monkey]" >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">
                                                    <span class="popover_ref" data-title="<b>{lang('Key for Mail Chimp list','admin')}</b>">
                                                        <i class="icon-info-sign"></i>
                                                    </span>
                                                    <div class="d_n">
                                                        {lang('The key to your list of <br />news for MailChimp','admin')}
                                                    </div>
                                                    <span>{lang('Key for Mail Chimp list','admin')}:</span>
                                                </label>
                                            </label>
                                            <div class="controls">
                                                <input type="text" value="{echo ShopCore::app()->SSettings->adminMessageMonkeylist}" name="messages[monkeylist]" >
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">
                                            </label>
                                            <div class="controls">
                                                <button type="button" class="btn btn-small btn-primary tt" ><i class="icon-ok"></i>{lang('Save','admin')}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            {form_csrf()}
        </form>
    </div>
</div>
</div>
</section>
</div>
<script type="text/javascript">
var usersDatas = {echo json_encode(array_values($usersDatas))};
</script>
{literal}
<script type="text/javascript">
window.onload = function () {
    if ($.exists('.datepicker')) {
        $(".datepicker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            prevText: '',
            nextText: ''
        });
    }
    $('.ui-datepicker').addClass('dropdown-menu');
}
</script>
{/literal}
