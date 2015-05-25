<!-- Create brand form -->
<div class="saPageHeader">
    <h2>{lang('Create','admin')} {lang('Brand','admin')}</h2>
</div>

<form method="post" action="{$ADMIN_URL}brands/create"  style="width:100%">

    <div class="form_text">{{lang('Name','admin')}:</div>
    <div class="form_input">
        <input type="text" name="Name" value="" class="textbox_long" /> <span class="required">*</span> 
    </div>
    <div class="form_overflow"></div>

    <div class="form_text">{lang('URL','admin')}:</div>
    <div class="form_input">
        <input type="text" name="Url" value="" class="textbox_long" />
    </div>
    <div class="form_overflow"></div>

    <div class="form_text">{lang('Description','admin')}:</div>
    <div class="form_input">
        <textarea name="Description" value="" class="elRTE"></textarea>
    </div>
    <div class="form_overflow"></div>

    <div class="form_text">{lang('Meta Title','admin')}:</div>
    <div class="form_input">
        <input type="text" name="MetaTitle" value="" class="textbox_long" />
    </div>
    <div class="form_overflow"></div>

    <div class="form_text">{lang('Meta Description','admin')}:</div>
    <div class="form_input">
        <input type="text" name="MetaDescription" value="" class="textbox_long" />
    </div>
    <div class="form_overflow"></div>

    <div class="form_text">{lang('Meta Keywords','admin')}:</div>
    <div class="form_input">
        <input type="text" name="MetaKeywords" value="" class="textbox_long" />
    </div>
    <div class="form_overflow"></div>

    <div class="footer_panel" align="right"> 
        <input type="submit" id="footerButton" name="_add" value="{lang('Save','admin')}" class="active" onClick="ajaxShopForm(this);" />
        <input type="submit" id="footerButton" name="_create" value="{lang('Save and create a new record','admin')}"  onClick="ajaxShopForm(this);" />
        <input type="submit" id="footerButton" name="_edit" value="{lang(' Save and edit','admin')}"  onClick="ajaxShopForm(this);" />
    </div>

    {form_csrf()}
</form>

<script type="text/javascript">
    load_editor();
</script>
