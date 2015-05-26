<!--Start. Top menu and authentication data block-->
<div class="content-header">
    <div class="container">
        <div class="header-left-content-header t-a_j">
            <!--        Logo-->
            <div class='contact-info' style='float: left; width: 33%;'>
                {widget('workday')}
            </div>
            <!--                Start. contacts block-->
            

            {if  $CI->uri->uri_string() == ''}
            <span class="logo" style='display: inline-block; width: 33%;'>
                <!-- <img src="{echo siteinfo('siteinfo_logo_url')}" alt="logo.png"/> -->
                <img src="{$THEME}images/header/logo.png" alt="logo.png" />
                <span style='color:red; margin-left:2px;'>Мы сделаем Ваш дом теплым и уютным</span> 
            </span>
            {else:}
            <a href="{site_url('')}" class="logo" style='display: inline-block; width: 33%;'>
                <!-- <img src="{echo siteinfo('siteinfo_logo_url')}" alt="logo.png"/> -->
                <img src="{$THEME}images/header/logo.png" alt="logo.png" />
                
            </a>
            <span style='color:red; margin-left:2px;'>Мы сделаем Ваш дом теплым и уютным</span> 
            {/if}
            <div class='phones-header-holder' style='float: right; width: 33%;'>
                <div class="phones-header">
                    <!-- <span class="f-s_0 d_b">
                        <span class="icon_phone_header"></span>
                        <span class="phone">
                            <span class="phone-number">{echo siteinfo('siteinfo_mainphone')}</span>
                        </span>
                    </span> -->
                    <div class="btn-order-call">
                        <button data-tab="true" data-drop="#ordercall" data-source="{site_url('shop/callback')}">
                            <!-- <span class="icon_order_call"></span> -->
                            <span class="text-el d_l" style='border-bottom:none; padding:0 12px;'>{lang('ЗАДАТЬ ВОПРОС','light')}</span>
                        </button>
                    </div>
                    <div class='btn-order-question'>
                        <span> dasdadas </span>
                    </div>
                </div>
                <div class="phones-header">
                    <!-- <span class="f-s_0 d_b">
                        <span class="icon_phone_header"></span>
                        <span class="phone">
                            <span class="phone-number">{echo siteinfo('siteinfo_mainphone')}</span>
                        </span>
                    </span> -->
                    <div class="btn-order-call">
                        <button data-tab="true" data-drop="#ordercall" data-source="{site_url('shop/callback')}">
                            <!-- <span class="icon_order_call"></span> -->
                            <span class="text-el d_l" style='border-bottom:none;'>{lang('ОСТАВИТЬ ЗАЯВКУ','light')}</span>
                        </button>
                    </div>
                </div>
            </div>
            <!--                End. Contacts block-->
            
        </div>
    </div>
</div>
{if strpos($CI->uri->uri_string, 'search') !== false}
{literal}
<script>
    $(document).on('scriptDefer', function() {
        var input = $('#inputString');
        input.setCursorPosition(input.val().length);
    });
</script>
{/literal}
{/if}
<div class="menu-header">
    <div class="container">
        <nav class="left-header f_l">
            <ul class="nav">
                {load_menu('top_menu')}
                <li class="see-all">
                    <button type="button" data-drop=".drop-hided-li" data-place="noinherit" data-overlay-opacity="0">
                        <span class="text-el">{lang('Еще', 'light')}</span>
                        <span class="icon-seeall"></span>
                    </button>
                    <div class="drop drop-hided-li">
                        <div class="inside-padd">
                            <ul class="nav nav-profile nav-vertical">

                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="right-header f_r">
            {include_shop_tpl('auth_data')}
        </div>
    </div>
</div>

<!-- <div class="frame-search-cleaner"> -->
                <!--                Start. Include cart data template-->

                <!--                    End. Include cart data template-->
                <!--                Start. Show search form-->
                <!-- <div class="frame-search-form">
                    <div class="p_r">
                        <form name="search" method="get" action="{shop_url('search')}">
                            <span class="btn-search">
                                <button type="submit"><span class="icon_search"></span><span class="text-el">{lang('Найти','light')}</span></button>
                            </span>
                            <div class="frame-search-input">
                                <input type="text" class="input-search" id="inputString" name="text" autocomplete="off" value="{if strpos($CI->uri->uri_string, 'search') !== false}{htmlspecialchars($_GET['text'])}{/if}"  placeholder="{lang('Я ищу', 'light')}&hellip;"/>
                                <div id="suggestions" class="drop drop-search"></div>
                            </div>
                        </form>
                    </div>
                </div> -->
                <!--                End. Show search form-->
<!--             </div> -->
<!--End. Top menu and authentication data block-->
