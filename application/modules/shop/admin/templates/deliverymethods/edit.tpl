<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Delivery method edit','admin')}: {echo ShopCore::encode($model->getName())}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="{$BASE_URL}admin/components/run/shop/deliverymethods/index" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#deliveryUpdate" data-action="close" data-submit><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                    <button type="button" class="btn btn-small action_on formSubmit" data-form="#deliveryUpdate" data-action="exit"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>
                        {echo create_language_select($languages, $locale, "/admin/components/run/shop/deliverymethods/edit/".$model->getId())}
                </div>
            </div>
        </div>
        <div class="tab-pane">
            <table class="table  table-bordered table-hover table-condensed content_big_td">
                <thead>
                    <tr>
                        <th colspan="6">
                            {lang('Delivery method edit','admin')}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">
                            <div class="inside_padd">
                                <div class="form-horizontal">
                                    <form id="deliveryUpdate" method="post" action="{$ADMIN_URL}deliverymethods/edit/{echo $model->getId()}/{echo $locale}">
                                        <div class="span9">
                                            <div class="control-group">
                                                <label class="control-label" for="Name">{lang('Title','admin')}:{$translatable}
                                                    <span class="must">*</span>
                                                </label>
                                                <div class="controls">
                                                    <input type="text" name="Name" id="Name" class="required" value="{echo ShopCore::encode($model->getName())}"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label"></div>
                                            <div class="controls">
                                                <span class="frame_label no_connection">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox" name="Enabled" value="1" {if $model->getEnabled() == true} checked="checked" {/if} />
                                                    </span>
                                                    {lang('Active','admin')}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="Description">{lang('Description','admin')}:{$translatable}</label>
                                            <div class="controls">
                                                <textarea  class="elRTE" name="Description" id="Description">{echo ShopCore::encode($descr) }</textarea>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="priceDescription">{lang('Description delivery price','admin')}:{$translatable}</label>
                                            <div class="controls">
                                                <textarea class="elRTE"  name="pricedescription" id="pricedescription">{echo ShopCore::encode($descrPrice)}</textarea>
                                            </div>
                                        </div>

                                        <div class="span9">
                                            <div id="deliveryPriceDisableBlock">
                                                <div class="control-group">
                                                    <label class="control-label" for="Price">{lang('Price','admin')}:</label>
                                                    <div class="controls number">
                                                        <span class="group_icon pull-right"><span class="help-block">{$CS}</span></span>
                                                        <div class="o_h">
                                                            <input type="text" 
                                                                   name="Price" 
                                                                   id="Price" 
                                                                   value="{echo preg_replace('/\.?0*$/','',number_format(ShopCore::encode($model->getPrice()), 5, ".", ""))}{if $model->getIsPriceInPercent() == true}%{/if}" 
                                                                   {if $model->getDeliverySumSpecified() == true} disabled="disabled"{/if} 
                                                                   onkeyup="checkLenghtStr('Price',11,5,event.keyCode);"
                                                                   />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="FreeFrom">{lang('Free','admin')} {lang('from','admin')}:</label>
                                                    <div class="controls number">
                                                        <span class="group_icon pull-right"><span class="help-block">{$CS}</span></span>
                                                        <div class="o_h">
                                                            <input type="text" 
                                                                   name="FreeFrom" 
                                                                   id="FreeFrom" 
                                                                   value="{echo preg_replace('/\.?0*$/','',number_format(ShopCore::encode($model->getFreeFrom()), 5, ".", ""))}" 
                                                                   {if $model->getDeliverySumSpecified() == true} disabled="disabled"{/if}
                                                                   onkeyup="checkLenghtStr('FreeFrom',11,5,event.keyCode);"
                                                                   />
                                                        </div>
                                                    </div>
                                                    <div class="controls">
                                                        <span class="frame_label no_connection">
                                                            <span class="niceCheck" id="deliverySumSpecifiedSpan">
                                                                <input id="deliverySumSpecifiedInput" 
                                                                       type="checkbox" 
                                                                       name="delivery_sum_specified" 
                                                                       value="1" 
                                                                       {if $model->getDeliverySumSpecified() == true} checked="checked"{/if}
                                                                       />
                                                            </span>
                                                            {lang('Price to be confirmed','admin')}
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="control-group" id="deliverySumSpecifiedMessageSpan"{if $model->getDeliverySumSpecified() != true} style="display: none;"{/if} > 
                                                <label class="control-label">{lang('Price to be confirmed message','admin')}:</label>
                                                <div class="controls">
                                                    <div class="o_h">
                                                        <input type="text" 
                                                               name="delivery_sum_specified_message" 
                                                               value="{echo ShopCore::encode($model->getDeliverySumSpecifiedMessage())}" required='required'/>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="control-group">
                                                <div class="control-label" for="inputRecCount">{lang('Payment method','admin')}:</div>
                                                <div class="controls">
                                                    {if sizeof($paymentMethods) > 0}
                                                        {foreach $paymentMethods as $pm}
                                                            <span class="frame_label no_connection d_b">
                                                                <span class="niceCheck b_n">
                                                                    <input type="checkbox"
                                                                           {if $model->getPaymentMethodss()->contains($pm)}
                                                                               checked="checked"
                                                                           {/if}
                                                                           name="paymentMethods[]" value="{echo $pm->getId()}"/>
                                                                </span>
                                                                {echo encode($pm->getName())}
                                                            </span>
                                                        {/foreach}
                                                    {else:}
                                                        {lang('List is empty','admin')}
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>
                                        {form_csrf()}
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane"></div>
    </section>
</div>