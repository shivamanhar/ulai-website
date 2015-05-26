<!--Start. Top menu and authentication data block-->
<div class="content-header">
    <div class="container">
        <div class="header-left-content-header t-a_j">
            <!--        Logo-->
            <div class='contact-info' style='float: left; width: 33%;'>
                <?php echo widget ('workday'); ?>
            </div>
            <!--                Start. contacts block-->
            

            <?php if($CI->uri->uri_string() == ''): ?>
            <span class="logo" style='display: inline-block; width: 33%;'>
                <!-- <img src="<?php echo siteinfo('siteinfo_logo_url')?>" alt="logo.png"/> -->
                <img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/header/logo.png" alt="logo.png" />
                <span style='color:red; margin-left:2px;'>Мы сделаем Ваш дом теплым и уютным</span> 
            </span>
            <?php else:?>
            <a href="<?php echo site_url (''); ?>" class="logo" style='display: inline-block; width: 33%;'>
                <!-- <img src="<?php echo siteinfo('siteinfo_logo_url')?>" alt="logo.png"/> -->
                <img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/header/logo.png" alt="logo.png" />
                
            </a>
            <span style='color:red; margin-left:2px;'>Мы сделаем Ваш дом теплым и уютным</span> 
            <?php endif; ?>
            <div class='phones-header-holder' style='float: right; width: 33%;'>
                <div class="phones-header">
                    <!-- <span class="f-s_0 d_b">
                        <span class="icon_phone_header"></span>
                        <span class="phone">
                            <span class="phone-number"><?php echo siteinfo('siteinfo_mainphone')?></span>
                        </span>
                    </span> -->
                    <div class="btn-order-call">
                        <button data-tab="true" data-drop="#ordercall" data-source="<?php echo site_url ('shop/callback'); ?>">
                            <!-- <span class="icon_order_call"></span> -->
                            <span class="text-el d_l" style='border-bottom:none; padding:0 12px;'><?php echo lang ('ЗАДАТЬ ВОПРОС','light'); ?></span>
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
                            <span class="phone-number"><?php echo siteinfo('siteinfo_mainphone')?></span>
                        </span>
                    </span> -->
                    <div class="btn-order-call">
                        <button data-tab="true" data-drop="#ordercall" data-source="<?php echo site_url ('shop/callback'); ?>">
                            <!-- <span class="icon_order_call"></span> -->
                            <span class="text-el d_l" style='border-bottom:none;'><?php echo lang ('ОСТАВИТЬ ЗАЯВКУ','light'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
            <!--                End. Contacts block-->
            
        </div>
    </div>
</div>
<?php if(strpos($CI->uri->uri_string, 'search') !== false): ?>
<script>
    $(document).on('scriptDefer', function() {
        var input = $('#inputString');
        input.setCursorPosition(input.val().length);
    });
</script>

<?php endif; ?>
<div class="menu-header">
    <div class="container">
        <nav class="left-header f_l">
            <ul class="nav">
                <?php echo load_menu ('top_menu'); ?>
                <li class="see-all">
                    <button type="button" data-drop=".drop-hided-li" data-place="noinherit" data-overlay-opacity="0">
                        <span class="text-el"><?php echo lang ('Еще', 'light'); ?></span>
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
            <?php $this->include_shop_tpl('auth_data', '/var/www/templates/light'); ?>
        </div>
    </div>
</div>

<!-- <div class="frame-search-cleaner"> -->
                <!--                Start. Include cart data template-->

                <!--                    End. Include cart data template-->
                <!--                Start. Show search form-->
                <!-- <div class="frame-search-form">
                    <div class="p_r">
                        <form name="search" method="get" action="<?php echo shop_url ('search'); ?>">
                            <span class="btn-search">
                                <button type="submit"><span class="icon_search"></span><span class="text-el"><?php echo lang ('Найти','light'); ?></span></button>
                            </span>
                            <div class="frame-search-input">
                                <input type="text" class="input-search" id="inputString" name="text" autocomplete="off" value="<?php if(strpos($CI->uri->uri_string, 'search') !== false): ?><?php echo htmlspecialchars ($_GET['text']); ?><?php endif; ?>"  placeholder="<?php echo lang ('Я ищу', 'light'); ?>&hellip;"/>
                                <div id="suggestions" class="drop drop-search"></div>
                            </div>
                        </form>
                    </div>
                </div> -->
                <!--                End. Show search form-->
<!--             </div> -->
<!--End. Top menu and authentication data block-->
<?php $mabilis_ttl=1432714922; $mabilis_last_modified=1432628897; ///var/www/templates/light/header.tpl ?>