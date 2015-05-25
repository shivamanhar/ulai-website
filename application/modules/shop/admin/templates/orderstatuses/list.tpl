<div class="container">
    <form method="post" action="{$ADMIN_URL}orderstatuses/savePositions" id="orderStatusesList">
        <section class="mini-layout">
            <div class="frame_title clearfix">
                <div class="pull-left">
                    <span class="help-inline"></span>
                    <span class="title">{lang('Order status','admin')}</span>
                </div>
                <div class="pull-right">
                    <div class="d-i_b">
                        <a  href="{$ADMIN_URL}orderstatuses/create" class="pjax btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i>{lang('Create status','admin')}</a>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="row-fluid">
                    <table class="table  table-bordered table-hover table-condensed t-a_l">
                        <thead>
                            <tr>
                                <th class="span1">ID</th>
                                <th>{lang('Title','admin')}</th>
                                <th class="span2">{lang('Background Color','admin')}</th>
                                <th class="span2">{lang('Font Color','admin')}</th>
                                <th class="span2">{lang('Delete','admin')}</th>
                            </tr>
                        </thead>
                        <tbody class ="sortable save_positions" data-url='/admin/components/run/shop/orderstatuses/savePositions'>
                            {foreach $model as $c}
                            <tr data-original-title="" data-position="{echo $c->getPosition()}" data-id="{echo $c->getId()}">
                                <input type="hidden" name="ids" value="{echo $c->getId()}"/>
                                <td>{echo $c->getId()}
                                    <input type="hidden" name="positions[{echo $c->getId()}]" value="{echo $c->getPosition()}">
                                </td>
                                <td>
                                    <a href="{$ADMIN_URL}orderstatuses/edit/{echo $c->getId()}/{$locale}" data-rel="tooltip" data-title="{lang('Edit status','admin')}">{echo ShopCore::encode($c->getName())}</a>
                                </td>
                                <td>
                                    <div style="border: 1px solid gray; background-color: {echo $c->getColor()}; height: 25px;border-radius: 5px;"></div>
                                </td>
                                <td>
                                    <div style="border: 1px solid gray; background-color: {echo $c->getFontcolor()}; height: 25px;border-radius: 5px;"></div>
                                </td>
                                <td class="t-a_c span1">
                                    {if $c->getId() != 1 && $c->getId() != 2}
                                    <a href="#" onclick="orderStatuses.deleteOne({echo $c->getId()});
                                        return false;" class="btn btn-small"> <i class="icon-trash"></i> </a>
                                        {/if}
                                    </td>
                                </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </form>
    </div>

    <div class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{lang('Order status deleting','admin')}</h3>
        </div>
        <div class="modal-body">
            <p>{lang('Delete order status(es)?','admin')}</p>
        </div>
        <div class="modal-footer">
            <a href="#" onclick="$('.modal').modal('hide');
            return true;" class="btn btn-primary formSubmit"  data-form="#deleteOrderStatus" >{lang('Delete','admin')}</a>
            <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
        </div>
    </div>