<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Gift certificate settings','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/gifts/" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#gift_settings_form" data-action="edit"><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#gift_settings_form" data-action="exit"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>
            </div>
        </div>                            
    </div>
    <div class="tab-content">
        <div class="row-fluid">
            <form method="post" action="{$ADMIN_URL}gifts/save_settings" class="form-horizontal" id="gift_settings_form">
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
                                        <div class="control-group">
                                            <label class="control-label">{lang('Use gift certificates?','admin')}:</label>
                                            <div class="controls">
                                                <span class="frame_label">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox" name="gifton" value="1"{if ShopCore::app()->SSettings->__get('usegifts') == 1}checked="checked"{/if}/>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</section>