<div class="frame-inside page-404">
    <div class="container">
        <div class="content">
            <img src="<?php if(isset($THEME)){ echo $THEME; } ?><?php if(isset($colorScheme)){ echo $colorScheme; } ?>/images/404.png"/>
            <div class="description">
                <?php if(isset($error)){ echo $error; } ?>
                <div class="title"><?php echo lang ('404 / Страница не найдена','light'); ?></div>
                <p><b><?php echo lang ('Эта страница не существует или была удалена.','light'); ?></b></p>
                <hr/>
                <p><?php echo lang ('Приносим свои извинения за доставленные неудобства. Для продолжения работы вы можете перейти к представленным пунктам меню, воспользоваться поиском по сайту либо перейти на главную страницу','light'); ?>
                <div class="btn-buy btn-buy-p">
                    <a href="<?php echo site_url (); ?>"><span class="text-el"><?php echo lang ('Главная страница','light'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        $(document).on('ready', function() {
            $('footer').css({'z-index': 1, 'position': 'relative'});
        });
    </script>
<?php $mabilis_ttl=1432206879; $mabilis_last_modified=1426010500; ///var/www/templates/light/404.tpl ?>