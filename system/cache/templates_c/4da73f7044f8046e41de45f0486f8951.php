<?php if($totalProducts > 0): ?>
    <div class="frame-header-category">
        <div class="header-category f-s_0">
            <div class="inside-padd clearfix">
                <!-- Start. Order by block -->
                <div class="frame-sort f-s_0 d_i-b">
                    <span class="title"><?php echo lang ('Выводить сначала','light'); ?>:</span>
                    <div class="lineForm">
                        <select class="sort" id="sort" name="order">
                            <?php $sort =ShopCore::app()->SSettings->getSortingFront()?>
                            <?php if(is_true_array($sort)){ foreach ($sort as $s){ ?>
                                <option value="<?php echo $s['get']?>" <?php if(ShopCore::$_GET['order']==$s['get']): ?>selected="selected"<?php endif; ?>><?php echo $s['name_front']?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                <!-- End. Order by block -->
                <!--         Start. Product per page  -->
                <div class="frame-count-onpage d_i-b">
                    <div class="f-s_0 d_i-b">
                        <span class="title"><?php echo lang ('На странице','light'); ?>:</span>
                        <?php if(ShopCore::$_GET['user_per_page'] == null): ?>
                            <?php ShopCore::$_GET['user_per_page'] =ShopCore::app()->SSettings->frontProductsPerPage;?>
                        <?php endif; ?>
                        <div class="lineForm">
                            <!--                Load settings-->
                            <?php $per_page_arr = unserialize(ShopCore::app()->SSettings->arrayFrontProductsPerPage)?>
                            <select id="sort2" name="user_per_page">
                                <?php if(is_true_array($per_page_arr)){ foreach ($per_page_arr as $pp){ ?>
                                    <option <?php if($pp == ShopCore::$_GET['user_per_page']): ?>selected="selected"<?php endif; ?> value="<?php if(isset($pp)){ echo $pp; } ?>"><?php if(isset($pp)){ echo $pp; } ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--         End. Product per page  -->
                <!--        Start. Show products as list or table-->
                <nav class="frame-catalog-view f-s_0 d_i-b">
                    <span class="title"><?php echo lang ('Вывод','light'); ?>:</span>
                    <ul class="tabs groups-buttons tabs-list-table" data-elchange="#items-catalog-main" data-cookie="listtable">
                        <li class="<?php if($_COOKIE['listtable'] == 'table' || $_COOKIE['listtable'] == NULl): ?>active<?php endif; ?>">
                            <button type="button" data-href="table" data-title="<?php echo lang ('Таблица','light'); ?>" data-rel="tooltip">
                                <span class="icon_table_cat"></span><span class="text-el"><?php echo lang ('Таблица','light'); ?></span>
                            </button>
                        </li>
                        <li class="<?php if($_COOKIE['listtable'] == 'list'): ?>active<?php endif; ?>">
                            <button type="button" data-href="list" data-title="<?php echo lang ('Список','light'); ?>" data-rel="tooltip">
                                <span class="icon_list_cat"></span><span class="text-el"><?php echo lang ('Список','light'); ?></span>
                            </button>
                        </li>
                    </ul>
                </nav>
                <!--        End. Show products as list or table-->
            </div>
            <!--                Start. if $CI->uri->segment(2) == "search" then show hidden field-->
            <?php if($CI->uri->segment(2) == "search"): ?>
                <input type="hidden" name="text" value="<?php echo $_GET['text']; ?>">
            <?php endif; ?>
            <!--                End. if $CI->uri->segment(2) == "search" then show hidden field-->
        </div>
    </div>
<?php endif; ?><?php $mabilis_ttl=1432206588; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/catalogue_header.tpl ?>