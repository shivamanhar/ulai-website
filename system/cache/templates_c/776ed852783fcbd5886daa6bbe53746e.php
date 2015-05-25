<?php include ('/var/www/application/libraries/mabilis/functions/func.truncate.php');  ?><!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
<div class="modal hide fade modal_del">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?php echo lang ('Delete products','admin'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo lang ('Really delete selected products?','admin'); ?></p>
        <!--<p><?php echo lang (a_products_del_body_warning); ?></p>-->
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('<?php if(isset($ADMIN_URL)){ echo $ADMIN_URL; } ?>products/ajaxDeleteProducts')" ><?php echo lang ('Delete','admin'); ?></a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');"><?php echo lang ('Cancel','admin'); ?></a>
    </div>
</div>
<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<div class="modal hide fade modal_move_to_cat">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?php echo lang ('Move products','admin'); ?></h3>
    </div>
    <div class="modal-body">
        <select name="" id="moveCategoryId" style="width:285px;">
            <?php if(is_true_array($categories)){ foreach ($categories as $category){ ?>
                <option <?php if($category->getId() == $categoryId): ?>selected<?php endif; ?> value="<?php echo $category->getId()?>"><?php echo str_repeat ('-',$category->getLevel()); ?> <?php echo ShopCore::encode($category->getName())?></option>
            <?php }} ?>
        </select>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary move_to_cat"><?php echo lang ('Move','admin'); ?></a>
        <a href="#" class="btn" onclick="$('.modal_move_to_cat').modal('hide');"><?php echo lang ('Cancel','admin'); ?></a>
    </div>
</div>

<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

<form action="<?php if(isset($ADMIN_URL)){ echo $ADMIN_URL; } ?>search/index/" id="filter_form" method="get" class="listFilterForm">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title"><?php if(isset($_GET['WithoutImages']) AND $_GET['WithoutImages'] == 1): ?><?php echo lang ('Products without images','admin'); ?><?php else:?><?php echo lang ('Products list','admin'); ?><?php endif; ?><?php if($totalProducts!=null): ?> (<?php echo $totalProducts?>)<?php endif; ?></span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <button title="<?php echo lang ('Filter','admin'); ?>" type="submit" class="d_n btn btn-small action_on disabled listFilterSubmitButton">
                        <i class="icon-filter"></i><?php echo lang ('Filter','admin'); ?>
                    </button>
                    <button title="<?php echo lang ('Reset filter','admin'); ?>"
                            onclick="if (!$(this).hasClass('disabled'))
                                    location.href = '/admin/components/run/shop/search/index<?php if($_GET['WithoutImages'] == 1): ?>?WithoutImages=1<?php endif; ?>'"
                            type="button" class="btn btn-small action_on <?php if($_GET['_pjax'] && count($_GET)==1 || $_GET == null || ($_GET['WithoutImages'] == 1 && count($_GET)==1)): ?>disabled<?php endif; ?>">
                        <i class="icon-refresh"></i><?php echo lang ('Cancel filter','admin'); ?>
                    </button>
                    <div class="dropdown d-i_b">
                        <button type="button" class="btn btn-small dropdown-toggle disabled action_on" data-toggle="dropdown">
                            <i class="icon-tag"></i>
                            <?php echo lang ('Change status','admin'); ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="" href="#" onclick="product.changeActive()" ><?php echo lang ('Active','admin'); ?></a></li>
                            <li class="divider"></li>
                            <li><a class="to_hit" href="#" onclick="product.toHit()" ><?php echo lang ('Hit','admin'); ?></a></li>
                            <li><a href="#" class="tonew" onclick="product.toNew()"><?php echo lang ('New','admin'); ?></a></li>
                            <li><a href="#" class="toaction" onclick="product.toAction()"><?php echo lang ('Promotion','admin'); ?></a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="clone pjax" onclick="product.cloneTo()"><?php echo lang ('Create copy','admin'); ?></a></li>
                            <li><a href="#" class="tocategory" onclick="product.toCategory()"><?php echo lang ('Move to category','admin'); ?></a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-small CreateFastT"  ><i class="icon-plus-sign"></i><?php echo lang ('Open fast create','admin'); ?></button>
                    <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/products/create" ><i class="icon-plus-sign icon-white"></i><?php echo lang ('Create product','admin'); ?></a>
                    <a class="btn btn-small btn-danger disabled action_on" id="del_in_search" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i><?php echo lang ('Delete','admin'); ?></a>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <table class="table  table-bordered table-hover table-condensed products_table">
                <thead>
                    <tr style="cursor: pointer;">
                        <th class="t-a_c span1">
                            <span class="frame_label">
                                <span class="niceCheck b_n">
                                    <input type="checkbox"/>
                                </span>
                            </span>
                        </th>
                        <th class="span1 product_list_order" data-column="Id">
                            <span class="thead_name">
                                <?php echo lang ('ID','admin'); ?>
                            </span>
                            <?php if(isset( $_GET['orderMethod'] ) AND  $_GET['orderMethod']  == 'Id'): ?>
                                <?php if($_GET['order']  == 'ASC'): ?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </th>
                        <th class="span3 product_list_order" data-column="Name">
                            <span class="thead_name">
                                <?php echo lang ('Product','admin'); ?>
                            </span>
                            <?php if(isset( $_GET['orderMethod'] ) AND  $_GET['orderMethod']  == 'Name'): ?>
                                <?php if($_GET['order']  == 'ASC'): ?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                            <?php endif; ?>

                        </th>
                        <th class="span2 product_list_order" data-column="CategoryName">
                            <span class="thead_name">
                                <?php echo lang ('Categories','admin'); ?>
                            </span>
                            <?php if(isset( $_GET['orderMethod'] ) AND  $_GET['orderMethod']  == 'CategoryName'): ?>
                                <?php if($_GET['order']  == 'ASC'): ?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </th>
                        <th class="product_list_order span1" data-column="Reference">
                            <span class="thead_name">
                                <?php echo lang ('Article', 'admin'); ?>
                            </span>
                            <?php if(isset( $_GET['orderMethod'] ) AND  $_GET['orderMethod']  == 'Reference'): ?>
                                <?php if($_GET['order']  == 'ASC'): ?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </th>
                        <th class="product_list_order span1" data-column="Active">
                            <span class="thead_name">
                                <?php echo lang ('Active','admin'); ?>
                            </span>
                            <?php if(isset( $_GET['orderMethod'] ) AND  $_GET['orderMethod']  == 'Active'): ?>
                                <?php if($_GET['order']  == 'ASC'): ?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </th>
                        <th class="span2"><?php echo lang ('Status','admin'); ?></th>
                        <th class="span2 product_list_order" data-column="Price">
                            <span class="thead_name">
                                <?php echo lang ('Price','admin'); ?>
                            </span>
                            <?php if(isset( $_GET['orderMethod'] ) AND  $_GET['orderMethod']  == 'Price'): ?>
                                <?php if($_GET['order']  == 'ASC'): ?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↑</span>
                                <?php else:?>
                                    &nbsp;&nbsp;&nbsp;<span class="f-s_14">↓</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </th>
                    </tr>
                    <tr class="head_body">
                <input type="hidden" name="WithoutImages" value="<?php echo $_GET['WithoutImages']; ?>"/>
                <input type="hidden" name="orderMethod" value="<?php echo $_GET['orderMethod']; ?>"/>
                <input type="hidden" name="order" value="<?php echo $_GET['order']; ?>"/>
                <td class="t-a_c">

                </td>
                <td class="">
                    <div>
                        <input id="filterID" name="filterID" onkeypress='validateN(event)' type="text" value="<?php echo $_GET['filterID']; ?>"/>
                    </div>
                </td>
                <td>
                    <input type="text" name="text" value="<?php echo $_GET['text']; ?>" maxlength="500"/>
                </td>
                <td>
                    <select class="prodFilterSelect" name="CategoryId">
                        <option value="0"><?php echo lang ('All','admin'); ?></option>
                        <?php if(is_true_array($categories)){ foreach ($categories as $category){ ?>
                            <?php $selected = ''?>
                            <?php if($category->getId() == (int) $_GET['CategoryId']): ?>
                                <?php $selected='selected="selected"'?>
                            <?php endif; ?>
                            <option value="<?php echo $category->getId()?>" <?php if(isset($selected)){ echo $selected; } ?> ><?php echo str_repeat ('-',$category->getLevel()); ?> <?php echo ShopCore::encode($category->getName())?></option>
                        <?php }} ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="sku" value="<?php echo $_GET['sku']; ?>" maxlength="255"/>
                </td>
                <td>
                    <select class="prodFilterSelect" name="Active">
                        <option value=""><?php echo lang ('All','admin'); ?></option>
                        <option value="true" <?php if($_GET['Active'] == 'true'): ?>selected="selected"<?php endif; ?>><?php echo lang ('Active','admin'); ?></option>
                        <option value="false" <?php if($_GET['Active'] == 'false'): ?>selected="selected"<?php endif; ?>><?php echo lang ('Not active','admin'); ?></option>
                    </select>
                </td>
                <td>
                    <select class="prodFilterSelect" name="s">
                        <option value=""><?php echo lang ('All','admin'); ?></option>
                        <option value="Hit" <?php if($_GET['s'] == 'Hit'): ?>selected="selected"<?php endif; ?>><?php echo lang ('Hit','admin'); ?></option>
                        <option value="Hot" <?php if($_GET['s'] == 'Hot'): ?>selected="selected"<?php endif; ?>><?php echo lang ('New','admin'); ?></option>
                        <option value="Action" <?php if($_GET['s'] == 'Action'): ?>selected="selected"<?php endif; ?>><?php echo lang ('Promotion','admin'); ?></option>
                    </select>
                </td>
                <td class="number f-s_0">
                    <label class="v-a_m" style="width:47%;margin-right:6%; display: inline-block;margin-bootom:0px;">
                        <span class="o_h d_b"><input id="min-price" placeholder="<?php echo lang ('From','admin'); ?>" onkeyup="checkLenghtStr('min-price', 11, 5, event.keyCode);" type="text" name="min_price" value="<?php echo $_GET['min_price']; ?>" maxlength="21"/></span>
                    </label>
                    <label class="v-a_m" style="width:47%;display: inline-block;margin-bootom:0px;">
                        <span class="o_h d_b"><input id="max-price" placeholder="<?php echo lang ('To','admin'); ?>" onkeyup="checkLenghtStr('max-price', 11, 5, event.keyCode);" type="text" name="max_price" value="<?php echo $_GET['max_price']; ?>" maxlength="21"/></span>
                    </label>
                </td>
                <?php echo form_csrf (); ?>
                </form>
                </tr>

                <?php $this->include_tpl('../products/fastCreateForm.tpl', '/var/www/application/modules/shop/admin/templates/search'); ?>

                <tr class="fast-create-btn">
                    <td colspan="8">
                        <div class="t-a_c">
                            <button type="button" onclick="fastCreateProduct();
                                return false;" class="btn btn-success" ><i class="icon-plus-sign icon-white"></i><?php echo lang ('Create fast product','admin'); ?></button>
                            <button type="button" class="btn closeFast"><?php echo lang ('Close fast create','admin'); ?></button>
                        </div>
                    </td>
                </tr>
                <?php if($_GET['fast_create']): ?>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                setTimeout(function () {
                                    $('.CreateFastT').click();
                                }, 1000)

                            })

                        </script>
                    
                <?php endif; ?>

                </thead>
                <tbody>
                    <?php if(is_true_array($products)){ foreach ($products as $p){ ?>
                        <?php $variants = $p->getProductVariants()?>
                        <?php if(sizeof($variants) == 1): ?>
                            <tr data-id="<?php echo $p->getId()?>" class="simple_tr">
                                <td class="t-a_c">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox" name="ids" value="<?php echo $p->getId()?>" data-id="<?php echo $p->getId()?>"/>
                                        </span>
                                    </span>
                                </td>
                                <td><p><?php echo $p->getId()?></p></td>
                                <td class="share_alt">
                                    <a href="/shop/product/<?php echo $p->getUrl()?>"
                                       target="_blank"
                                       class="go_to_site pull-right btn btn-small"
                                       data-rel="tooltip"
                                       data-placement="top"
                                       data-original-title="<?php echo lang ('Show on site','admin'); ?>">
                                        <i class="icon-share-alt"></i>
                                    </a>
                                    <div class="a-photo-out">
                                        <a href="/admin/components/run/shop/products/edit/<?php echo $p->getId()?><?php echo $_SESSION['ref_url']; ?>"
                                           class="pjax title"
                                           data-rel="tooltip"
                                           data-title="<?php echo lang ('Edit product','admin'); ?>">
                                            <span class="photo-block">
                                                <span class="helper"></span>
                                                <?php if($p->getfirstvariant()->getSmallPhoto()): ?>
                                                    <img src="<?php echo site_url ($p->getfirstvariant()->getSmallPhoto()); ?>">
                                                <?php else:?>
                                                    <img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/select-picture.png" class="img-polaroid">
                                                <?php endif; ?>
                                            </span>
                                            <span class="text-el"><?php echo func_truncate (ShopCore::encode($p->getName()),100); ?></span>
                                        </a>
                                        <?php if($p->getBrand()): ?>
                                            <div class="category-list-brand">
                                                <a href="/admin/components/run/shop/brands/edit/<?php echo $p->getBrand()->getId()?>"
                                                   class="pjax title t-d_n"
                                                   data-rel="tooltip"
                                                   data-title="<?php echo lang ('Edit brand','admin'); ?>">
                                                    <span class=""><?php echo $p->getBrand()->getName()?></span>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="share_alt">
                                    <a href="/shop/category/<?php echo $p->getMainCategory()->getFullPath()?>"
                                       target="_blank"
                                       class="go_to_site pull-right btn btn-small"
                                       data-rel="tooltip"
                                       data-placement="top"
                                       data-original-title="<?php echo lang ('Show on site','admin'); ?>">
                                        <i class="icon-share-alt"></i>
                                    </a>
                                    <div class="o_h">
                                        <a href="<?php if(isset($ADMIN_URL)){ echo $ADMIN_URL; } ?>categories/edit/<?php echo $p->getMainCategory()->getId()?>"
                                           class="pjax"
                                           data-rel="tooltip"
                                           data-title="<?php echo lang ('Edit category','admin'); ?>">
                                            <?php echo $p->getMainCategory()->getName()?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <p><?php echo $variants[0]->getNumber()?></p>
                                </td>
                                <td>
                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="<?php echo lang ('show','admin'); ?>">
                                        <?php if($p->getActive() == true): ?>
                                            <span class="prod-on_off" data-id="<?php echo $p->getId()?>"></span>
                                        <?php else:?>
                                            <span class="prod-on_off disable_tovar" data-id="<?php echo $p->getId()?>"></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($p->getHit() == true): ?>
                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small hits-value btn-primary active <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setHit" data-title-new="<?php echo lang ('Hit','admin'); ?>"><i class="icon-fire"></i></button>
                                        <?php else:?>
                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small hits-value <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setHit" data-title-new="<?php echo lang ('Hit','admin'); ?>"><i class="icon-fire"></i></button>
                                        <?php endif; ?>

                                    <?php if($p->getHot() == true): ?>
                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small noveltys-value btn-primary active <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setHot" data-title-new="<?php echo lang ('Novelty','admin'); ?>"><i class="icon-gift"></i></button>
                                        <?php else:?>
                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small noveltys-value <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setHot" data-title-new="<?php echo lang ('Novelty','admin'); ?>"><i class="icon-gift"></i></button>
                                        <?php endif; ?>

                                    <?php if($p->getAction() == true): ?>
                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small actions-value btn-primary active <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setAction" data-title-new="<?php echo lang ('Promotion','admin'); ?>"><i class="icon-star"></i></button>
                                        <?php else:?>
                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small actions-value <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setAction" data-title-new="<?php echo lang ('Promotion','admin'); ?>"><i class="icon-star"></i></button>
                                        <?php endif; ?>
                                </td>
                                <td>
                                    <span class="pull-right"><span class="neigh_form_field help-inline"></span>&nbsp;&nbsp;<?php echo ShopCore::app()->SCurrencyHelper->getSymbolById($variants[0]->getCurrency())?></span>
                                    <div class="p_r o_h frame_price number">
                                        <input type="text"
                                               value="<?php echo preg_replace('/\.?0*$/','',number_format($variants[0]->getPriceInMain(), 5, ".", ""))?>"
                                               <?php /*        value="<?php echo \Currency\Currency::create()->decimalPointsFormat($variants[0]->getPriceInMain(), $variants[0]->getCurrency())?>"*/?>
                                               class="js_price"
                                               data-value="<?php echo number_format($variants[0]->getPriceInMain(), 5, ".", "")?>">
                                        <button class="btn btn-small refresh_price"
                                                data-id="<?php echo $p->getId()?>"
                                                type="button">
                                            <i class="icon-refresh"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php else:?>
                            <tr data-id="<?php echo $p->getId()?>" class="simple_tr">
                                <td colspan="8">
                                    <table>
                                        <thead class="no_vis">
                                            <tr>
                                                <td class="span1"></td>
                                                <td class="span1"></td>
                                                <td class="span3"></td>
                                                <td class="span2"></td>
                                                <td class="span1"></td>
                                                <td class="span1"></td>
                                                <td class="span2"></td>
                                                <td class="span2"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="t-a_c">
                                                    <span class="frame_label">
                                                        <span class="niceCheck b_n">
                                                            <input type="checkbox" name="ids" value="<?php echo $p->getId()?>" data-id="<?php echo $p->getId()?>"/>
                                                        </span>
                                                    </span>
                                                </td>
                                                <td>
                                                    <p><?php echo $p->getId()?></p>
                                                </td>
                                                <td class="share_alt">
                                                    <a href="/shop/product/<?php echo $p->getUrl()?>"
                                                       target="_blank"
                                                       class="go_to_site pull-right btn btn-small"
                                                       data-rel="tooltip"
                                                       data-placement="top"
                                                       data-original-title="<?php echo lang ('Show on site','admin'); ?>">
                                                        <i class="icon-share-alt"></i>
                                                    </a>
                                                    <div class="a-photo-out">
                                                        <a href="/admin/components/run/shop/products/edit/<?php echo $p->getId()?><?php echo $_SESSION['ref_url']; ?>"
                                                           class="pjax title"
                                                           data-rel="tooltip"
                                                           data-title="<?php echo lang ('Edit product','admin'); ?>">
                                                            <span class="photo-block">
                                                                <span class="helper"></span>
                                                                <?php if($p->getfirstvariant()->getSmallPhoto()): ?>
                                                                    <img src="<?php echo site_url ($p->getfirstvariant()->getSmallPhoto()); ?>">
                                                                <?php else:?>
                                                                    <img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/select-picture.png" class="img-polaroid">
                                                                <?php endif; ?>
                                                            </span>
                                                            <span class="text-el"><?php echo func_truncate (ShopCore::encode($p->getName()),100); ?></span>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="share_alt">
                                                    <a href="/shop/category/<?php echo $p->getMainCategory()->getFullPath()?>"
                                                       target="_blank"
                                                       class="go_to_site pull-right btn btn-small"
                                                       data-rel="tooltip"
                                                       data-placement="top"
                                                       data-original-title="<?php echo lang ('Show on site','admin'); ?>">
                                                        <i class="icon-share-alt"></i>
                                                    </a>
                                                    <div class="o_h">
                                                        <a href="<?php if(isset($ADMIN_URL)){ echo $ADMIN_URL; } ?>categories/edit/<?php echo $p->getMainCategory()->getId()?>"
                                                           class="pjax"
                                                           data-rel="tooltip"
                                                           data-title="<?php echo lang ('Edit category','admin'); ?>">
                                                            <?php echo $p->getMainCategory()->getName()?>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="<?php echo lang ('show','admin'); ?>">
                                                        <?php if($p->getActive() == true): ?>
                                                            <span class="prod-on_off" data-id="<?php echo $p->getId()?>"></span>
                                                        <?php else:?>
                                                            <span class="prod-on_off disable_tovar" data-id="<?php echo $p->getId()?>"></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if($p->getHit() == true): ?>
                                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small btn-primary active <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setHit" data-rel="tooltip" data-placement="top" data-original-title="<?php echo lang ('Hit','admin'); ?>"><i class="icon-fire"></i></button>
                                                        <?php else:?>
                                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setHit" data-rel="tooltip" data-placement="top" data-original-title="<?php echo lang ('Hit','admin'); ?>"><i class="icon-fire"></i></button>
                                                        <?php endif; ?>

                                                    <?php if($p->getHot() == true): ?>
                                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small btn-primary active <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setHot" data-rel="tooltip" data-placement="top" data-original-title="<?php echo lang ('Novelty','admin'); ?>"><i class="icon-gift"></i></button>
                                                        <?php else:?>
                                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setHot" data-rel="tooltip" data-placement="top" data-original-title="<?php echo lang ('Novelty','admin'); ?>"><i class="icon-gift"></i></button>
                                                        <?php endif; ?>

                                                    <?php if($p->getAction() == true): ?>
                                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small btn-primary active <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setAction" data-rel="tooltip" data-placement="top" data-original-title="<?php echo lang ('Promotion','admin'); ?>"><i class="icon-star"></i></button>
                                                        <?php else:?>
                                                        <button type="button" data-id="<?php echo $p->getId()?>" class="btn btn-small <?php if($p->getActive() != true): ?> disabled<?php endif; ?> setAction" data-rel="tooltip" data-placement="top" data-original-title="<?php echo lang ('Promotion','admin'); ?>"><i class="icon-star"></i></button>
                                                        <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="t-d_n variants"><span class="js"><?php echo lang ('Variants','admin'); ?></span> <span class="f-s_14">↓</span></a>
                                                </td>
                                            </tr>
                                            <tr style="display: none;">
                                                <td colspan="8">
                                                    <table>
                                                        <thead class="no_vis">
                                                            <tr>
                                                                <td class="span1"></td>
                                                                <td class="span1"></td>
                                                                <td class="span3"></td>
                                                                <td class="span2"></td>
                                                                <td class="span1"></td>
                                                                <td class="span1"></td>
                                                                <td class="span2"></td>
                                                                <td class="span2"></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="sortable save_positions_variant" data-url="/admin/components/run/shop/search/save_positions_variant">

                                                            <?php if(is_true_array($variants)){ foreach ($variants as $v){ ?>

                                                                <tr data-title="<?php echo lang ('Drag product variant','admin'); ?>">
                                                                    <td class="t-a_c">
                                                                        <input name="idv" type="hidden" value="<?php echo $v->id?>"/>
                                                                    </td>
                                                                    <td></td>
                                                                    <td class="variants-items-in">
                                                                        <div class="a-photo-out">
                                                                            <span class="simple_tree">↳</span>
                                                                            <span class="photo-block">
                                                                                <span class="helper"></span>
                                                                                <?php if($v->getSmallPhoto()): ?>
                                                                                    <img src="<?php echo site_url ($v->getSmallPhoto()); ?>">
                                                                                <?php else:?>
                                                                                    <img src="<?php if(isset($THEME)){ echo $THEME; } ?>images/select-picture.png" class="img-polaroid">
                                                                                <?php endif; ?>
                                                                            </span>
                                                                            <?php if($v->getName() != ''): ?>
                                                                                <span><?php echo $v->getName()?></span>
                                                                            <?php else:?>
                                                                                <span><?php echo $p->getName()?></span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                    <td><p><?php echo $v->getNumber()?></p></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>
                                                                        <span class="pull-right">
                                                                            <span class="neigh_form_field help-inline"></span>&nbsp;&nbsp;<?php echo ShopCore::app()->SCurrencyHelper->getSymbolById($v->getCurrency())?></span>
                                                                        <div class="p_r o_h frame_price number">
                                                                            <input type="text"
                                                                                   value="<?php echo preg_replace('/\.?0*$/','',number_format($v->getPriceInMain(), 5, ".", ""))?>"
                                                                                   <?php /*                                value="<?php echo \Currency\Currency::create()->decimalPointsFormat($v->getPriceInMain(), $v->getCurrency())?>"*/?>
                                                                                   class="js_price"
                                                                                   data-value="<?php echo number_format($v->getPriceInMain(), 5, ".", "")?>">
                                                                            <button class="btn btn-small refresh_price"
                                                                                    data-id="<?php echo $v->getProductId()?>"
                                                                                    variant-id="<?php echo $v->getId()?>"
                                                                                    type="button">
                                                                                <i class="icon-refresh"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php }} ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php }} ?>
                </tbody>
            </table>
            <?php if($totalProducts == 0): ?>
                <div class="row-fluid news">
                    <div class="span12">
                        <div class="alert alert-info">
                            <p><?php echo lang ('Product list is empty','admin'); ?>.</p>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <div class="clearfix">
            <?php if($pagination > ''): ?>
                <?php if(isset($pagination)){ echo $pagination; } ?>
            <?php endif; ?>
            <div class="pagination pull-right">
                <select style="max-width:60px;" onchange="change_per_page(this);
                    return false;">
                    <?php if($_COOKIE['per_page'] == ShopCore::app()->SSettings->adminProductsPerPage): ?><option selected="selected" value="<?php echo $_COOKIE['per_page']?>"><?php echo $_COOKIE['per_page']?></option><?php endif; ?>
                    <option <?php if($_COOKIE['per_page'] == 10): ?>selected="selected"<?php endif; ?> value="10">10</option>
                    <option <?php if($_COOKIE['per_page'] == 20): ?>selected="selected"<?php endif; ?> value="20">20</option>
                    <option <?php if($_COOKIE['per_page'] == 30): ?>selected="selected"<?php endif; ?> value="30">30</option>
                    <option <?php if($_COOKIE['per_page'] == 40): ?>selected="selected"<?php endif; ?> value="40">40</option>
                    <option <?php if($_COOKIE['per_page'] == 50): ?>selected="selected"<?php endif; ?> value="50">50</option>
                    <option <?php if($_COOKIE['per_page'] == 60): ?>selected="selected"<?php endif; ?> value="60">60</option>
                    <option <?php if($_COOKIE['per_page'] == 70): ?>selected="selected"<?php endif; ?> value="70">70</option>
                    <option <?php if($_COOKIE['per_page'] == 80): ?>selected="selected"<?php endif; ?> value="80">80</option>
                    <option <?php if($_COOKIE['per_page'] == 90): ?>selected="selected"<?php endif; ?> value="90">90</option>
                    <option <?php if($_COOKIE['per_page'] == 100): ?>selected="selected"<?php endif; ?> value="100">100</option>
                </select>
            </div>
            <div class="pagination pull-right" style="margin-right: 10px; margin-top: 24px;"><?php echo lang ('At the products page','admin'); ?>:</div>
        </div>
        </div>

    </section>
<?php $mabilis_ttl=1432206758; $mabilis_last_modified=1426010500; //application/modules/shop/admin/templates/search/list.tpl ?>