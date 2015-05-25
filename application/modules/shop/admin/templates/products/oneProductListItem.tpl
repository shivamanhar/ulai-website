<tr data-id="{echo $model->getId()}" class="simple_tr dasdas">
    <td class="t-a_c">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox" name="ids" value="{echo $model->getId()}"
                                                   data-id="{echo $model->getId()}"/>
                                        </span>
                                    </span>
    </td>
    <td><p>{echo $model->getId()}</p></td>
    <td class="share_alt">
        <a href="/shop/product/{echo $model->getUrl()}"
           target="_blank"
           class="go_to_site pull-right btn btn-small"
           data-rel="tooltip"
           data-placement="top"
           data-original-title="{lang('Show on site','admin')}">
            <i class="icon-share-alt"></i>
        </a>

        <div class="a-photo-out">
            <a href="/admin/components/run/shop/products/edit/{echo $model->getId()}{$_SESSION['ref_url']}"
               class="pjax title"
               data-rel="tooltip"
               data-title="{lang('Edit product','admin')}">
                                            <span class="photo-block">
                                                <span class="helper"></span>
                                                {if $model->getfirstvariant()->getSmallPhoto()}
                                                    <img src="{site_url($model->getfirstvariant()->getSmallPhoto())}">





                                                                                                                                                                                                                                                                                                                                        {else:}





                                                    <img src="{$THEME}images/select-picture.png" class="img-polaroid">
                                                {/if}
                                            </span>
                <span class="text-el">{truncate(ShopCore::encode($model->getName()),100)}</span>
            </a>
            {if $model->getBrand()}
                <div class="category-list-brand">
                    <a href="/admin/components/run/shop/brands/edit/{echo $model->getBrand()->getId()}"
                       class="pjax title t-d_n"
                       data-rel="tooltip"
                       data-title="{lang('Edit brand','admin')}">
                        <span class="">{echo $model->getBrand()->getName()}</span>
                    </a>
                </div>
            {/if}
        </div>
    </td>
    <td class="share_alt">
        <a href="/shop/category/{echo $model->getMainCategory()->getFullPath()}"
           target="_blank"
           class="go_to_site pull-right btn btn-small"
           data-rel="tooltip"
           data-placement="top"
           data-original-title="{lang('Show on site','admin')}">
            <i class="icon-share-alt"></i>
        </a>

        <div class="o_h">
            <a href="{$ADMIN_URL}categories/edit/{echo $model->getMainCategory()->getId()}"
               class="pjax"
               data-rel="tooltip"
               data-title="{lang('Edit category','admin')}">
                {echo $model->getMainCategory()->getName()}
            </a>
        </div>
    </td>
    <td>
        <p>{echo $model->firstVariant->getNumber()}</p>
    </td>
    <td>
        <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top"
             data-original-title="{lang('show','admin')}">
            {if $model->getActive() == true}
                <span class="prod-on_off" data-id="{echo $model->getId()}"></span>
            {else:}
                <span class="prod-on_off disable_tovar" data-id="{echo $model->getId()}"></span>
            {/if}
        </div>
    </td>
    <td>
        {if $model->getHit() == true}
            <button type="button" data-id="{echo $model->getId()}"
                    class="btn btn-small btn-primary active {if $model->getActive() != true} disabled{/if} setHit"
                    data-rel="tooltip" data-placement="top" data-original-title="{lang('Hit','admin')}"><i
                        class="icon-fire"></i></button>
        {else:}
            <button type="button" data-id="{echo $model->getId()}"
                    class="btn btn-small {if $model->getActive() != true} disabled{/if} setHit" data-rel="tooltip"
                    data-placement="top" data-original-title="{lang('Hit','admin')}"><i class="icon-fire"></i></button>
        {/if}

        {if $model->getHot() == true}
            <button type="button" data-id="{echo $model->getId()}"
                    class="btn btn-small btn-primary active {if $model->getActive() != true} disabled{/if} setHot"
                    data-rel="tooltip" data-placement="top" data-original-title="{lang('Novelty','admin')}"><i
                        class="icon-gift"></i></button>
        {else:}
            <button type="button" data-id="{echo $model->getId()}"
                    class="btn btn-small {if $model->getActive() != true} disabled{/if} setHot" data-rel="tooltip"
                    data-placement="top" data-original-title="{lang('Novelty','admin')}"><i class="icon-gift"></i>
            </button>
        {/if}

        {if $model->getAction() == true}
            <button type="button" data-id="{echo $model->getId()}"
                    class="btn btn-small btn-primary active {if $model->getActive() != true} disabled{/if} setAction"
                    data-rel="tooltip" data-placement="top" data-original-title="{lang('Promotion','admin')}"><i
                        class="icon-star"></i></button>
        {else:}
            <button type="button" data-id="{echo $model->getId()}"
                    class="btn btn-small {if $model->getActive() != true} disabled{/if} setAction" data-rel="tooltip"
                    data-placement="top" data-original-title="{lang('Promotion','admin')}"><i class="icon-star"></i>
            </button>
        {/if}
    </td>
    <td>
        <span class="pull-right">
            <span
                    class="neigh_form_field help-inline"></span>&nbsp;&nbsp;{echo ShopCore::app()->SCurrencyHelper->getSymbolById($model->firstVariant->getCurrency())}</span>

        <div class="p_r o_h frame_price number">
            <input type="text"
                   value="{echo rtrim(number_format($model->firstVariant->getPriceInMain(), 5, ".", ""),'0.')}"
                   class="js_price"
                   data-value="{echo number_format($model->firstVariant->getPriceInMain(), 5, ".", "")}">
            <button class="btn btn-small refresh_price"
                    data-id="{echo $model->getId()}"
                    type="button">
                <i class="icon-refresh"></i>
            </button>
        </div>
    </td>
</tr>