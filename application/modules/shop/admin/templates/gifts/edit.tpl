<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Gift certificate edit','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/gifts" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#gift_ed_form" data-action="edit" data-submit><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#gift_ed_form" data-action="tomain"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>
            </div>
        </div>
    </div>
    <form method="post" action="{$ADMIN_URL}gifts/edit/{echo $model->getId()}" class="form-horizontal" id="gift_ed_form">
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
                                <label class="control-label">{lang('Gift certificate price','admin')}:</label>
                                <div class="controls">
                                    <input type="text" name="price" value="{echo $model->getPrice()}" required/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">{lang('Key','admin')}:</label>
                                <div class="controls">
                                    <input id="keyholder" type="text" name="key" value="{echo $model->getKey()}" disabled="disabled" required/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">{lang('Active until','admin')}:</label>
                                <div class="controls">
                                    <input id="created" class="datepicker" type="text" value="{echo date('Y-m-d', $model->getEspDate())}" name="espir" required/>
                                </div>
                            </div>        
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        {form_csrf()}
    </form>
</section>