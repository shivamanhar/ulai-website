<div class="container">
    <section class="mini-layout without-frame_title">
        <div class="btn-group myTab" data-toggle="buttons-radio">
            <a href="#new_order" class="btn btn-small active">{lang('New orders','admin')}</a>
            {if count($bestSellers)>0}
                <a href="#bestseller" class="btn btn-small">{lang('Bestsellers','admin')}</a>
            {/if}
            {if $newUsers}
                <a href="#last_users" class="btn btn-small">{lang('New users','admin')}</a>
            {/if}
            {if $moduleAdditions}
                <a href="#modules_additions" class="btn btn-small">{lang('Modules additions', 'admin')}</a>
            {/if}
        </div>
        <section class="tab-content">

            <div class="tab-pane active" id="new_order">
                {if count($model)>0}
                    <table class="table  table-bordered table-hover table-condensed t-l_a">
                        <thead>
                            <tr>
                                <th >ID</th>
                                <th>{lang('Status','admin')}</th>
                                <th>{lang('Date','admin')}</th>
                                <th>{lang('Customer','admin')}</th>
                                <th>{lang('Products','admin')}</th>
                                <th>{lang('Amount','admin')}</th>
                                <th>{lang('Delivery price','admin')}</th>
                                <th>{lang('Payment status','admin')}</th>
                            </tr>
                        </thead>
                        <tbody>

                            {foreach $model as $o}
                                <tr>
                                    <td><a href="{$ADMIN_URL}orders/edit/{echo $o->getId()}" data-title="{lang('Edit order','admin')}" data-rel="tooltip">{echo $o->getId()} </a></td>
                                    <td><span class="badge">
                                            {foreach $orderStatuses as $orderStatus}
                                                {if $orderStatus->getId() == $o->getStatus()}
                                                    {echo $orderStatus->getName()}
                                                {/if}
                                            {/foreach}
                                        </span>
                                    </td>
                                    <td>{date("d-m-Y, H:i:s", $o->getDateCreated())}</td>
                                    <td>
                                        <span>
                                            {if $o->getUserId()}
                                                {echo ShopCore::encode($o->getUserFullName())}
                                            {else:} 
                                                {echo ShopCore::encode($o->getUserFullName())} 
                                            {/if}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="buy_prod" data-title="{lang('Purchased Product','admin')}" data-original-title="">
                                            <span>{echo count($o->getSOrderProductss())}</span>
                                            <i class="icon-info-sign"></i>
                                        </div>

                                        <div class="d_n">
                                            {if count($o->getSOrderProductss())>0}
                                                {foreach $o->getSOrderProductss() as $p}
                                                    <div class="check_product">
                                                        {$productUrl = '#'}
                                                        {$productModel = $p->getSProducts()}
                                                        {if $productModel}
                                                            {$productUrl = '/shop/product/'.$productModel->getUrl()}
                                                            <a target="_blank" href="{$productUrl}">{echo $p->getProductName()}</a>
                                                        {else:}
                                                            {echo $p->getProductName()}
                                                        {/if}
                                                        {echo $p->getVariantName()}
                                                        {echo $p->getQuantity()} {lang('pcs','admin')}. × {echo $p->getPrice(true)} {$CS}
                                                    </div>
                                                {/foreach}
                                            {/if}
                                    </td>
                                    <td>						
                                        {$total = 0}
                                        {if count($o->getSOrderProductss())>0}
                                            {foreach $o->getSOrderProductss() as $p}
                                                {$total = $total + $p->getQuantity() *  $p->getPrice()}
                                            {/foreach}
                                        {/if}
                                        {$total} {$CS}
                                    </td>
                                    <td>{echo $o->getDeliveryPrice()}</td>
                                    <td>
                                        {if $o->getPaid() == true}
                                            <span class="label label-success">{lang('Paid','admin')}</span>
                                        {else:}
                                            <span class="label">{lang('Unpaid','admin')}</span>
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}

                        </tbody>
                    </table>
                {else:}
                    </br>
                    <div class="alert alert-info">
                        {lang("No orders", 'admin')}
                    </div>
                {/if}
            </div>

            <div class="tab-pane" id="bestseller">
                <table class="table  table-bordered table-hover table-condensed t-l_a">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{lang('Product','admin')}</th>
                            <th>{lang('Price','admin')}</th>
                            <th>{lang('Amount of additions to Cart','admin')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {if count($bestSellers)>0}
                            {foreach $bestSellers as $bestSeller}
                                <tr>
                                    <td>{echo $bestSeller->getId()}</td>
                                    <td><a href="{site_url("/shop/product") . '/' . $bestSeller->getUrl()}" target="_blank">{echo $bestSeller->getName()}</a></td>
                                    <td>{echo $bestSeller->getFirstVariant()->getPrice()} {$CS}</td>
                                    <td>{echo $bestSeller->getAddedToCartCount()}</td>
                                </tr>
                            {/foreach}
                        {/if}
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="last_users">
                <table class="table  table-bordered table-hover table-condensed t-l_a">
                    <thead>
                        <tr>
                            <th class="span1">ID</th>
                            <th>{lang('User','admin')}</th>
                            <th>{lang('Date of registration','admin')}</th>
                            <th>{lang('Purchase price','admin')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $newUsers as $newUser}
                            <tr>
                                <td>{echo $newUser->getId()}</td>
                                <td><a href="{$ADMIN_URL}users/edit/{echo $newUser->getId()}" data-title="{lang('Edit user','admin')}" data-rel="tooltip">{echo $newUser->getFullName()}</a></td>
                                <td>{echo date('Y-m-d, H:i:s', $newUser->getDateCreated())}</td>
                                <td>{echo $amountPurchases[$newUser->getId()]} {$CS}</td>
                            </tr>
                        {/foreach}    
                    </tbody>
                </table>
            </div>
            {include_tpl('../modules_additions')}
        </section>
        <!--
        <div class="btn-group myTab" data-toggle="buttons-radio">
            <a href="#last_comments" class="btn btn-small">Последние комментарии</a>
        </div>
        
        <section class="tab-content">
        
            <div class="tab-pane" id="last_comments">
        -->
        {if $lastCommentsArray}
            <h4>{lang('Last comments','admin')}</h4>
            <table class="table  table-bordered table-hover table-condensed t-l_a">
                <thead>
                    <tr>
                        <th class="span1">ID</th>
                        <th class="span2">{lang('Status','admin')}</th>
                        <th>{lang('Text','admin')}</th>
                        <th class="span2">{lang('Date Created','admin')}</th>
                        <th class="span2">{lang('User','admin')}</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $lastCommentsArray as $comment}
                        <tr>
                            <td><a href="/admin/components/cp/comments/edit/{echo $comment.id}" data-title="{lang('Edit comment','admin')}" data-rel="tooltip" class="pjax">{$comment.id}</a></td>
                            <td>
                                {if 0 == $comment.status}
                                    <span class="label label-success">{lang('Approved','admin')}</span>
                                {/if}
                                {if 1 == $comment.status}
                                    <span class="label label-warning">{lang('Waiting for approval','admin')}</span>
                                {/if}
                                {if 2 == $comment.status}
                                    <span class="label label-important">{lang('Spam','admin')}</span>
                                {/if}
                            </td>
                            <td>{$comment.text}</td>
                            <td>{echo date('Y-m-d, H:i:s', $comment.date)}</td>
                            <td><a href="{$ADMIN_URL}users/edit/{$comment.user_id}" data-title="{lang('Edit user','admin')}" data-rel="tooltip">{$comment.user_name}</a></td>
                        </tr>
                    {/foreach}    
                </tbody>
            </table>
        {/if}
        <!--
    </div>
    </section>
    </section>
        -->
        
</div>
