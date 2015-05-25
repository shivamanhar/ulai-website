<div class="frame-bask-person clearfix">
    <ul class="nav nav-enter-reg">
        <?php if(!$CI->dx_auth->is_logged_in()): ?>
        <li class="btn-enter">
            <button type="button"
            id="loginButton"
            data-drop=".drop-enter"
            data-source="<?php echo site_url ('auth'); ?>"
            class="ref t-d_n"
            >
            <span class="icon_enter"></span>
            <span class="text-el"><?php echo lang ('Вход','light'); ?></span>
        </button>
    </li>
    <!--Else show link for personal cabinet -->
    <?php else:?>
    <li class="btn-personal-area">
        <button type="button" data-drop=".drop-profile" data-place="noinherit" data-overlay-opacity="0">
            <span class="text-el ref t-d_n"><?php echo lang ('Личный кабинет','light'); ?></span>
            <span class="icon_arrow_b"></span>
        </button>
        <div class="drop drop-style3 drop-profile">
            <div class="inside-padd">
                <nav>
                    <ul class="nav nav-profile nav-vertical">
                        <li><a href="<?php echo site_url ('/shop/profile/#my_data'); ?>"><?php echo lang ('Основные данные', 'light'); ?></a></li>
                        <li><a href="<?php echo site_url ('/shop/profile/#change_pass'); ?>"><?php echo lang ('Изменить пароль', 'light'); ?></a></li>
                        <li><a href="<?php echo site_url ('/shop/profile/#history_order'); ?>"><?php echo lang ('История заказа', 'light'); ?></a></li>
                        <li>
                            <button type="button" onclick="ImageCMSApi.formAction('/auth/authapi/logout', '',{'durationHideForm': 0, callback: function(msg, status, form, DS) {
                            if (status) {
                            localStorage.removeItem('wishList');
                        }
                    }});
                    return false;">
                    <span class="text-el"><?php echo lang ('Выйти','light'); ?></span>
                </button>
            </li>
        </ul>
    </nav>
</div>
</div>
</li>
<?php endif; ?>
</ul>
<div id="tinyBask" class="frame-cleaner">
    <?php $this->include_tpl('cart_data', '/var/www/templates/light/shop'); ?>
</div>
</div><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/auth_data.tpl ?>