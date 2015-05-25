<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Edit category ID','admin')}: {echo $model->Id}. {echo ShopCore::encode($model->getName())}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/run/shop/categories/index" class="t-d_n m-r_15 pjax">
                    <span class="f-s_14">←</span>
                    <span class="t-d_u">{lang('Go back','admin')}</span>
                </a>
                <button type="button" class="btn btn-small btn-primary action_on formSubmit" data-form="#cat_ed_form" data-action="edit" data-submit>
                    <i class="icon-ok"></i>
                    {lang('Save','admin')}
                </button>
                <button type="button" class="btn btn-small action_on formSubmit" data-form="#cat_ed_form" data-action="close">
                    <i class="icon-check"></i>{lang('Save and go back','admin')}
                </button>
                {echo create_language_select($languages, $locale, "/admin/components/run/shop/categories/edit/".$model->getId())}
            </div>
        </div>
    </div>
    <form method="post" onkeypress="if (window.event.keyCode == 13)
                return false;"  action="{$ADMIN_URL}categories/edit/{$modelArray.Id}/{echo $locale}" enctype="multipart/form-data" class="form-horizontal m-t_10" id="cat_ed_form">
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
                        <div class="inside_padd">
                            <div class="span9">
                                <div class="control-group">
                                    <label class="control-label" for="inputName">
                                        {echo $translatable}&nbsp;{echo $model->getLabel('Name')}:
                                        <span class="must">*</span>
                                    </label>

                                    <div class="controls">
                                        <input type="text" name="Name" required="required" value="{echo ShopCore::encode($modelArray.Name)}" id="inputName"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="ParentId">{echo $model->getLabel('ParentId')}:</label>
                                    <div class="controls">
                                        <select name="ParentId" id="ParentId" value="" class="chosen">
                                            <option value="0">{lang('Not selected','admin')}</option>
                                            {foreach $categories as $category}
                                                {if $category->getName()}
                                                    <option
                                                        {if $category->getId()==$modelArray.Id}
                                                            disabled="disabled"
                                                        {/if}
                                                        {if $category->getId()==$modelArray.ParentId}
                                                            selected="selected"
                                                        {/if}
                                                        {if in_array($modelArray.Id, unserialize($category->getFullPathIds()))}
                                                            disabled="disabled"
                                                        {/if}
                                                        value="{echo $category->getId()}"> {str_repeat('-', count(unserialize($category->getFullPathIds())))} {echo ShopCore::encode($category->getName())}
                                                    </option>
                                                {/if}
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="Img">
                                        {lang('Logo', 'admin')}:
                                    </label>
                                    <div class="controls">
                                        <div class="group_icon pull-right">
                                           <a href="{echo site_url('application/third_party/filemanager/dialog.php?type=1&field_id=Img');}" class="btn  iframe-btn" type="button">
                                                <i class="icon-picture"></i>
                                                {lang('Select image', 'admin')}
                                            </a>
                                        </div>
                                        <div class="o_h">
                                            <input type="text" name="Image" id="Img" value="{$modelArray.Image}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputDescr">{echo $translatable}{echo $model->getLabel('Description')}:</label>
                                <div class="controls">
                                    <textarea class="elRTE" name="Description" id="inputDescr">{echo ShopCore::encode($modelArray.Description)}</textarea>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table  table-bordered table-hover table-condensed content_big_td">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('Settings','admin')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd span9">
                            <div class="row-fluid">
                                <div class="control-group">
                                    <label class="control-label" for="inputTemplateCategory">{echo $model->getLabel('tpl')}:</label>
                                    <div class="controls">
                                        <div class="group_icon pull-right">
                                            <button type="button" class="btn btn-small btn-success" id="create_tpl"><i class="icon-plus-sign icon-white"></i>{lang('Create a new template','admin')}</button>
                                        </div>
                                        <span class="o_h d_b">
                                            <input type="text" name="tpl" value="{echo $model->getTpl()}"  maxlength="250" id="inputTemplateCategory"/>
                                        </span>
                                        <span class="help-block">
                                            {lang('The basic template category. Default category.tpl','admin')}
                                        </span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputUrl">{echo $model->getLabel('Url')}:</label>
                                    <div class="controls">
                                        <div class="group_icon pull-right">
                                            <button type="button" class="btn btn-small" id="translateCategoryTitle"><i class="icon-refresh"></i>&nbsp;&nbsp;{lang('Autoselection','admin')}</button>
                                        </div>
                                        <span class="o_h d_b">
                                            <input type="text" name="Url" id="inputUrl" value="{$modelArray.Url}"/>
                                        </span>
<!--                                                <img onclick="translateCategoryTitle($('CategoryName').value);" align="absmiddle" style="cursor:pointer" src="{$THEME}images/translit.png" width="16" height="16" title="Транслитерация заголовка." />-->
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputSortdefault">{echo $model->getLabel('order_method')}:</label>
                                    <div class="controls">
                                        <select name="order_method">
                                            <option {if $model->order_method == 0}selected{/if} value="0">-{lang('Not selected','admin')}-</option>
                                            <option {if $model->order_method == 1}selected{/if} value="1">{lang('By raiting','admin')}</option>
                                            <option {if $model->order_method == 2}selected{/if} value="2">{lang('From cheap to expensive','admin')}</option>
                                            <option {if $model->order_method == 3}selected{/if} value="3">{lang('From expensive to cheap','admin')}</option>
                                            <option {if $model->order_method == 4}selected{/if} value="4">{lang('Popular','admin')}</option>
                                            <option {if $model->order_method == 5}selected{/if} value="5">{lang('Novelty','admin')}</option>
                                            <option {if $model->order_method == 6}selected{/if} value="6">{lang('Promotions','admin')}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <span class="frame_label no_connection">
                                            <span class="niceCheck b_n">
                                                <input type="checkbox" value="1"  {if $model->getActive() == true}checked="checked"{/if}  name="Active" />
                                            </span>
                                            {echo $model->getLabel('Active')}
                                        </span>
                                        <!--                                                <span class="frame_label no_connection m-l_15">
                                                                                            <span class="niceCheck b_n">
                                                                                                <input type="checkbox"/>
                                                                                            </span>
                                                                                            Не отображать товары подкатегории
                                                                                        </span>-->
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <span class="frame_label no_connection">
                                            <span class="niceCheck b_n">
                                                <input type="checkbox" value="1"  {if $model->getShowsitetitle() == 1}checked="checked"{/if}  name="showsitetitle" />
                                            </span>
                                            {lang('Do not show short name of the site','admin')}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table  table-bordered table-hover table-condensed content_big_td">
            <thead>
                <tr>
                    <th colspan="6">
                        {lang('Meta data','admin')}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd span9" style="width:984px">
                            <div class="row-fluid">
                                <div class="control-group">
                                    <label class="control-label" for="inputTagmeta">{echo $translatable}{echo $model->getLabel('H1')}:</label>
                                    <div class="controls">
                                        <input type="text"  name="H1" value="{echo ShopCore::encode($modelArray.H1)}" id="inputTagmeta"  style="width:100%"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputTagmetadescription">{echo $translatable}{echo $model->getLabel('MetaDesc')}:</label>
                                    <div class="controls">
                                        <input type="text" name="MetaDesc" value="{echo ShopCore::encode($modelArray.MetaDesc)}" id="inputTagmetadescription"  style="width:100%"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputTagmetakey">{echo $translatable}{echo $model->getLabel('MetaTitle')}:</label>
                                    <div class="controls">
                                        <input type="text" name="MetaTitle" value="{echo ShopCore::encode($modelArray.MetaTitle)}" id="inputTagmetakey"  style="width:100%"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputaddname">{echo $translatable}{echo $model->getLabel('MetaKeywords')}:</label>
                                    <div class="controls">
                                        <input type="text" name="MetaKeywords" value="{echo ShopCore::encode($modelArray.MetaKeywords)}" id="inputaddname"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        {include_tpl('../modules_additions')}
        {form_csrf()}
    </form>
</section>
<div id="elFinder"></div>
<script type="text/javascript"> var tpls = {echo json_encode(array_values($tpls))};</script>