<div class="control-group">
    <label class="control-label" for="inputRecCount">{lang('Id cashbox', 'payment_method_interkassa')} :</label>
    <div class="controls">
        <input type="text" name="payment_method_interkassa[merchant_id]" value="{echo $data['merchant_id']}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputRecCount">{lang('Secret key', 'payment_method_interkassa')} :</label>
    <div class="controls">
        <input type="text" name="payment_method_interkassa[merchant_sig]" value="{echo $data['merchant_sig']}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputRecCount">{lang('Test secret key', 'payment_method_interkassa')} :</label>
    <div class="controls">
        <input type="text" name="payment_method_interkassa[merchant_sig_test]" value="{echo $data['merchant_sig_test']}"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputRecCount">{lang('Test mode', 'payment_method_interkassa')} :</label>
    <div class="controls">
        <input type="checkbox" name="payment_method_interkassa[test_checkbox]" {if $data['test_checkbox']}checked='checked'{/if}/>
    </div>
</div>
    <div class="control-group">
                <div class="controls">
                    <p>{lang('Проверять подпись в форме запроса платежа: да', 'payment_method_interkassa')}</p>
                    <p>{lang('Проверять уникальность платежей : да', 'payment_method_interkassa')}</p>
                    <p>{lang('Алгоритм подписи: MD5', 'payment_method_interkassa')}</p>
                    <br/>
                    <p>{lang('URL успешной оплаты:', 'payment_method_interkassa')}</p>
                    <p style="margin-left:50px">{lang('POST, разрешить переопределять в запросе', 'payment_method_interkassa')}</p>
                    <p>{lang('URL неуспешной оплаты:', 'payment_method_interkassa')}</p>
                    <p style="margin-left:50px">{lang('POST, разрешить переопределять в запросе', 'payment_method_interkassa')}</p>
                    <p>{lang('URL ожидания проведения платежа:', 'payment_method_interkassa')}</p>
                    <p style="margin-left:50px">{lang('POST, разрешить переопределять в запросе', 'payment_method_interkassa')}</p>
                    <p>{lang('URL взаимодействия:', 'payment_method_interkassa')}</p>
                    <p style="margin-left:50px">{lang('POST', 'payment_method_interkassa')},  {echo site_url('/payment_method_interkassa/callback')}</p>
                </div>				
    </div>