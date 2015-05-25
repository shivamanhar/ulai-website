<div class="frame-crumbs">
    {widget('path')}
</div>
<div class="frame-inside page-text">
    <div class="container">
            <h1>{echo encode($category.name)}</h1>
            {$CI->load->module('banners')->render($category.id)}
            {if $pages == NULL}
                {lang('Категория на стадии разработки', 'light')}
            {else:}
                <ul class="items items-text-category">
                    {foreach $pages as $p}
                        <li>
                            <a href="{site_url('')}{$p.cat_url}{$p.url}" class="frame-photo-title {if $p.field_field_img}is-img{/if}">
                                {if $p.field_field_img}
                                    <span class="photo-block">
                                        <span class="helper"></span>
                                        <img src="{$p.field_field_img}" alt="" />
                                    </span>
                                {/if}
                                <span class="d_b">
                                    <span class="date f-s_0 d_b">
                                        <span class="icon_time"></span><span class="text-el"></span>
                                        <span class="day">{echo date("d", $p.publish_date)} </span>
                                        <span class="month">{echo month(date("n", $p.publish_date))} </span>
                                        <span class="year">{echo date("Y ", $p.publish_date)}</span>
                                    </span>
                                    <span class="title">{$p.title}</span>
                                </span>
                            </a>
                            <div class="description">
                                {$p.prev_text}
                            </div>
                        </li>
                    {/foreach}
                </ul>
                {$pagination}
            {/if}
    </div>
</div>
