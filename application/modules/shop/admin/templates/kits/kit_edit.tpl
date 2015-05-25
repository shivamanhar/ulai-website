<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Product kit editing','admin')}: {echo $model->getId()}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$ADMIN_URL}kits/index" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Go back','admin')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#kit_edit_form" data-submit><i class="icon-ok"></i>{lang('Save','admin')}</button>
                <button type="button" class="btn btn-small formSubmit" data-form="#kit_edit_form" data-action="tomain"><i class="icon-check"></i>{lang('Save and go back','admin')}</button>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="modules">
            <div class="row-fluid">
                <form method="post" action="{$ADMIN_URL}kits/kit_edit/{echo $model->getId()}" class="form-horizontal" id="kit_edit_form">
                    <input type="hidden" name="Locale" value="{echo $locale}"/>
                    <table class="table  table-bordered table-hover table-condensed content_big_td">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    {lang('Properties','admin')}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="inside_padd span9">
                                        <div class="control-group">
                                            <label class="control-label" for="kitMainProductName">{lang('Main product','admin')}: <span class="must">*</span></label>
                                            <div class="controls">
                                                {if $model->getMainProduct()->firstVariant->getNumber()}
                                                    {$numberMainProduct = '(' .$model->getMainProduct()->firstVariant->getNumber() . ')';}
                                                {else:}
                                                    {$numberMainProduct = '';}
                                                {/if}
                                                <input type="text" name="Name" value="{echo $model->getMainProduct()->getId()} - {echo $model->getMainProduct()->getName()} {echo $numberMainProduct}" id="kitMainProductName" {if !$canChangeMainProduct}disabled="disabled"{/if} class="input-xxlarge"/>
                                                <input type="hidden" id="MainProductHidden" name="MainProductId" value="{echo $model->getMainProduct()->getId()}">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">{lang('Attached products','admin')}: <span class="must">*</span></div>
                                            <div class="controls" id="forAttached">
                                                <span class="help-inline d_b">{lang('Name','admin')}</span>
                                                <input type="text" id="AttachedProducts" value="" class="input-xxlarge"/>
                                                {foreach $model->getShopKitProducts() as $shopKitProduct}
                                                    {$ap = $shopKitProduct->getSProducts()}
                                                    {if $ap->firstVariant->getNumber()}
                                                        {$numberMainProduct = ShopCore::encode('(' . $ap->firstVariant->getNumber() . ')');}
                                                    {else:}
                                                        {$numberMainProduct = '';}
                                                    {/if}
                                                    <div id="tpm_row{echo $ap->getId()}" class="m-t_10">
                                                        <div class="d-i_b number v-a_b">
                                                            <span class="help-inline d_b">ID</span>
                                                            <input type="text" name="AttachedProductsIds[]" readonly="readonly" value="{echo $ap->getId()}" data-placement="left" data-original-title="{lang('numbers only','admin')}" class="input-mini"/>
                                                        </div>
                                                        <div class="d-i_b v-a_b">
                                                            <span class="help-inline d_b">{lang('Name','admin')}</span>
                                                            <input type="text" value="{echo ShopCore::encode($ap->getName())} {echo $numberMainProduct}" readonly="readonly" class="input-xxlarge"/>
                                                        </div>
                                                        <div class="d-i_b number v-a_b">
                                                            <span class="help-inline d_b">{lang('Discount','admin')} %</span>
                                                            <input type="text" name="Discounts[]" maxlength="3" value="{echo $shopKitProduct->getDiscount()}" data-placement="left" data-original-title="{lang('numbers only','admin')}" class="input-mini valueInputN"/>
                                                        </div>
                                                        <a class="btn del_tmp_row btn-small btn-danger" data-kid="{echo $ap->getId()}" data-rel="tooltip" data-title="{lang('Delete','admin')}"><i class="icon-trash"></i></a>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label"></div>
                                            <div class="controls">
                                                <span class="frame_label no_connection">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox" name="Active" id="MainProductHidden" value="1" {if $model->getActive() == true}checked="checked"{/if} />
                                                    </span>
                                                    {lang('Active','admin')}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label"></div>
                                            <div class="controls">
                                                <span class="frame_label no_connection">
                                                    <span class="niceCheck b_n">
                                                        <input type="checkbox" name="OnlyForLogged" value="1" {if $model->getOnlyForLogged() == true}checked="checked"{/if} />
                                                    </span>
                                                    {lang('Only for logged users','admin')}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {form_csrf()}
                </form>
            </div>
        </div>
        <div class="tab-pane"></div>
    </div>
</section>