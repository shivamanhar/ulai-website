<section class="mini-layout mod_stats">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Stats', 'mod_stats')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                {if $_GET['view_type'] == 'chart'}
                <button  class="btn btn-small btn-primary" id="saveAsPng">
                    <i class="icon-download"></i> {lang('Save Image', 'mod_stats')}
                </button>
                {/if}
            </div>
        </div>
    </div>
    <div class="row-fluid">
        {include_tpl('../include/left_block')}
        <div class="clearfix span9 content-statistic" id="chartArea">
            {include_tpl('../include/top_form')}
            <div class="alert alert-info" id="showNoChartData">
                {lang('No chart data for displaying','mod_stats')}
            </div>
            {if $_GET['view_type'] == 'chart'}
            <svg class="cumulativeLineChartStats" data-from="orders/getStatusesChartData" style="height: 600px; width: 800px;"></svg>
            {else:}
            {if count($data) > 0}
            <table class="table  table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>{lang('Period', 'mod_stats')}</th>
                        <th>{lang('Orders', 'mod_stats')}</th>
                        <th>{lang('Unique products', 'mod_stats')}</th>
                        <th>{lang('Total products', 'mod_stats')}</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $data as $order}
                    <tr>
                        <td>{$order.date}</td>
                        <td>{$order.orders_count}</td>
                        <td>{$order.products_count}</td>
                        <td>{$order.quantity}</td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            {else:}
            <div class="alert alert-info">
                {lang('There are no orders for specified period', 'mod_stats')}
            </div>
            {/if}

            {/if}
        </div>
    </div>
</section>
