<div class="row-category">
    <div class="t-a_c" >
        <span class="frame_label"> <span class="niceCheck b_n">
                <input name="ids" type="checkbox" value="{echo $cat->id}"/>
            </span>
        </span>
    </div>
    <div style="line-height: 24px;">
        <p>{echo $cat->id}</p>
    </div>
    <div class="share_alt" style="width: 26%;">
        <a href="{shop_url('category/'.$cat->url)}" class="go_to_site pull-right btn btn-small" data-rel="tooltip" data-placement="top" data-original-title="{lang('go to the website','admin')}" target="blank"><i class="icon-share-alt"></i></a>
        <div class="title lev">
            {if $cat->parent != '-'}
                <span class="simple_tree">↳</span> 
            {/if}
            
            {if $cat->hasChilds}
                <button type="button" class="btn btn-small my_btn_s"
                        style="display: none; " data-rel="tooltip"
                        data-placement="top" data-original-title="{lang('Collapse category','admin')}">
                    <i class="my_icon icon-minus"></i>
                </button>
                <button href="#cat{echo $cat->id}"
                        type="button"
                        class="btn btn-small my_btn_s btn-primary expandButton cat{echo $cat->id}"
                        data-rel="tooltip"
                        data-placement="top"
                        data-original-title="{lang('expand the category','admin')}"
                        onclick="ajaxLoadChildCategory(this,{echo $cat->id})">
                    <i class="my_icon icon-plus"></i>
                </button>
            {else:}
                <span class="folder-icons"></span>
            {/if}
            <a href="{$ADMIN_URL}categories/edit/{echo $cat->id}" class="pjax" data-rel="tooltip" data-placement="top" data-original-title="{lang('Edit category','admin')}">{echo $cat->name}</a>
        </div>
    </div>
    <div style="width: 22%;line-height: 24px;">{echo $cat->parent}</div>
    <div style="width: 26%;line-height: 24px;">
        <p>
            <a href="{shop_url('category/'.$cat->url)}" target="_blank" data-rel="tooltip" data-placement="top" data-original-title="{lang('go to the website','admin')}"> {echo $cat->url} </a>
        </p>
    </div>
    <div style="width: 8%;line-height: 24px;">
        <p>{echo $cat->myProdCnt}</p>
    </div>

    <div>
        <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('show','admin')}">
            <span class="prod-on_off cat_change_active{if !$cat->active} disable_tovar{/if}" data-id="{echo $cat->id}"></span>
        </div>
    </div>

</div>
