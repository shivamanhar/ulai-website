<?php if($_GET['brand'] != "" || $_GET['p'] != "" || ($_GET['lp'] && $_GET['lp'] != $minPrice) || ($_GET['rp'] && $_GET['rp'] != $maxPrice)): ?>
    <div class="frame-check-filter">
        <div class="inside-padd">
            <div class="title"><?php echo lang ('Выбранные фильтры', 'light'); ?></div>
            <ul class="list-check-filter">
                <?php if($curMin != $minPrice || $curMax != $maxPrice): ?>
                    <li class="clear-slider" data-rel="sliders.slider1"><button type="button" class="ref"><span class="icon_times icon_remove_filter f_l"></span><span class="name-check-filter"><?php echo lang ('Цена от', 'light'); ?> <?php echo $_GET['lp']?> <?php echo lang ('до', 'light'); ?> <?php echo $_GET['rp']?> <span class="cur"><?php if(isset($CS)){ echo $CS; } ?></span></></button></li>
                    <?php endif; ?>
                    <?php if(count($brands) > 0): ?>
                        <?php if(is_true_array($brands)){ foreach ($brands as $brand){ ?>
                            <?php if(is_true_array($_GET['brand'])){ foreach ($_GET['brand'] as $id){ ?>
                                <?php if($id == $brand->id): ?>
                                <li data-name="brand_<?php echo $brand->id?>" class="clear-filter"><button type="button" class="ref"><span class="icon_times icon_remove_filter f_l"></span><span class="name-check-filter"><?php echo $brand->name?></span></button></li>
                                        <?php endif; ?>
                                    <?php }} ?>
                                <?php }} ?>
                            <?php endif; ?>
                            <?php if(count($propertiesInCat) > 0): ?>
                                <?php if(is_true_array($propertiesInCat)){ foreach ($propertiesInCat as $prop){ ?>
                                    <?php if(is_true_array($prop->possibleValues)){ foreach ($prop->possibleValues as $key){ ?>
                                        <?php if(is_true_array($_GET['p'][$prop->property_id])){ foreach ($_GET['p'][$prop->property_id] as $nm){ ?>
                                            <?php if($nm ==  $key['value']): ?>
                                    <li data-name="p_<?php echo $prop->property_id?>_<?php echo  $key['id']  ?>" class="clear-filter"><button type="button" class="ref"><span class="icon_times icon_remove_filter f_l"></span><span class="name-check-filter"><?php echo $prop->name?>: <?php echo  $key['value']  ?></span></button></li>
                                            <?php endif; ?>
                                        <?php }} ?>
                                    <?php }} ?>
                                <?php }} ?>
                            <?php endif; ?>
            </ul>
            <div class="foot-check-filter">
                <button type="button" onclick="location.href = location.origin + location.pathname" class="btn-reset-filter">
                    <span class="text-el d_l_1"><?php echo lang ('Сбросить все фильтры', 'light'); ?></span>
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- end of selected filters block -->

<?php if($category->hasSubCats()): ?>
    <div class="frame-category-menu layout-highlight">
        <div class="title-menu-category">
            <div class="title-default">
                <div class="title-h3 title"><?php echo lang ('Категории', 'light'); ?>:</div>
            </div>
        </div>
        <div class="inside-padd">
            <nav>
                <ul class="nav nav-vertical nav-category">
                    <?php if(is_true_array($category->getChildsByParentIdI18n($category->getId()))){ foreach ($category->getChildsByParentIdI18n($category->getId()) as $key => $value){ ?>
                        <li>
                            <a href="<?php echo shop_url ('category/' . $value->getFullPath()); ?>"><?php echo $value->getName()?></a>
                        </li>
                    <?php }} ?>
                </ul>
            </nav>
        </div>
    </div>
<?php endif; ?>

<form method="get" id="catalogForm">
    <input type="hidden" name="order" value="<?php echo $order_method?>" />
    <input type="hidden" name="user_per_page" value="<?php if(!$_GET['user_per_page']): ?><?php echo \ShopCore::app()->SSettings->frontProductsPerPage?><?php else:?><?php echo $_GET['user_per_page']?><?php endif; ?>"/>
    <div class="frame-filter p_r">
        <?php $this->include_tpl('filter', '/var/www/templates/light/smart_filter'); ?>
    </div>
</form>
<?php $mabilis_ttl=1432206589; $mabilis_last_modified=1426010500; ///var/www/templates/light/smart_filter/main.tpl ?>