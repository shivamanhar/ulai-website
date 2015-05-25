<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo  lang('Name of recipient', 'payment_method_sberbank') }:</label>
    <div class="controls">
        <input type="text" name="payment_method_sberbank[receiverName]" value="{echo  $data['receiverName'] }"  />
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo  lang('Recipient bank', 'payment_method_sberbank') }:</label>
    <div class="controls">
        <input type="text" name="payment_method_sberbank[bankName]" value="{echo  $data['bankName'] }"  />
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo  lang('TIN address', 'payment_method_sberbank') }:</label>
    <div class="controls">
        <input type="text" name="payment_method_sberbank[receiverInn]" value="{echo  $data['receiverInn'] }"/>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo  lang('Recipient account', 'payment_method_sberbank') }:</label>
    <div class="controls">
        <input type="text" name="payment_method_sberbank[account]" value="{echo  $data['account'] }" />
    </div>
</div>


<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo  lang('BIC', 'payment_method_sberbank') }:</label>
    <div class="controls">
        <input type="text" name="payment_method_sberbank[BIK]" value="{echo  $data['BIK'] }"/>
    </div>
</div>


<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo  lang('Correspondent account', 'payment_method_sberbank') }:</label>
    <div class="controls">
        <input type="text" name="payment_method_sberbank[cor_account]" value="{echo  $data['cor_account'] }"  />
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo  lang('Bank notes', 'payment_method_sberbank') }:</label>
    <div class="controls">
        <input type="text" name="payment_method_sberbank[bankNote]" value="{echo  $data['bankNote'] }"  />
        <span class="help-block">{echo lang('For example: руб, грн', 'payment_method_sberbank')}</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo  lang('Kopeck', 'payment_method_sberbank') }:</label>
    <div class="controls">
        <input type="text" name="payment_method_sberbank[bankNote2]" value="{echo  $data['bankNote2'] }"/>
        <span class="help-block">{echo lang('For example: коп, копеек', 'payment_method_sberbank')}</span>
    </div>
</div>