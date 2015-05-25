<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Notification editing','admin')}</span>  
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="/admin/components/run/shop/notifications" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                    <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#editNot" data-action="edit" data-submit><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                    <button type="button" class="btn btn-small action_on formSubmit" data-action="close" data-form="#editNot"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>

                </div>
            </div>                            
        </div>
        <form action="{$ADMIN_URL}notifications/edit/{echo $model->getId()}" id="editNot" method="post" >
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
                                <div class="span9">
                                    <dl class="dl-horizontal">
                                        <dt>{lang('ID','admin')}:</dt>
                                        <dd>{echo $model->getId()}</dd>
                                        <dt>{lang('Status','admin')}:</dt>
                                        <dd>
                                            <select name="Status">
                                                {foreach $notificationStatuses as $notificationStatus}
                                                    <option value="{echo $notificationStatus->getId()}" {if $notificationStatus->getId() == $model->getStatus()}selected="selected"{/if}>
                                                        {echo $notificationStatus->getName()}
                                                    </option>
                                                {/foreach}
                                            </select>
                                        </dd>

                                        <dt>{lang('Date of creation','admin')}:</dt>
                                        <dd>{date("Y-m-d H:i:s", $model->getDateCreated())}</dd>
                                        <dt>{lang('Date active to','admin')}:</dt>
                                        <dd><input type="text"  class="datepicker" id="end_date" name="ActiveTo" value="{if $model->getActiveTo()}{encode(date("Y-m-d", $model->getActiveTo()))}{/if}"/></dd>
                                        <dt>{lang('Status has been set','admin')}:</dt>
                                        <dd>{echo ShopCore::encode($managerName)}</dd>
                                        <dt>{lang('Inform','admin')}:</dt>
                                        <dd>
                                            {if $model->getNotifiedByEmail() == true}
                                                <img src="/application/modules/shop/admin/templates/assets/images/mail_sent.png" 
                                                     class="proccessNotificationButton" 
                                                     title="{lang('Notify a buyer about the status change','admin')}"/>
                                            {else:}
                                                <img src="/application/modules/shop/admin/templates/assets/images/mail_send.png" 
                                                     class="proccessNotificationButton" 
                                                     onclick="change_status('{$ADMIN_URL}notifications/notifyByEmail/{echo $model->getId()}')" 
                                                     title="{lang('E-mail notification','admin')}"/>
                                            {/if}
                                        </dd>
                                    </dl>

                                    <div class="form-horizontal">

                                        <div class="control-group">
                                            <label class="control-label" for="inputFio">{lang('User name','admin')}:</label>
                                            <div class="controls">
                                                <input type="text" value="{echo ShopCore::encode($model->getUserName())}" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPhone">{lang('E-mail','admin')}:</label>
                                            <div class="controls">
                                                <input type="text" value="{echo ShopCore::encode($model->getUserEmail())}" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail">{lang('Telephone','admin')}:</label>
                                            <div class="controls">
                                                <input type="text" name="UserPhone" value="{echo ShopCore::encode($model->getUserPhone())}" />

                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputAddress">{lang('Comment','admin')}:</label>
                                            <div class="controls">
                                                <textarea name="UserComment">{echo ShopCore::encode($model->getUserComment())}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div class="frame_table row-fluid">                        
            {if $product}
                <table class="table  table-bordered table-hover table-condensed t-l_a">
                    <thead>
                        <tr>
                            <th>{lang('Image','admin')}</th>
                            <th>{lang('Product','admin')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="{$ADMIN_URL}products/edit/{echo $product->getId()}">
                                    <img width="60px" height="60px"  src="{echo $variant->getSmallPhoto()}" title="{lang('Notified email','admin')}"/>
                                </a>
                            </td>
                            <td><a href="{$ADMIN_URL}products/edit/{echo $product->getId()}" data-rel="tooltip" data-placement="top" data-original-title="{lang('Edit product','admin')}">{echo ShopCore::encode($product->getName())} {echo ShopCore::encode($variant->getName())}</a></td>
                        </tr>
                    </tbody>
                </table>
            {/if}
        </div>
    </section>

</div>