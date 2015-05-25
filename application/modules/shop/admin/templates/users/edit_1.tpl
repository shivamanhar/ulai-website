<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('User editing','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="/admin/components/run/shop/users/index" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small action_on formSubmit btn-primary" data-form="#editUsers" data-action="close" data-submit><i class="icon-ok"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-form="#editUsers" data-action="exit"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>
            </div>
        </div>
    </div>
    <form id="editUsers" action="{$ADMIN_URL}users/edit/{echo $model->getId()}" method="post">
        <table class="table  table-bordered table-hover table-condensed content_big_td">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('User data','admin')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd span9">
                            <div class="clearfix">
                                <dl class="dl-horizontal">
                                    <dt>{lang('ID','admin')}:</dt>
                                    <dd>{echo $model->getId()}</dd>
                                    <dt>{lang('Time of registration','admin')}:</dt>
                                    <dd>{echo date('d/m/Y, H:i',$model->getDateCreated())}</dd>
                                    <dt>{lang('Purchase price','admin')}:</dt>
                                    <dd>{echo $model->getAmout()} {$CS}</dd>
                                </dl>
                            </div>
                            <div class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label" for="Name">{lang('Full name','admin')}:</label>
                                    <div class="controls">
                                        <input type="text" name="Name" id="Name" value="{echo ShopCore::encode($model->getFullName())}" required/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="Phone">{lang('Telephone','admin')}:</label>
                                    <div class="controls">
                                        <input type="text" name="Phone" id="Phone" value="{echo ShopCore::encode($model->getPhone())}" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="Address">{lang('Address','admin')}:</label>
                                    <div class="controls">
                                        <input type="text" name="Address" id="Address" value="{echo ShopCore::encode($model->getAddress())}" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="UserEmail">{lang('E-mail','admin')}:</label>
                                    <div class="controls">
                                        <input type="text" name="UserEmail" id="UserEmail" value="{echo ShopCore::encode($model->getUserEmail())}" class="email required"/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="new_pass">{lang('New password','admin')}:</label>
                                    <div class="controls">
                                        <input type="password" name="new_pass" id="new_pass"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="new_pass_conf">{lang('Password confirm','admin')}:</label>
                                    <div class="controls">
                                        <input type="password" name="new_pass_conf" id="new_pass_conf" />
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label" for="RoleId">{lang('Role','admin')}:</label>
                                    <div class="controls">
                                        <select name="RoleId" id="RoleId">
                                            <option value="-">-</option>
                                            {foreach $roles as $role}
                                                <option {if $role->id == $model->getRoleId()} selected="selected" {/if} value="{echo $role->id}">{echo ShopCore::encode($role->alt_name)}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        {$addField = ShopCore::app()->CustomFieldsHelper->getCustomFields('user', $model->getId())->asAdminHtml()}

        {if !empty($addField)}
            <table class="table  table-bordered table-hover table-condensed content_big_td">
                <thead>
                    <tr>
                        <th colspan="6">
                            {lang('Additional data','admin')}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">
                            <div class="inside_padd span9">
                                <div class="form-horizontal">
                                    {$addField}
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="elFinder"> </div>
        {/if}
    </form>
    <div class="frame_table row-fluid">

        {if count($newData)}
            <table class="table  table-bordered table-hover table-condensed t-l_a">
                <thead>
                    <tr>
                        <th>{lang('Content','admin')} {lang('WishList','admin')} </th>
                        <th>{lang('Price','admin')}</th>
                    </tr>
                </thead>
                <tbody>
                    {$total = 0}
                    {foreach $newData as $key=>$item}
                        <tr>{$total += ShopCore::app()->SCurrencyHelper->convert($item.price)}
                            {$productUrl = '/shop/product/'.$item.model->getId()}
                            <td><a href="{$productUrl}">{echo ShopCore::encode($item.model->getName())}  {echo ShopCore::encode($item.variantName)}</a></td>
                            <td>{echo ShopCore::app()->SCurrencyHelper->convert($item.price)} {$CS}</td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {/if}
    </div>

    {if count($ordersModel)}
        <div class="frame_table m-t_t row-fluid">
            <table class="table  table-bordered table-hover table-condensed t-l_a">
                <thead>
                    <tr>
                        <th>{lang('Status','admin')}</th>
                        <th>{lang('Time of the order','admin')}</th>
                        <th># {lang('Orders','admin')}</th>
                        <th>{lang('Cart','admin')}</th>
                        <th>{lang('Total price','admin')}</th>
                        <th>{lang('Payment status','admin')}</th>
                    </tr>
                </thead>
                <tbody>
                    {$counter = 0}
                    {foreach $ordersModel as $o}
                        <tr>
                            <td>
                                {foreach $orderStatuses as $orderStatus}
                                    {if $orderStatus->getId() == $o->getStatus()}
                                        <span class="badge" style="background-color: {echo $orderStatus->getColor()}; color: {echo $orderStatus->getFontcolor()};"></span>
                                        {echo $orderStatus->getName()}
                                    {/if}
                                {/foreach}
                            </td>
                            <td>
                                {date("d/m/Y, H:i", $o->getDateCreated())}
                            </td>
                            <td>
                                <a data-rel="tooltip" data-title="{lang("Edit order", 'admin')}" href="{$ADMIN_URL}orders/edit/{echo $o->getId()}">{lang('Order','admin')} #{echo $o->getId()}</a>
                            </td>
                            <td>
                                <div class="buy_prod" data-title="{lang('Purchased Product','admin')}">
                                    {$quantity = 0}
                                    {foreach $o->getSOrderProductss() as $p}
                                        {$quantity += $p->getQuantity()}
                                    {/foreach}
                                    <span>{echo $quantity}</span>
                                    <i class="icon-info-sign"></i>
                                </div>
                                <div class="d_n">
                                    {foreach $o->getSOrderProductss() as $p}
                                        {$productUrl = '#'}
                                        {$productModel = $p->getSProducts()}
                                        {if $productModel}
                                            {$productUrl = '/shop/product/'.$productModel->getUrl()}
                                            <div class="check_product">
                                                <a href="{$productUrl}" target="_blank">
                                                    {echo $p->getProductName()} {echo $p->getVariantName()}
                                                </a>
                                                {echo $p->getQuantity()} {lang('Pcs','admin')}. × {echo $p->getPrice(true)} {$CS}
                                            </div>
                                        {else:}
                                            {echo $p->getProductName()}
                                        {/if}
                                    {/foreach}
                                </div>
                            </td>
                            <td>{echo $o->getTotalPrice()}</td>
                            <td>
                                {if $o->getPaid() == 1}
                                    <span class="label label-success"> {lang('Paid','admin')} </span>
                                {else:}
                                    <span class="label"> {lang('Unpaid','admin')} </span>
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {/if}
</section>