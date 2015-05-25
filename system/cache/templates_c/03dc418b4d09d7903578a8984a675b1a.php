<?php $openLevels = getOpenLevels()?>
<?php if($openLevels): ?>
    <?php if($openLevels == 'all'): ?>
        <?php $menuClass = 'menu-col-category'?>
    <?php else:?>
        <?php $menuClass = 'menu-row-category'?>
    <?php endif; ?>
<?php else:?>
    <?php $menuClass = 'menu-row-category'?>
<?php endif; ?>
<div class="container">
    <div class="menu-main not-js <?php if(isset($menuClass)){ echo $menuClass; } ?>">
        <nav>
            <table>
                <tbody>
                    <tr>
                        <?php if(isset($wrapper)){ echo $wrapper; } ?>
                    </tr>
                </tbody>
            </table>
        </nav>
    </div>
</div><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light//category_menu/level_0/container.tpl ?>