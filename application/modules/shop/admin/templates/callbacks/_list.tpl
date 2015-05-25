<div class="container">
    {$ci = get_instance()}
    {$ci->load->model('dx_auth/users', 'users')}
    <form>
        <section class="mini-layout">
            <div class="frame_title clearfix">
                <div class="pull-left">
                    <span class="help-inline"></span>
                    <span class="title">{lang('Callback list','admin')} ({$totalCallbacks})</span>
                </div>
                <div class="pull-right">
                    <div class="d-i_b">
                        <button type="button" onclick="$('.modal').modal();"
                        class="btn btn-small btn-danger disabled action_on"><i
                        class="icon-trash"></i>{lang('Delete','admin')}</button>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
                    <a href="#callbacks_all" class="btn active btn-small">{lang('All','admin')}</a>
                    {foreach $callbackStatuses as $s}
                    <a href="#callbacks_{echo $s->getId()}" class="btn btn-small">{echo $s->getText()}</a>
                    {/foreach}
                </div>
            </div>
            {if sizeof($model)}
            <div class="tab-content">
                <div class="active  row-fluid tab-pane" id="callbacks_all">
                    <table class="table  table-bordered table-hover table-condensed t-l_a">
                        <thead>
                            <tr>
                                <th class="t-a_c span1">
                                    <span class="frame_label">
                                        <span class="niceCheck" style="background-position: -46px 0px; ">
                                            <input type="checkbox">
                                        </span>
                                    </span>
                                </th>
                                <th >{lang('ID','admin')}</th>
                                <th >{lang('User name','admin')}</th>
                                <th >{lang('Telephone','admin')}</th>
                                <th >{lang('Theme','admin')}</th>
                                <th >{lang('Status','admin')}</th>
                                <th >{lang('Date','admin')}</th>
                                <!--  <th  >{lang('Manager','admin')}</th>  -->
                                <th class="span1">{lang('Delete', 'admin')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $model as $c}
                            <tr data-status="{echo $c->getStatusId()}" data-id="{echo $c->getId()}"
                                class="simple_tr">
                                <td class="t-a_c">
                                    <span class="frame_label">
                                        <span class="niceCheck" style="background-position: -46px 0px; ">
                                            <input type="checkbox" name="ids" value="{echo $c->getId()}">
                                        </span>
                                    </span>
                                </td>
                                <td>{echo $c->getId()}</td>
                                <td><a class="pjax" href="{$ADMIN_URL}callbacks/update/{echo $c->getId()}"
                                 data-rel="tooltip" data-title="{lang('Edit callback','admin')}">
                                 {truncate(ShopCore::encode($c->getName()), 50)}
                             </a></td>
                             <td>{echo encode($c->getPhone())}</td>
                             <td>
                                <div>
                                    <select name="theme"
                                    onchange="callbacks.changeTheme({echo $c->getId()}, this.value)">
                                    <option value="0"
                                    selected="selected">{lang('Does not have','admin')}</option>
                                    {foreach $callbackThemes as $callbackTheme}
                                    <option value="{echo $callbackTheme->getId()}" {if $callbackTheme->getId() == $c->getThemeId()} selected="selected" {/if}>{echo $callbackTheme->getText()}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </td>
                        <td>
                            <div>
                                <select name="status"
                                onchange="callbacks.changeStatus({echo $c->getId()}, this.value)">
                                {foreach $callbackStatuses as $callbackStatus}
                                <option value="{echo $callbackStatus->getId()}" {if $callbackStatus->getId() == $c->getStatusId()} selected="selected" {/if}>{echo $callbackStatus->getText()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </td>
                    <td>{echo date('H:i:s d-m-Y', $c->getDate())}</td>
                    <td class="t-a_c span1">
                        <a href="#" class="btn btn-small btn-danger"
                        onclick="callbacks.deleteOne({echo $c->getId()})"><i class="icon-trash"></i></a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    {foreach $callbackStatuses as $s}
    <div class="row-fluid tab-pane  " id="callbacks_{echo $s->getId()}">
        <table class="table  table-bordered table-hover table-condensed t-l_a">
            <thead>
                <tr>
                    <th class="t-a_c span1">
                        <span class="frame_label">
                            <span class="niceCheck" style="background-position: -46px 0px; ">
                                <input type="checkbox">
                            </span>
                        </span>
                    </th>
                    <th >{lang('ID','admin')}</th>
                    <th >{lang('User name','admin')}</th>
                    <th >{lang('Telephone','admin')}</th>
                    <th >{lang('Theme','admin')}</th>
                    <th >{lang('Status','admin')}</th>
                    <th >{lang('Date','admin')}</th>
                    <!-- <th  >{lang('Manager','admin')}</th>  -->
                    <th>{lang('Delete', 'admin')}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $model as $c}
                {if $c->getStatusId() == $s->getId()}
                <tr data-status="{echo $c->getStatusId()}" id="callback_{echo $c->getId()}"
                    class="simple_tr">
                    <td class="t-a_c">
                        <span class="frame_label">
                            <span class="niceCheck"
                            style="background-position: -46px 0px; ">
                            <input type="checkbox" name="ids"
                            value="{echo $c->getId()}">
                        </span>
                    </span>
                </td>
                <td>{echo $c->getId()}</td>
                <td><a class="pjax" href="{$ADMIN_URL}callbacks/update/{echo $c->getId()}"
                 data-rel="tooltip"
                 data-title="{lang('Edit callback','admin')}">
                 {truncate(ShopCore::encode($c->getName()), 50)}
             </a>
         </td>
         <td>{echo encode($c->getPhone())}</td>
         <td>
            <select name="theme"
            onchange="callbacks.changeTheme({echo $c->getId()}, this.value)">
            <option value="0"
            selected="selected">{lang('Does not have','admin')}</option>
            {foreach $callbackThemes as $callbackTheme}
            <option value="{echo $callbackTheme->getId()}" {if $callbackTheme->getId() == $c->getThemeId()} selected="selected" {/if}>{echo $callbackTheme->getText()}</option>
            {/foreach}
        </select>
    </td>
    <td>
        <div>
            <select name="status"
            onchange="callbacks.changeStatus({echo $c->getId()}, this.value)">
            {foreach $callbackStatuses as $callbackStatus}
            <option value="{echo $callbackStatus->getId()}" {if $callbackStatus->getId() == $c->getStatusId()} selected="selected" {/if}>{echo $callbackStatus->getText()}</option>
            {/foreach}
        </select>
    </div>
</td>
<td>{echo date('Y-m-d H:i:s', $c->getDate())}</td>
<td>
    <a href="#" class="btn btn-small" onclick="callbacks.deleteOne({echo $c->getId()})"><i class="icon-trash"></i></a>
</td>
</tr>
{/if}
{/foreach}
</tbody>
</table>
</div>
{/foreach}
<div id="gopages" class="navigation">
    {$pagination}
</div>
<div style="padding:10px 10px 0 20px;">
    <div id="totalCallbacks">
        <b>{if ShopCore::$_GET.status != -1}{lang('All Callbacks ','admin')} :{else:}{lang('Found results','admin')}:{/if}</b> {$totalCallbacks}
    </div>
</div>
</div>
{else:}
<div class="alert alert-info" style="margin-bottom: 18px; margin-top: 18px;">
    {lang('Empty callback list.','admin')}
</div>
{/if}
</section>
</form>
</div>

<div class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Remove callback(s)','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('Really delete callback(s)','admin')}?</p>
    </div>
    <div class="modal-footer">
        <a href="#" onclick="callbacks.deleteMany();" class="btn btn-primary formSubmit"
        data-form="#deleteOrderStatus">{lang('Remove','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>