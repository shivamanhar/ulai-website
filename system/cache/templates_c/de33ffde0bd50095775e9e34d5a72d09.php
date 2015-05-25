<?php if(count($recent_news) > 0): ?>
    <div class="frame-news">
        <div class="frame-title">
            <div class="title"><a href="<?php echo site_url ('novosti'); ?>"><?php echo lang ('Статьи, новости и акции','light'); ?></a></div>
        </div>
        <ul class="items items-news">
            <?php if(is_true_array($recent_news)){ foreach ($recent_news as $item){ ?>
                <?php $item = $CI->load->module('cfcm')->connect_fields($item, 'page')?>
                <li>
                    <a href="<?php echo site_url ( $item['full_url'] ); ?>" class="frame-photo-title">
                        <?php if(trim( $item['field_list_image'] ) != ""): ?>
                            <span class="photo-block">
                                <span class="helper"></span>
                                <img src="<?php echo $item['field_list_image']; ?>" alt="" />
                            </span>
                        <?php endif; ?>
                        <span class="title"><?php echo $item['title']; ?></span>
                    </a>
                    <div class="description<?php if(trim( $item['field_list_image'] ) != ""): ?> neigh-photo-block<?php endif; ?>">
                        <?php echo $item['prev_text']; ?>
                        <?php if(trim( $item['field_info'] ) != ""): ?>
                            <div class="info"><?php echo $item['field_info']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="date f-s_0<?php if(trim( $item['field_list_image'] ) != ""): ?> neigh-photo-block<?php endif; ?>">
                        <span class="icon_time"></span><span class="text-el"></span>
                        <span class="day"><?php echo date("d",  $item['publish_date'] ) ?> </span>
                        <span class="month"><?php echo month(date("n",  $item['publish_date'] )) ?> </span>
                        <span class="year"><?php echo date("Y ",  $item['publish_date'] ) ?></span>
                    </div>
                </li>
            <?php }} ?>
        </ul>
    </div>
<?php endif; ?><?php $mabilis_ttl=1432201437; $mabilis_last_modified=1426010500; ///var/www/templates/light/widgets/latest_news.tpl ?>