<tr class="fast-create" {if $show_fast_form}style="display: table-row;"{/if}>
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
                        <input type="hidden" name="deleteImage" id="deleteImage" value=""/>
                    </span>
                    <span class="frame_label no_connection active d_b m-t_10">
                        <button class="btn btn-small deleteMainImages"
                                onclick="$('#deleteImage').val(1)" type="button">
                            <i class="icon-trash"></i>
                        </button>
                    </span>
                </label>

                <div class="controls" {/*}style="height: 102px;width: 102px; margin: 0px; padding: 0px;"{ */}>
                    <div class="photo-block">
                        <span class="helper"></span>
                        <img src="{$THEME}images/select-picture.png" class="img-polaroid " style="width: 40px; ">
                    </div>
                </div>
            </div>
            <div class="input-text-in">
                <input name="name" type="text"/>
            </div>
        </div>
    </td>
    <td>
        <select name="catId">
            {foreach \Category\CategoryApi::getInstance()->getTree() as $cat}
                <option value="{echo $cat->getId()}">{echo str_repeat("-", $cat->getLevel() * 2)} {echo $cat->getName()}</option>
            {/foreach}

        </select>
    </td>
    <td>
        <div class="url-input-out">
            <input name="number" type="text"/>
        </div>
    </td>
    <td>
        <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top"
             data-original-title="{lang('show','admin')}">

            <span class="prod-on_off" data-id=""></span>

        </div>
    </td>
    <td>
        <button type="button" data-id="" class="btn btn-small setHit" data-rel="tooltip" data-placement="top"
                data-original-title="{lang('Hit','admin')}"><i class="icon-fire"></i></button>
        <button type="button" data-id="" class="btn btn-small setHot" data-rel="tooltip" data-placement="top"
                data-original-title="{lang('Novelty','admin')}"><i class="icon-gift"></i></button>
        <button type="button" data-id="" class="btn btn-small setAction" data-rel="tooltip" data-placement="top"
                data-original-title="{lang('Promotion','admin')}"><i class="icon-star"></i></button>
    </td>
    <td>
        <div class="url-input-out">
            <input name="price" type="text" value="{echo \Currency\Currency::create()->decimalPointsFormat(0)}"/>
        </div>
    </td>
</tr>