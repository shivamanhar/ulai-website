<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title"><?php echo lang ("Module settings starRating", 'star_rating'); ?></span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?>admin/components/modules_table/" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u"><?php echo lang ("Back", 'admin'); ?></span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#widget_form"><i class="icon-ok"></i><?php echo lang ("Save", 'star_rating'); ?></button>
                <button type="button" class="btn btn-small formSubmit" data-form="#widget_form" data-action="tomain"><i class="icon-check"></i><?php echo lang ("Save and exit", 'star_rating'); ?></button>
            </div>
        </div>
    </div>
    <form action="<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?>admin/components/cp/star_rating/update_settings" id="widget_form" method="post" class="form-horizontal">
        <div class="tab-content">
            <div class="tab-pane active" id="likes">
                <div class="row-fluid">
                    <table class="table  table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <th><?php echo lang ('Show on pages', 'star_rating'); ?></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>


                                 <div class="control-group">
                                    <label class="control-label" style="padding-top: 2px;"><?php echo lang ('Show on', 'star_rating'); ?>:</label>
                                    <div class="controls">
                                        <div class="">
                                         <span class="frame_label">
                                           <span class="niceCheck">
                                               <input type="checkbox" name="sr[main]" value="1" <?php if($settings->main == 1): ?>checked="checked"<?php endif; ?>/>
                                           </span> <?php echo lang ('Main', 'star_rating'); ?>
                                       </span>
                                   </div>
                                   <div class="">
                                       <span class="frame_label ">
                                           <span class="niceCheck">
                                               <input type="checkbox" name="sr[page]" value="1" <?php if($settings->page == 1): ?>checked="checked"<?php endif; ?>/>
                                           </span> <?php echo lang ('Contains', 'star_rating'); ?>
                                       </span>
                                   </div>
                                   <div class="">
                                       <span class="frame_label">
                                           <span class="niceCheck">
                                               <input type="checkbox" name="sr[category]" value="1" <?php if($settings->category == 1): ?>checked="checked"<?php endif; ?>/>
                                           </span>
                                           <?php echo lang ('Category', 'star_rating'); ?>
                                       </span>
                                   </div>
                                   <?php if($is_shop != null): ?>
                                   <div class="">
                                       <span class="frame_label">
                                           <span class="niceCheck">
                                               <input type="checkbox" name="sr[product]" value="1" <?php if($settings->product == 1): ?>checked="checked"<?php endif; ?>/>
                                           </span> <?php echo lang ('Product', 'star_rating'); ?>
                                       </span>
                                   </div>
                                   <div class="">
                                       <span class="frame_label">
                                           <span class="niceCheck">
                                               <input type="checkbox" name="sr[shop_category]" value="1" <?php if($settings->shop_category == 1): ?>checked="checked"<?php endif; ?>/>
                                           </span> <?php echo lang ('Products category', 'star_rating'); ?>
                                       </span>
                                   </div>
                                   <div class="">
                                       <span class="frame_label">
                                           <span class="niceCheck">
                                               <input type="checkbox" name="sr[brand]" value="1" <?php if($settings->brand == 1): ?>checked="checked"<?php endif; ?>/>
                                           </span> <?php echo lang ('Brands', 'star_rating'); ?>
                                       </span>
                                   </div>
                                   <?php endif; ?>
                               </div>
                           </div>


                       </td>
                   </tr>
               </tbody>
           </table>
       </div>
   </div>
   <?php echo form_csrf (); ?>
</div>
</form>
</section>
<!--                <div class="form_text">Код для вставки в шаблон:  echo $CI->load->module('share')->_make_share_form()</div>
    <div class="form_overflow"></div>-->

<?php $mabilis_ttl=1432201615; $mabilis_last_modified=1426010500; //application/modules/star_rating/assets/admin/settings.tpl ?>