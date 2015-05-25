<div class="content-footer">
    <div class="container">
        <div class="box-1">
            <div class="inside-padd">
                <div class="c_b f-w_b">{echo siteinfo('siteinfo_companytype')} {echo date('Y')}</div>
                <div class="s-t">{lang('Все права защищены', 'light')}</div>
            </div>
            <div class="engine"></div>
        </div>
        <div class="box-2">
            <div class="inside-padd">
                <div class="main-title">{lang('Наши контакты','light')}</div>
                <ul class="nav nav-vertical">

                    <li>
                        <span class="f-s_0">
                            <span class="text-el">{echo siteinfo('siteinfo_mainphone')}</span>
                        </span>
                    </li>

                    <li>
                        <span class="f-s_0">
                            <span class="text-el">{echo siteinfo('Email')}</span>
                        </span>
                    </li>

                    <li>
                        <span class="f-s_0">
                            <span class="text-el">Skype:</span>
                            <span class="text-el">{echo siteinfo('Skype')}</span>
                        </span>
                    </li>

                    <li>
                        <span class="f-s_0">
                            <span class="text-el">icq:</span>
                            <span class="text-el">{echo siteinfo('icq')}</span>
                        </span>
                    </li>

                </ul>
            </div>

        </div>
        <div class="box-3">
            <div class="inside-padd">
                <div class="main-title">{lang('Сайт','light')}</div>
                <ul class="nav nav-vertical">
                    {load_menu('top_menu')}
                </ul>
            </div>
        </div>
        <div class="box-4">
            <div class="inside-padd">
                <div class="main-title">{lang('Продукция','light')}</div>
                <ul class="footer-category-menu nav nav-vertical">
                    {\Category\RenderMenu::create()->setConfig(array('cache'=>FALSE))->load('footer_category_menu')}
                </ul>
            </div>
        </div>
        <div class="box-5">
            <div class="inside-padd">
                <div class="main-title">{lang('Пользователь','light')}</div>
                <ul class="nav nav-vertical">
                    {if $is_logged_in}
                        <li>
                            <button type="button" onclick="location = '{site_url('auth/logout')}'"
                                    title="{lang('Выход','light')}">{lang('Выход','light')}</button>
                        </li>
                        <li>
                            <button type="button" onclick="location = '{site_url('shop/profile')}'"
                                    title="{lang('Личный кабинет','light')}">{lang('Личный кабинет','light')}</button>
                        </li>
                        <li>
                            <button type="button" onclick="location = '{site_url('wishlist')}'"
                                    title="{lang('Список желаний','light')}">{lang('Список желаний','light')}</button>
                        </li>
                    {else:}
                        <li>
                            <button type="button" data-trigger="#loginButton"
                                    title="{lang('Вход','light')}">{lang('Вход','light')}</button>
                        </li>
                        <li>
                            <button onclick="location = '{site_url('auth/register')}'"
                                    title="{lang('Регистрация','light')}">{lang('Регистрация','light')}</button>
                        </li>
                    {/if}
                    {if $compare = $CI->session->userdata('shopForCompare')}
                        {$count = count($compare);}
                        {if $count > 0}
                            <li>
                                <button type="button" onclick="location = '{site_url('shop/compare')}'"
                                        title="{lang('Список сравнений','light')}">{lang('Список сравнений','light')}</button>
                            </li>
                        {/if}
                    {/if}
                    <li>
                        <button type="button" data-trigger="[data-drop='#ordercall']"
                                title="{lang('Обратный звонок','light')}">{lang('Обратный звонок','light')}</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>