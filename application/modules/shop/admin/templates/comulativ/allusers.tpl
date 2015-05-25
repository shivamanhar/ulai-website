<div class="container">
    <section class="mini-layout">
        <div class="frame_title clearfix">
            <div class="pull-left">
                <span class="help-inline"></span>
                <span class="title">{lang('Deposit rates','admin')}</span>
            </div>
            <div class="pull-right">
                <div class="d-i_b">
                    <a href="/admin/components/run/shop/discounts/index" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                </div>
            </div>                            
        </div>{if count($users) > 0}
        <div class="tab-content">

            <div class="row-fluid">

                <table class="table  table-bordered table-hover table-condensed t-l_a">
                    <thead>
                        <tr>                                
                            <th class="span1">{lang('ID','admin')}</th>
                            <th>{lang('Full name','admin')}</th>
                            <th>{lang('E-mail','admin')}</th>
                            <th>{lang('Discount','admin')}</th>
                            <th>{lang('Date','admin')}</th>
                        </tr>
                    </thead>
                    <tbody class="sortable">
                        {foreach $users as $c}

                            <tr>
                                <td><p>{echo $c['id']}</p></td>
                                <td><a href="{$ADMIN_URL}comulativ/user/{echo $c['id']}">{echo $c['username']}</a></td>
                                <td><p>{echo $c['email']}</p></td>
                                <td><p>{if $c['discount'] == NULL}0%{else:}{echo $c['discount']}%{/if}</p></td>
                                <td><p>{echo date('d-m-Y H:i:s',$c['created'])}</p></td>
                            </tr>
                        {/foreach}

                    </tbody>
                </table>

            </div>
        </div>
        {else:}
            <div class="alert alert-info" style="margin-bottom: 18px; margin-top: 18px;">
                {lang('Empty user list.','admin')}
            </div>
            {/if}
            </section>
        </div>
