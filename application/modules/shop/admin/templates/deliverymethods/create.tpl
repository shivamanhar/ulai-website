<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Delivery method create','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="{$BASE_URL}admin/components/run/shop/deliverymethods/index" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    <button type="button" class="btn btn-small btn-success formSubmit" data-form="#createDelivery"><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                    <button type="button" class="btn btn-small action_on formSubmit" data-form="#createDelivery" data-action="close"><i class="icon-check"></i>{lang('Create and exit','admin')}</button>
                </div>
            </div>                            
        </div>
        <div class="tab-pane">
            <table class="table  table-bordered table-hover table-condensed content_big_td ">
                <thead>
                    <tr>
                        <th colspan="6">
                            {lang('Delivery method create','admin')}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">
                            <div class="inside_padd">
                                <div class="form-horizontal">
                                    <div class="row-fluid">
                                        <form id="createDelivery" method="post" active="{$ADMIN_URL}deliverymethods/create">

                                            <div class="control-group">
                                                <label class="control-label" for="Name">{lang('Title','admin')}:
                                                    <span class="must">*</span>
                                                </label>
                                                <div class="controls">
                                                    <input type="text" name="Name" id="Name" value="" required/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="control-label"></div>
                                                <div class="controls">
                                                    <span class="frame_label no_connection">
                                                        <span class="niceCheck">
                                                            <input type="checkbox" name="Enabled" value="1" />
                                                        </span>
                                                        {lang('Active','admin')}
                                                    </span>
                                                </div>
                                            </div>


                                            <div class="control-group">
                                                <label class="control-label" for="Description">{lang('Description','admin')}:</label>
                                                <div class="controls">
                                                    <textarea  name="Description" id="Description" class="elRTE"></textarea>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="priceDescription">{lang('Description delivery price','admin')}:</label>
                                                <div class="controls">
                                                    <textarea  name="pricedescription" id="priceDescription" class="elRTE"></textarea>
                                                </div>
                                            </div>

                                            <div id="deliveryPriceDisableBlock">
                                                <div class="control-group">
                                                    <label class="control-label" for="Price">{lang('Delivery price','admin')}:</label>
                                                    <div class="controls number">
                                                        <div class="pull-right group_icon">
                                                            <span class="help-block">{$CS}</span>
                                                        </div>
                                                        <div class="o_h">
                                                            <input type="text" name="Price" id="Price" value="" onkeyup="checkLenghtStr('Price',11,5,event.keyCode);"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="FreeFrom">{lang('Free','admin')} {lang('from','admin')}:</label>
                                                    <div class="controls number">
                                                        <div class="pull-right group_icon">
                                                            <span class="help-block">{$CS}</span>
                                                        </div>
                                                        <div class="o_h">
                                                            <input type="text" name="FreeFrom" id="FreeFrom" value="" onkeyup="checkLenghtStr('FreeFrom',11,5,event.keyCode);"/> 
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
                                    <!--</div>-->
                                                    
                                        <div class="control-group" id="deliverySumSpecifiedMessageSpan"{if $model->getDeliverySumSpecified() != true} style="display: none;"{/if} > 
                                            <label class="control-label">{lang('Price to be confirmed message','admin')}:</label>
                                            <div class="controls">
                                                <div class="o_h">
                                                    <input type="text" 
                                                           name="delivery_sum_specified_message" 
                                                           value="{echo ShopCore::encode($model->getDeliverySumSpecifiedMessage())}" 
                                                           required
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        <div class="control-label" for="inputRecCount">{lang('Payment method','admin')}:</div>
                                        <div class="controls">
                                            {if sizeof($paymentMethods) > 0}
                                                {foreach $paymentMethods as $pm}
                                                    <div>
                                                        <button type="button" class="focus frame_label no_connection">
                                                            <span class="niceCheck">
                                                                <input type="checkbox"
                                                                       {if $model->getPaymentMethodss()->contains($pm)}
                                                                           checked="checked"
                                                                       {/if}
                                                                       name="paymentMethods[]" value="{echo $pm->getId()}">
                                                            </span>
                                                            {echo encode($pm->getName())}
                                                        </button>
                                                    </div>
                                                {/foreach}
                                            {else:}
                                                {lang('List is empty.','admin')}
                                            {/if}
                                        </div>
                                    </div>
                                {form_csrf()}
                                </form>
                            </div>
                        </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>                               

        <div class="tab-pane">

        </div>
    </div>
</div>
</section>
</div>
