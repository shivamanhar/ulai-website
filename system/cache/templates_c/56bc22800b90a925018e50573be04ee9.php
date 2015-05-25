<div class="container">
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo lang ('Module deinstalling', 'admin'); ?></h3>
        </div>
        <div class="modal-body">
            <p><?php echo lang ('Delete selected module(s)?', 'admin'); ?></p>
        </div>
        <div class="modal-footer">  `
            <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('/admin/components/deinstall')" ><?php echo lang ('Delete','admin'); ?></a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');"><?php echo lang ('Cancel','admin'); ?></a>
        </div>
    </div>


    <div id="delete_dialog" title="<?php echo lang ('Module deinstalling','admin'); ?>" style="display: none">
        <?php echo lang ('Delete modules?','admin'); ?>
    </div>
    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

    <form method="post" action="#">
        <section class="mini-layout">
            <div class="frame_title clearfix">
                <div class="pull-left">
                    <span class="help-inline"></span>
                    <span class="title" id="allM"><?php echo lang ('All modules','admin'); ?></span>
                </div>
                <div class="pull-right">
                    <div class="d-i_b">
                        <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()" id="module_delete"><i class="icon-trash"></i><?php echo lang ('Delete','admin'); ?></button>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="clearfix">
                    <div class="btn-group myTab m-t_10 pull-left" data-toggle="buttons-radio">
                        <a href="#modules" class="btn btn-small active" onclick="$('#allM').html('<?php echo lang ('All modules','admin'); ?>')"><?php echo lang ('Modules','admin'); ?></a>
                        <a href="#set_modul" class="btn btn-small" onclick="$('#allM').html('<?php echo lang ('Install modules','admin'); ?>')"><?php echo lang ('Install modules','admin'); ?></a>
                    </div>
                    <div class="pull-right m-t_10">
                        <input type="text" id="modules_filter" class="span3 m-b_0" placeholder="<?php echo lang ('Start typing name here','admin'); ?>" />
                    </div>
                </div>
                <div class="tab-content">
                    <?php if(count($installed) != 0): ?>
                        <div class="tab-pane active" id="modules">
                            <div class="row-fluid">
                                <table class="modules_table table  table-bordered table-hover table-condensed t-l_a">
                                    <thead>
                                        <tr>
                                            <th class="t-a_c span1">
                                                <span class="frame_label">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox"/>
                                                    </span>
                                                </span>
                                            </th>
                                            <th><?php echo lang ('Module','admin'); ?></th>
                                            <th><?php echo lang ('Description','admin'); ?></th>
                                            <th width="120"><?php echo lang ('URL','admin'); ?></th>
                                            <th class="t-a_c" width="80"><?php echo lang ('Auto loading ','admin'); ?></th>
                                            <th class="t-a_c" width="80"><?php echo lang ('URL access','admin'); ?></th>
                                            <th class="t-a_c" width="120"><?php echo lang ('Show in menu','admin'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="sortable save_positions" data-url="/admin/components/save_components_positions">
                                        <?php if(is_true_array($installed)){ foreach ($installed as $module){ ?>
                                            <?php if($module['name']  == 'shop'): ?>
                                                <?php continue;?>
                                            <?php endif; ?>
                                            <tr data-id="<?php echo $module['id']; ?>" class="module_row">
                                                <td class="t-a_c">
                                                    <span class="frame_label">
                                                        <?php if($module['name']  != 'shop' &&  $module['name']  != 'cmsemail'): ?>
                                                            <span class="niceCheck b_n">
                                                                <input type="checkbox" name="ids" value="<?php echo $module['name']; ?>"/>
                                                            </span>
                                                        <?php endif; ?>
                                                    </span>
                                                </td>
                                                <td class="module_name">
                                                    <div class="pull-left" style="width: 10%;">
                                                        <?php if($module['icon_class']): ?>
                                                            <i class="<?php echo $module['icon_class']?>" style="margin-left: 5px;"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div style="margin-left: 25px;">
                                                        <?php if($module['admin_file'] == 1): ?>
                                                            <?php if($module['name']  == 'shop'): ?>
                                                                <?php echo $module['menu_name']; ?>
                                                            <?php else:?>
                                                                <a href="/admin/components/init_window/<?php echo $module['name']; ?>"><?php echo $module['menu_name']; ?></a>
                                                            <?php endif; ?>
                                                        <?php else:?>
                                                            <?php echo $module['menu_name']; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!--                                    <a href="#"><?php echo lang ('Users','admin'); ?></a>-->
                                                </td>
                                                <td class="module_description">
                                                    <p><?php echo $module['description']; ?></p>
                                                </td>
                                                <td class="urlholder">
                                                    <?php if($module['admin_file'] == 1): ?>
                                                        <?php if($module['name']  == 'shop'): ?>
                                                            <?php echo $module['menu_name']; ?>
                                                        <?php else:?>
                                                            <p><?php if($module['enabled'] == "1"): ?><?php echo anchor ( $module['name'] , $module['identif'] ,array('target'=>'_blank')); ?><?php else:?>-<?php endif; ?></p>
                                                        <?php endif; ?>
                                                    <?php else:?>
                                                        <p><?php if($module['enabled'] == "1"): ?><?php echo $module['identif']; ?><?php else:?>-<?php endif; ?></p>
                                                    <?php endif; ?>

                                                </td>
                                                <td class="t-a_c">
                                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="<?php if(! $module['autoload']): ?><?php echo lang ('switch off','admin'); ?><?php else:?><?php echo lang ('switch on','admin'); ?><?php endif; ?>"  data-off="<?php echo lang ('switch off','admin'); ?>">
                                                        <span class="prod-on_off autoload_ch <?php if(! $module['autoload']): ?>disable_tovar<?php endif; ?>" data-mid="<?php echo $module['id']; ?>"></span>
                                                    </div>
                                                </td>
                                                <td class="t-a_c">
                                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="<?php if(! $module['enabled']): ?><?php echo lang ('switch off','admin'); ?><?php else:?><?php echo lang ('switch on','admin'); ?><?php endif; ?>"  data-off="<?php echo lang ('switch off','admin'); ?>">
                                                        <span class="prod-on_off urlen_ch <?php if(! $module['enabled']): ?>disable_tovar<?php endif; ?> <?php if($module['name']  == 'filter'): ?>disabled<?php endif; ?>" data-mid="<?php echo $module['id']; ?>" data-murl="<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?><?php echo $module['identif']; ?>" data-mname="<?php echo $module['identif']; ?>"></span>
                                                    </div>
                                                </td>
                                                <td class="t-a_c">
                                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="<?php if(! $module['in_menu']): ?><?php echo lang ('switch off','admin'); ?><?php else:?><?php echo lang ('switch on','admin'); ?><?php endif; ?>"  data-off="<?php echo lang ('switch off','admin'); ?>">
                                                        <span class="prod-on_off show_in_menu <?php if($module['in_menu']  == 0): ?>disable_tovar<?php endif; ?>" data-mid="<?php echo $module['id']; ?>"></span>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else:?>
                        <h3><?php echo lang ('Modules has not been installed','admin'); ?></h3>
                    <?php endif; ?>
                    <div class="tab-pane" id="set_modul">
                        <?php if(count($not_installed) > 0): ?>
                            <div class="row-fluid" id="nimc">
                                <table class="table  table-bordered table-hover table-condensed t-l_a" id="nimt">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang ('Module','admin'); ?></th>
                                            <th><?php echo lang ('Description','admin'); ?></th>
                                            <th><?php echo lang ('Version','admin'); ?></th>
                                            <th><?php echo lang ('Install','admin'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="nim">
                                        <?php if(is_true_array($not_installed)){ foreach ($not_installed as $module){ ?>
                                            <tr class="module_row">
                                                <td class="module_name">
                                                    <div class="pull-left" style="width: 10%;">
                                                        <?php if($module['icon_class']): ?>
                                                            <i class="<?php echo $module['icon_class']?>" style="margin-left: 5px;"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div style="margin-left: 25px;">
                                                        <?php echo $module['menu_name']; ?>
                                                    </div>
                                                </td>
                                                <td class="module_description">
                                                    <p><?php echo $module['description']; ?></p>
                                                </td>
                                                <td class="fdel">
                                                    <p><?php echo $module['version']; ?></p>
                                                </td>
                                                <td class="fdel2">
                                                    <a href="#" class="mod_instal" data-mname="<?php echo $module['com_name']; ?>" data-mid="<?php echo $module['id']; ?>"><?php echo lang ('Install','admin'); ?></a>
                                                </td>
                                            </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else:?>
                            </br>
                            <div class="alert alert-info">
                                <?php echo lang ('There is not any module for install!', 'admin'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        </section>
    </form>
</div><?php $mabilis_ttl=1432201504; $mabilis_last_modified=1426010500; ///var/www/templates/administrator/module_table.tpl ?>