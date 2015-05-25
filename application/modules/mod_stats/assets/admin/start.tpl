<section class="mini-layout mod_stats">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Stats', 'mod_stats')}</span>
        </div>
          </div>
    <div class="row-fluid">
        {include_tpl('include/left_block')}
        <div class="clearfix span9 content-statistic" id="chartArea">
            <table id="common-info-table">
                <tr>
                    <td>{lang('Unique visitors count (all time)','mod_stats')}</td>
                    <td>{$countUniqueUsers}</td>
                </tr>
                <tr>
                    <td>{lang('Count of robots (all time)','mod_stats')}</td>
                    <td>{$countUniqueRobots}</td>
                </tr>
                <!--tr>
                    <td>{lang('Count of redirects from search engines','mod_stats')}</td>
                    <td>{lang('No data','mod_stats')}</td>
                </tr>
                <tr>
                    <td>{lang('Count of redirects from other sites','mod_stats')}</td>
                    <td>{lang('No data','mod_stats')}</td>
                </tr-->
                <tr>
                    <td>{lang('Last viewed page','mod_stats')}</td>
                    <td>
                        {if !empty($lastPage)}
                            <a href="/{$lastPage['url']}" target="_blank">{$lastPage['page_name']}</a>
                            {if !empty($lastPage['username'])}
                                {lang('by user','mod_stats')} <strong> {echo $lastPage['username']} </strong>
                            {else:}
                                ({lang('Guest','mod_stats')})
                            {/if}
                        {else:}
                            {lang('No data','mod_stats')}
                        {/if}

                    </td>
                </tr>
            </table>

        </div>
    </div>



</section>