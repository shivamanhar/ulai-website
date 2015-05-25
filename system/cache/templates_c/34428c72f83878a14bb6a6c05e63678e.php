<!-- php vars to js -->
<?php if($is_logged_in == '1'): ?>
    <?php $is_logged_in = 1?>
    <?php $wish_list = $CI->load->module('wishlist')?>
    <?php $countWL = $wish_list->getUserWishListItemsCount($CI->dx_auth->get_user_id())?>
<?php else:?>
    <?php $is_logged_in = 0?>
    <?php $countWL = 0?>
<?php endif; ?>
<?php $cart = \Cart\BaseCart::getInstance()->getItems('SProducts')?>
<?php if(count($cart['data']) > 0): ?>
    <?php if(is_true_array($cart['data'])){ foreach ($cart['data'] as $item){ ?>
        <?php $arrCartId[] = $item->id?>
    <?php }} ?>
<?php endif; ?>
<?php $countSh = getProductViewsCount()?>
<?php $openLevels = getOpenLevels()?>
<?php if($openLevels): ?>
    <?php if($openLevels == 'all'): ?>
        <?php $menuClass = 'col'?>
    <?php else:?>
        <?php $menuClass = 'row'?>
    <?php endif; ?>
<?php else:?>
    <?php $menuClass = 'row'?>
<?php endif; ?>
<script type="text/javascript">
    <?php if($comp = $CI->session->userdata('shopForCompare')): ?>
        <?php $cnt_comp = count($comp)?>
    <?php else:?>
        <?php $cnt_comp = 0?>
    <?php endif; ?>
    var curr = '<?php if(isset($CS)){ echo $CS; } ?>',
            cartItemsProductsId = <?php echo json_encode($arrCartId)?>,
            nextCs = '<?php echo $NextCS?>',
            nextCsCond = nextCs == '' ? false : true,
            pricePrecision = parseInt('<?php echo ShopCore::app()->SSettings->pricePrecision?>'),
            checkProdStock = "<?php echo ShopCore::app()->SSettings->ordersCheckStocks?>", //use in plugin plus minus
            inServerCompare = parseInt("<?php if(isset($cnt_comp)){ echo $cnt_comp; } ?>"),
            inServerWishList = parseInt("<?php if(isset($countWL)){ echo $countWL; } ?>"),
            countViewProd = parseInt("<?php if(isset($countSh)){ echo $countSh; } ?>"),
            theme = "<?php if(isset($THEME)){ echo $THEME; } ?>",
            siteUrl = "<?php echo site_url()?>",
            colorScheme = "<?php if(isset($colorScheme)){ echo $colorScheme; } ?>",
            isLogin = "<?php if(isset($is_logged_in)){ echo $is_logged_in; } ?>" === '1' ? true : false,
            typePage = "<?php echo $CI->core->core_data['data_type']; ?>",
            typeMenu = "<?php if(isset($menuClass)){ echo $menuClass; } ?>";
        text = {
            search: function(text) {
                return '<?php echo lang ("Введите более", 'light'); ?>' + ' ' + text + ' <?php echo lang ("символов", 'light'); ?>';
                        },
                        error: {
                            notLogin: '<?php echo lang ("В список желаний могут добавлять только авторизированные пользователи", 'light'); ?>',
                                        fewsize: function(text) {
                                            return '<?php echo lang ("Выберете размер меньше или равно", 'light'); ?>' + ' ' + text + ' <?php echo lang ("пикселей", 'light'); ?>';
                                                        },
                                                        enterName: '<?php echo lang ("Введите название", 'light'); ?>'
                                                                }
                                                            }
    
        text.inCart = '<?php echo lang ('В корзине','light'); ?>';
        text.pc = '<?php echo lang ('шт','light'); ?>.';
        text.quant = '<?php echo lang ('Кол-во','light'); ?>:';
        text.sum = '<?php echo lang ('Сумма','light'); ?>:';
        text.toCart = '<?php echo lang ('Купить','light'); ?>';
        text.pcs = '<?php echo lang ('Количество:'); ?>';
        text.kits = '<?php echo lang ('Комплектов:'); ?>';
        text.captchaText = '<?php echo lang ('Код протекции'); ?>';
        text.plurProd = ['<?php echo lang ("товар",'light'); ?>', "<?php echo lang ("товара",'light'); ?>", '<?php echo lang ("товаров",'light'); ?>'];
        text.plurKits = ['<?php echo lang ("набор",'light'); ?>', "<?php echo lang ("набора",'light'); ?>", '<?php echo lang ("наборов",'light'); ?>'];
        text.plurComments = ['<?php echo lang ("отзыв",'light'); ?>', '<?php echo lang ("отзыва",'light'); ?>', '<?php echo lang ("отзывов",'light'); ?>'];
</script>
<?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/config.js.tpl ?>