<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Editing discounts','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="/admin/components/run/shop/comulativ/index" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    <button type="button" class="btn btn-small btn-primary formSubmit" data-action="edit" data-form="#comulativUpdate" ><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                    <button type="button" class="btn btn-small action_on formSubmit" data-action="close" data-form="#comulativUpdate"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>                    
                </div>
            </div>                            
        </div>
        <div class="clearfix">
            <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
                <a href="#parameters" class="btn btn-small active">{lang('Discount options','admin')}</a>
                <a href="#user" class="btn btn-small">{lang('Member Discount','admin')}</a>
            </div>             
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="parameters">
                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {lang('Editing','admin')} {lang('Discounts','admin')}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $model as $mod}
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd span9">
                                        <div class="form-horizontal">
                                            <div class="row-fluid">
                                                <form id="comulativUpdate" method="post" active="{$ADMIN_URL}comulativ/edit/{$mod['id']}">

                                                    <div class="control-group">
                                                        <label class="control-label" for="discount">{lang('Discount','admin')}</label>
                                                        <div class="controls">
                                                            <input type="text" name="discount" id="discount" value="{echo encode($mod['discount'])}" />
                                                            <span class="help-block">{lang('Just like the number 10','admin')}</span>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="active">{lang('Active','admin')}:</label>
                                                        <div class="controls">
                                                            <input type="checkbox" name="active" id="active" value="1" {if $mod['active'] == 1}checked="checked"{/if}/>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="total">{lang('Discount','admin')} {lang('from','admin')}:</label>
                                                        <div class="controls">
                                                            <input type="text" name="total" id="total"  value="{$mod['total']}"/>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="total_a">{lang('Discount','admin')} {lang('to','admin')}:</label>
                                                        <div class="controls">
                                                            <input type="text" name="total_a" id="total_a"  value="{$mod['total_a']}" />

                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="description">{lang('Name','admin')} {lang('to','admin')}:</label>
                                                        <div class="controls">
                                                            <input type="text" name="description" id="description"  value="{$mod['description']}" />

                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table> 
            </div>
            <div class="tab-pane" id="user">
                {if count($rowDC) > 0}
                    <table class="table  table-bordered table-hover table-condensed t-l_a">
                        <thead>
                            <tr>                                    
                                <th class="span1">{lang('ID','admin')}</th>
                                <th>{lang('Full name','admin')}</th>
                                <th>{lang('E-mail','admin')}</th>
                                <th>{lang('Address','admin')}</th>
                                <th>{lang('Telephone','admin')}</th>
                                <th>{lang('Date','admin')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $rowDC as $c}
                                <tr >
                                    <td><p>{echo $c['id']}</p></td>
                                    <td><p>{echo $c['username']}</p></td>
                                    <td><p>{echo $c['email']}</p></td>
                                    <td><p>{echo $c['address']}</p></td>                                
                                    <td><p>{echo $c['phone']}</p></td>                                
                                    <td><p>{echo date('d-m-Y H:i:s',$c['created'])}</p></td>                              
                                </tr>
                            {/foreach}
                        </tbody>
                    </table> 
                </div>
            {/if}
        </div>
    </section>
</div>
