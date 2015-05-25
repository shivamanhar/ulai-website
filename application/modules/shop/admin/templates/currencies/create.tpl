<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Currency create','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/currencies" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-success formSubmit" data-form="#cur_cr_form"><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#cur_cr_form" data-action="tomain"><i class="icon-check"></i>{lang('Create and go back','admin')}</button>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="modules">
            <form method="post" action="{$BASE_URL}admin/components/run/shop/currencies/create" class="form-horizontal" id="cur_cr_form">
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
                                        <label class="control-label">{lang('Title','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="Name" value="" required/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{lang('ISO','admin')} {lang('Code','admin')}: <span class="must">*</span></label>
                                        <div class="controls" style="width: 500px">
                                            <input type="text" name="Code" value="" required/>
                                            <p class="help-block">({lang('For example','admin')}: USD)</p>
                                            <p class="help-block">{lang('The list of possible code rates listed in the international standard','admin')} <a href='http://www.currency-iso.org/dam/downloads/table_a1.xml' target="_blank">ISO 4217</a></p>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" >{lang('Character','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="Symbol" value="" required/>
                                            <p class="help-block">({lang('For example','admin')}: $)</p>
                                        </div>
                                    </div>
                                    <div class="control-group" id="mod_name">
                                        <label class="control-label">{lang('Currency rate','admin')}: <span class="must">*</span></label>
                                        <div class="controls number">
                                            <input type="text" id="rate-currency" class="input-medium required" data-title="только цифры" data-placement="top" onkeyup="checkLenghtStr('rate-currency', 6, 8, event.keyCode);"  name="Rate" value="" required/>
                                            <p class="help-block">
                                                =
                                                1.000 {$CS}
                                            </p>
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
        <div class="tab-pane"></div>
    </div>
</section>