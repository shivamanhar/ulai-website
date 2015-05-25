<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Payment method create','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="{$ADMIN_URL}paymentmethods" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    <button type="button" class="btn btn-small btn-success formSubmit" data-form="#createPayment"><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                    <button type="button" class="btn btn-small formSubmit" data-form="#createPayment" data-action="exit"><i class="icon-check"></i>{lang('Create and exit','admin')}</button>
                </div>
            </div>                            
        </div>
        <table class="table  table-bordered table-hover table-condensed content_big_td m-t_10">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('Payment method create','admin')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd">
                            <div class="form-horizontal">
                                <form id="createPayment" id="createPayment" method="post" active="{$ADMIN_URL}paymentmethods/create">
                                    <div class="span9">
                                        <div class="control-group">
                                            <label class="control-label" for="Name">{lang('Title','admin')}:
                                                <span class="must">*</span>
                                            </label>
                                            <div class="controls">
                                                <input type="text" name="Name" value="" id="Name" required/>
                                            </div>
                                        </div>
                                        <input type="hidden" name="CurrencyId" value="{echo \Currency\Currency::create()->getMainCurrency()->getId()}">
                                        {/*}<div class="control-group">
                                            <label class="control-label" for="CurrencyId">{lang('Currency','admin')}:</label>
                                            <div class="controls">
                                                <select name="CurrencyId" style="width:280px;" id="CurrencyId">
                                                    {foreach $currencies as $c}
                                                        <option value="{echo $c->getId()}">
                                                            {echo ShopCore::encode($c->getName())} 
                                                            ({echo $c->getRate()}
                                                            {echo $c->getSymbol()} = 1 {$CS})
                                                        </option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                        { */}
                                        <div class="control-group">
                                            <div class="control-label"></div>
                                            <div class="controls">
                                                <span class="frame_label">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox" name="Active" checked="checked" value="1" id="inputActive"/>
                                                    </span>
                                                    {lang('Active','admin')}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="Description">{lang('Description','admin')}:</label>
                                        <div class="controls">
                                            <textarea name="Description" id="Description" value="" class="elRTE" id="inputDesc"></textarea>
                                        </div>
                                    </div>
                                    <div class="span9">
                                        <div class="control-group">
                                            <label class="control-label" for="inputRecCount">{lang('System','admin')} {lang('Payments','admin')}:</label>
                                            <div class="controls">
                                                <select name="PaymentSystemName">
                                                    <option value="0">{lang('No','admin')}</option>
                                                    {foreach ShopCore::app()->SPaymentSystems->getList() as $key=>$val}
                                                        <option value="{$key}" {if $model->getPaymentSystemName() == $key}selected="selected"{/if}>{echo encode($val.listName)}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                        <div id="paymentSystemConfigureBox" >
                                            {$paymentSystemForm}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>                               
    </section>
</div>













