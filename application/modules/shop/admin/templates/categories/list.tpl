<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Product categories','admin')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <button type="button" class="btn btn-small CreateFastT"  ><i class="icon-plus-sign"></i>{lang('Open fast create','admin')}</button>
                <a class="btn btn-small btn-success pjax" href="/admin/components/run/shop/categories/create"><i class="icon-plus-sign icon-white"></i>{lang('Create a category','admin')}</a>
                <button type="button" onclick="shopCategories.deleteCategories()" class="btn btn-small btn-danger disabled action_on" id="del_sel_cat"><i class="icon-trash"></i>{lang('Delete','admin')}</button>
            </div>
        </div>
    </div>
    <div class="frame_level table table-hover table-condensed products_table">
        {if sizeof($tree)>0}
        <div id="category">
            <div class="row-category p_cat_row-category head">
                <div class="t-a_c">
                    <span class="frame_label">
                        <span class="niceCheck b_n">
                            <input type="checkbox">
                        </span>
                    </span>
                </div>
                <div>ID</div>
                <div style="width: 26%;">{lang('Title','admin')}</div>
                <div style="width: 22%;">{lang('Parent Category','admin')}</div>
                <div style="width: 26%;">{lang('URL','admin')}</div>
                <div style="width: 8%;">{lang('Number of products','admin')}</div>
                <div style="width: 8%;">{lang('Active','admin')}</div>
            </div>


            <div class="dropCategoryFast">
                <div class="row-category">
                    <div class="">
                        {/*lang('Fast create','admin') */}
                    </div>
                    <div style="width: 26%;">
                        <div class="clearfix input-photo-text-out">
                            <div class="input-text-in">
                                <input name="Name" type="text" id="toTranslation"/>
                            </div>
                        </div>
                    </div>
                    <div style="width: 22%;">
                        <div class="d-i_b">
                            <select name="catId">
                                <option value="0">-----</option>
                                {foreach $tree as $cat}
                                <option value="{echo $cat->getId()}">{echo str_repeat("-", $cat->getLevel() * 2)} {echo $cat->getName()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div style="width: 34%;">
                        <div class="url-input-out">
                            <input type="text" id="slug" name="url" value=""/>
                        </div>
                    </div>
                    <div>
                        <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top" data-original-title="{lang('switch on','admin')}"  data-off="{lang('switch off','admin')}">
                            <span class="prod-on_off prop_active" data-id=""></span>
                        </div>
                    </div>
                </div>
                <div class="fast-create-btn t-a_c">
                    <button type="submit" class="btn btn-success"
                    onclick="createCatFast($('[name=Name]').val(), $('[name=catId]').val(), $('[name=url]').val(), $('.dropCategoryFast .prod-on_off'));
                    return false;"
                    ><i class="icon-plus-sign icon-white"></i>{lang('Create fast category','admin')}</button>
                    <button type="button" class="btn closeFast">{lang('Close fast create','admin')}</button>
                </div>
            </div>
            {if $_GET['fast_create']}
            {literal}
            <script type="text/javascript">
            $(document).ready(function () {
                setTimeout(function () {
                    $('.CreateFastT').click();
                }, 1000)

            })

            </script>
            {/literal}
            {/if}



            <div class="body_category">
                {$htmlTree}
            </div>
        </div>
        {else:}
    </br>
    <div class="alert alert-info">
        {lang('There are no categories at the site','admin')}
    </div>
    {/if}
</div>
<div class="clearfix">
</div>

<div class="modal categoryDeleteModal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>{lang('Delete categories','admin')}</h3>
    </div>
    <div class="modal-body">
        <p>{lang('Remove selected categories','admin')}?</p>
        <p>{lang('Attention! will also remove all the products from this category','admin')}</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary pjax" onclick="shopCategories.deleteCategoriesConfirm()" >{lang('Delete','admin')}</a>
        <a href="#" class="btn" onclick="$('.modal').modal('hide');">{lang('Cancel','admin')}</a>
    </div>
</div>

</section>
