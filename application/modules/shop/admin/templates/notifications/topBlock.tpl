<a href="/admin/components/run/shop/orders/index?status_id=1" class="btn-quick-access pjax">
    <span class="frame-icon">
        <i class="icon-bask{if $totalNewOrders} active{/if}">
            {if $totalNewOrders}<span class="badge badge-important">{echo $totalNewOrders}</span>{/if}
        </i>
    </span>
    <span class="text-el">{lang('Orders','admin')}</span>
</a>
<a href="/admin/components/cp/comments" class="btn-quick-access pjax">
    <span class="frame-icon">
        <i class="icon-comment_head{if $totalNewComments} active{/if}">
            {if  $totalNewComments} <span class="badge badge-important">{echo $totalNewComments}</span>  {/if}
        </i>
    </span>
    <span class="text-el">{lang("Comments","admin")}</span>
</a>
<a href="/admin/components/run/shop/search/index?WithoutImages=1" class="btn-quick-access pjax">
    <span class="frame-icon">
        <i class="icon-report_exists{if $toralProductsWithoutImage} active{/if}">
            {if $toralProductsWithoutImage}<span class="badge badge-important">{echo $toralProductsWithoutImage}</span>{/if}
        </i>
    </span>
    <span class="text-el">{lang("No photo","admin")}</span>
</a>
<a href="{$ADMIN_URL}callbacks#callbacks_1" class="btn-quick-access pjax">
    <span class="frame-icon">
        <i class="icon-callback{if $totalNewCallbacks} active{/if}">
            {if $totalNewCallbacks} <span class="badge badge-important">{echo $totalNewCallbacks}</span> {/if}
        </i>
    </span>
    <span class="text-el">{lang("Callback", "admin")}</span>
</a>