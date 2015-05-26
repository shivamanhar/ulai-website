<?php /*
    /**
    * @main.tpl - template for displaying shop main page
    * Variables
    *   $site_title: variable for insert site title
    *   $canonical: variable for insert canonical
    *   $site_description: variable for insert site description
    *   $THEME: variable for template path
    *   $site_keywords : variable for insert site keywords
    *   $content : variable for insert content of page
    */?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title><?php if(isset($site_title)){ echo $site_title; } ?></title>
        <meta name="description" content="<?php if(isset($site_description)){ echo $site_description; } ?>" />
        <meta name="keywords" content="<?php if(isset($site_keywords)){ echo $site_keywords; } ?>" />
        <meta name="generator" content="ImageCMS" />
        <meta name = "format-detection" content = "telephone=no" />

        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/style.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?><?php if(isset($colorScheme)){ echo $colorScheme; } ?>/colorscheme.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?><?php if(isset($colorScheme)){ echo $colorScheme; } ?>/color.css" media="all" />

        <?php if($CI->uri->segment(1) == MY_Controller::getCurrentLocale()): ?>
        <?php $lang = '/' . \MY_Controller::getCurrentLocale()?>
        <?php else:?>
        <?php $lang = ''?>
        <?php endif; ?>
        <?php if($CI->uri->segment(2) == 'profile' || $CI->uri->segment(1) == 'wishlist'): ?>
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW" />
        <?php endif; ?>
        <script type="text/javascript">
        var locale = "<?php echo $lang?>";
        </script>
        <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/jquery-1.8.3.min.js"></script>
        <?php $this->include_tpl('config.js', '/var/www/templates/light'); ?>
        <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/settings.js"></script>
        <!--[if lte IE 9]><script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/lte_ie_8.css" /><![endif]-->
        <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>css/ie_7.css" />
            <script src="<?php if(isset($THEME)){ echo $THEME; } ?>js/localStorageJSON.js"></script>
            <![endif]-->

            <link rel="icon" href="<?php echo siteinfo('siteinfo_favicon_url')?>" type="image/x-icon" />
            <link rel="shortcut icon" href="<?php echo siteinfo('siteinfo_favicon_url')?>" type="image/x-icon" />
        </head>
        <body class="is<?php echo $agent[0]?> not-js <?php echo $CI->core->core_data['data_type']; ?>">
            <?php $this->include_tpl('language/jsLangsDefine.tpl', '/var/www/templates/light'); ?>
            <?php $this->include_tpl('language/jsLangs.tpl', '/var/www/templates/light'); ?>
            <div class="main-body">
                <div class="fon-header">
                    <header>
                        <?php $this->include_tpl('header', '/var/www/templates/light'); ?>
                    </header>

                    <?php if(!strpos($CI->uri->uri_string, '/cart')): ?>
                    <div class="frame-menu-main horizontal-menu">
                        <?php \Category\RenderMenu::create()->setConfig(array('cache'=>TRUE))->load('category_menu')?>
                    </div>
                    <?php else:?>
                    <div class="container menu-border"></div>
                    <?php endif; ?>
                </div>
                <div class="content">
                    <?php if(isset($content)){ echo $content; } ?>
                </div>
                <div class="h-footer"></div>
            </div>
            <footer>
                <?php $this->include_tpl('footer', '/var/www/templates/light'); ?>
            </footer>
            <?php $this->include_tpl('user_toolbar', '/var/www/templates/light'); ?>

            <?php /*?>Start. delete before upload to server<?php */?>
            <?php /*?>
            <!-- scripts -->
            <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/_united_side_plugins.js"></script>
            <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/_plugins.js"></script>
            <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/drop_extend_methods.js"></script>
            <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/_shop.js"></script>
            <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/_global_vars_objects.js"></script>
            <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/_functions.js"></script>
            <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/_scripts.js"></script>
            <!-- scripts end -->
            <script type="text/javascript">
            $(window).load(function() {
                init();
                setTimeout(function() {
                    $(document).trigger({type: 'scriptDefer'})
                }, 0)
            })
            </script>
            
            <?php */?>
            <?php /*?>End. delete before upload to server<?php */?>
            <?php /*fancybox?>
            <link rel="stylesheet" type="text/css" href="<?php if(isset($THEME)){ echo $THEME; } ?>js/fancybox/jquery.fancybox-1.3.4.css" media="all" />
            <script type="text/javascript" src="<?php if(isset($THEME)){ echo $THEME; } ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
            <?php end. fancybox*/?>

            <?php /*?>uncomment before opload to server and combine and minimize scripts (in comment <!-- scripts -->...<!-- scripts end -->) into united_scripts file<?php */?>
            <?php /*?> Start. uncoment before development <?php */?>

            <script type="text/javascript">
            initDownloadScripts(['united_scripts'], 'init', 'scriptDefer');
            </script>

            <?php /*?> End. uncoment before development <?php */?>
            <?php $this->include_shop_tpl('js_templates', '/var/www/templates/light'); ?>
        </body>
        </html>
        <?php $mabilis_ttl=1432714922; $mabilis_last_modified=1426010500; ///var/www/templates/light/shop/../main.tpl ?>