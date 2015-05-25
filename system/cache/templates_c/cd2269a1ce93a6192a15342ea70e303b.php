<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title"><?php echo lang ("Feedback settings", 'feedback'); ?></span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="/admin/components/modules_table/" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u"><?php echo lang ("Back", 'admin'); ?></span></a>
                    <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#save" data-submit><i class="icon-ok icon-white"></i><?php echo lang ("Save", 'feedback'); ?></button>
                </div>
            </div>                            
        </div>               
        <div class="tab-content">
            <!-----------------------------------------------------SETTINGS-------------------------------------------------------------->
            <div class="tab-pane active" id="mail">
                <table class="table  table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                <?php echo lang ("Properties", 'feedback'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd">
                                    <div class="form-horizontal">
                                        <form id="save" method="post" action="<?php echo site_url ('admin/components/cp/feedback/settings/update'); ?>">
                                            <div class="control-group">
                                                <label class="control-label" for="email"><?php echo lang ("E-Mail", 'feedback'); ?></label>
                                                <div class="controls">
                                                    <input type="text" class="textbox_long" name="email" id="email" value="<?php echo $settings['email']; ?>" />
                                                    <span class="help-block"><?php echo lang ("Specify the e-mail address for mailing", 'feedback'); ?></span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="message_max_len"><?php echo lang ("Maximum message length", 'feedback'); ?></label>
                                                <div class="controls">
                                                    <input type="text" class="textbox_long" name="message_max_len" id="message_max_len" value="<?php echo $settings['message_max_len']; ?>" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<?php $mabilis_ttl=1432201571; $mabilis_last_modified=1426010500; ///var/www/application/modules/feedback/templates/admin/settings.tpl ?>