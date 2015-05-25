<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title w-s_n">{lang('Orders status edit','admin')}</span>
        </div>
        <div class="pull-right">
            <span class="help-inline"></span>
            <div class="d-i_b">
                <a href="{$ADMIN_URL}orderstatuses" class="pjax t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary action_on formSubmit" data-action="edit" data-form="#editOrderStatusForm" data-submit><i class="icon-ok icon-white"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-action="close" data-form="#editOrderStatusForm"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>
                    {echo create_language_select($languages, $locale, '/admin/components/run/shop/orderstatuses/edit/'. $model->getId())}
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
                        <form method="post" class="form-horizontal span9" action="{$ADMIN_URL}orderstatuses/edit/{echo $model->getId()}/{echo $locale}" id="editOrderStatusForm">
                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Title','admin')}:
                                    <span class="must">*</span>
                                </label>
                                <div class="controls">
                                    <input type="text" name="Name" value="{echo ShopCore::encode($model->getName())}" class="required" maxlength="50" />	
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Background Color','admin')}:
                                </label>
                                <div class="controls span2">
                                    <input type="text" name="Color" style="float: right;" class="ColorPicker" value="{echo ShopCore::encode($model->getColor())}" class="required" />	
                                    <div style="border: 1px solid gray; background-color: {echo ShopCore::encode($model->getColor())}; height: 25px; width: 27px;float: right;margin-top: -27px;margin-right: -22px;border-bottom-right-radius: 5px;border-top-right-radius: 5px;"></div>
                                </div>

                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    {lang('Font Color','admin')}:
                                </label>
                                <div class="controls span2">
                                    <input type="text" name="Fontcolor" style="float: right;"  class="ColorPicker" value="{echo ShopCore::encode($model->getFontcolor())}" class="required" />
                                    <div style="border: 1px solid gray; background-color: {echo ShopCore::encode($model->getFontcolor())}; height: 25px; width: 27px;float: right;margin-top: -27px;margin-right: -22px;border-bottom-right-radius: 5px;border-top-right-radius: 5px;"></div>
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



