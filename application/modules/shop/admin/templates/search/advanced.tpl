<div class="container">

    <form action="{$ADMIN_URL}search/index/" id="filter_form" method="get">

        <section class="mini-layout">
            <div class="frame_title clearfix">
                <div class="pull-left">
                    <span class="help-inline"></span>
                    <span class="title">{lang('Search results','admin')}: "{$_GET['q']}"</span>
                </div>                            
            </div>
            <div class="row-fluid">

                {if count($users)}
                    <div class="clearfix">
                        <div class="btn-group myTab m-t_20 pull-left" data-toggle="buttons-radio">
                            <a href="#products" class="btn btn-small {if count($model)} active{/if}">{lang('Products','admin')} 
                                <span style="top:-13px;" class="badge {if count($model)}badge-important{/if}">{count($model)}</span>
                            </a>
                            <a href="#users" class="btn btn-small {if !count($model) && count($users)} active{/if}">{lang('User','admin')}
                                <span style="top:-13px;" class="badge {if count($users)} badge-important{/if}">{count($users)}</span>
                            </a>
                        </div>
                    </div>
                {/if}

                <div class="tab-content">
                    <div class="tab-pane {if count($model)}active{/if}" id="products" >

                        {if count($model)}
                            <table class="table  table-bordered table-hover table-condensed products_table">
                                <thead>
                                    <tr style="cursor: pointer;">
                                        <th class="span1 product_list_order" data-column="Id">{lang('ID','admin')}</th>
                                        <th class="span3 product_list_order" data-column="Name">{lang('Name','admin')}</th>
                                        <th class="span2 product_list_order" data-column="CategoryId">{lang('Categories','admin')}</th>
                                        <th class="span1">{lang('Reference','admin')}</th>
                                        <th class="span1 product_list_order" data-column="Active">{lang('Active','admin')}</th>
                                        <th class="span2">{lang('Status','admin')}</th>
                                        <th class="span2 product_list_order" data-column="Price">{lang('Price','admin')}</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    {foreach $model as $p}
                                        {$variants = $p->getProductVariants()}
                                        {if sizeof($variants) == 1}
                                            <tr data-id="{echo $p->getId()}">

                                                <td><p>{echo $p->getId()}</p></td>
                                                <td class="share_alt">
                                                    <a href="/shop/product/{echo $p->getUrl()}" target="_blank" class="go_to_site pull-right btn btn-small"  data-rel="tooltip" data-placement="top" data-original-title="{lang('go to the website','admin')}"><i class="icon-share-alt"></i></a>
                                                    <div class="o_h">
                                                        <a href="/admin/components/run/shop/products/edit/{echo $p->getId()}" class="title">{truncate(ShopCore::encode($p->getName()),100)}</a>
                                                    </div>
                                                </td>
                                                <td class="share_alt">
                                                    <a href="/shop/category/{echo $p->getMainCategory()->getFullPath()}" target="_blank" class="go_to_site pull-right btn btn-small"  data-rel="tooltip" data-placement="top" data-original-title="{lang('go to the website','admin')}"><i class="icon-share-alt"></i></a>
                                                    <div class="o_h">
                                                        <a href="{$ADMIN_URL}categories/edit/{echo $p->getMainCategory()->getId()}" class="pjax" >{echo $p->getMainCategory()->getName()}</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p>{echo $variants[0]->getNumber()}</p>
                                                </td>
                                                <td>
                                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('show','admin')}">
                                                        {if $p->getActive() == true}
                                                            <span class="prod-on_off" data-id="{echo $p->getId()}"></span>
                                                        {else:}
                                                            <span class="prod-on_off disable_tovar" data-id="{echo $p->getId()}"></span>
                                                        {/if}
                                                    </div>
                                                </td>
                                                <td>
                                                    {if $p->getHit() == true}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('hit','admin')}"><i class="icon-fire"></i></button>
                                                        {else:}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('hit','admin')}"><i class="icon-fire"></i></button>
                                                        {/if}

                                                    {if $p->getHot() == true}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('novelty','admin')}"><i class="icon-gift"></i></button>
                                                        {else:}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('novelty','admin')}"><i class="icon-gift"></i></button>
                                                        {/if}

                                                    {if $p->getAction() == true}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('promotion','admin')}"><i class="icon-star"></i></button>
                                                        {else:}
                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('promotion','admin')}"><i class="icon-star"></i></button>
                                                        {/if}
                                                </td>
                                                <td>
                                                    <span class="pull-right"><span class="neigh_form_field help-inline"></span>&nbsp;&nbsp;{echo ShopCore::app()->SCurrencyHelper->getSymbolById($variants[0]->getCurrency())}</span>
                                                    <div class="p_r o_h frame_price number">
                                                        <input type="text" value="{echo $variants[0]->getPriceInMain()}" class="js_price" data-value="{echo $variants[0]->getPriceInMain()}">
                                                        <button class="btn btn-small refresh_price" data-id="{echo $p->getId()}" type="button"><i class="icon-refresh"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        {else:}
                                            <tr data-id="{echo $p->getId()}">
                                                <td colspan="7">
                                                    <table>
                                                        <thead class="no_vis">
                                                            <tr>
                                                                <td class="span1"></td>
                                                                <td class="span3"></td>
                                                                <td class="span2"></td>
                                                                <td class="span1"></td>
                                                                <td class="span1"></td>
                                                                <td class="span2"></td>
                                                                <td class="span2"></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><p>{echo $p->getId()}</p></td>
                                                                <td class="share_alt">
                                                                    <a href="/shop/product/{echo $p->getUrl()}" target="_blank" class="go_to_site pull-right btn btn-small"  data-rel="tooltip" data-placement="top" data-original-title="{lang('go to the website','admin')}"><i class="icon-share-alt"></i></a>
                                                                    <div class="o_h">
                                                                        <a href="/admin/components/run/shop/products/edit/{echo $p->getId()}" class="title">{truncate(ShopCore::encode($p->getName()),100)}</a>
                                                                    </div>
                                                                </td>
                                                                <td><a href="/shop/category/{echo $p->getMainCategory()->getUrl()}">{echo $p->getMainCategory()->getName()}</a></td>
                                                                <td></td>
                                                                <td>
                                                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('show','admin')}">
                                                                        {if $p->getActive() == true}
                                                                            <span class="prod-on_off" data-id="{echo $p->getId()}"></span>
                                                                        {else:}
                                                                            <span class="prod-on_off disable_tovar" data-id="{echo $p->getId()}"></span>
                                                                        {/if}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {if $p->getHit() == true}
                                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('hit','admin')}"><i class="icon-fire"></i></button>
                                                                        {else:}
                                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setHit" data-rel="tooltip" data-placement="top" data-original-title="{lang('hit','admin')}"><i class="icon-fire"></i></button>
                                                                        {/if}

                                                                    {if $p->getHot() == true}
                                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('novelty','admin')}"><i class="icon-gift"></i></button>
                                                                        {else:}
                                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setHot" data-rel="tooltip" data-placement="top" data-original-title="{lang('novelty','admin')}"><i class="icon-gift"></i></button>
                                                                        {/if}

                                                                    {if $p->getAction() == true}
                                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small btn-primary active {if $p->getActive() != true} disabled{/if} setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('promotion','admin')}"><i class="icon-star"></i></button>
                                                                        {else:}
                                                                        <button type="button" data-id="{echo $p->getId()}" class="btn btn-small {if $p->getActive() != true} disabled{/if} setAction" data-rel="tooltip" data-placement="top" data-original-title="{lang('promotion','admin')}"><i class="icon-star"></i></button>
                                                                        {/if}
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="t-d_n variants"><span class="js">{lang('Variants','admin')}</span> <span class="f-s_14">↓</span></a>
                                                                </td>
                                                            </tr>
                                                            <tr style="display: none;">
                                                                <td colspan="7">
                                                                    <table>
                                                                        <thead class="no_vis">
                                                                            <tr>
                                                                                <td class="span1"></td>
                                                                                <td class="span3"></td>
                                                                                <td class="span2"></td>
                                                                                <td class="span1"></td>
                                                                                <td class="span1"></td>
                                                                                <td class="span2"></td>
                                                                                <td class="span2"></td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="sortable">
                                                                            {foreach $variants as $v}
                                                                                <tr data-title="{lang('Drag product variant','admin')}">
                                                                                    <td class="t-a_c"></td>
                                                                                    <td>
                                                                                        <span class="simple_tree">&#8627;</span>&nbsp;&nbsp;
                                                                                        {if $v->getName() != ''}
                                                                                            <span>{echo $v->getName()}</span>
                                                                                        {else:}
                                                                                            <span>{echo $p->getName()}</span>
                                                                                        {/if}    
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td><p>{echo $v->getNumber()}</p></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td>
                                                                                        <span class="pull-right"><span class="neigh_form_field help-inline"></span>&nbsp;&nbsp;{echo ShopCore::app()->SCurrencyHelper->getSymbolById($v->getCurrency())}</span>
                                                                                        <div class="p_r o_h frame_price number">
                                                                                            <input type="text" value="{echo $v->getPriceInMain()}" class="js_price" data-value="{echo $v->getPriceInMain()}">
                                                                                            <button class="btn btn-small refresh_price" data-id="{echo $v->getProductId()}" variant-id="{echo $v->getId()}" type="button"><i class="icon-refresh"></i></button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            {/foreach}
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        {/if}
                                    {/foreach}
                                </tbody>
                            </table>

                        {else:}
                            <div class="alert alert-info" style="margin: 18px;">{lang('No relevant data has been found','admin')}</div>
                        {/if}    

                    </div>

                    <div class="tab-pane  {if !count($model) && count($users)} active{/if}" id="users">
                        {if count($users)}

                            <table class="table  table-bordered table-hover table-condensed" style="clear: both;">
                                <thead>
                                    <tr>
                                        <th class="span1">{lang('ID','admin')}</th>
                                        <th>{lang('User','admin')}</th>
                                        <th>{lang('E-mail','admin')}</th>
                                        <th>{lang('Telephone','admin')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach $users as $user}
                                        <tr>
                                            <td><p>{echo $user.id}</p></td>
                                            <td><a href="/admin/components/run/shop/users/edit/{echo $user.id}" class="pjax">{echo $user.username}</a></td>                            
                                            <td>{$user.email}</td>
                                            <td><p>{$user.phone}</p></td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>

                        {else:}
                            <div class="alert alert-info" style="margin: 18px;">{lang('No relevant data has been found','admin')}</div>
                        {/if}
                    </div>    

                    {if !count($model) && !count($users)}
                        <div class="alert alert-info" style="margin: 18px;">{lang('No relevant data has been found','admin')}</div>
                    {/if}
                </div>
            </div>
            {if $pagination > ''}
                <div class="clearfix">
                    {$pagination}
                </div>
            {/if}
        </section>
</div>