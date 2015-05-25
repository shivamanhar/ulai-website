<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo lang('Recipient', 'payment_method_oschadbank')}:</label>
    <div class="controls">
        <input type="text" name="payment_method_oschadbank[receiver]" value="{echo $data['receiver']}" />
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo lang('Identifier code', 'payment_method_oschadbank')}:</label>
    <div class="controls number">
        <input type="text" name="payment_method_oschadbank[code]" value="{echo $data['code']}" maxlength="10" />
        <span class="help-block">{echo lang('Integer. The maximum length of 10 characters.', 'payment_method_oschadbank')}</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo lang('Current account', 'payment_method_oschadbank')}:</label>
    <div class="controls number">
        <input type="text" name="payment_method_oschadbank[account]" value="{echo $data['account']}" maxlength="14" />
        <span class="help-block">{echo lang('Integer. The maximum length of 14 characters.', 'payment_method_oschadbank')}</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo lang('Bank MFI', 'payment_method_oschadbank')}:</label>
    <div class="controls number">
        <input type="text" name="payment_method_oschadbank[mfo]" value="{echo $data['mfo']}" maxlength="6" />
        <span class="help-block">{echo lang('Integer. The maximum length of 6 characters.', 'payment_method_oschadbank')}</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="inputRecCount">{echo lang('Money sign', 'payment_method_oschadbank')}:</label>
    <div class="controls">
        <input type="text" name="payment_method_oschadbank[banknote]" value="{echo $data['banknote']}"  />
        <span class="help-block">{echo lang('For example: руб, грн', 'payment_method_oschadbank')}</span>
    </div>
</div>