<div class="frame_nav header-menu-out">
    <table class="container">
        <tbody>
        <tr>
            <?php if(is_true_array($menu)){ foreach ($menu as $item){ ?>
                <td class="<?php echo $item['class']; ?> <?php if($item['subMenu']  or  $item['identifier']  == 'modules'): ?> dropdown<?php endif; ?>">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo  $item['text']  ?>
                        <?php if($item['callback']): ?>
                            <?php echo admin_menu\classes\MenuCallback::run( $item['callback'] ) ?>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu" <?php if($item['identifier']  == 'modules'): ?>style="min-width: 250px;"<?php endif; ?>>
                        <?php if(is_true_array($item['subMenu'])){ foreach ($item['subMenu'] as $itemSub1){ ?>
                            <?php if($item['identifier']  == 'modules'): ?>

                                <?php if(is_true_array($modules)){ foreach ($modules as $module){ ?>
                                    <li>

                                        <a style="padding: 3px 15px;"
                                                <?php if($SAAS): ?>
                                                    href="<?php echo \saas\server\classes\StoreAutologin::getAutologinUrl('/admin/components/cp/' . $module['name'])?>"
                                                <?php else:?>
                                                    href="/admin/components/cp/<?php echo $module['name']?>"
                                                <?php endif; ?>
                                                >
                                            <?php if($module['icon_class']): ?>
                                                <i class="<?php echo $module['icon_class']?>"
                                                   style="margin-right: 5px;top: 2px;"></i>
                                            <?php endif; ?>
                                            <?php echo $module['menu_name']?>
                                            <?php if($module['callback']): ?>
                                                <?php echo admin_menu\classes\MenuCallback::run( $item['callback'] ) ?>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php }} ?>
                                <li class="divider"></li>
                            <?php endif; ?>

                            <li <?php if($itemSub1['header']): ?> class="nav-header"<?php endif; ?>>
                                <?php if($itemSub1['link']  ||  $itemSub1['id']): ?>
                                    <a
                                            <?php if($itemSub1['link']): ?>
                                                <?php if($SAAS): ?>
                                                    href="<?php echo \saas\server\classes\StoreAutologin::getAutologinUrl( $itemSub1['link'] ) ?>"
                                                <?php else:?>
                                                    href="<?php echo  $itemSub1['link']  ?>"
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if($itemSub1['id']): ?> id="<?php echo $itemSub1['id']; ?>" <?php endif; ?>
                                            <?php if($itemSub1['pjax']  != FALSE): ?> class="pjax" <?php endif; ?>>
                                        <?php echo  $itemSub1['text']  ?>
                                        <?php if($itemSub1['callback']): ?>
                                            <?php echo admin_menu\classes\MenuCallback::run( $itemSub1['callback'] ) ?>
                                        <?php endif; ?>
                                    </a>
                                <?php else:?>
                                    <a><?php echo  $itemSub1['text']  ?></a>
                                <?php endif; ?>

                            </li>

                            <?php if($itemSub1['divider']): ?>
                                <li class="divider"></li>
                            <?php endif; ?>

                        <?php }} ?>


                    </ul>
                </td>
            <?php }} ?>
        </tr>
        </tbody>
    </table>
</div>
<?php $mabilis_ttl=1432201353; $mabilis_last_modified=1426010500; //application/modules/admin_menu/assets/admin/menu.tpl ?>