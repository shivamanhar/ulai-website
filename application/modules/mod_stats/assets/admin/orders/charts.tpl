<section class="mini-layout mod_stats">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Stats', 'mod_stats')}</span>
        </div>
    </div>
    <div class="row-fluid">
        {include_tpl('../include/left_block')}
        <div class="clearfix span9 content-statistic" id="chartArea">
            {include_tpl('../include/top_form_charts')}
            <div class="alert alert-info" id="showNoChartData">
                {lang('No chart data for displaying','mod_stats')}
            </div>
            <!--<button  class="btn btn-small btn-primary" id="saveAsPng">
                <i class="icon-download"></i> {lang('Save Image', 'mod_stats')}
            </button>-->
            <svg class="cumulativeLineChartStats" data-from="orders/getChartData{$show_by}" style="height: 600px; width: 800px;"></svg>
        </div>
    </div>
</section>
