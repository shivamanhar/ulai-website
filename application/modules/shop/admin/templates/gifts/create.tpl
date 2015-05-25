<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Gift certificate create','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/gifts" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-success formSubmit" data-form="#gift_cr_form" data-action="new" data-submit><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                <button type="button" class="btn btn-small  formSubmit" data-form="#gift_cr_form" data-action="exit"><i class="icon-check"></i>{lang('Create and exit','admin')}</button>
            </div>
        </div>
    </div>
    <form method="post" action="{$ADMIN_URL}gifts/create" class="form-horizontal" id="gift_cr_form">
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
                                <label class="control-label" for="dd">{lang('Gift certificate price','admin')}:</label>
                                <div class="controls number">
                                    <input type="text" name="price" value="" id="dd" required/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="generateButton">{lang('Key','admin')}:</label>
                                <div class="controls">
                                    <button type="button" class="btn btn-small pull-right" id="generateButton" name="generate_button"><i class="icon-random"></i>{lang('Generate','admin')}</button>
                                    <div class="o_h">
                                        <input id="keyholder" type="text" name="key" value="" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="created">{lang('Active until','admin')}:</label>
                                <div class="controls">
                                    <input id="created" class="datepicker" type="text" value="" name="espir" required/>
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