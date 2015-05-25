<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Currency edit','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/currencies" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#cur_ed_form" data-submit><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#cur_ed_form" data-action="tomain"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="modules">
            <form method="post" action="{$ADMIN_URL}currencies/edit/{echo $model->getId()}" class="form-horizontal" id="cur_ed_form">
                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {lang('Properties','admin')}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd">
                                    <div class="control-group m-t_10">
                                        <label class="control-label">{lang('Title','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="Name" value="{echo ShopCore::encode($model->getName())}" required/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{lang('ISO','admin')} {lang('Code','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="Code" value="{echo ShopCore::encode($model->getCode())}" required/>
                                            <div class="help-block">
                                                <p>({lang('For example','admin')}: USD)</p>
                                                <p>{lang('The list of possible code rates listed in the international standard','admin')} <a href='http://www.currency-iso.org/dam/downloads/table_a1.xml' target="_blank">ISO 4217</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" >{lang('Character','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="Symbol" value="{echo ShopCore::encode($model->getSymbol())}" required/>
                                            <input type="hidden" name="SymbolOld" value="{echo ShopCore::encode($model->getSymbol())}"/>
                                            <p class="help-block">({lang('For example','admin')}: $)</p>
                                        </div>
                                    </div>
                                    <div class="control-group" id="mod_name">
                                        <label class="control-label">{lang('Currency rate','admin')}: <span class="must">*</span></label>
                                        <div class="controls number"  >
                                            <input type="text" class="input-medium required" data-title="только цифры" data-placement="top" id="rate-currency" onkeyup="checkLenghtStr('rate-currency', 6, 8, event.keyCode);" name="Rate" value="{echo $model->getRate()}" required/>
                                            <p class="help-block">
                                                =
                                                1.000 {$CS}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {lang('Template output currency','admin')}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd">
                                    <div class="control-group m-t_10">
                                        <label class="control-label">{lang('Template carrency','admin')}:</label>
                                        {$cs = ShopCore::encode($model->getSymbol())}
                                        <input id="select-sym" type="hidden" value="{echo $cs}">
                                        {$t = '1'}
                                        {$h = '234'}
                                        {$th = '10'}
                                        {$curprice = $t . $currFormat['Thousands_separator'] . $h . $currFormat['Separator_tens'] . $th}
                                        {if explode('#', $currFormat['Format'])[0] == $cs}
                                        {$cur = $cs .' '. $curprice}
                                        {else:}
                                        {$cur = $curprice .' '. $cs }
                                        {/if}
                                        <div style="display: none;">{$pat = [['cs#', '.', ','], ['cs#', ' ', ','], ['cs#', ' ', '.'], ['cs#', ',', '.'], ['cs#', '', '.'], ['cs#', '', ','], ['#cs', '.', ','], ['#cs', ' ', ','], ['#cs', ' ', '.'], ['#cs', ',', '.'], ['#cs', '', '.'], ['#cs', '', ',']]}</div>
                                        <div class="controls">
                                            <select id="select-format" onchange="changeFormat()">
                                                {/*}<option value=''>{lang('- Not selected -','admin')}</option>{ */}
                                                {foreach $pat as $p}
                                                {$res = ''}
                                                {$price = ''}
                                                {$price .= $t . $p[1] . $h . $p[2] . $th}
                                                {if explode('#', $p[0])[0] == 'cs'}
                                                {$res = $cs .' '. $price}
                                                {else:}
                                                {$res = $price .' '. $cs}
                                                {/if}
                                                <option value='{json_encode($p)}' {if $cur == $res}selected="selected"{/if}>
                                                    {echo $res}
                                                </option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                    <input id='select-format-currency' type="hidden" name="Format" value="{echo $currFormat['Format']}"/>
                                    <input id='select-thousands-separator' type="hidden" name="Thousands_separator" value="{echo $currFormat['Thousands_separator']}" />
                                    <input id='select-separator-tens' type="hidden" name="Separator_tens" value="{echo $currFormat['Separator_tens']}" />
                                    <div class="control-group">
                                        <label class="control-label">{lang('Number of decimal places','admin')}
                                            <span data-title="" class="popover_ref" data-original-title="{lang('The number of characters depends on the main currency','admin')}">
                                                <i class="icon-info-sign"></i>
                                            </span>
                                            :</label>
                                            <div class="controls">
                                                <select name="Decimal_places" required="required" id="select-decimal-places" >
                                                    {if $model->getMain()}
                                                    {$iterator = 5}
                                                    {else:}
                                                    {$iterator = $mainDecimal+1 }
                                                    {/if}
                                                    {for $i=0; $i<$iterator; $i++}
                                                    <option value='{echo $i}'
                                                    {if $currFormat['Decimal_places'] == $i}
                                                    selected='selected'
                                                    {/if}
                                                    >{echo $i}</option>
                                                    {/for}
                                                </select>

                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">&nbsp;</label>
                                            <div class="controls ctext">
                                                <span class="frame_label no_connection">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox" name="Zero" value="1" {if $currFormat['Zero']}checked='checked'{/if}/>
                                                    </span>
                                                    {lang('Do not show zeros in the fractional part','admin')}
                                                    <div class="help-block">{lang('Remove the display in the public section of leading zeros in the fractional part of the price - if you price 12500,00 dollars - will be shown 12500 if you 12500.5 - 12500.5 will be displayed','admin')}</div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {form_csrf()}
                </form>
            </div>
            <div class="tab-pane"></div>
        </div>
    </section>
    {literal}
    <script type="text/javascript">
    function changeFormat() {
        var format = $('#select-format').val() ? eval($('#select-format').val()) : false,
        symbol = $('#select-sym').val();
        if (format) {
            var f = '';
            if (format[0].split('#')[0] === 'cs')
                f = symbol + '#';
            else
                f = '#' + symbol;
            $('#select-format-currency').val(f);
            $('#select-thousands-separator').val(format[1]);
            $('#select-separator-tens').val(format[2]);
        }
        else
            $('#select-format-currency, #select-separator-tens, #select-thousands-separator').val('');
    }
    </script>
    {/literal}
