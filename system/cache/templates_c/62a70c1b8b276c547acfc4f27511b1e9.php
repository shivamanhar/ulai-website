<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title"><?php echo lang ('Banner creating', 'banners'); ?></span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="/admin/components/init_window/banners" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u"><?php echo lang ('Back', 'banners'); ?></span></a>
                <button onclick="selects()" type="button" class="btn btn-small btn-success formSubmit" data-form="#image_upload_form" data-submit data-action="toedit"><i class="icon-plus-sign icon-white"></i><?php echo lang ('Create', 'admin'); ?></button>
                <button onclick="selects()" type="button" class="btn btn-small action_on formSubmit" data-form="#image_upload_form" data-action="tomain"><i class="icon-check"></i><?php echo lang ('Create and exit', 'admin'); ?></button>
            </div>
        </div>
    </div>
    <form method="post" action="/admin/components/init_window/banners/create" enctype="multipart/form-data" id="image_upload_form" class="m-t_10">
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
                                        <input type="text" name="name" class="input-long" id="Name" value="" required/>
                                    </div>
                                    <div class="controls">
                                        <span class="frame_label no_connection m-r_15">
                                            <span class="niceCheck" style="background-position: -46px 0px; ">
                                                <input type="checkbox" name="active" value="1" checked="checked">
                                            </span>
                                            <?php echo lang ('Active', 'banners'); ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="Text"><?php echo lang ('Text banner', 'banners'); ?> <?php if(isset($translatable)){ echo $translatable; } ?>:</label>
                                    <div class="controls">
                                        <textarea name="description" id="Text" class="elRTE" ></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="Url"> <?php echo lang ('URL', 'banners'); ?> <?php if(isset($translatable)){ echo $translatable; } ?>:</label>
                                    <div class="controls">
                                        <input type="text" name="url" id="Url" value=""/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="data"><?php echo lang ('Selected items', 'banners'); ?>:</label>
                                    <div class="controls">
                                        <select id="data" name="data[]" multiple="multiple" class="notchosen" >

                                        </select>
                                        <span class="help-block"><?php echo lang ('Double click to deleting', 'banners'); ?></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="banner_type"><?php echo lang ('Show in categories (select items)', 'banners'); ?>:</label>
                                    <div class="controls">
                                        <select id="banner_type" name="" onchange="autosearch(this, '/admin/components/init_window/banners/autosearch', '#autodrop', 'autodrop')">
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
                                        <div id="autodrop" >
                                        </div>

                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo lang ('Active until', 'banners'); ?>:</label>
                                    <div class="controls">
                                        <span class="frame_label no_connection">
                                            <span class="niceCheck b_n no_connection" onclick="$('#active_to').fadeToggle()">
                                                <input required="required"
                                                type="checkbox"
                                                checked="checked"
                                                name="active_to_permanent"/>
                                            </span>
                                        </span>
                                        <?php echo lang ('Banner permanent', 'banners'); ?>
                                    </div>
                                    <div class="controls">
                                        <input class="datepicker" id="active_to" type="text" value="" name="active_to" style="display: none"/>
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
                                            <input type="text" name="photo" id="Img" value="" required="required" >
                                        </div>
                                        <div id="Img-preview" style="width: 400px;" class="m-t_20"></div>
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
</section><?php $mabilis_ttl=1432206569; $mabilis_last_modified=1426010500; //application/modules/banners/assets/admin/create.tpl ?>