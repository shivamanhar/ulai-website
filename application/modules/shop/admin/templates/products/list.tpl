<div class="saPageHeader" style="float:left;width:100%;">
    <div class="saPageHeader" style="float:left;width:100%;">
        <div style="float:right;padding-top:2px;margin-right:5px;position:relative;" onsubmit="return false;">
            <form action="{$ADMIN_URL}search/index/" method="get">
                <input type="hidden" value="{echo $model->getId()}" name="CategoryId">
                <input type="text" name="text" class="textbox_long" />
                <input type="submit" value="{lang('Search','admin')}" class="search_submit" name="_search" onclick="ajaxShopForm(this, 'shopAdminPage');" />
            </form>
        </div>
        <script>
            var variant = "{lang('Product variations ','admin')}";
            var del = "{lang('Delete ','admin')}";
            var wf = "{lang('product','admin')}";
            var jid = "{lang('ID : ','admin')}";
            var whislist = "{lang('Selected ','admin')}";
            var copy_product = "{lang(' Create a product copy?','admin')}";
            var remove_product = "{lang('Product displacement','admin')}";

        </script>
        <div style="float:right;padding:6px 10px 0 0">
            <input type="button" class="button_silver_130" value="{lang('Create a product','admin')}" onclick="ajaxShop('products/create?select_cat={echo $model->getId()}');"/>
        </div>

        <h2>{lang('View','admin')} {lang('Product','admin')} {lang('Categories','admin')}"{truncate(ShopCore::encode($model->getName()),60)}"</h2>
    </div>

    {if $totalProducts == 0}
        <div id="notice" class="alert alert-info">{lang('in','admin')} {lang('Categories','admin')} {lang('No','admin')} {lang('Product','admin')}.
            <a href="products/create?select_cat={echo $model->getId()}" class="pjax">{lang('Create','admin')}.</a>
        </div>
        {return}
    {/if}

    <div id="sortable" style="clear:both;"> 
        <table id="ShopProductsHtmlTable">
            <thead>
            <th width="1px"><input type="checkbox" onclick="ShopSwitchChecks(this);"/></th>
            <th title="{lang('Sort by ID','admin')}" width="5px" {if $orderField == 'Id'}
            {if $nextOrderCriteria == 'ASC'}class="tableHeaderOver sortedDESC"{else:}
        {if $nextOrderCriteria == 'DESC'}class="tableHeaderOver sortedASC"{/if}{/if}{else:}class="tableHeaderOver"{/if} 
                onclick="ajaxShop('products/index/{echo $model->getId()}/offset/Id/{if $orderField == 'Id'}{if $nextOrderCriteria == 'ASC'}ASC{else:}DESC{/if}{else:}DESC{/if}');
                return false;">ID</th>
            <th title="{lang('Sort by name .','admin')}" {if $orderField == 'Name'}
            {if $nextOrderCriteria == 'ASC'}class="tableHeaderOver sortedDESC"{else:}
        {if $nextOrderCriteria == 'DESC'}class="tableHeaderOver sortedASC"{/if}{/if}{else:}class="tableHeaderOver"{/if} 
                onclick="ajaxShop('products/index/{echo $model->getId()}/offset/Name/{if $orderField == 'Name'}{if $nextOrderCriteria == 'ASC'}ASC{else:}DESC{/if}{else:}DESC{/if}');
                return false;">{lang('Name','admin')}</th>
            <th width="18px"></th>
            <th width="18px"></th>
            <th width="18px"></th>
            <th width="18px"></th>
            <th title="{lang('Sort by price','admin')}" width="100px" {if $orderField == 'Price'}
            {if $nextOrderCriteria == 'ASC'}class="tableHeaderOver sortedDESC"{else:}
        {if $nextOrderCriteria == 'DESC'}class="tableHeaderOver sortedASC"{/if}{/if}{else:}class="tableHeaderOver"{/if} 
                onclick="ajaxShop('products/index/{echo $model->getId()}/offset/Price/{if $orderField == 'Price'}{if $nextOrderCriteria == 'ASC'}ASC{else:}DESC{/if}{else:}DESC{/if}');
                return false;">{lang('Price','admin')}</a></th>
            <th></th>
            </thead>
            <tbody>
                {foreach $products as $p}
                    {setDefaultLanguage($p)}
                    {$variants = $p->getProductVariants()}
                    <tr id="productRow{echo $p->getId()}" class="row">
                        <td width="1px"><input type="checkbox" class="chbx" rel="{echo $p->getId()}" onclick="productsListcheckForChecked();"/></td>
                        <td>{echo $p->getId()}</td>
                        <td>
                            <a id="editProductLink{echo $p->getId()}" href="#"
                            {if $p->getActive() == false} class="productNotActivated" {/if}
                            onClick="ajaxShop('products/edit/{echo $p->getId()}/{$locale}?redirect={base64_encode(ShopCore::$ci->uri->uri_string())}');
                return false;">{truncate(ShopCore::encode($p->getName()),100)}</a>
                    </td>
                    <td>
                        {if $p->getActive() == true}
                            <img src="{$SHOP_THEME}images/tick_16.png" title="{lang('Active','admin')}" onclick="shopChangeProductActive(this, {echo $p->getId()});" rel="true"/>
                        {else:}
                            <img src="{$SHOP_THEME}images/tick_16_empty.png"  title="{lang('Active','admin')}" onclick="shopChangeProductActive(this, {echo $p->getId()});" rel="false"/>
                        {/if}
                    </td>
                    <td>
                        {if $p->getHit() == true}
                            <img src="{$SHOP_THEME}images/star_16.png" title="{lang('Hit','admin')}" onclick="shopChangeProductHit(this, {echo $p->getId()});" rel="true"/>
                        {else:}
                            <img src="{$SHOP_THEME}images/star_16_empty.png" title="{lang('Hit','admin')}" onclick="shopChangeProductHit(this, {echo $p->getId()});" rel="false"/>
                        {/if}
                    </td>
                    <td>
                        {if $p->getHot() == true}
                            <img src="{$SHOP_THEME}images/hot_16.png" title="{lang('Novelty','admin')}" onclick="shopChangeProductHot(this, {echo $p->getId()});" rel="true"/>
                        {else:}
                            <img src="{$SHOP_THEME}images/hot_16_empty.png" title="{lang('Novelty','admin')}" onclick="shopChangeProductHot(this, {echo $p->getId()});" rel="false"/>
                        {/if}
                    </td>
                    <td>
                        {if $p->getAction() == true}
                            <img src="{$SHOP_THEME}images/action_16.png" title="{lang('Promotion','admin')}" onclick="shopChangeProductAction(this, {echo $p->getId()});" rel="true"/>
                        {else:}
                            <img src="{$SHOP_THEME}images/action_16_empty.png" title="{lang('Promotion','admin')}" onclick="shopChangeProductAction(this, {echo $p->getId()});" rel="false"/>
                        {/if}
                    </td>
                    <td>
                        {if sizeof($variants) == 1}
                            {echo $variants[0]->getPrice()} {$CS}
                        {else:}
                            <img src="{$SHOP_THEME}images/arrow-315.png" title="{lang('View','admin')} {lang('Variant','admin')}"  onclick="showVariantsWindow('vBlock{echo $p->getId()}');"/>
                            <div style="display:none;">
                                <div id="vBlock{echo $p->getId()}">
                                    <table width="100%" cellpadding="3" cellspacing="2">
                                        <thead>
                                        <th>{lang('Name','admin')}</th>
                                        <th>{lang('Price','admin')}</th>
                                        </thead>
                                        <tbody>
                                            {foreach $variants as $v}
                                                {setDefaultLanguage($v)}
                                                <tr>
                                                    <td>{echo $v->getName()}</td>
                                                    <td>{echo $v->getPrice()} {$CS}</td>
                                                </tr>
                                            {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        {/if}
                    </td>
                    <td style="text-align:right;">
                        {if count(ShopCore::$ci->cms_admin->get_langs(true)) > 1}
                            <img onclick="translate_list_item({echo $p->getId()});
                return false;" src="/application/modules/shop/admin/templates/assets/images/translateable.png" width="16" height="16"/> 	
                        {/if}
                        <img
                            onclick="confirm_delete_product({echo $p->getId()}, {echo $model->getId()});"
                            src="{$THEME}images/delete.png"
                            style="cursor:pointer;width:16px;height:16px;" title="{lang('Delete','admin')}" />
                    </td>
                </tr>
            {/foreach}
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<div style="float:right;padding:10px 10px 0 0" class="pagination">
    {$pagination}
</div>

<div style="padding:10px 10px 0 20px;">
    <b>{lang('All','admin')} {lang('Product','admin')}:</b> {$totalProducts}
</div>

<div class="footer_panel" align="right" id="productsListFooter" style="display:none;">
    <input id="footerImageButton" class="Arrow" value="&nbsp;" type="button" onclick="shopProductsList_showMoveWindow('{echo $category->getId()}');" title="{lang('Move','admin')}">
    <input id="footerImageButton" class="Clone" value="&nbsp;" type="button" onclick="shopProductsList_Clone('{echo $category->getId()}');" title="{lang('Create','admin')} {lang('Copy','admin')}">
    <input id="footerImageButton" class="Tick" value="&nbsp;" type="button" onclick="shopProductsList_changeActive('{echo $CI->uri->uri_string()}');" title="{lang('Change','admin')} '{lang('Active','admin')}'">
    <input id="footerImageButton" class="Star" value="&nbsp;" type="button" onclick="shopProductsList_changeHit('{echo $CI->uri->uri_string()}');" title="{lang('Change','admin')} '{lang('Hit','admin')}'">
    <input id="footerImageButton" class="Hot" value="&nbsp;" type="button" onclick="shopProductsList_changeHot('{echo $CI->uri->uri_string()}?{http_build_query(ShopCore::$_GET)}');" title="{lang('Change','admin')} '{lang('New','admin')}'">
    <input id="footerImageButton" class="Action" value="&nbsp;" type="button" onclick="shopProductsList_changeAction('{echo $CI->uri->uri_string()}?{http_build_query(ShopCore::$_GET)}');" title="{lang('Change','admin')} '{lang('Special offers','admin')}'">
    <input type="button" id="footerButtonRed" name="_delete" value="{lang('Delete','admin')}" onclick="shopProductsList_Delete('{echo $category->getId()}');" class="active">
</div>

{literal}
    <script type="text/javascript">
            window.addEvent('domready', function() {
                shopProductsTable = new sortableTable('ShopProductsHtmlTable', {overCls: 'over', sortOn: -1, onClick: function() {
                    }});
                shopProductsTable.altRow();
            });

            function translate_list_item(iId)
            {
                MochaUI.translate_list_item_Window = function() {
                    new MochaUI.Window({
                        id: 'translate_list_item_Window',
                        title: '<img width="16" height="16" align="absmiddle" src="/application/modules/shop/admin/templates/assets/images/translateable.png"/> {/literal}{lang('Translation','admin')} {lang('Product','admin')} {lang('ID','admin')}:{literal} ' + iId,
                        loadMethod: 'xhr',
                        contentURL: shop_url + 'products/translate/' + iId,
                        width: 950,
                        height: 540
                    });
                    $('translate_list_item_Window_content').setStyles({
                        'padding-top': 0,
                        'padding-bottom': 0,
                        'padding-left': 0,
                        'padding-right': 0
                    });
                }

                MochaUI.translate_list_item_Window();
            }

            function shopProductsList_moveProducts(categoryId)
            {
                var ids = shopProductsList_GetSelectedIds();
                start_ajax();
                var req = new Request.HTML({
                    method: 'post',
                    url: shop_url + 'products/ajaxMoveProducts',
                    onComplete: function(response) {
                        stop_ajax();
                        // Redirect to current category
                        ajaxShop('products/index/{/literal}{echo $category->getId()}{literal}');
                        MochaUI.closeWindow($('productsListMoveWindow'));
                    }
                }).post({'ids': ids, 'categoryId': categoryId});
            }
    </script>
{/literal}
