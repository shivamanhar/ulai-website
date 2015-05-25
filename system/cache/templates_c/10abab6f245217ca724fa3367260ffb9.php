<?php /*
/**
* @file Template for search results
* @updated 26 February 2013;
* Variables
* $products:(object) instance of SProducts
* $totalProducts: (int) Products amount
* $brandsInSearchResult: (object) instance of SBrands
* $pagination: (string) Show pagination
* $tree : (array) All Categories tree.
* $categories: (array). Categories in search results with amount of found products
*
*/?>
<div class="frame-crumbs">
    <?php echo widget ('path'); ?>
</div>
<div class="frame-inside">
    <div class="container">
        <div class="right-catalog" <?php if(!$totalProducts > 0): ?>style="width:100% !important"<?php endif; ?>>
            <?php if($totalProducts != 0): ?>
                <div class="f-s_0 title-category">
                    <div class="frame-title">
                        <h1 class="d_i"><span class="s-t"><?php echo lang ('Результаты поиска','light'); ?></span> <span class="what-search">«<?php echo encode ($_GET['text']); ?>»</span></h1>
                    </div>
                <span class="count">(<?php echo lang ('Найдено','light'); ?> <?php if(isset($totalProducts)){ echo $totalProducts; } ?> <?php echo SStringHelper::Pluralize($totalProducts, array(lang('товар','light'),lang('товара','light'),lang('товаров','light')))?>)</span>
                </div>
            <?php endif; ?>
            <?php if($totalProducts == 0): ?>
                <div class="msg layout-highlight layout-highlight-msg">
                    <div class="info">
                        <span class="icon_info"></span>
                        <span class="text-el"><?php echo lang ('Не найдено товаров','light'); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <?php $this->include_tpl('catalogue_header', '/var/www/templates/light/shop'); ?>
            <?php if($totalProducts > 0): ?>
                <ul class="animateListItems items items-catalog <?php if($_COOKIE['listtable'] == 'table' || $_COOKIE['listtable'] == NULL): ?> table<?php else:?> list<?php endif; ?>" id="items-catalog-main">
                    <!-- Include template for one product item-->
                    <?php echo getOPI ($products, array('opi_wishlist'=>true, 'opi_codeArticle' => true)); ?>
                </ul>
            <?php endif; ?>            <!--Start. Pagination -->
            <?php if($pagination): ?>
                <?php if(isset($pagination)){ echo $pagination; } ?>
            <?php endif; ?>
            <!-- End pagination -->
        </div>

        <?php if($totalProducts > 0): ?>
            <div class="left-catalog">
                <form method="GET" action="" id="catalogForm">
                    <input type="hidden" name="order" value="<?php echo $_GET[order]?>" />
                    <input type="hidden" name="text" value="<?php echo $_GET[text]?>">
                    <input type="hidden" name="category" value="<?php echo $_GET[category]?>">
                    <input type="hidden" name="user_per_page" value="<?php echo $_GET[user_per_page]?>">
                </form>
                <div class="frame-category-menu layout-highlight">
                    <div class="title-menu-category">
                        <div class="title-default">
                            <div class="title-h3 title"><?php echo lang ('Категории','light'); ?>:</div>
                        </div>
                    </div>
                    <div class="inside-padd">
                        <nav>
                            <?php if(is_true_array($categories)){ foreach ($categories as $key => $category){ ?>
                                <ul class="nav nav-vertical nav-category">
                                    <li>
                                        <span><?php echo trim(key($category))?></span>
                                    </li>
                                    <?php if(is_true_array($category[key($category)])){ foreach ($category[key($category)] as $subItem){ ?>
                                        <?php if($_GET['category'] && $_GET['category'] == $subItem['id']): ?>
                                            <li class="active">
                                                <span><?php echo $subItem['name']?></span>
                                            <?php else:?>
                                            <li>
                                                <a rel="nofollow" data-id="<?php echo $subItem['id']?>" href="<?php echo shop_url ('search?text='.$_GET['text'].'&category='.$subItem['id']); ?>"><span class="text-el"><?php echo $subItem['name']?></span> <span class="count">(<?php echo $subItem['count']?>)</span></a>
                                            <?php endif; ?>
                                        </li>
                                    <?php }} ?>
                                </ul>
                            <?php }} ?>
                        </nav>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php /* ?>
<?php echo count ($tree); ?>
<?php if(is_true_array($tree)){ foreach ($tree as $item){ ?>
    <?php if($categories[$item->getId()]): ?>
        <ul data-cid="<?php echo $item->getId()?>" <?php if($item->getParentId() != 0): ?> data-pid="<?php echo $item->getParentId()?>"<?php endif; ?>>
            <div class="title">
                <?php echo trim($item->getName())?>
            </div>
            <?php if(is_true_array($item->getSubtree())){ foreach ($item->getSubtree() as $subItem){ ?>
                <?php if($categories[$item->getId()][$subItem->getId()]): ?>
                    <li<?php if($_GET['category'] && $_GET['category'] == $subItem->getId()): ?> class="active"<?php endif; ?>>
                        <?php if($_GET['category'] && $_GET['category'] == $subItem->getId()): ?>
                            <?php echo $subItem->getName()?>
                        <?php else:?>
                            <a rel="nofollow" data-id="<?php echo $subItem->getId()?>" href="<?php echo shop_url ('search?text='.$_GET['text'].'&category='.$subItem->getId()); ?>"><?php echo $subItem->getName()?></a>
                        <?php endif; ?>
                        <span class="count">(<?php echo $categories[$item->getId()][$subItem->getId()]?>)</span>
                    </li>
                <?php endif; ?>
            <?php }} ?>
        </ul>
    <?php endif; ?>
<?php }} ?>
<?php */ ?>
<script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/cusel-min-2.5.js"></script><?php $mabilis_ttl=1432206680; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/search.tpl ?>