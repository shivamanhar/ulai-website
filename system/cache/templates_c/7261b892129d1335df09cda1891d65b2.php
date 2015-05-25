<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title"><?php echo lang ('Discounts of online store', 'mod_discount'); ?> (<?php echo count($discountsList)?>)</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <!--        <button title="Фильтровать" type="submit" class="btn btn-small"><i class="icon-filter"></i>Фильтр</button>
                        <a href="/admin/components/run/shop/search/index" title="Сбросить фильтр" type="button" class="btn btn-small pjax"><i class="icon-refresh"></i>Сбросить фильтр</a>-->
                <a class="btn btn-small btn-success" href="/admin/components/init_window/mod_discount/create"><i class="icon-plus-sign icon-white"></i><?php echo lang ('Create discount', 'mod_discount'); ?></a>
            </div>
        </div>
        <div class="pull-right">
            <?php echo lang ('Choose discount type', 'mod_discount'); ?>
            <div class="d-i_b">
                <select id="selectFilterDiscountType">
                    <option  <?php if(!$_GET['filterBy']): ?>selected=selected<?php endif; ?>value=""><?php echo lang ('All', 'mod_discount'); ?></option>
                    <option <?php if($_GET['filterBy'] == "all_order"): ?>selected=selected<?php endif; ?> value="all_order"><?php echo lang ('Order amount of more than', 'mod_discount'); ?></option>
                    <option <?php if($_GET['filterBy'] == "comulativ"): ?>selected=selected<?php endif; ?>value="comulativ"><?php echo lang ('Cumulative discount', 'mod_discount'); ?></option>
                    <option <?php if($_GET['filterBy'] == "user"): ?>selected=selected<?php endif; ?>value="user"><?php echo lang ('User', 'mod_discount'); ?></option>
                    <option <?php if($_GET['filterBy'] == "group_user"): ?>selected=selected<?php endif; ?>value="group_user"><?php echo lang ('User group', 'mod_discount'); ?></option>
                    <option <?php if($_GET['filterBy'] == "category"): ?>selected=selected<?php endif; ?>value="category"><?php echo lang ('Category', 'mod_discount'); ?></option>
                    <option <?php if($_GET['filterBy'] == "product"): ?>selected=selected<?php endif; ?>value="product"><?php echo lang ('Product', 'mod_discount'); ?></option>
                    <option <?php if($_GET['filterBy'] == "brand"): ?>selected=selected<?php endif; ?>value="brand"><?php echo lang ('Brand', 'mod_discount'); ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <?php if(count($discountsList) > 0): ?>
            <table class="table  table-bordered table-hover table-condensed discounts_table t-l_a">
                <thead>
                    <tr style="cursor: pointer;">
                        <th><?php echo lang ('Key', 'mod_discount'); ?></th>
                        <th><?php echo lang ('Name', 'mod_discount'); ?></th>
                        <th><?php echo lang ('Limit', 'mod_discount'); ?></th>
                        <th><?php echo lang ('Used', 'mod_discount'); ?></th>
                        <th><?php echo lang ('Beggining time', 'mod_discount'); ?></th>
                        <th><?php echo lang ('End time', 'mod_discount'); ?></th>
                        <th style="width: 60px;"><?php echo lang ('Active', 'mod_discount'); ?></th>
                        <th style="width: 60px;"><?php echo lang ('Delete', 'mod_discount'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_true_array($discountsList)){ foreach ($discountsList as $discount){ ?>
                        <tr data-id="<?php echo $discount['id']?>">
                            <td>
                                <a data-rel="tooltip" data-title="<?php echo lang ("Edit discount", 'mod_discount'); ?>" href="/admin/components/init_window/mod_discount/edit/<?php echo $discount['id']?>" ><?php echo $discount['key']?></a>
                            </td>
                            <td>
                                <p><?php echo $discount['name']?></p>
                            </td>
                            <td>
                                <?php if($discount['max_apply'] != 0): ?>
                                    <?php echo $discount['max_apply']?>
                                <?php else:?> 
                                    <?php if(!$discount['max_apply'] && $discount['is_gift']): ?>1<?php else:?><?php echo lang ('Unlimited', 'mod_discount'); ?><?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($discount['count_apply'] != null): ?>
                                    <?php echo $discount['count_apply']?>
                                <?php else:?> - 
                                <?php endif; ?>
                            </td>
                            <td <?php if(time()< (int)$discount['date_begin']): ?>style="color: red;"<?php endif; ?>>
                                <?php echo date("Y-m-d", $discount['date_begin'])?>
                            </td>
                            <td <?php if(time()> (int)$discount['date_end'] && $discount['date_end'] != '0'): ?>style="color: red;"<?php endif; ?>>
                                <?php if($discount['date_end'] != 0): ?>
                                    <?php echo date("Y-m-d", $discount['date_end'])?>
                                <?php else:?> - 
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="
                                     <?php if($discount['active'] == 1): ?>
                                         <?php echo lang ('Yes', 'mod_discount'); ?>
                                     <?php else:?>
                                         <?php echo lang ('No', 'mod_discount'); ?>
                                     <?php endif; ?>">
                                    <?php if($discount['active'] == 1): ?>
                                        <span class="prod-on_off" data-id="<?php echo $discount['id']?>"></span>
                                    <?php else:?>
                                        <span class="prod-on_off disable_tovar" data-id="<?php echo $discount['id']?>"></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <button class="btn removeDiscountLink btn-small">
                                    <i class="icon-trash"></i> 
                                </button>
                            </td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        <?php else:?>

            <div class="alert alert-info" style="margin: 18px;" ><?php echo lang ('Discounts list is empty', 'mod_discount'); ?></div>

        <?php endif; ?>
    </div>
</section>
<?php $mabilis_ttl=1432206723; $mabilis_last_modified=1426010500; //application/modules/mod_discount/assets/admin/list.tpl ?>