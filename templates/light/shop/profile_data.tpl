<div class="inside-padd clearfix">
    <div class="frame-change-profile">
        <div class="horizontal-form">
            <form method="post" id="form_change_info" onsubmit="ImageCMSApi.formAction('{site_url("/shop/profileapi/changeInfo")}', '#form_change_info', {literal}{hideForm: false, durationHideForm: 1000}{/literal});
            return false;">
            <label>
                <span class="title">{lang('Ваше имя','light')}:</span>
                <span class="frame-form-field">
                    <input type="text" value="{echo encode($profile->getName())}" name="name"/>
                    <span class="help-block">{lang('Не меньше 4-х символов','light')}</span>
                </span>
            </label>
            <label>
                <span class="title">{lang('Телефон','light')}:</span>
                <span class="frame-form-field">
                    <input type="text" value="{echo encode($profile->getPhone())}" name="phone"/>
                </span>
            </label>
            <label>
                <span class="title">Email:</span>
                <span class="frame-form-field">
                    <input type="text" disabled="disabled" value="{echo encode($profile->getUserEmail())}" name="email"/>
                    <input type="hidden" value="{echo encode($profile->getUserEmail())}" name="email"/>
                    <span class="help-block">{lang('E-mail является логином','light')}</span>
                </span>
            </label>
            <label>
                <span class="title">{lang('Адрес','light')}:</span>
                <span class="frame-form-field">
                    <input type="text" value="{echo encode($profile->getAddress())}" name="address"/>
                </span>
            </label>
            {foreach ShopCore::app()->CustomFieldsHelper->getCustomFielsdAsArray('user', $profile->getId()) as $cf}
            <label for="custom_field_{$cf.id}">
                <span class="title">{$cf.field_label}:</span>
                <span class="frame-form-field">
                    {if $cf.is_required}
                    <span class="must">*</span>
                    {/if}
                    <input type="text" name="custom_field[{$cf.id}]" value="{$cf.field_data}" id="custom_field_{$cf.id}">
                </span>
            </label>
            {/foreach}
            <div class="frame-label">
                <span class="title">&nbsp;</span>
                <span class="frame-form-field">
                    <span class="btn-form">
                        <input type="submit" value="{lang('Сохранить данные','light')}"/>
                    </span>
                </span>
            </div>
            {form_csrf()}
        </form>
    </div>
</div>


{$dApi = $CI->load->module('mod_discount/discount_api')}
{if $dApi->discountsExists()}
{$discount = $dApi->get_user_discount_api()}
<div class="layout-highlight info-discount">
    <div class="title-default">
        <div class="title">{lang('Скидки','light')}</div>
    </div>
    <div class="content">
        <ul class="items items-info-discount">
            <li class="inside-padd">
                <div>
                    {lang('Товаров на сумму','light')}:
                    <span class="price-item">
                        <span class="text-discount">
{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), ShopCore::app()->SCurrencyHelper->convert($profile->getamout()),'span', 'curr', '',  'span', 'price', '')}

                        </span>
                    </span>
                </div>
                {if $dApi->userDiscountExists()}
                <div>
                    {lang('Ваша текущая скидка','light')}:
                    <span class="price-item">
 <span class="text-discount">{if $discount["user"][0]["type_value"] == 1}{echo $discount["user"][0]["value"]}%{else:}{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $discount['user'][0]['value'])}{/if}</span> 
                    </span>
                </div>
                {/if}
                {if $dApi->groupDiscountExists()}
                <div>
                    {lang('Ваша текущая скидка группы пользователей','light')}:
                    <span class="price-item">
 <span class="text-discount">{if $discount["group_user"][0]["type_value"] == 1}{echo $discount["group_user"][0]["value"]}%{else:}{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $discount['group_user'][0]['value'])}{/if}</span> 
                    </span>
                </div>
                {/if}
                {if $discount['comulativ']}
                {foreach $discount['comulativ'] as $key => $disc}
                {if $disc['begin_value'] < $profile->getamout() and $profile->getamout() < $disc['end_value']}
                {$discount_comul_next = $discount['comulativ'][$key + 1];}
                {$discount_comul_curr = $discount['comulativ'][$key];}
                {/if}
                {/foreach}
                {/if}
                {if $discount_comul_curr}
                <div>
                    {lang('Ваша текущая скидка','light')}:
                    <span class="price-item">
<span class="text-discount">{if $discount_comul_curr["type_value"] == 1}{echo $discount_comul_curr["value"]}%{else:}{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $discount_comul_next['value'])}{/if}</span> 
                    </span>
                </div>
                {/if}

            </li>

            {if $discount_comul_next}
            <li class="inside-padd">
<div>{lang('Для следующей скидки','light')} {if $discount_comul_next["type_value"] == 1}{echo $discount_comul_next["value"]}%{else:}{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $discount_comul_next["value"])}{/if} {lang('осталось','light')}</div> 
<div>{lang('cделать покупки на сумму','light')}: <b>echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $discount_comul_next['begin_value'] - $profile->getamout())}</b></div> 
            </li>
            {/if}
            {if  $discount['comulativ']}
            <li class="inside-padd">
                <button type="button" class="d_l_1" data-drop=".drop-comulativ-discounts" data-place="noinherit" data-placement="bottom left" data-overlay-opacity= "0">{lang('Посмотреть таблицу скидок','light')}</button>
            </li>
            {/if}
        </ul>
    </div>
</div>
</div>
{/if}
{if  $discount['comulativ']}
<div class="drop-style drop drop-comulativ-discounts">
    <button type="button" class="icon_times_drop" data-closed="closed-js"></button>
    <div class="drop-header">
        <div class="title">{lang('Накопительные скидки','light')}</div>
    </div>
    <div class="drop-content">
        <div class="inside-padd characteristic">
            <table class="">
                <thead>
                    <tr>
                        <th>{lang('Размер скидки','light')}</th>
                        <th>{lang('От','light')}</th>
                        <th>{lang('До','light')}</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $discount['comulativ'] as $disc}
                    <tr>
 <td class="text-discount">{if $disc["type_value"] == 1}{echo $disc["value"]}%{else:}{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $disc['value'])}{/if}</td> 
<td> {echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $disc['begin_value'])}</td> 
<td>{if $disc['end_value']}{echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), $disc['end_value'])}{else:}{lang('Бесконечно','light')}{/if}</td> 
                    </tr>
                    {/foreach}
                </tbody>
            </table>

        </div>
    </div>
    <div class="drop-footer"></div>
</div>
{/if}
