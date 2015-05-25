<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Product property creating','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/properties/index/{echo $filter}" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-success formSubmit" data-form="#property_cr_form" data-submit><i class="icon-plus-sign icon-white"></i>{lang('Create','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#property_cr_form" data-action="tomain"><i class="icon-check"></i>{lang('Create and go back','admin')}</button>
            </div>
        </div>

    </div>
    <form method="post" action="{$ADMIN_URL}properties/create" class="form-horizontal" id="property_cr_form">
        <input type="hidden" name="Locale" value="{echo $locale}"/>
        <div class="tab-content">
            <div class="tab-pane active" id="params">
                <table class="table  table-bordered table-hover table-condensed content_big_td">
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
                                    <div class="control-group m-t_10">
                                        <label class="control-label">{echo $model->getLabel('Name')}: <span class="must">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="Name" value="" required id="toTranslation"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{echo $model->getLabel('CsvName')}:</label>
                                        <div class="controls">
                                            <input type="text" name="CsvName" value="" id="slug" />
                                            <span class="help-inline">{lang('The field must contain only Latin characters .','admin')}</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" checked="checked" value="1" name="Active" />
                                                </span>
                                                {echo $model->getLabel('Active')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" value="1" name="MainProperty" />
                                                </span>
                                                {echo $model->getLabel('MainProperty')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" value="1" name="ShowFaq" />
                                                </span>
                                                {lang('Hint','admin')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" value="1" name="ShowOnSite" />
                                                </span>
                                                {echo $model->getLabel('ShowOnSite')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" value="1" name="ShowInCompare" />
                                                </span>
                                                {echo $model->getLabel('ShowInCompare')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" value="1" name="ShowInFilter" />
                                                </span>
                                                {echo $model->getLabel('ShowInFilter')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label no_connection">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" value="1" name="Multiple" />
                                                </span>
                                                {echo $model->getLabel('Multiple')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{echo $model->getLabel('UseInCategories')}:</label>
                                        <div class="controls">
                                            <select name="UseInCategories[]" multiple="multiple">
                                                <option value="all">- {lang('Show in all categories','admin')} -</option>
                                                {foreach $categories as $category}
                                                    <option value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group m-t_10">
                                        <label class="control-label">FAQ:</label>
                                        <div class="controls">
                                            <textarea name="Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{echo $model->getLabel('Data')}:</label>
                                        <div class="controls">
                                            <textarea name="Data"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {form_csrf()}
    </form>
</section>