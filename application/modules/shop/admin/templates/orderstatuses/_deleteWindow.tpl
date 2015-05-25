<form action="/admin/components/run/shop/orderstatuses/delete" method="post" class="form-horizontal" id="deleteOrderStatus" {/*}{if !count($orders)} style="display:none;" {/if}{ */} >
    <div class="control-group">
        {if count($orders)}
            <h5 style="text-align: right; margin-right: 10px; color: red;">{lang('Orders with this status','admin')}: {count($orders)}!</h5>
        {else:}
            <p>{lang('Do you really want to delete the status?','admin')}</p>
        {/if}
    </div>
    <input type="hidden" name="id" value="{echo $statusId}">
    <div class="control-group">
        <label class="control-label">
            {lang('Set another status for these orders','admin')}:
        </label>
        <div class="controls">
            <input type="radio" value="1" checked="checked" name="moveOrDelete" />
            <select name="CategoryId" style="width: 90% !important;">
                {foreach $statuses as $status}
                    {if $status->getId() != $statusId}<option value="{echo $status->getId()}">{echo $status->getName()}</option>{/if}
                {/foreach}
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            {lang('Delete all orders with this status','admin')}
        </label>
        <div class="controls">
            <div class="form_text"><input type="radio" value="2" name="moveOrDelete" />
            </div>
        </div>

        <div class="form_overflow"></div>

    </div>
    <br />


</form>