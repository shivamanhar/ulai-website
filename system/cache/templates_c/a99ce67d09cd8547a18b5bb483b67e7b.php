<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title"><?php echo lang ("RSS channel options or specifications", 'rss'); ?></span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?>admin/components/modules_table" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u"><?php echo lang ("Back", 'admin'); ?></span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#rss_settings_form" data-submit><i class="icon-ok"></i><?php echo lang ("Save", 'rss'); ?></button>
            </div>
        </div>
    </div>
    <form action="<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?>admin/components/cp/rss/settings_update" id="rss_settings_form" method="post" class="form-horizontal m-t_10">
        <table class="table  table-bordered table-hover table-condensed content_big_td">
            <thead>
            <th><?php echo lang ("Settings", 'rss'); ?></th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="inside_padd">
                            <div class="control-group">
                                <label class="control-label" for="comcount"><?php echo lang ("Name", 'rss'); ?>:</label>
                                <div class="controls">
                                    <input type="text" name="title" value="<?php echo $settings['title']; ?>" id="comcount"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="symcount"><?php echo lang ("Description", 'rss'); ?>:</label>
                                <div class="controls">
                                    <textarea class="mceEditor" name="description" id="symcount"><?php echo $settings['description']; ?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="selectcat"><?php echo lang ("Categories", 'rss'); ?>:</label>
                                <div class="controls">
                                    <select name="categories[]" multiple="multiple" id="selectcat">
                                        <option value="0" <?php if($settings['categories']['0']  == 0): ?> selected="selected" <?php endif; ?>><?php echo lang ("Without a category", 'rss'); ?></option>
                                        <option disabled="disabled"> </option>
                                        <?php echo build_cats_tree($cats,  $settings['categories'] ) ?>
                                    </select>
                                    <span class="help-block"><?php echo lang ("Choose transmition categories", 'rss'); ?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="pages_count"><?php echo lang ("Number of pages", 'rss'); ?>:</label>
                                <div class="controls">
                                    <input type="text" name="pages_count" value="<?php echo $settings['pages_count']; ?>" id="pages_count"/>
                                    <span class="help-block"><?php echo lang ("Specify the number of pages for display", 'rss'); ?></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="cache"><?php echo lang ("Cache", 'rss'); ?>:</label>
                                <div class="controls">
                                    <input type="text" name="cache_ttl" value="<?php echo $settings['cache_ttl']; ?>" id="cache"/>
                                    <span class="help-block"><?php echo lang ("Specify caсhe lifetime in minutes", 'rss'); ?></span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php echo form_csrf (); ?>
    </form>
</section><?php $mabilis_ttl=1432201617; $mabilis_last_modified=1426010500; ///var/www/application/modules/rss/templates/admin/settings.tpl ?>