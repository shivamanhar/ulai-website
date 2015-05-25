<form action="{$ADMIN_URL}categories/translate/{echo $model->Id}" method="post" id="item_t_save_form" style="width:100%;">
<div id="shopSettingsTabs">

	{foreach $languages as $language}
		<h4 title="{echo $language.lang_name}">{echo $language.lang_name}</h4>
		<div> <!-- Begin {echo $language.lang_name} tab -->
			{$model->setLocale($language.identif)}
			{foreach $translatableFieldNames as $fieldName}
					{$methodName = 'get'.$fieldName}
					<div class="form_text">{echo $model->getLabel($fieldName)}:</div>
					<div class="form_input">
						{if in_array($fieldName, $mceEditorFieldNames)}
							<textarea class="elRTE" name="{echo $fieldName}_{echo $language.identif}" >{echo $model->$methodName()}</textarea>
						{else:}
							<input type="text" name="{echo $fieldName}_{echo $language.identif}" value="{echo $model->$methodName()}" class="textbox_long" />
						{/if}
                        {if in_array($fieldName, $requairedFieldNames)}
                            <span class="required">*</span>
                        {/if}
					</div>
				<div class="form_overflow"></div>
			{/foreach}
		</div>
{/foreach}
</div>
{form_csrf()}

<div class="form_text"></div>
<div class="form_input">
    <input type="submit" name="button" class="button" value="{lang('Save','admin')}" onclick="ajax_me('item_t_save_form');" />
    <input type="button" name="button" class="button" value="{lang('Cancel','admin')}" onclick="MochaUI.closeWindow($('translate_list_item_Window'));" />
<div class="form_overflow"></div>
</div>

</form>

{literal}
<script type="text/javascript">
		var SSettings_tabs = new SimpleTabs('shopSettingsTabs', {
		    selector: 'h4'
		});
		
		load_editor();
</script>
{/literal}