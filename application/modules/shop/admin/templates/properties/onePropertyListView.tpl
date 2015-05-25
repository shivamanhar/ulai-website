<tr data-id="{echo $p->getId()}">
    <td class="t-a_c">
                                <span class="frame_label">
                                    <span class="niceCheck b_n">
                                        <input type="checkbox" name="ids" value="{echo $p->getId()}"/>
                                    </span>
                                </span>
    </td>
    <td>{echo $p->getId()}</td>
    <td>
        <a class="pjax"
           href="{$ADMIN_URL}properties/edit/{echo $p->getId()}/{echo $locale}"
           data-rel="tooltip"
           data-title="{lang('Edit property','admin')}">{truncate(ShopCore::encode($p->getName()),100)}</a>
    </td>
    <td>
        {foreach $p_cat[$p->getId()] as $k=>$categ_name}
            {if trim($categ_name)}
                {echo $categ_name}{if count($p_cat[$p->getId()]) != $k+1 },{/if}
            {/if}
        {/foreach}
    </td>
    <td>{echo $p->getCSVName()}</td>
    <td class="span1">
        <div class="frame_prod-on_off" data-rel="tooltip" data-placement="top"
             data-original-title="{lang('switch on','admin')}"
             data-off="{lang('switch off','admin')}">
                                            <span class="prod-on_off prop_active {if $p->getActive() != 1}disable_tovar{/if}"
                                                  data-id="{echo $p->getId()}"></span>
        </div>
    </td>
</tr>