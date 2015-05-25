<div class="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
    <div class="container">
        <ul class="items items-crumbs">
            <li class="btn-crumb">
                <a href="{site_url()}" typeof="v:Breadcrumb">
                    <span class="text-el">{lang('Главная', 'gallery')}<span class="divider">→</span></span>
                </a>
            </li>
            <li class="btn-crumb">
                <button href="{site_url()}" typeof="v:Breadcrumb" disabled="disabled">
                    <span class="text-el">{lang('Галерея', 'gallery')}</span>
                </button>
            </li>
        </ul>
    </div>
</div>
<div class="frame-inside without-crumbs">
    <div class="container">
        <h1>{lang('Галерея','gallery')}</h1>
        <h4>{lang('Категории','gallery')}:</h4>
        {if is_array($categories)}
            <ul class="items items-galleries">
                {foreach $categories as $category}     
                    <li>
                        <a href="{site_url('gallery/category/' . $category.id)}" class="frame-photo-title">
                            <span class="frame-title d_b"><span class="title">{$category.name}</span></span>
                        </a>
                        {if trim($category.description) != ''}
                            <div class="description" style="max-width: 150px; word-wrap: break-word;">
                                <span class="s-t">{lang('Описание','gallery')}:</span>
                                {$category.description}
                            </div>
                        {/if}
                    </li>
                {/foreach}
            </ul>
        {else:}
            <div class="msg">
                <div class="info">
                    {lang('There are no categories.','gallery')}.
                </div>
            </div>
        {/if}
        {if $albums}
            <div class="msg">
                <div class="info">
                    <a href="{site_url('gallery/albums/')}" class="frame-photo-title">
                        <span class="frame-title d_b"><span class="title">{lang('All albums','gallery')}</span></span>
                    </a>                
                </div>
            </div>
        {/if}
    </div>
</div>