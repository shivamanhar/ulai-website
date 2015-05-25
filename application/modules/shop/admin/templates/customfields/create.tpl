<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Create additional field','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="/admin/components/run/shop/customfields" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-success formSubmit" data-form="#create" data-action="edit" data-submit><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>                
<!--                <button type="button" class="btn btn-small formSubmit" data-form="#create" data-action="exit" ><i class="icon-plus-sign icon-white"></i>{lang('Create and exit','admin')}</button>                -->
            </div>
        </div>                            
    </div>
    <table class="table  table-bordered table-hover table-condensed content_big_td m-t_10">
        <thead>
            <tr>
                <th colspan="6">
                    {lang('Data','admin')}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <div class="inside_padd">
                        <div class="form-horizontal">
                            <form id="create" method="post" active="{$ADMIN_URL}customfields/create">
                                <div class="span12">
                                    <div class="control-group">
                                        <label class="control-label" for="Entity_select">{lang('Entity','admin')}:</label>
                                        <div class="controls">
                                            <select name="Entity" id="Entity_select">
                                                <option value="user">{lang('Users','admin')}</option>
                                                <option value="order">{lang('Orders ','admin')}</option> 
                                                <option value="product">{lang('Product','admin')}</option>
                                                <option value="user_order">{lang('Users','admin')}, {lang('Orders ','admin')}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="inputName">{lang('Name','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="name" value="" id="inputName" class="required"/>
                                            <span class="help-block">{lang('The field should only contain letters without numbers','admin')}</span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="inputLabel">{lang('Label','admin')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="fLabel" id="inputLabel" class="required"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputDesc">{lang('Description','admin')}:</label>
                                        <div class="controls">
                                            <textarea name="description" value="" class="elRTE" id="inputDesc"></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" name="is_required" class=""/>
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
                                                    <input type="checkbox" name="is_active" class="" checked="checked"/>
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
                                                    <input type="checkbox" name="is_private" id="inputPrivate"/>
                                                </span>
                                                {lang('Field private','admin')}
                                            </span>
                                        </div> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="type_select">{lang('Field type','admin')}:</label>
                                        <div class="controls">
                                            <select name="typeId" id="type_select">
                                                <option value="0">{lang('Text', 'admin')}</option>
                                                <option value="1">{lang('Textarea field', 'admin')}</option>
                                                <option value="3">{lang('File field', 'admin')}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group" id="possVal" style="display: none;">
                                        <label class="control-label" for="inputPV">{lang('Possible values','admin')}:</label>
                                        <div class="controls">
                                            <textarea name="possible_values" id="inputPV"></textarea>
                                        </div>
                                    </div>
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
                                            <input type="text" name="validators" id="inputValidators"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">
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
                                            <input type="text" name="classes" id="inputClasses"/>
                                        </div>
                                    </div>

                                    <!--
                                    <div class="control-group">
                                        <label class="control-label" >
                                            <span class="popover_ref" data-title="<b>{lang('Access rights','admin')}</b>">                                                       
                                                <i class="icon-info-sign"></i>
                                            </span>
                                            <div class="d_n">
                                    {lang('Access rights define <br />a set of actions (eg, read,<br /> write, execute) permissions for<br /> the subjects (for example, users<br /> of the system) of <br />the data objects.','admin')}
                                </div>
                                <span>{lang('Access rights','admin')}</span>
                                    :</label>

                                <div class="controls">
                                    <textarea name="rules" value="" class="elRTE" id="inputARights"></textarea>
                                </div>
                            </div>
                                    -->
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>                               
</section>