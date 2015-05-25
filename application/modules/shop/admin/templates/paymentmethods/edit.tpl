<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Payment method editing','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$ADMIN_URL}paymentmethods" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#paymentmethodsUpdate" data-action="edit" data-submit><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#paymentmethodsUpdate" data-action="exit"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>
                    {echo create_language_select($languages, $locale, "/admin/components/run/shop/paymentmethods/edit/".$model->getId())}
            </div>
        </div>
    </div>
    <table class="table  table-bordered table-hover table-condensed content_big_td m-t_10">
        <thead>
            <tr>
                <th colspan="6">
                    {lang('Payment method editing','admin')}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="inside_padd">
                        <div class="form-horizontal">
                            <form id="paymentmethodsUpdate" id="paymentmethodsUpdate" method="post" active="{$ADMIN_URL}paymentmethods/edit/{$model->getId()}/{$locale}">
                                <div class="span9">
                                    <div class="control-group">
                                        <label class="control-label" for="inputRecCount">{lang('Title','admin')}:{$translatable}
                                            <span class="must">*</span>
                                        </label>
                                        <div class="controls">
                                            <input type="text" name="Name" value="{echo ShopCore::encode($model->getName())}" required/>
                                        </div>
                                    </div>
                                        <input type="hidden" name="CurrencyId" value="{echo \Currency\Currency::create()->getMainCurrency()->getId()}">
                                    {/*}<div class="control-group">
                                        <label class="control-label" for="inputRecCount">{lang('Currency','admin')}:</label>
                                        <div class="controls">
                                            <select name="CurrencyId" style="width:280px;">
                                                {foreach $currencies as $c}
                                                    <option value="{echo $c->getId()}" {if $c->getId() == $model->getCurrencyId()}selected="selected"{/if}>
                                                        {echo ShopCore::encode($c->getName())}
                                                        ({echo $c->getRate()}
                                                        {echo $c->getSymbol()} = 1 {$CS})
                                                    </option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>{ */}

                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" value="1" name="Active" {if $model->getActive() == true} checked="checked" {/if} />
                                                </span>
                                                {lang('Active','admin')}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputRecCount">{lang('Description','admin')}:{$translatable}</label>
                                    <div class="controls">
                                        <textarea name="Description" value="" class="elRTE">{echo ShopCore::encode($model->getDescription())}</textarea>
                                    </div>
                                </div>
                                <div class="span9">
                                    <div class="control-group">
                                        <label class="control-label" for="inputRecCount">{lang('System','admin')} {lang('Payments','admin')}:</label>
                                        <div class="controls">
                                            <select name="PaymentSystemName" onchange="loadPaymentSystemConfigForm(this.value, {echo $model->getId()}, '{echo $lang}');">
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
                        </div>
                    </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</section>

<script type="text/javascript">


    shop_url = "{$ADMIN_URL}";

    {literal}
        function loadPaymentSystemConfigForm(val, modelId, loc1)
        {
           // $('#paymentSystemConfigureBox').load(shop_url + 'paymentmethods/getAdminForm/' + val + '/' + modelId);
           if(val != 0){
               $('#paymentSystemConfigureBox').load('/'+loc1+'/'+val+'/getAdminForm/'+modelId+'/'+val);
           }else{
               $('#paymentSystemConfigureBox').html('');
           }
        }
    </script>
{/literal}