{$model->setlocale($locale)}
{$entities = array('product' => lang('P

roduct','admin'), 'user'=>'<i class="icon-user"></i> '.lang('User','admin'), 'order'=>'<i class="icon-shopping-cart"></i> '.lang('Order','admin'))}
<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Editing a custom field','admin')} {lang('ID','admin')}: {echo $model->getId()}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="/admin/components/run/shop/customfields" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-action="edit" data-form="#update" data-submit><i class="icon-ok"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small action_on formSubmit" data-action="exit" data-form="#update"><i class="icon-check"></i>{lang('Save and exit','admin')}</button>                  
                    {echo create_language_select($languages, $locale, $ADMIN_URL . "customfields/edit/" .$model->getId())}
            </div>
        </div>                            
    </div>
    <table class="table  table-bordered table-hover table-condensed content_big_td m-t_10">
        <thead>
            <tr>
                <th colspan="6">
                    {lang('Additional field data','admin')}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="inside_padd">
                        <div class="form-horizontal">
                            <form id="update" method="post" action="">
                                <div class="span12">

                                    <div class="control-group">
                                        <label class="control-label">{lang('Related entity','admin')}:</label>
                                        <div class="controls" style="margin-top: 5px;">
                                            <span>{echo $entities[$model->getEntity()]}</span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="name">{lang('Name','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="name" id="name" class="required" required="required" value="{echo ShopCore::encode($model->getName())}"/>
                                            <span class="help-block">{lang('The field should only contain letters without numbers','admin')}</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="fLabel">{lang('Label','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="fLabel" id="fLabel" class="required" required="required" value="{echo ShopCore::encode($model->getfieldlabel())}" />
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="description">{lang('Description','admin')}:</label>
                                        <div class="controls">
                                            <textarea name="description" id="description" class="elRTE">{echo ShopCore::encode($model->getfieldDescription())}</textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" name="is_required" {if ShopCore::encode($model->getIsRequired()) == 1} checked="checked" {/if}class="" />
                                                </span>
                                                {lang('Field required','admin')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" name="is_active" {if ShopCore::encode($model->getIsActive()) == 1} checked="checked" {/if} class=""/>
                                                </span>
                                                {lang('Field active','admin')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" id="private" name="is_private" {if  ShopCore::encode($model->getIsPrivate()) == 1} checked="checked" {/if}/>
                                                </span>
                                                {lang('Field private','admin')}
                                            </span>
                                        </div>
                                    </div>
                                    {if $model->getTypeId() == 2}
                                        <div class="control-group">
                                            <label class="control-label" for="possible">{echo $model->getLabel('possible_values')}:</label>
                                            <div class="controls">
                                                <textarea id="possible" name="possible_values" >{echo implode( unserialize($model->getpossibleValues()), ', ')}</textarea>
                                            </div>
                                        </div>
                                    {/if}
                                    <div class="control-group">
                                        <label class="control-label">
                                            <span class="popover_ref" data-title="<b>{lang('Validators','admin')}</b>">                                                                    
                                                <i class="icon-info-sign"></i>
                                            </span>
                                            <div class="d_n">
                                                {lang('Snippet of a certain format,<br /> verifies syntactic correctness<br /> of the entered information - that is,<br /> to validate.','admin')}
                                            </div>
                                            <span>{lang('Validators','admin')}:</span>
                                        </label>
                                        <div class="controls">
                                            <input type="text" id="validators" name="validators" class="textbox_long" value="{echo $model->getValidators()}" /> 
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        <label class="control-label" >
                                            <span class="popover_ref" data-title="<b>{lang('Classes', 'admin')}</b>">                                                                    
                                                <i class="icon-info-sign"></i>
                                            </span>
                                            <div class="d_n">
                                                {lang('Custom classes for widget', 'admin')}
                                                <hr>
                                                <h5>{lang('Visualizators classes', 'admin')}:</h5>
                                                <b>ColorPicker</b> - {lang('Color popup selector', 'admin')}<br/>
                                                <b>datepickerTime</b> - {lang('Date popup selector', 'admin')}<br/>
                                            </div>
                                            <span>{lang('Classes', 'admin')}:</span>
                                        </label>
                                        <div class="controls">
                                            <input type="text" name="classes" id="inputClasses" value="{echo $model->getClasses()}"/>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table> 
</section>