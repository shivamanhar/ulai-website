<button type="button" id="showCartPopup" data-drop="#popupCart" style="display: none;"></button>
<div class="drop-bask drop drop-style" id="popupCart"></div>

<?php #
/**
* @file Render autocomplete results
* @partof main.tpl
* @updated 25 February 2013;
* Variables
*   items : (object javascript) Contain found products
*/
#?>
    <script type="text/template" id="searchResultsTemplate">
        <div class="inside-padd">
        <% if (_.keys(items).length > 1) { %>
        <ul class="items items-search-autocomplete">
        <% _.each(items, function(item){
        if (item.name != null){%>
        <li>
        <!-- Start. Photo Block and name  -->
        <a href="<?php echo shop_url ('product'); ?>/<%- item.url %>" class="frame-photo-title">
        <span class="photo-block">
        <span class="helper"></span>
        <img src="<%- item.smallImage %>">
        </span>
        <span class="title"><% print(item.name)  %></span>
        <!-- End. Photo Block and name -->

        <span class="description">
        <!-- Start. Product price  -->
        <span class="frame-prices f-s_0">
        <span class="current-prices var_price_{echo $p->firstVariant->getId()} prod_price_{echo $p->getId()}">
        <span class="price-new">
        <span>
        <span class="price"><%- item.price %></span>
        </span>
        </span>
        <% if (item.nextCurrency != null) { %>
        <span class="price-add">
        <span>
        (<span class="price addCurrPrice"><%- item.nextCurrency %></span>
    )                                            
        </span>
        </span>
        <% } %>
        </span>
        </span>
        </span>
        <!-- End. Product price  -->
        </a>
        </li>
        <% }
        }) %>
        </ul>
        <!-- Start. Show link see all results if amount products >0  -->
        <div>
        <div class="btn-autocomplete">
        <a href="<?php echo shop_url ('search'); ?>?text=<%- items.queryString %>"  class="f-s_0 t-d_u">
        <span class="icon_show_all"></span><span class="text-el"><?php echo lang ('Посмотреть все результаты','light'); ?> →</span>
        </a>
        </div>
        <!-- End. Show link  -->
        <% } else {%>    
    <div class="msg f-s_0">
    <div class="info"><span class="icon_info"></span><span class="text-el"><?php echo ShopCore::t(lang('По Вашему запросу ничего не найдено','light'))?></span></div>
    </div>
    <% }%>
    </div>
    </div>
</script>

        <script type="text/template" id="reportappearance">
            <% var nextCsCond = nextCs == '' ? false : true %>
            <ul class="items items-bask item-report">
            <li>
            <a href="<%-item.url%>" class="frame-photo-title" title="<%-item.name%>">
            <span class="photo-block">
            <span class="helper"></span>
            <img src="<%-item.img%>" alt="<%-item.name%>">
            </span>
            <span class="title"><%-item.name%></span>
            </a>
            <div class="description">
            <div class="frame-prices f-s_0">
            <%if (item.origprice) { %>
            <span class="price-discount">
            <span>
            <span class="price"><%- item.templatepricedisc %></span>
            </span>
            </span>
            <% } %>
            <span class="current-prices f-s_0">
            <span class="price-new">
            <span>
            <span class="price priceVariant"><%- item.templateprice %></span>
            </span>
            </span>
            <%if (nextCsCond){%>
            <span class="price-add">
            <span>
            (<span class="price addCurrPrice"><%-item.templatepriceadd%></span>)
            </span>
            </span>
            <%}%>
            </span>
            </div>
            </div>
            </li>
            </ul>
        </script>
    
    <span class="tooltip"></span>
    <div class="apply">
        <div class="content-apply">
            <div class="description"><?php echo lang ('Найдено','light'); ?> <span class="f-s_0"><span id="apply-count">5</span><span class="text-el">&nbsp;</span><span class="plurProd"></span></span><a href="#"><?php echo lang ('Показать','light'); ?></a></div>
        </div>
        <button type="button" class="icon_times icon_times_apply"></button>
    </div>
    <div class="drop drop-style" id="notification">
        <div class="drop-content-notification">
            <div class="inside-padd notification">

            </div>
        </div>
        <div class="drop-footer"></div>
    </div>
    <button style="display: none;" type="button" data-drop="#notification"  data-modal="true" data-effect-on="fadeIn" data-effect-off="fadeOut" class="trigger"></button>

    <div class="drop drop-style" id="confirm">
        <div class="drop-header">
            <div class="title"><?php echo lang ('Удалить список?' , 'light'); ?></div>
        </div>
        <div class="drop-content-confirm">
            <div class="inside-padd cofirm w-s_n-w">
                <div class="btn-def">
                    <button type="button" data-button-confirm data-modal="true">
                        <span class="text-el"><?php echo lang ('Подтвердить' , 'light'); ?></span>
                    </button>
                </div>
                <div class="btn-def">
                    <button type="button" data-closed="closed-js">
                        <span class="text-el"><?php echo lang ('Отменить' , 'light'); ?></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="drop-footer"></div>
    </div>
    <button style="display: none;" type="button" data-drop="#confirm"  data-confirm="true" data-effect-on="fadeIn" data-effect-off="fadeOut"></button>

    <div class="drop drop-style drop-auth">
        <div class="drop-content">
            <div class="inside-padd">
                <button type="button" class="d_l_1" data-trigger="#loginButton"><?php echo lang ('Авторизуйтесь', 'light'); ?></button>
            </div>
        </div>
    </div>
    <?php if(!$is_logged_in): ?>
        <div class="drop drop-style" id="dropAuth">
            <button type="button" class="icon_times_drop" data-closed="closed-js"></button>
            <div class="drop-content t-a_c" style="width: 350px;min-height: 0;">
                <div class="inside-padd">
                    <?php echo lang ('Для того, что бы добавить товар в список желаний, Вам нужно', 'light'); ?> <button type="button" class="d_l_1" data-drop=".drop-enter" data-source="<?php echo site_url ('auth'); ?>"><?php echo lang ('авторизоваться', 'light'); ?></button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/js_templates.tpl ?>