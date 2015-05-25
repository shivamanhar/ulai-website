<div class="container">

    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close f-s_26" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Kit removal','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Do you really want to delete selected kits?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}kits/kit_delete')" >{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Product kits','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()" id="del_sel_brand"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
                    <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/kits/kit_create" ><i class="icon-plus-sign icon-white"></i>{lang('Create a set','admin')}</a>
                </div>
            </div>
        </div>
        <div class="tab-content">
            {if count($model)>0}
            <div class="row-fluid">
                <form method="post" action="#" class="form-horizontal">
                    <table class="table  table-bordered table-hover table-condensed t-l_a">
                        <thead>
                            <tr>
                                <th class="t-a_c span1">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox"/>
                                        </span>
                                    </span>
                                </th>
                                <th class="span1">{echo $model[0]->getLabel('Id')}</th>
                                <th>{lang('Main product ID','admin')}</th>
                                <th>{lang('Main product','admin')}</th>
                                <th>{lang('Products in the kit','admin')}</th>
                                <th>{lang('Active','admin')}</th>
                            </tr>
                        </thead>
                        <tbody class="sortable">
                            {foreach $model as $item}
                            <tr>
                                <td class="t-a_c">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox" name="ids" value="{echo $item->getId()}"/>
                                        </span>
                                    </span>
                                </td>
                                <td><a class="pjax" href="{$ADMIN_URL}kits/kit_edit/{echo $item->getId()}" data-rel="tooltip" data-title="{lang('Edit product kit','admin')}">{echo $item->getId()}</a></td>
                                <td class="span2"><p>{echo $item->getSProducts()->getId()}</p></td>
                                <td>
                                    <div class="share_alt">
                                        <a target="_blank" href="{shop_url('product')}/{echo $item->getSProducts()->getUrl()}" class="go_to_site pull-right btn btn-small" data-rel="tooltip" data-placement="top" data-original-title="{lang('go to the website','admin')}"><i class="icon-share-alt"></i></a>
                                        <div class="o_h">
                                            <a class="pjax" href="{$ADMIN_URL}products/edit/{echo ShopCore::encode($item->getSProducts()->getId())}" data-rel="tooltip" data-title="{lang('Edit product','admin')}">{echo ShopCore::encode($item->getSProducts()->getName())}</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {$attachedProducts = $item->getShopKitProducts()}
                                    {if $attachedProducts->count() == 1}
                                    {$attachedSProduct = $attachedProducts[0]->getSProducts()}
                                    <a href="{$ADMIN_URL}products/edit/{echo $attachedSProduct->getId()}" data-rel="tooltip" data-title="{lang('Edit product','admin')}">{truncate(ShopCore::encode($attachedSProduct->getName()),100)}</a>
                                    {else:}
                                    <div class="buy_prod" data-title="{lang('Attached products','admin')}" data-original-title="">
                                        <span>{echo count($attachedProducts)}</span>
                                        {if count($attachedProducts) != 0}
                                        <i class="icon-info-sign"></i>
                                        {/if}
                                    </div>
                                    <div class="d_n">
                                        {foreach $attachedProducts as $attachedProduct}
                                        <div class="check_product">
                                            {$productUrl = '#'}
                                            {$attachedSProduct = $attachedProduct->getSProducts()}
                                            {if $attachedSProduct}
                                            {$productUrl = '/shop/product/'.$attachedSProduct->getUrl()}
                                            <a href="{$ADMIN_URL}products/edit/{echo $attachedSProduct->getId()}">{truncate(ShopCore::encode($attachedSProduct->getName()),100)}</a>
                                            {/if}
                                        </div>
                                        {/foreach}
                                    </div>
                                    {/if}
                                </td>
                                <td class="t-a_c span1">
                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('switch on','admin')}"  data-off="{lang('switch off','admin')}">
                                        <span class="prod-on_off kit_change_active {if $item->getActive() != 1}disable_tovar{/if}" data-kid="{echo $item->getId()}"></span>
                                    </div>
                                </td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </form>
            </div>
            {else:}
        </br>
        <div class="alert alert-info">
            {lang('Kit List products are empty','admin')}
        </div>
        {/if}
    </div>
</section>
</div>