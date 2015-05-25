<tr class="fast-create fast-create-brand" {if $_GET['fast_create']}style="display: table-row;"{/if}>
    <td colspan="2">
        <div class="create-brand-title"></div>
    </td>
    <td>
        <div class="clearfix input-photo-text-out">
            <div class="control-group input-photo">
                <label class="control-label d_n" for="inputSImg">
                                        <span class="btn btn-small p_r" data-url="file">
                                            <input type="file" class="btn-small btn" id="inputSImg" name="mainPhoto"
                                                   accept="image/jpeg,image/png,image/gif">
                                            {/*}<input type="hidden" name="deleteImage" id="deleteImage" value=""/>{ */}
                                        </span>
                                        <span class="frame_label no_connection active d_b m-t_10">
                                            <button class="btn btn-small deleteMainImages"
                                                    onclick="$('#deleteImage').val(1)" type="button">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </span>
                </label>

                <div class="controls m-l_0_">
                    <div class="photo-block">
                        <span class="helper"></span>
                        <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 40px; ">
                    </div>
                </div>
            </div>
            <div class="input-text-in">
                <input type="text" id="toTranslation" name="Name"/>
            </div>
        </div>
    </td>
    <td>
        <div class="url-input-out">
            <input type="text" id="slug" name="Url"/>
        </div>
    </td>

    <input type="hidden" name='Locale' value="{echo \MY_Controller::getCurrentLocale()}"/>
    <input type="hidden" name="Description" value=""/>
    <input type="hidden" name="MetaDescription" value=""/>
    <input type="hidden" name="MetaTitle" value=""/>
    <input type="hidden" name="MetaKeywords" value=""/>
    {form_csrf()}
</tr>

