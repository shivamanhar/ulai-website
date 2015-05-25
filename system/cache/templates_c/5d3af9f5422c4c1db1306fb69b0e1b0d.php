<li class="column_<?php echo getCategoryColumns($id)?>">
    <a href="<?php if(isset($link)){ echo $link; } ?>" title="<?php if(isset($title)){ echo $title; } ?>" class="title-category-l1 <?php if($wrapper != FALSE): ?> is-sub<?php endif; ?>">
        <span class="helper"></span>
        <span class="text-el"><?php if(isset($title)){ echo $title; } ?></span>
    </a>
    <?php if(isset($wrapper)){ echo $wrapper; } ?>
</li><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light//category_menu/level_1/item_default.tpl ?>