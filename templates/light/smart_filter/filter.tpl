{include_tpl('filter_opt')}
<div class="preloader wo-i"></div>
<div class="frames-checks-sliders">
    <div class="frame-slider" data-rel="sliders.slider1">
        <div class="inside-padd">
            <div class="title">{lang('Цена', 'light')}</div>
            <div class="slider-cont">
                <noscript>{lang('Джаваскрипт не включен', 'light')}</noscript>
                {/*id="slider1" for cleaverfilter that paste frame with count finded products*/}
                <div class="slider" id="slider1">
                    <a href="#" class="ui-slider-handle left-slider"></a>
                    <a href="#" class="ui-slider-handle right-slider"></a>
                </div>
            </div>
            <div class="form-cost number">
                <div class="t-a_j">
                    {/*may been delete*/}
                    <label>
                        <input type="text" class="minCost" data-title="{lang('только цифры', 'light')}" name="lp" value="{echo $curMin}" data-mins="{echo $minPrice}"/>
                    </label>
                    <label>
                        <input type="text" class="maxCost" data-title="{lang('только цифры', 'light')}" name="rp" value="{echo $curMax}" data-maxs="{echo $maxPrice}"/>
                    </label>
                </div>
            </div>
        </div>
    </div>
    {if count($brands) > 0}
        <div class="frame-group-checks">
            <div class="inside-padd">
                <div class="title">
                    <span class="f-s_0">
                        <span class="icon-arrow"></span>
                        <span class="d_b">
                            <span class="text-el">{lang('Производитель', 'light')}</span>
                        </span>
                    </span>
                </div>
                <ul class="filters-content">
                    {foreach $brands as $brand}
                        {if is_array(ShopCore::$_GET['brand']) && in_array($brand->id, ShopCore::$_GET['brand'])}
                            {$check = 'checked="checked"'}
                        {else:}
                            {$check = ''}
                        {/if}
                        {if $brand->countProducts == 0 && $check == ''}
                            {$dis = 'disabled="disabled"'}
                        {else:}
                            {$dis = ""}
                        {/if}
                        <li>
                            <div class="frame-label" id="brand_{echo $brand->id}">
                                <span class="niceCheck b_n">
                                    <input {$dis} class="brand{echo $brand->id}" name="brand[]" value="{echo $brand->id}" type="checkbox" {$check}/>
                                </span>
                                <div class="name-count">
                                    <span class="text-el">{echo $brand->name}</span>
                                    <span class="count">({echo $brand->countProducts})</span>
                                </div>
                            </div>
                        </li>
                    {/foreach}
                </ul>
            </div>
        </div>
    {/if}

    {if count($propertiesInCat) > 0}
        {$flagScroll = 0}
        {foreach $propertiesInCat as $prop}
            {if count($prop->possibleValues) > 0}
                {$typeProperty = getPropertyTypes($prop->property_id)}
                {$condTypeProperty = $typeProperty != '' && sizeof($typeProperty) != 0}
                <div class="frame-group-checks" {if $condTypeProperty}data-rel="{implode(" ",$typeProperty)}"{/if} {if in_array('dropDown', $typeProperty)}id="dropDown{$flagScroll}"{$flagScroll++}{/if}>
                    <div class="inside-padd">
                        <div class="title">
                            <span class="f-s_0">
                                <span class="icon-arrow"></span>
                                <span class="d_b">
                                    <span class="text-el">{echo $prop->name}</span>
                                </span>
                            </span>
                        </div>
                        {if !in_array('cusel', $typeProperty) || !$typeProperty}
                            <div class="filters-content">
                                <ul>
                                    {foreach $prop->possibleValues as $item}
                                        {if is_array(ShopCore::$_GET['p'][$prop->property_id]) && (in_array($item.value, ShopCore::$_GET['p'][$prop->property_id]) or in_array(htmlspecialchars_decode($item.value), ShopCore::$_GET['p'][$prop->property_id]))}
                                            {$check = 'checked="checked"'}
                                        {else:}
                                            {$check = ''}
                                        {/if}
                                        {if $item.count == 0 && $check == ''}
                                            {$dis = 'disabled="disabled"'}
                                        {else:}
                                            {$dis = ""}
                                        {/if}
                                        <li>
                                            <div class="frame-label" id="p_{echo $prop->property_id}_{echo $item.id}">
                                                <span class="niceCheck b_n">
                                                    <input {$dis} name="p[{echo $prop->property_id}][]" value='{echo $item.value}' type="checkbox" {$check} />
                                                </span>
                                                <div class="name-count">
                                                    <span class="text-el">{echo $item.value}</span>
                                                    <span class="count">({echo $item.count})</span>
                                                </div>
                                            </div>
                                        </li>
                                    {/foreach}
                                </ul>
                            </div>
                        {else:}
                            <div class="lineForm">
                                <select name="p[{echo $prop->property_id}][]" id="p{echo $prop->property_id}" onchange="Filter.changeSelectFilter(this)">
                                    <option id="none"  value=''>--{lang('Не выбрано', 'light')}--</option>
                                    {foreach $prop->possibleValues as $item}
                                        {if is_array(ShopCore::$_GET['p'][$prop->property_id]) && in_array($item.value, ShopCore::$_GET['p'][$prop->property_id])}
                                            {$check = 'selected="selected"'}
                                        {else:}
                                            {$check = ''}
                                        {/if}
                                        {if $item.count == 0 && $check == ''}
                                            {$dis = 'disabled="disabled"'}
                                        {else:}
                                            {$dis = ""}
                                        {/if}
                                        <option {$dis} id="p_{echo $prop->property_id}_{echo $item.id}"  value='{echo $item.value}' {$check}>{echo $item.value} ({echo $item.count})</option>
                                    {/foreach}
                                </select>
                            </div>
                        {/if}
                    </div>
                </div>
            {/if}
        {/foreach}
    {/if}
    <div class="frame-group-checks">
        <div class="inside-padd t-a_c">
            <div class="btn-form m-b_5">
                <button type="submit">
                    <span class="text-el">{lang('Фильтровать', 'light')}</span>
                </button>
            </div>
        </div>
    </div>
</div>
<input disabled="disabled" type="hidden" name="requestUri" value="{echo site_url($CI->uri->uri_string())}"/>