<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->    
<div class="modal hide fade modal_del">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Removing discounts','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('Remove selected discount?','admin')}</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" onclick="delete_function.deleteFunctionConfirm('{$ADMIN_URL}comulativ/deleteAll')" >{lang('Delete','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>


<div id="delete_dialog" title="{lang('Removing discounts','admin')}" style="display: none">
    {lang('Remove the discount?','admin')}
</div>
<!-- ---------------------------------------------------Блок видалення---------------------------------------------------- -->
<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('List of cumulative discounts','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/comulativ/create"><i class="icon-plus-sign icon-white"></i>{lang('Create a discount','admin')}</a>
                <button type="button" class="btn btn-small btn-danger disabled action_on" onclick="delete_function.deleteFunction()"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
            </div>
        </div>                            
    </div>{if count($model) > 0}
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
                        <th>{lang('ID','admin')}</th>
                        <th>{lang('Name','admin')}</th>
                        <th>{lang('Discount Amount of','admin')}</th>
                        <th>{lang('Discount Amount to','admin')}</th>
                        <th>{lang('Discount','admin')}</th>
                        <th>{lang('Date of creation','admin')}</th>
                        <th>{lang('Active','admin')}</th>
                    </tr>
                </thead>
                <tbody class="sortable">
                    {foreach $model as $c}

                        <tr>
                            <td class="t-a_c">
                                <span class="frame_label">
                                    <span class="niceCheck b_n">
                                        <input type="checkbox" name="ids" value="{echo $c['id']}"/>
                                    </span>
                                </span>
                            </td>
                            <td><p>{echo $c['id']}</p></td>
                            <td>
                                <a href="{$ADMIN_URL}comulativ/edit/{echo $c['id']}" data-rel="tooltip" data-title="{lang('Editing','admin')}">{echo $c['description']}</a>
                            </td>
                            <td><p>{echo $c['total']}</p></td>
                            <td><p>{echo $c['total_a']}</p></td>
                            <td><p>{echo $c['discount']} %</p></td>
                            <td><p>{echo date('d-m-Y H:i:s',$c['date'])}</p></td>
                            <td>
                                <div class="frame_prod-on_off" 
                                     data-rel="tooltip" 
                                     data-placement="top" 
                                     data-original-title="{lang('Active','admin')}" 
                                     onclick="change_status('{$ADMIN_URL}comulativ/change_comulativ_dis_status/{echo $c['id']}');" >
                                    <span class="prod-on_off {if $c['active'] != 1}disable_tovar{/if}" ></span>
                                </div>
                            </td>
                        </tr>
                    {/foreach}

                </tbody>
            </table>

        </div>
    </div>
</section>
{else:}
    <div class="alert alert-info" style="margin-bottom: 18px; margin-top: 18px;">
        {lang('Empty discount list','admin')}
    </div>
    {/if}