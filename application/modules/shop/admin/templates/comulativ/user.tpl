<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Editing by discounts','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="/admin/components/run/shop/comulativ/allusers" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    <button type="button" class="btn btn-small btn-primary formSubmit" data-action="edit" data-form="#comUserUpdate" ><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                    <button type="button" class="btn btn-small action_on formSubmit" data-action="close" data-form="#comUserUpdate"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>                    
                </div>
            </div>                            
        </div>
        <div class="tab-pane">
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
                                    <div class="row-fluid">
                                        {foreach $user as $u}
                                            <form id="comUserUpdate" method="post" active="{$ADMIN_URL}comulativ/user/{$u['user_id']}">
                                                <div class="control-group">
                                                    <label class="control-label" for="inputRecCount">{lang('Full name','admin')}</label>
                                                    <div class="controls">
                                                        <input type="text" readonly="readonly" disabled="disabled"  value="{echo encode($u['name'])}" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="inputRecCount">{lang('E-mail','admin')}:</label>
                                                    <div class="controls">
                                                        <input type="text" readonly="readonly" disabled="disabled"  value="{$u['user_email']}"/> 
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="inputRecCount">{lang('Purchase price','admin')}:</label>
                                                    <div class="controls">
                                                        <input type="text" readonly="readonly" disabled="disabled"  value="{$u['amout']}"/>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="discount">{lang('Discount','admin')}:</label>
                                                    <div class="controls">
                                                        <input type="text" name="discount"  id="discount" value="{$u['discount']}"/>
                                                        <span class="help-block">{lang('Off manually entered','admin')} </span>
                                                    </div>
                                                </div>
                                            {/foreach}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>                               

        </div>
</div>
</section>
