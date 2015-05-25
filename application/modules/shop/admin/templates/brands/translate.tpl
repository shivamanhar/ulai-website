<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Translated brand ID:','admin')} {echo $model->Id}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/brands/index" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary action_on formSubmit" data-form="#br_tr_form" data-action="tomain"><i class="icon-ok"></i>{lang('Save','admin')}</button>
            </div>
        </div>                            
    </div>
    <div class="btn-group myTab m-t_20" data-toggle="buttons-radio">
        {$act = 1}
        {foreach $languages as $language}
            <a href="#{echo $language.identif}" class="btn btn-small {if $act == 1} active {$act = 0} {/if}">{echo $language.lang_name}</a>
        {/foreach}
    </div>        
    <form method="post" action="{$ADMIN_URL}brands/translate/{echo $model->Id}" class="form-horizontal" id="br_tr_form">
    <div class="tab-content">
            {$act = 1}
            {foreach $languages as $language}
                {$model->setLocale($language.identif)}    
                <div class="tab-pane {if $act == 1} active {$act = 0} {/if}" id="{echo $language.identif}">
                    <div class="row-fluid">
                        <table class="table  table-bordered table-hover table-condensed content_big_td">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        {echo $language.lang_name}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">
                                        <div class="inside_padd">
                                            <div class="row-fluid">
                                                {foreach $translatableFieldNames as $fieldName}
                                                    {$methodName = 'get'.$fieldName}
                                                    <div class="control-group">
                                                        <label class="control-label">{echo $model->getLabel($fieldName)}:</label>
                                                        <div class="controls">
                                                            {if in_array($fieldName, $mceEditorFieldNames)}
                                                                <textarea class="elRTE" name="{echo $fieldName}_{echo $language.identif}" >{echo $model->$methodName()}</textarea>
                                                            {else:}
                                                                <input type="text" name="{echo $fieldName}_{echo $language.identif}" value="{echo $model->$methodName()}"/>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                {/foreach}    
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {form_csrf()}
                    </div>
                </div>
            {/foreach}
            <div class="tab-pane"></div>
        </div>
    </form>
</section>


