<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Creating cumulative discount','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="/admin/components/run/shop/comulativ/index" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-success formSubmit" data-form="#createComulativ" data-action="new" data-submit><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>                
                <button type="button" class="btn btn-small action_on formSubmit" data-form="#createComulativ" data-action="exit"><i class="icon-check"></i>{lang('Create and exit','admin')}</button>               
            </div>
        </div>                            
    </div>
    <table class="table  table-bordered table-hover table-condensed content_big_td">
        <thead>
            <tr>
                <th colspan="6">
                    {lang('These discounts','admin')}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="inside_padd span9">
                        <div class="form-horizontal">
                            <form id="createComulativ" method="post" active="{$ADMIN_URL}comulativ/create">
                                <div class="control-group">
                                    <label class="control-label" for="discount">{lang('Discount','admin')}:</label>
                                    <div class="controls number">
                                        <input type="text" name="discount" id="discount" value="" data-max="100" required/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="total">{lang('Discount','admin')} {lang('from','admin')}:</label>
                                    <div class="controls number">
                                        <input type="text" name="total" id="total" value="" required/>
                                        <span class="help-block">{lang('Amount of which will be a discount.','admin')}</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="total_a">{lang('Discount','admin')} {lang('to','admin')}:</label>
                                    <div class="controls number">
                                        <input type="text" name="total_a" id="total_a" value="" required/>
                                        <span class="help-block">{lang('The amount to which there will be a discount','admin')}</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="active">{lang('Active','admin')}:</label>
                                    <div class="controls">
                                        <select name="active" id="active">
                                            <option value="1">{lang('Active','admin')}</option>
                                            <option value="2">{lang('Not active','admin')}</option>
                                        </select>
                                    </div>
                                </div>
                        <div class="control-group">
                            <label class="control-label" for="description">{lang('Name','admin')}:</label>
                            <div class="controls">
                                <input type="text" name="description" id="description" value="" required/>
                            </div> 
                        </div>
                        </div>
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>                               
</section>
