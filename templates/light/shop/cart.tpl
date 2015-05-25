<div class="frame-inside page-cart pageCart">
    <div class="container">
        <!-- Start. Show empty cart -->
        <div class="js-empty empty {if count($items) == 0}d_b{/if}">
            <div class="f-s_0 title-cart without-crumbs">
                <div class="frame-title">
                    <h1 class="d_i">{lang('Оформление заказа','light')}</h1>
                </div>
            </div>
            <div class="msg layout-highlight layout-highlight-msg">
                <div class="info">
                    <span class="icon_info"></span>
                    <span class="text-el">{lang('Корзина пуста','light')}</span>
                </div>
            </div>
        </div>
        <!-- End. Show empty cart -->

        <!-- Start. Show cart-->
        <div class="js-no-empty no-empty {if count($items) == 0}d_n{/if}">
            <div class="f-s_0 title-cart without-crumbs">
                <!-- Start. Show login button -->
                <div class="frame-title">
                    <h1 class="d_i">{lang('Оформление заказа','light')}</h1>
                    {if !$is_logged_in}
                    <span class="old-buyer">
                        <button type="button" data-trigger="#loginButton">
                            <span class="d_l text-el">{lang('Я уже здесь покупал','light')}</span>
                        </button>
                    </span>
                    {/if}
                </div>
                <!-- End. Show login button -->
            </div>

            <div class="left-cart">
                <form method="post" action="{$BASE_URL}shop/order/make_order" class="clearfix">
                    {if $gift_key}
                    <input type="hidden" name="gift" value="{echo $gift_key}"/>
                    <input type="hidden" name="gift_ord" value="1"/>
                    {/if}
                    <div class="horizontal-form order-form big-title">
                        <!-- Start. Errors block -->
                        {if $errors}
                        <div class="groups-form">
                            <div class="msg">
                                <div class="error">
                                    <span class="icon_error"></span>
                                    <span class="text-el">{echo $errors}</span>
                                </div>
                            </div>
                        </div>
                        {/if}
                        <!-- End . Errors block -->

                        <!-- Start. User info block -->
                        <div class="groups-form">
                            <label>
                                <span class="title">{lang('Имя: ','light')}</span>
                                <span class="frame-form-field">
                                    {if $isRequired['userInfo[fullName]']}
                                    <span class="must">*</span>
                                    {/if}
                                    <input type="text" value="{$profile.name}" name="userInfo[fullName]">
                                </span>
                            </label>
                            <div class="frame-label">
                                <span class="title">{lang('Телефон','light')}:</span>
                                <div class="frame-form-field">
                                 <div class="d_b o_h">
                                    {if $isRequired['userInfo[phone]']}
                                    <span class="must">*</span>
                                    {/if}
                                    <input type="text" name="userInfo[phone]" value="{$profile.phone}" class="">
                                </div>
                            </div>
                        </div>
                        <label>
                            <span class="title">{lang('Email','light')}:</span>
                            <span class="frame-form-field">
                                {if $isRequired['userInfo[email]']}
                                <span class="must">*</span>
                                {/if}
                                <input type="text" value="{$profile.email}" name="userInfo[email]">
                            </span>
                        </label>
                    </div>
                    <!-- End. User info block -->

                    <div class="groups-form">
                        {if count($deliveryMethods) > 0}
                        <!-- Start. Delivery methods block -->
                        <div class="frame-label" id="frameDelivery">
                            <span class="title">{lang('Доставка:','light')}</span>
                            <div class="frame-form-field check-variant-delivery">
                                {/* <div class="lineForm">
                                <select id="method_deliv" name="deliveryMethodId">
                                    <option value="">{lang('--Выбирете способ доставки--', 'light')}</option>
                                    {foreach $deliveryMethods as $deliveryMethod}
                                    <option
                                    name="met_del"
                                    value="{echo $deliveryMethod->getId()}">
                                    {echo $deliveryMethod->getName()}
                                </option>
                                {/foreach}
                            </select>
                        </div>*/}
                        <div class="frame-radio">
                            {foreach $deliveryMethods as $deliveryMethod}
                            <div class="frame-label">
                                <span class="niceRadio b_n">
                                    <input type="radio"
                                    name="deliveryMethodId"
                                    value="{echo $deliveryMethod->getId()}"
                                    />
                                </span>
                                <div class="name-count">
                                    <span class="text-el">{echo $deliveryMethod->getName()}</span>
                                    {if $deliveryMethod->getDescription() && trim($deliveryMethod->getDescription()) != ""}
                                    <span class="icon_ask" data-rel="tooltip" data-title="{echo $deliveryMethod->getDescription()}"></span>
                                    {/if}
                                </div>
                                <div class="help-block">
                                    {if $deliveryMethod->getDeliverySumSpecified()}
                                    {echo $deliveryMethod->getDeliverySumSpecifiedMessage()}
                                    {else:}
<div>{lang('Стоимость','light')}: {echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), number_format($deliveryMethod->getPrice(),$pricePrecision,'.',''),'span', 'curr', '');}</div> 
 <div>{lang('Бесплатно от','light')}: {echo \Currency\Currency::create()->getCurrencyToFormat(\Currency\Currency::create()->getMainCurrency()->getId(), number_format($deliveryMethod->getFreeFrom(),$pricePrecision,'.',''),'span', 'curr', '');}</div> 
                                    {/if}
                                </div>
                            </div>
                            {/foreach}
                        </div>
                    </div>
                    <!-- End. Delivery methods block -->
                </div>
                {/if}


                {foreach ShopCore::app()->CustomFieldsHelper->getCustomFielsdAsArray('order') as $cf}
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

                <!-- Start. Delivery  address block and comment-->
                <div class="frame-label">
                    <span class="title">{lang('Адрес доставки', 'light')}:</span>
                    <span class="frame-form-field">
                        {if $isRequired['userInfo[deliverTo]']}
                        <span class="must">*</span>
                        {/if}
                        <input name="userInfo[deliverTo]" type="text" value="{$profile.address}"/>
                    </span>
                </div>
                <div class="frame-label" style="margin-top:-5px;">
                    <div class="frame-form-field">
                        <button type="button" class="d_l_1 m-b_5" data-drop=".hidden-comment" data-place="inherit" data-overlay-opacity="0">{lang('Добавить комментарий к заказу', 'light')}</button>
                        <div class="hidden-comment drop">
                            <textarea name="userInfo[commentText]" ></textarea>
                        </div>
                    </div>
                </div>
                <!-- End. Delivery  address block and comment-->
                {if count($deliveryMethods) > 0}
                <!-- Start. Payment methods block-->
                <div class="frame-payment p_r">
                    <div id="framePaymentMethod">
                        <div class="frame-label">
                            <span class="title">{lang('Оплата','light')}:</span>
                            <div class="frame-form-field">
                                <div class="help-block pseudo-cusel">{lang('Сначала выберите способ доставки', 'light')}</div>
                            </div>
                        </div>
                    </div>
                    <div class="preloader d_n_"></div>
                </div>
                <!-- End. Payment methods block-->
                {/if}
            </div>
            <div class="groups-form">
                <div class="frame-label">
                    <span class="title">&nbsp;</span>
                    <span class="frame-form-field">
                        <div class="btn-buy btn-buy-p">
                            <input type="submit" value="{lang('Оформить заказ','light')}" id="submitOrder"/>
                        </div>
                    </span>
                </div>
            </div>
        </div>
        {form_csrf()}
    </form>
</div>
<div class="right-cart">
    <div class="frameBask frame-bask frame-bask-order">
        <div class="frame-title clearfix">
            <div class="title f_l">{lang('Мой заказ', 'light')}</div>
            <div class="f_r">
                <button type="button" class="d_l_1 editCart">{lang('Редактировать', 'light')}</button>
            </div>
        </div>
        <div id="orderDetails" class="p_r">
            {include_tpl('cart_order')}
        </div>
    </div>
</div>
</div>
<!-- End. Show cart -->
</div>
</div>
<script type="text/javascript">     initDownloadScripts(['jquery.maskedinput-1.3.min', 'cusel-min-2.5', 'order'], 'initOrderTrEv', 'initOrder');
</script>