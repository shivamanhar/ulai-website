<tr class="fast-create" {if $_GET['fastcreate'] OR $open_fast_create}style="display: table-row;"{/if}>
    <td colspan="2">
        <div class="create-brand-title"></div>
    </td>
    <td>
        <div class="clearfix input-photo-text-out">
            <div class="input-text-in">
                <input type="text" name="Name" id="toTranslation"/>
            </div>
        </div>
    </td>
    <td>
        <div class="d-i_b">
            <select multiple="multiple" class="chosen fastPropertyCreateCategorySelect" name="inCat" style="margin-bottom: 0px;">
                <option value="0">- {lang('Show in all categories','admin')}
                    -
                </option>
                {$categories = $categories ? $categories : ShopCore::app()->SCategoryTree->getTree_();}

                {foreach $categories as $category}
                    <option value="{echo $category->getId()}" {$selected} >{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                {/foreach}
            </select>
        </div>
    </td>
    <td>
        <div class="url-input-out">
            <input type="text" id="slug" name="CsvName"/>
        </div>
    </td>
    <td>
        <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top"
             data-original-title="{lang('switch on','admin')}"
             data-off="{lang('switch off','admin')}">
            <span class="prod-on_off prop_active" data-id=""></span>
        </div>
    </td>

</tr>