<div class="modal hide fade" id='myModal'>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?php echo lang ('Create group', 'banners'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo lang ('Group name', 'banners'); ?></p>
        <input type="text" name="nameGroup" id="nameGroup">
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="groupCreate();
        $('#myModal').modal('hide')"><?php echo lang ('Create', 'banners'); ?></a>
    </div>
</div>

<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title"><?php echo lang ('Editing banner', 'banners'); ?></span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="/admin/components/init_window/banners" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u"><?php echo lang ('Back', 'banners'); ?></span></a>
                <button onclick="selects()" type="button" class="btn btn-small btn-primary formSubmit" data-form="#image_upload_form" data-submit><i class="icon-ok icon-white"></i><?php echo lang ('Save', 'banners'); ?></button>
                <button onclick="selects()" type="button" class="btn btn-small action_on formSubmit" data-form="#image_upload_form" data-action="tomain"><i class="icon-check"></i><?php echo lang ('Save and exit', 'banners'); ?></button>
                <?php echo create_language_select($languages, $locale, "/admin/components/init_window/banners/edit/".$banner['id'])?>
            </div>
        </div>
    </div>
    <form method="post" action="/admin/components/init_window/banners/edit/<?php echo $banner['id']?>/<?php if(isset($locale)){ echo $locale; } ?>" enctype="multipart/form-data" id="image_upload_form" class="m-t_10">
        <table class="table  table-bordered table-hover table-condensed content_big_td">
            <thead>
                <tr>
                    <th colspan="6">
                        <?php echo lang ('Options', 'banners'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd">
                            <div class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label" for="Name"><?php echo lang ('Name', 'banners'); ?> <?php if(isset($translatable)){ echo $translatable; } ?>: <span class="must">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="name" id="Name" value="<?php echo $banner['name']?>" required/>
                                    </div>
                                    <div class="controls">
                                        <span class="frame_label no_connection m-r_15">
                                            <span class="niceCheck" style="background-position: -46px 0px; ">
                                                <input type="checkbox" name="active" value="1" <?php if($banner['active'] == true): ?>checked="checked"<?php endif; ?>>
                                            </span>
                                            <?php echo lang ('Active', 'banners'); ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="Text"><?php echo lang ('Text banner', 'banners'); ?> <?php if(isset($translatable)){ echo $translatable; } ?>:</label>
                                    <div class="controls">
                                        <textarea name="description" id="Text" class="elRTE" ><?php echo $banner['description']?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="Url"> <?php echo lang ('URL', 'banners'); ?> <?php if(isset($translatable)){ echo $translatable; } ?>:</label>
                                    <div class="controls">
                                        <input type="text" name="url" id="Url" value="<?php if(trim($banner['url'])): ?><?php echo $banner['url']?><?php endif; ?>"/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="Url"> <?php echo lang ('Banner group', 'banners'); ?> <?php if(isset($translatable)){ echo $translatable; } ?>:</label>
                                    <div class="controls">
                                        <div class="">
                                            <select class="span3 notchosen"
                                            id="appendedInputButton"
                                            ondblclick="groupDel()"
                                            type="text"
                                            name="group[]"
                                            multiple="multiple">
                                            <?php if(is_true_array($groups)){ foreach ($groups as $group){ ?>
                                            <option value="<?php echo  $group['name']  ?>"<?php if(in_array( $group['name'] ,unserialize( $banner['group'] ))): ?>selected="selected"<?php endif; ?>><?php echo  $group['name']  ?></option>
                                            <?php }} ?>
                                        </select>

                                        <a class="btn" style="margin-left: 10px;" onclick="$('#myModal').modal('show')"> <i class="icon-plus-sign"></i> <?php echo lang ('Create group', 'banners'); ?></a>
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="data"><?php echo lang ('Selected items', 'banners'); ?>:</label>
                                <div class="controls">
                                    <select id="data" name="data[]" multiple="multiple" class="notchosen" style="height:200px; max-width: 500px !important" >
                                        <?php $result = unserialize($banner['where_show']); 
 if(is_true_array($result)){ foreach ($result as $w){ ?>
                                        <option  ondblclick='delEntity(this)' value="<?php echo $w?>"><?php echo get_entity_mod ($w); ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="banner_type"><?php echo lang ('Show in categories (select items)', 'banners'); ?>:</label>
                                <div class="controls">
                                    <select id="banner_type" onchange="autosearch(this, '/admin/components/init_window/banners/autosearch', '#autodrop', 'autodrop')">
                                        <option value="default">--<?php echo lang ('select essence', 'banners'); ?>--</option>
                                        <option value="main"><?php echo lang ('Main', 'banners'); ?></option>
                                        <?php if($is_shop): ?>
                                        <option value="product"><?php echo lang ('Product', 'banners'); ?></option>
                                        <option value="shop_category"><?php echo lang ('Product category', 'banners'); ?></option>
                                        <option value="brand"><?php echo lang ('Brand', 'banners'); ?></option>
                                        <?php endif; ?>
                                        <option value="category"><?php echo lang ('Pages categories', 'banners'); ?></option>
                                        <option value="page"><?php echo lang ('Pages', 'banners'); ?></option>
                                    </select>
                                    <div id="autodrop"></div>

                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php echo lang ('Active until', 'banners'); ?>:</label>
                                <div class="controls">
                                    <span class="frame_label no_connection">
                                        <span class="niceCheck b_n" onclick="$('#active_to').fadeToggle()">
                                            <input required="required"
                                            type="checkbox"
                                            <?php if($banner['active_to'] == -1): ?>checked="checked"<?php endif; ?>
                                            name="active_to_permanent"/>
                                        </span>
                                    </span>
                                    <?php echo lang ('Banner permanent', 'banners'); ?>
                                </div>
                                <div class="controls">
                                    <input class="datepicker"
                                    id="active_to"
                                    required="required"
                                    type="text"
                                    <?php if($banner['active_to'] == -1): ?>style="display: none"<?php endif; ?>
                                    value="<?php if($banner['active_to']): ?><?php echo date('Y-m-d',$banner['active_to'])?><?php else:?><?php echo $date?><?php endif; ?>"
                                    name="active_to" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="Img">
                                    <?php echo lang ('Image', 'banners'); ?>: <span class="must">*</span>
                                </label>
                                <div class="controls">
                                    <div class="group_icon pull-right">
                                        <a href="<?php echo site_url('application/third_party/filemanager/dialog.php?type=1&field_id=Img');?>" class="btn  iframe-btn" type="button">
                                            <i class="icon-picture"></i>
                                            <?php echo lang ('Choose an image ', 'banners'); ?>
                                        </a>
                                    </div>
                                    <div class="o_h" id="banerChangePhoto">
                                        <input type="text" name="photo" id="Img" value="<?php echo $banner['photo'];?>" required="required">
                                    </div>
                                    <div id="Img-preview" style="width: 400px;" class="m-t_20">
                                        <?php if($banner['photo']): ?>
                                        <img src="<?php echo $banner['photo']?>" class="img-polaroid">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<div id="elFinder"></div>
</section><?php $mabilis_ttl=1432206642; $mabilis_last_modified=1426010500; //application/modules/banners/assets/admin/edit.tpl ?>