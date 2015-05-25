<div class="container">

    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->    
    <div class="modal hide fade modal_del">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo lang ("Menu deleting", "menu"); ?></h3>
        </div>
        <div class="modal-body">
            <p><?php echo lang ("Delete selected menu?", 'menu'); ?></p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('/admin/components/cp/menu/delete_menu')" ><?php echo lang ("Delete", "menu"); ?></a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');"><?php echo lang ("Cancel", "menu"); ?></a>
        </div>
    </div>

    <!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->

    <form id="deleteMenu">
        <section class="mini-layout">
            <div class="frame_title clearfix">
                <div class="pull-left">
                    <span class="help-inline"></span>
                    <span class="title"><?php echo lang ("Menu list", "menu"); ?></span>
                </div>
                <div class="pull-right">
                    <div class="d-i_b">
                        <button type="button" class="btn btn-small btn-success" onclick="window.location.href = '<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?>admin/components/cp/menu/create_tpl'"><i class="icon-plus-sign icon-white"></i><?php echo lang ("Create a menu", "menu"); ?></button>
                        <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i><?php echo lang ("Delete", "menu"); ?></button>
                    </div>
                </div>                            
            </div>
            <div class="tab-content">
                <div class="row-fluid">
                    <table class="table  table-bordered table-hover table-condensed t-l_a">
                        <thead>
                            <tr>
                                <th class="t-a_c span1">
                                    <span class="frame_label">
                                        <span class="niceCheck b_n">
                                            <input type="checkbox"/>
                                        </span>
                                    </span>
                                </th>
                                <th><?php echo lang ("ID", "menu"); ?></th>
                                <th><?php echo lang ("Denotation", "menu"); ?></th>
                                <th><?php echo lang ("Name", "menu"); ?></th>
                                <th><?php echo lang ("Description", "menu"); ?></th>
                                <th><?php echo lang ("Created", "menu"); ?></th>
                                <th><?php echo lang ("Editing", "menu"); ?></th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php if(count($menus) > 0): ?>
                                <?php if(is_true_array($menus)){ foreach ($menus as $item){ ?>
                                    <tr class="simple_tr">
                                        <td class="t-a_c">
                                            <span class="frame_label">
                                                <span class="niceCheck b_n" >
                                                    <input type="checkbox" name="ids" value="<?php echo $item['name']; ?>"/>
                                                </span>
                                            </span>
                                        </td>
                                        <td ><p><?php echo $item['id']; ?></p></td>
                                        <td>
                                            <a class="pjax" href="<?php if(isset($SELF_URL)){ echo $SELF_URL; } ?>/menu_item/<?php echo $item['name']; ?>" id="del" ><?php echo $item['main_title']; ?></a>
                                        </td>
                                        <td><p><?php echo $item['name']; ?></p></td>
                                        <td><?php echo $item['description']; ?>
                                        </td>
                                        <td><?php echo $item['created']; ?></td>
                                        <td><a href="<?php if(isset($BASE_URL)){ echo $BASE_URL; } ?>admin/components/cp/menu/edit_menu/<?php echo $item['id']; ?>" class="pjax"><?php echo lang ("Editing", "menu"); ?></a></td>
                                    </tr>
                                <?php }} ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </form>
</div><?php $mabilis_ttl=1432201353; $mabilis_last_modified=1426010500; //application/modules/menu/assets/admin/menu_list.tpl ?>