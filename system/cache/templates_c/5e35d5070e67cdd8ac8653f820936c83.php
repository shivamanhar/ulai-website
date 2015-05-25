<div class="container">
    <div class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo lang ('Order removal','admin'); ?></h3>
        </div>
        <div class="modal-body">
            <p><?php echo lang (' Delete selected orders?','admin'); ?></p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="orders.deleteOrdersConfirm()" ><?php echo lang ('Delete','admin'); ?></a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');"><?php echo lang ('Cancel','admin'); ?></a>
        </div>
    </div>

    <form method="get" action="/admin/components/run/shop/orders/index" id="ordersListFilter" class="listFilterForm">
        <section class="mini-layout">
            <div class="frame_title clearfix">
                <div class="pull-left">
                    <span class="help-inline"></span>
                    <span class="title"><?php echo lang ('Orders list','admin'); ?> <?php /* ?>(<?php if(isset($totalOrders)){ echo $totalOrders; } ?>)<?php */ ?></span>
                </div>
                <div class="pull-right">
                    <div class="d-i_b">
                        <a title="<?php echo lang ('Reset filter','admin'); ?>" type="button" <?php if(!$_GET || (count($_GET)==1 && $_GET['_pjax'])): ?>disabled="disabled"<?php else:?>href="<?php if(isset($ADMIN_URL)){ echo $ADMIN_URL; } ?>orders/index"<?php endif; ?> class="btn btn-small"><i class="icon-refresh"></i><?php echo lang ('Cancel filter','admin'); ?></a>
                        <div class="dropdown d-i_b">
                            <button type="submit" class="d_n btn btn-small disabled action_on listFilterSubmitButton" disabled="disabled"><i class="icon-filter"></i><?php echo lang ('Filter','admin'); ?></button>
                            <button type="button" class="btn btn-small dropdown-toggle disabled action_on" data-toggle="dropdown">
                                <i class="icon-bookmark"></i>
                                <?php echo lang ('Change status','admin'); ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="nav-header"><?php echo lang ('Order status','admin'); ?></li>
                                <?php if(is_true_array($orderStatuses)){ foreach ($orderStatuses as $os){ ?>
                                <li><a onclick="orders.chOrderStatus(<?php echo $os->getId()?>)" href="#" class="chOrderStatus" ><?php echo $os->getName()?></a></li>
                                <?php }} ?>
                                <li class="nav-header"><?php echo lang ('Payment status','admin'); ?></li>
                                <li><a onclick="orders.chOrderPaid(1)" href="#" id="chOrderStatusNew" ><?php echo lang ('Paid','admin'); ?></a></li>
                                <li><a onclick="orders.chOrderPaid(0)" href="#" id="chOrderStatusDelivered" ><?php echo lang ('Not paid','admin'); ?></a></li>
                            </ul>
                        </div>
                        <button onclick="orders.deleteOrders()" type="button" class="btn btn-small btn-danger disabled action_on"><i class="icon-trash"></i><?php echo lang ('Delete','admin'); ?></button>
                        <a href="/admin/components/run/shop/orders/create" class="btn btn-small btn-success pjax"><i class="icon-plus-sign icon-white"></i><?php echo lang ('Create order','admin'); ?></a>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <table class="table  table-bordered table-hover table-condensed t-l_a">
                    <thead>
                        <tr>
                            <th class="t-a_c span1">
                                <span class="frame_label">
                                    <span class="niceCheck" style="background-position: -46px 0px; ">
                                        <input type="checkbox">
                                    </span>
                                </span>
                            </th>
                            <th class="span1" id="orderId">
                                <a href="#" class="order_list_order" data-method="Id" data-criteria="<?php if($orderField == 'Id'): ?><?php if(isset($nextOrderCriteria)){ echo $nextOrderCriteria; } ?><?php else:?>ASC<?php endif; ?>"><?php echo lang ('ID','admin'); ?></a>
                                <?php if(isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'Id' AND ShopCore::$_GET['orderCriteria']): ?>
                                <?php if(ShopCore::$_GET['orderCriteria'] == 'ASC'): ?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                                <?php endif; ?>
                            </th>
                            <th id="orderStatus" class="span1" style="width:12%;">
                                <a class="order_list_order" href="#" data-method="Status" data-criteria="<?php if($orderField == 'Status'): ?><?php if(isset($nextOrderCriteria)){ echo $nextOrderCriteria; } ?><?php else:?>ASC<?php endif; ?>"><?php echo lang ('Status','admin'); ?></a>
                                <?php if(isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'Status'): ?>
                                <?php if(ShopCore::$_GET['orderCriteria'] == 'ASC'): ?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                                <?php endif; ?>
                            </th>
                            <th id="orderDateCreated" class="span3">
                                <a href="#" class="order_list_order" data-method="DateCreated" data-criteria="<?php if($orderField == 'DateCreated'): ?><?php if(isset($nextOrderCriteria)){ echo $nextOrderCriteria; } ?><?php else:?>ASC<?php endif; ?>"><?php echo lang ('Date','admin'); ?></a>
                                <?php if(isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'DateCreated'): ?>
                                <?php if(ShopCore::$_GET['orderCriteria'] == 'ASC'): ?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                                <?php endif; ?>
                            </th>
                            <th class="span2"><?php echo lang ('Customer','admin'); ?></th>
                            <th class="span1"><?php echo lang ('Products','admin'); ?></th>
                            <th id="orderTotalPrice" style="width: 15%">
                                <a href="#" class="order_list_order" data-method="TotalPrice" data-criteria="<?php if($orderField == 'TotalPrice'): ?><?php if(isset($nextOrderCriteria)){ echo $nextOrderCriteria; } ?><?php else:?>ASC<?php endif; ?>"><?php echo lang ('Total price','admin'); ?> <?php echo lang ('no delivery','admin'); ?></a>
                                <?php if(isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'TotalPrice'): ?>
                                <?php if(ShopCore::$_GET['orderCriteria'] == 'ASC'): ?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                                <?php endif; ?>
                            </th>
                            <th id="orderPaid" class="span2">
                                <a href="#" class="order_list_order" data-method="Paid" data-criteria="<?php if($orderField == 'Paid'): ?><?php if(isset($nextOrderCriteria)){ echo $nextOrderCriteria; } ?><?php else:?>ASC<?php endif; ?>"><?php echo lang ('Payment status','admin'); ?></a>

                                <?php if(isset(ShopCore::$_GET['orderMethod']) AND ShopCore::$_GET['orderMethod'] == 'Paid'): ?>
                                <?php if(ShopCore::$_GET['orderCriteria'] == 'ASC'): ?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                                <?php endif; ?>
                                <input type="hidden" name="orderMethod" value="<?php if(isset(ShopCore::$_GET['orderMethod'])): ?><?php echo ShopCore::$_GET['orderMethod']?><?php else:?>Id<?php endif; ?>"/>
                                <!--<input type="hidden" name="orderCriteria" value="<?php if(ShopCore::$_GET['orderCriteria'] != ''): ?><?php ShopCore::$_GET['orderCriteria']?><?php else:?>DESC<?php endif; ?>"/>-->
                                <input type="hidden" name="orderCriteria" value="<?php echo ShopCore::$_GET['orderCriteria']?>"/>
                            </th>
                        </tr>
                        <tr class="head_body">
                            <td>
                            </td>
                            <td class="number">
                                <div>
                                    <input type="text" name="order_id" data-placement="top" data-original-title="<?php echo lang ('numbers only','admin'); ?>" value="<?php echo $_GET['order_id']; ?>">
                                </div>
                            </td>
                            <td>
                                <select name="status_id" onchange="$(this).closest('form').submit();">
                                    <option <?php if(!$_GET['status_id']): ?> selected="selected" <?php endif; ?> >-- <?php echo lang ('All', 'admin'); ?> --</option>
                                    <?php if(is_true_array($orderStatuses)){ foreach ($orderStatuses as $orderStatus){ ?>
                                    <option <?php if($orderStatus->getId() == $_GET['status_id']): ?> selected="selected" <?php endif; ?> value="<?php echo $orderStatus->getId()?>"><?php echo $orderStatus->getName()?></option>
                                    <?php }} ?>
                                </select>
                            </td>
                            <td class="f-s_0">
                                <label class="v-a_m" style="width:47%;margin-right:6%; display: inline-block;margin-bootom:0px;">
                                    <span class="o_h d_b p_r">
                                        <input type="text" placeholder="<?php echo lang ('from','admin'); ?>" data-placement="top" data-original-title="<?php echo lang ('choose a date','admin'); ?>" data-rel="tooltip" class="datepicker "  name="created_from" value="<?php echo $_GET['created_from']; ?>" >
                                        <i class="icon-calendar"></i>
                                    </span>
                                </label>
                                <label class="v-a_m" style="width:47%; display: inline-block;margin-bootom:0px;">
                                    <span class="o_h d_b p_r">
                                        <input type="text" placeholder="<?php echo lang ('to','admin'); ?>" data-placement="top" data-original-title="<?php echo lang ('choose a date','admin'); ?>" data-rel="tooltip" class="datepicker "  name="created_to" value="<?php echo $_GET['created_to']; ?>">
                                        <i class="icon-calendar"></i>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <input  type="text" name="customer" id="usersDatas" value="<?php echo $_GET['customer']; ?>">
                            </td>
                            <td>
                                <input type="text" name="product" value="<?php echo $_GET['product']; ?>" id="ordersFilterProduct">
                                <input name="product_id" type="hidden" value="<?php echo $_GET['product_id']; ?>" id="ordersFilterProdId">
                            </td>
                            <td class="number f-s_0">
                             <label class="v-a_m" style="width:47%;margin-right:6%; display: inline-block;margin-bootom:0px;">
                                <span class="o_h d_b"><input value="<?php echo ShopCore::$_GET['amount_from']?>" placeholder="<?php echo lang ('from','admin'); ?>" type="text" data-placement="top" data-original-title="<?php echo lang ('numbers only','admin'); ?>" name="amount_from"></span>
                            </label>
                            <label class="v-a_m" style="width:47%;display: inline-block;margin-bootom:0px;">
                                <span class="o_h d_b"><input value="<?php echo ShopCore::$_GET['amount_to']?>" placeholder="<?php echo lang ('to','admin'); ?>" type="text" data-placement="top" data-original-title="<?php echo lang ('numbers only','admin'); ?>" name="amount_to"></span>
                            </label>
                        </td>
                        <td>
                            <select name="paid" onchange="$(this).closest('form').submit();">
                                <option <?php if(!ShopCore::$_GET['paid']): ?> selected="selected" <?php endif; ?> value="">-- <?php echo lang ('All', 'admin'); ?> --</option>
                                <option <?php if("0" === ShopCore::$_GET['paid']): ?> selected="selected" <?php endif; ?> value="0"><?php echo lang('Not paid','admin')?></option>
                                <option <?php if("1" == ShopCore::$_GET['paid']): ?> selected="selected" <?php endif; ?> value="1"><?php echo lang('Paid','admin')?></option>
                            </select>
                        </td>
                    </tr>
                </thead>
                <tbody >
                    <?php $total_price_all=0?><?php $total_products=0?><?php $total_paid=0?>
                    <?php if(is_true_array($model)){ foreach ($model as $o){ ?>
                    <tr data-original-title="" class="simple_tr">
                        <td class="t-a_c">
                            <span class="frame_label">
                                <span class="niceCheck" style="background-position: -46px 0px; ">
                                    <input type="checkbox" name="ids" value="<?php echo $o->getId()?>">
                                </span>
                            </span>
                        </td>
                        <td><a class="pjax" href="<?php if(isset($ADMIN_URL)){ echo $ADMIN_URL; } ?>orders/edit/<?php echo $o->getId()?>" data-title="<?php echo lang ('Edit order','admin'); ?>" data-rel="tooltip"><?php echo $o->getId()?></a></td>
                        <td>
                            <?php if(is_true_array($orderStatuses)){ foreach ($orderStatuses as $orderStatus){ ?>
                            <?php if($orderStatus->getId() == $o->getStatus()): ?>
                            <span class="badge" style="background-color: <?php echo $orderStatus->getColor()?>; color: <?php echo $orderStatus->getFontcolor()?>;">
                                <?php echo $orderStatus->getName()?>
                                <?php endif; ?>
                                <?php }} ?>
                            </span></td>
                            <td><?php echo date ("d-m-Y, H:i:s", $o->getDateCreated()); ?></td>
                            <td>
                                <?php if($o->getUserId()): ?><a class="pjax" href="<?php if(isset($ADMIN_URL)){ echo $ADMIN_URL; } ?>users/edit/<?php echo $o->getUserId()?>" data-title="<?php echo lang ('Edit user','admin'); ?>" data-rel="tooltip"><?php echo ShopCore::encode($o->getUserFullName())?></a>
                                <?php else:?> <?php echo ShopCore::encode($o->getUserFullName())?> <?php endif; ?>
                            </td>
                            <td>
                                <div class="buy_prod" data-title="<?php echo lang ('Purchased Product','admin'); ?>" data-original-title="">
                                    <?php $count = 0?>
                                    <?php if(is_true_array($o->getSOrderProductss())){ foreach ($o->getSOrderProductss() as $i){ ?>
                                    <?php $count += $i->getQuantity()?>
                                    <?php }} ?>
                                    <span><?php echo $count?></span>
                                    <i class="icon-info-sign"></i>
                                </div>
                                <div class="d_n">
                                    <?php if(is_true_array($o->getSOrderProductss())){ foreach ($o->getSOrderProductss() as $p){ ?>
                                    <div class="check_product">
                                        <?php $productUrl = '#'?>
                                        <?php $productModel = $p->getSProducts()?>
                                        <?php if($productModel): ?>
                                        <div class="">
                                            <?php $productUrl = '/shop/product/'.$productModel->getUrl()?>
                                            <a target="_blank" href="<?php if(isset($productUrl)){ echo $productUrl; } ?>"><?php echo $p->getProductName()?></a>
                                        </div>
                                        <?php else:?>
                                        <?php echo $p->getProductName()?>
                                        <?php endif; ?>
                                        <div class=""><?php echo $p->getVariantName()?></div>
                                        <?php if($p->getQuantity() != 1): ?>
                                        <?php echo $p->getQuantity()?> <?php echo lang ('pcs','admin'); ?>. ×
                                        <?php endif; ?>
                                        <?php echo $p->getPrice(true)?> <?php if(isset($CS)){ echo $CS; } ?>
                                    </div>
                                    <?php }} ?>
                                </div>
                            </td>

                            <td>

                                <?php //$total = 0?>

                                <?php if(is_true_array($o->getSOrderProductss())){ foreach ($o->getSOrderProductss() as $p){ ?>
                                <?php //$total = $total + $p->getQuantity() *  $p->getPrice()?>
                                <?php $total_products += $p->getQuantity()?>
                                <?php }} ?>
                                <?php $total_price_all+=$o->getTotalPrice()?>

                                <?php //$total?> <?php //$CS?>


                                <?php echo \Currency\Currency::create()->decimalPointsFormat($o->getTotalPrice())?> <?php if(isset($CS)){ echo $CS; } ?>

                            </td>
                            <td> <?php $count_orders++?>
                                <?php if($o->getPaid() == true): ?>
                                <span class="label label-success"><?php echo lang ('Paid','admin'); ?></span><?php $total_paid++?>
                                <?php else:?>
                                <span class="label"><?php echo lang ('Not paid','admin'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php }} ?>
                        <tr style="font-weight:bold;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?php if($total_products == 0): ?>
                                    <?php echo "-"?>
                                <?php else:?>
                                    <?php echo $total_products++?>
                                <?php endif; ?>    
                            </td>
                            <td>
                                <?php if($total_price_all == 0): ?>
                                    <?php echo "-"?>
                                <?php else:?>    
                                    <?php echo \Currency\Currency::create()->decimalPointsFormat($total_price_all)?> <?php if(isset($CS)){ echo $CS; } ?> 
                                <?php endif; ?>    
                            </td>
                            <td> 
                                <?php if($total_paid == 0 && $count_orders == NULL): ?>
                                    <?php echo "-"?> / <?php echo "-"?>
                                <?php else:?>
                                    <?php echo $total_paid++?> / <?php if(isset($count_orders)){ echo $count_orders; } ?> 
                                <?php endif; ?>    
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix">

                <?php if(isset($pagination)){ echo $pagination; } ?>


                <div class="pagination pull-right">

                    <select title="<?php echo lang ('Orders on the page','admin'); ?>" onchange="change_status('<?php if(isset($ADMIN_URL)){ echo $ADMIN_URL; } ?>orders/paginationVariant/' + this.value + '/1');" class="input-mini">
                        <option <?php if($paginationVariant == 12): ?> selected="selected" <?php endif; ?>>12</option>
                        <option <?php if($paginationVariant == 24): ?> selected="selected" <?php endif; ?>>24</option>
                        <option <?php if($paginationVariant == 36): ?> selected="selected" <?php endif; ?>>36</option>
                        <option <?php if($paginationVariant == 48): ?> selected="selected" <?php endif; ?>>48</option>
                        <option <?php if($paginationVariant == 60): ?> selected="selected" <?php endif; ?>>60</option>
                        <option <?php if($paginationVariant == 78): ?> selected="selected" <?php endif; ?>>78</option>
                        <option <?php if($paginationVariant == 100): ?> selected="selected" <?php endif; ?>>100</option>
                    </select>
                </div>
                <div class="pagination pull-right" style="margin-right: 10px; margin-top: 24px;"><?php echo lang ('Orders on the page','admin'); ?></div>
            </div>
        </section>
    </form>
</div>
<script type="text/javascript"> var usersDatas = <?php echo json_encode(array_values($usersDatas))?>;
var productsDatas = <?php echo json_encode($productsDatas)?>;
var orderField = "<?php if(isset($orderField)){ echo $orderField; } ?>";
var noc = "<?php if(isset($nextOrderCriteria)){ echo $nextOrderCriteria; } ?>";
var oldest_date = '<?php echo $oldest_order_date->oldest_date?>';
var newest_date = '<?php echo $oldest_order_date->newest_date?>';
</script>
<?php $mabilis_ttl=1432206541; $mabilis_last_modified=1426010500; //application/modules/shop/admin/templates/orders/list.tpl ?>