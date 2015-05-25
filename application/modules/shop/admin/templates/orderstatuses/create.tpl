<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title w-s_n">{lang('Orders status creating','admin')}</span>
        </div>

        <div class="pull-right">
            <span class="help-inline"></span>
            <div class="d-i_b">
                <a href="{$ADMIN_URL}orderstatuses" class="pjax t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-success action_on formSubmit" data-action="edit" data-form="#addOrderStatusForm" data-submit><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-action="close" data-form="#addOrderStatusForm"><i class="icon-check"></i>{lang('Create and go back','admin')}</button>
            </div>
        </div>                            
    </div>  
    <table class="table  table-bordered table-hover table-condensed content_big_td m-t_10">
        <thead>
            <tr>
                <th colspan="6">
                    {lang('Information','admin')}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="inside_padd span9">
                        <form method="post" class="form-horizontal span9" action="{$ADMIN_URL}orderstatuses/create" id="addOrderStatusForm">
                            <div class="control-group">
                                <label class="control-label" for="Name">
                                    {lang('Title','admin')}:
                                    <span class="must">*</span>
                                </label>
                                <div class="controls">
                                    <input type="text" name="Name" id="Name" class="required" maxlength="50" />	
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="Color">
                                    {lang('Background Color','admin')}:
                                </label>
                                <div class="controls span2">
                                    <input type="text" style="float: right" name="Color" class="ColorPicker" value="#7d7c7d"/>
                                    <div style=" border: 1px solid gray; background-color: #999; height: 25px; width: 27px;float: right;margin-top: -27px;margin-right: -22px;border-bottom-right-radius: 5px;border-top-right-radius: 5px;"></div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="Color">
                                    {lang('Font Color','admin')}:
                                </label>
                                <div class="controls span2">
                                    <input type="text" name="Fontcolor" style="float: right" class="ColorPicker" value="#ffffff"/>
                                    <div style="border: 1px solid gray; background-color: white; height: 25px; width: 27px;float: right;margin-top: -27px;margin-right: -22px;border-bottom-right-radius: 5px;border-top-right-radius: 5px;"></div>
                                </div>
                            </div>

                            {form_csrf()}
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</section>

{/*}
<div style="float:right;padding:2px;">
    {foreach $languages as $language}
        |<a {if $language.identif == $locale}style="font-weight:bold;"{/if}href="javascript:ajaxShop('orderstatuses/edit/{echo $model->getId()}/{$language.identif}');">{echo $language.lang_name}</a>
    {/foreach}
</div>
{*/}

