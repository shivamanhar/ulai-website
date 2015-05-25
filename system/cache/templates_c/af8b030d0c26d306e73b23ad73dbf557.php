<div class="content-footer">
    <div class="container">
        <div class="box-1">
            <div class="inside-padd">
                <div class="c_b f-w_b"><?php echo siteinfo('siteinfo_companytype')?> <?php echo date('Y')?></div>
                <div class="s-t"><?php echo lang ('Все права защищены', 'light'); ?></div>
            </div>
            <div class="engine"></div>
        </div>
        <div class="box-2">
            <div class="inside-padd">
                <div class="main-title"><?php echo lang ('Наши контакты','light'); ?></div>
                <ul class="nav nav-vertical">

                    <li>
                        <span class="f-s_0">
                            <span class="text-el"><?php echo siteinfo('siteinfo_mainphone')?></span>
                        </span>
                    </li>

                    <li>
                        <span class="f-s_0">
                            <span class="text-el"><?php echo siteinfo('Email')?></span>
                        </span>
                    </li>

                    <li>
                        <span class="f-s_0">
                            <span class="text-el">Skype:</span>
                            <span class="text-el"><?php echo siteinfo('Skype')?></span>
                        </span>
                    </li>

                    <li>
                        <span class="f-s_0">
                            <span class="text-el">icq:</span>
                            <span class="text-el"><?php echo siteinfo('icq')?></span>
                        </span>
                    </li>

                </ul>
            </div>

        </div>
        <div class="box-3">
            <div class="inside-padd">
                <div class="main-title"><?php echo lang ('Сайт','light'); ?></div>
                <ul class="nav nav-vertical">
                    <?php echo load_menu ('top_menu'); ?>
                </ul>
            </div>
        </div>
        <div class="box-4">
            <div class="inside-padd">
                <div class="main-title"><?php echo lang ('Продукция','light'); ?></div>
                <ul class="footer-category-menu nav nav-vertical">
                    <?php \Category\RenderMenu::create()->setConfig(array('cache'=>FALSE))->load('footer_category_menu')?>
                </ul>
            </div>
        </div>
        <div class="box-5">
            <div class="inside-padd">
                <div class="main-title"><?php echo lang ('Пользователь','light'); ?></div>
                <ul class="nav nav-vertical">
                    <?php if($is_logged_in): ?>
                        <li>
                            <button type="button" onclick="location = '<?php echo site_url ('auth/logout'); ?>'"
                                    title="<?php echo lang ('Выход','light'); ?>"><?php echo lang ('Выход','light'); ?></button>
                        </li>
                        <li>
                            <button type="button" onclick="location = '<?php echo site_url ('shop/profile'); ?>'"
                                    title="<?php echo lang ('Личный кабинет','light'); ?>"><?php echo lang ('Личный кабинет','light'); ?></button>
                        </li>
                        <li>
                            <button type="button" onclick="location = '<?php echo site_url ('wishlist'); ?>'"
                                    title="<?php echo lang ('Список желаний','light'); ?>"><?php echo lang ('Список желаний','light'); ?></button>
                        </li>
                    <?php else:?>
                        <li>
                            <button type="button" data-trigger="#loginButton"
                                    title="<?php echo lang ('Вход','light'); ?>"><?php echo lang ('Вход','light'); ?></button>
                        </li>
                        <li>
                            <button onclick="location = '<?php echo site_url ('auth/register'); ?>'"
                                    title="<?php echo lang ('Регистрация','light'); ?>"><?php echo lang ('Регистрация','light'); ?></button>
                        </li>
                    <?php endif; ?>
                    <?php if($compare = $CI->session->userdata('shopForCompare')): ?>
                        <?php $count = count($compare);?>
                        <?php if($count > 0): ?>
                            <li>
                                <button type="button" onclick="location = '<?php echo site_url ('shop/compare'); ?>'"
                                        title="<?php echo lang ('Список сравнений','light'); ?>"><?php echo lang ('Список сравнений','light'); ?></button>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li>
                        <button type="button" data-trigger="[data-drop='#ordercall']"
                                title="<?php echo lang ('Обратный звонок','light'); ?>"><?php echo lang ('Обратный звонок','light'); ?></button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/footer.tpl ?>