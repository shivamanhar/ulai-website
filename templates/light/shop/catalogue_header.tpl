{if $totalProducts > 0}
    <div class="frame-header-category">
        <div class="header-category f-s_0">
            <div class="inside-padd clearfix">
                <!-- Start. Order by block -->
                <div class="frame-sort f-s_0 d_i-b">
                    <span class="title">{lang('Выводить сначала','light')}:</span>
                    <div class="lineForm">
                        <select class="sort" id="sort" name="order">
                            {$sort =ShopCore::app()->SSettings->getSortingFront()}
                            {foreach $sort as $s}
                                <option value="{echo $s['get']}" {if ShopCore::$_GET['order']==$s['get']}selected="selected"{/if}>{echo $s['name_front']}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <!-- End. Order by block -->
                <!--         Start. Product per page  -->
                <div class="frame-count-onpage d_i-b">
                    <div class="f-s_0 d_i-b">
                        <span class="title">{lang('На странице','light')}:</span>
                        {if ShopCore::$_GET['user_per_page'] == null}
                            {ShopCore::$_GET['user_per_page'] =ShopCore::app()->SSettings->frontProductsPerPage;}
                        {/if}
                        <div class="lineForm">
                            <!--                Load settings-->
                            {$per_page_arr = unserialize(ShopCore::app()->SSettings->arrayFrontProductsPerPage)}
                            <select id="sort2" name="user_per_page">
                                {foreach $per_page_arr as $pp}
                                    <option {if $pp == ShopCore::$_GET['user_per_page']}selected="selected"{/if} value="{$pp}">{$pp}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                <!--         End. Product per page  -->
                <!--        Start. Show products as list or table-->
                <nav class="frame-catalog-view f-s_0 d_i-b">
                    <span class="title">{lang('Вывод','light')}:</span>
                    <ul class="tabs groups-buttons tabs-list-table" data-elchange="#items-catalog-main" data-cookie="listtable">
                        <li class="{if $_COOKIE['listtable'] == 'table' || $_COOKIE['listtable'] == NULl}active{/if}">
                            <button type="button" data-href="table" data-title="{lang('Таблица','light')}" data-rel="tooltip">
                                <span class="icon_table_cat"></span><span class="text-el">{lang('Таблица','light')}</span>
                            </button>
                        </li>
                        <li class="{if $_COOKIE['listtable'] == 'list'}active{/if}">
                            <button type="button" data-href="list" data-title="{lang('Список','light')}" data-rel="tooltip">
                                <span class="icon_list_cat"></span><span class="text-el">{lang('Список','light')}</span>
                            </button>
                        </li>
                    </ul>
                </nav>
                <!--        End. Show products as list or table-->
            </div>
            <!--                Start. if $CI->uri->segment(2) == "search" then show hidden field-->
            {if $CI->uri->segment(2) == "search"}
                <input type="hidden" name="text" value="{$_GET['text']}">
            {/if}
            <!--                End. if $CI->uri->segment(2) == "search" then show hidden field-->
        </div>
    </div>
{/if}