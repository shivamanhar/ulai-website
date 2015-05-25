{$count = $CI->load->module('wishlist')->getUserWishListItemsCount($CI->dx_auth->get_user_id())}
<div class="wish-list-btn tinyWishList">
    <button data-href="{site_url('wishlist')}" data-drop=".drop-info-wishlist" data-place="inherit" data-overlay-opacity="0">
        <span class="icon_wish_list"></span>
        <span class="text-wish-list">
            <span class="js-empty empty" {if $count == 0}style="display: inline"{/if}>
                <span class="text-el">{lang('Список желаний','light')} </span>
                <span class="text-el">(</span>
                <span class="text-el wishListCount">0</span>
                <span class="text-el">)</span>
            </span>
            <span class="js-no-empty no-empty" {if $count != 0}style="display: inline"{/if}>
                <span class="text-el">{lang('Список желаний','light')} </span>
                <span class="text-el">(</span>
                <span class="text-el wishListCount">{echo $count}</span>
                <span class="text-el">)</span>
            </span>
        </span>
    </button>
</div>
<div class="drop drop-info drop-info-wishlist">
    <span class="helper"></span>
    <span class="text-el">
        {lang('Ваш список', 'light')} <br/>
        “{lang('Список желаний', 'light')}” {lang('пуст', 'light')}</span>
</div>