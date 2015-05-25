<tr class="fast-create" <?php if($show_fast_form): ?>style="display: table-row;"<?php endif; ?>>
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

                <div class="controls" <?php /*?>style="height: 102px;width: 102px; margin: 0px; padding: 0px;"<?php */?>>
                    <div class="photo-block">
                        <span class="helper"></span>
                        <img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/select-picture.png" class="img-polaroid " style="width: 40px; ">
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
            <?php $result = \Category\CategoryApi::getInstance()->getTree(); 
 if(is_true_array($result)){ foreach ($result as $cat){ ?>
                <option value="<?php echo $cat->getId()?>"><?php echo str_repeat("-", $cat->getLevel() * 2)?> <?php echo $cat->getName()?></option>
            <?php }} ?>

        </select>
    </td>
    <td>
        <div class="url-input-out">
            <input name="number" type="text"/>
        </div>
    </td>
    <td>
        <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top"
             data-original-title="<?php echo lang ('show','admin'); ?>">

            <span class="prod-on_off" data-id=""></span>

        </div>
    </td>
    <td>
        <button type="button" data-id="" class="btn btn-small setHit" data-rel="tooltip" data-placement="top"
                data-original-title="<?php echo lang ('Hit','admin'); ?>"><i class="icon-fire"></i></button>
        <button type="button" data-id="" class="btn btn-small setHot" data-rel="tooltip" data-placement="top"
                data-original-title="<?php echo lang ('Novelty','admin'); ?>"><i class="icon-gift"></i></button>
        <button type="button" data-id="" class="btn btn-small setAction" data-rel="tooltip" data-placement="top"
                data-original-title="<?php echo lang ('Promotion','admin'); ?>"><i class="icon-star"></i></button>
    </td>
    <td>
        <div class="url-input-out">
            <input name="price" type="text" value="<?php echo \Currency\Currency::create()->decimalPointsFormat(0)?>"/>
        </div>
    </td>
</tr><?php $mabilis_ttl=1432206758; $mabilis_last_modified=1426010500; ///var/www/application/modules/shop/admin/templates/search/../products/fastCreateForm.tpl ?>