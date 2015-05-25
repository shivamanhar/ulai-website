<div class="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
    <div class="container">
        <ul class="items items-crumbs">
            <li class="btn-crumb">
                <a href="{site_url()}" typeof="v:Breadcrumb">
                    <span class="text-el">{lang('Главная', 'gallery')}<span class="divider">→</span></span>
                </a>
            </li>
            <li class="btn-crumb">
                <a href="{site_url('gallery')}" typeof="v:Breadcrumb">
                    <span class="text-el">{lang('Галерея', 'gallery')}<span class="divider">→</span></span>
                </a>
            </li>

            {if strstr($_SERVER['HTTP_REFERER'], 'albums')}
                <li class="btn-crumb">
                    <a href="{site_url('gallery/albums')}/{$current_category.id}" typeof="v:Breadcrumb">
                        <span class="text-el">{lang('All albums','gallery')}<span class="divider">→</span></span>
                    </a>
                </li>
            {else:}
                <li class="btn-crumb">
                    <a href="{site_url('gallery/category')}/{$current_category.id}" typeof="v:Breadcrumb">
                        <span class="text-el">{$current_category.name}<span class="divider">→</span></span>
                    </a>
                </li>
            {/if}


            <li class="btn-crumb">
                <button href="{site_url('gallery')}" typeof="v:Breadcrumb" disabled="disabled">
                    <span class="text-el">{$album.name}</span>
                </button>
            </li>
        </ul>
    </div>
</div>
<div class="frame-inside without-crumbs">
    <div class="container">
        <h1>{$album.name}</h1>

        <div class="frame-gallery">
            <ul class="items items-photo-galery">
                {foreach $album.images as $image}
                    <li>
                        <a href="{site_url($album_url . $image.full_name)}" class="photo-block" rel="group">
                            <img src="{site_url($thumb_url . $image.full_name)}"
                                 alt="{strip_tags($image.description)}"/>
                        </a>
                        {if trim($image.description) != ''}
                            <div class="description">{$image.description}</div>
                        {/if}
                    </li>
                {/foreach}
            </ul>
        </div>
    </div>
</div>