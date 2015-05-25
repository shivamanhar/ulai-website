<div class="frame-bask-person clearfix">
    <ul class="nav nav-enter-reg">
        {if !$CI->dx_auth->is_logged_in()}
        <li class="btn-enter">
            <button type="button"
            id="loginButton"
            data-drop=".drop-enter"
            data-source="{site_url('auth')}"
            class="ref t-d_n"
            >
            <span class="icon_enter"></span>
            <span class="text-el">{lang('Вход','light')}</span>
        </button>
    </li>
    <!--Else show link for personal cabinet -->
    {else:}
    <li class="btn-personal-area">
        <button type="button" data-drop=".drop-profile" data-place="noinherit" data-overlay-opacity="0">
            <span class="text-el ref t-d_n">{lang('Личный кабинет','light')}</span>
            <span class="icon_arrow_b"></span>
        </button>
        <div class="drop drop-style3 drop-profile">
            <div class="inside-padd">
                <nav>
                    <ul class="nav nav-profile nav-vertical">
                        <li><a href="{site_url('/shop/profile/#my_data')}">{lang('Основные данные', 'light')}</a></li>
                        <li><a href="{site_url('/shop/profile/#change_pass')}">{lang('Изменить пароль', 'light')}</a></li>
                        <li><a href="{site_url('/shop/profile/#history_order')}">{lang('История заказа', 'light')}</a></li>
                        <li>
                            <button type="button" onclick="ImageCMSApi.formAction('/auth/authapi/logout', '', {literal}{'durationHideForm': 0, callback: function(msg, status, form, DS) {
                            if (status) {
                            localStorage.removeItem('wishList');
                        }
                    }}{/literal});
                    return false;">
                    <span class="text-el">{lang('Выйти','light')}</span>
                </button>
            </li>
        </ul>
    </nav>
</div>
</div>
</li>
{/if}
</ul>
<div id="tinyBask" class="frame-cleaner">
    {include_tpl('cart_data')}
</div>
</div>