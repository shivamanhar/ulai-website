<form action="{$ADMIN_URL}products/translate/{echo $model->Id}" method="post" id="item_t_save_form" style="width:100%;">
    <div id="shopSettingsTabs">

        {foreach $languages as $language}
            <h4 title="{echo $language.lang_name}">{echo $language.lang_name}</h4>
            <div> <!-- Begin {echo $language.lang_name} tab -->
                {$model->setLocale($language.identif)}
                {foreach $translatableFieldNames as $fieldName}
                    {$methodName = 'get'.$fieldName}
                    {if $fieldName == 'Name'}
                        <div class="form_text"> </div>
                        <div class="form_input variantsTableContainer">
                            <div style="padding-left:31px;padding-bottom:5px;">
                                <b>{echo $model->getLabel($fieldName)}:</b>
                                {if in_array($fieldName, $requairedFieldNames)}
                                    <span class="required">*</span>
                                {/if}
                            </div>

                            <div style="padding:0 30px 0 30px;">
                                <input type="text" name="{echo $fieldName}_{echo $language.identif}" value="{echo $model->$methodName()}" class="textbox_long" />
                            </div>

                            <table>
                                <thead>
                                <td width="25"></td>
                                <th><b>{lang('Name','admin')} {lang('Variant','admin')}:</b></th>
                                </thead>
                                <tbody>
                                    {foreach $model->getProductVariants() as $v}
                                        {$v->setLocale($language.identif)}
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="variants_{echo $language.identif}[CurrentId][]" value="{echo $v->getId()}" />
                                                <input type="text" name="variants_{echo $language.identif}[Name][]" value="{echo ShopCore::encode($v->getName())}" class="textbox_long" />
                                            </td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                                <tfoot>
                                <th></th>
                                <th></th>
                                </tfoot>
                            </table>
                        </div>
                    {else:}
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
                    {/if}
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