<?php $i=0?>
<div class="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
    <div class="container">
        <ul class="items items-crumbs">
            <li class="btn-crumb">
                <a href="<?php echo site_url (); ?>" typeof="v:Breadcrumb">
                    <span class="text-el"><?php echo lang ('Главная', 'lightRed'); ?></span>
                </a>
            </li>
            <?php if(is_true_array($navi_cats)){ foreach ($navi_cats as $item){ ?> <?php $i++?>
                <li class="btn-crumb">
                    <?php if($i < count($navi_cats)): ?>
                        <a href="<?php echo site_url ( $item['path_url'] ); ?>" typeof="v:Breadcrumb">
                            <span class="divider">/</span>
                            <span class="text-el"><?php echo $item['name']; ?>
                        </a>
                    <?php else:?>
                        <button typeof="v:Breadcrumb" disabled="disabled">
                            <span class="divider">/</span>
                            <span class="text-el"><?php echo $item['name']; ?></span>
                        </button>
                    <?php endif; ?>
                </li>
            <?php }} ?>
        </ul>
    </div>
</div>
<?php $mabilis_ttl=1432206588; $mabilis_last_modified=1426010500; ///var/www/templates/light/widgets/path.tpl ?>