<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Integration with 1C settings ', 'exchange')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/modules_table" 
                   class="t-d_n m-r_15 pjax">
                    <span class="f-s_14">←</span> 
                    <span class="t-d_u">{lang('Back', 'exchange')}</span>
                </a>
                <a  href="/admin/components/cp/exchange/setAdditionalCats"
                    class="btn btn-small btn-primary pjax" 
                    <i class="icon-ok"></i>{lang('Fix', 'exchange')}
                </a>
                <button type="button" 
                        class="btn btn-small btn-primary action_on formSubmit" 
                        data-form="#exchange_settings_form" 
                        data-action="tomain">
                    <i class="icon-ok"></i>{lang('Save', 'exchange')}
                </button>
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    {lang('Logs', 'exchange')}
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="{$SELF_URL}/error_log">?</a>
                    </li>
                </ul>
            </div>
        </div>                            
    </div>
    <form method="post" action="{site_url('admin/components/cp/exchange/update_settings')}" class="form-horizontal m-t_10" id="exchange_settings_form">
        <table class="table  table-bordered table-hover table-condensed content_big_td">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('Integration with 1C settings ', 'exchange')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd">
                            <div class="control-group">
                                <label class="control-label" for="zip">{lang('Use commpres', 'exchange')}:</label>
                                <div class="controls">
                                    <select name = "1CSettings[zip]" id="zip">
                                        <option value = "yes" {if $settings['zip']=='yes'}selected="selected"{/if} {if !class_exists('ZipArchive')}disabled{/if}>{lang('Yes', 'exchange')}</option>
                                        <option value = "no" {if $settings['zip']=='no'}selected="selected"{/if}>{lang('No', 'exchange')}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="size">{lang('Size', 'exchange')}:</label>
                                <div class="controls">
                                    <input type = "text" name = "1CSettings[filesize]" value = "{$settings['filesize']}" id="size"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="address">{lang('1C Ip addres ', 'exchange')}:</label>
                                <div class="controls">
                                    <input type = "text" name = "1CSettings[validIP]" value = "{$settings['validIP']}" id="address"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="usepass">{lang('Use server password', 'exchange')}:</label>
                                <div class="controls">
                                    <span class="frame_label no_connection">
                                        <span class="niceCheck b_n">
                                            <input type = "checkbox" name = "1CSettings[usepassword]" {if $settings['usepassword']}checked="checked"{/if} id="usepass"/>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="login">{lang('Set up a login to access the server 1C', 'exchange')}:</label>
                                <div class="controls">
                                    <input type = "text" name = "1CSettings[login]" class="textbox_short" value="{$settings['login']}" id="login"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="pass">{lang('Server password', 'exchange')}:</label>
                                <div class="controls">
                                    <input type = "password" name = "1CSettings[password]" class="textbox_short" value="{$settings['password']}" id="pass"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="back">{lang('Database backup', 'exchange')}:</label>
                                <div class="controls">
                                    <span class="frame_label no_connection">
                                        <span class="niceCheck b_n">
                                            <input value="1" type = "checkbox" name = "1CSettings[backup]" {if $settings['backup']}checked="checked"{/if} id="back"/>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="status">{lang('Select order status', 'exchange')}:</label>
                                <div class="controls">
                                    <select name="1CSettings[statuses][]" multiple="multiple" id="status">
                                        {foreach $statuses as $status}
                                            <option value="{$status['id']}" {if is_array($settings['userstatuses']) AND in_array($status['id'], $settings['userstatuses'])}selected="selected"{/if}>
                                                {echo $status['name']}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>   
                            <div class="control-group">
                                <label class="control-label" for="brand">{lang('Property, which will be mean like brand', 'exchange')}:</label>
                                <div class="controls">
                                    <input type = "text" name = "1CSettings[brand]" value = "{$settings['brand']}" id="brand"/>
                                </div>
                            </div>   
                            <div class="control-group">
                                <label class="control-label" for="status_after">{lang('Order status after export', 'exchange')}:</label>
                                <div class="controls">
                                    <select name="1CSettings[userstatuses_after]" id="status_after">
                                        {foreach $statuses as $status}
                                            <option value="{$status['id']}" {if $settings['userstatuses_after'] == $status['id']}selected="selected"{/if}>
                                                {echo $status['name']}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>  
                            <div class="control-group">
                                <label class="control-label" for="autores">{lang('Run automatically resize images?', 'exchange')}</label>
                                <div class="controls">
                                    <span class="frame_label no_connection">
                                        <span class="niceCheck b_n">
                                            <input type = "checkbox" name = "1CSettings[autoresize]" id="autores" {if $settings['autoresize'] == 'on'}checked="checked"{/if}/>
                                        </span>
                                    </span>
                                </div>
                            </div><!--
                            <div class="control-group">
                                <label class="control-label">Ручной запуск ресайза</label>
                                <div class="controls">
                                    <a class="btn runResize"><i class="icon-play"></i>&nbsp;Запустить</a>
                                </div>
                            </div>-->

                            <div class="control-group">
                                <span class="control-label">
                                    <span data-title="&lt;b&gt;Debug&lt;/b&gt;" class="popover_ref" data-original-title="">
                                        <i class="icon-info-sign"></i>
                                    </span>
                                    <div class="d_n">{lang('All errors will be written to the file', 'exchange')} error_log.txt</div>&nbsp;{lang('Debugging mode', 'exchange')}
                                </span>
                                <div class="controls">
                                    <span class="frame_label no_connection">
                                        <span class="niceCheck b_n">
                                            <input type = "checkbox" name = "1CSettings[debug]" id="debug" {if $settings['debug'] == 'on'}checked="checked"{/if}/>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="control-group">
                                <span class="control-label">
                                    <span data-title="&lt;b&gt;Debug&lt;/b&gt;" class="popover_ref" data-original-title="">
                                        <i class="icon-info-sign"></i>
                                    </span>
                                    <div class="d_n">{lang('If you specify an email errors when incorrect password', 'exchange')}<br>
                                        {lang('and security  will be sent to administrator', 'exchange')}</div>&nbsp;
                                        {lang('Email Administrator for sending important safety mistakes', 'exchange')}
                                </span>
                                <div class="controls">
                                    <input type = "text" name = "1CSettings[email]" id="email" />
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</section>