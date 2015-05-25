{foreach $rows as $key => $row}
    <div class="control-group">
        <span class="control-label">
            {if $key === 0}
                <span data-title="&lt;b&gt;{lang('Attributes','import_export')}&lt;/b&gt;" class="popover_ref" data-original-title=""><i class="icon-info-sign"></i></span>
                <div class="d_n">{lang('The list of attributes that will be imported','import_export')}</div>
                <span>{lang('Properties','import_export')}:</span>
            {/if}
        </span>
        <div class="controls">
            <div class="input-append span7 dropup">
                <div class="btn-group pull-right">
                    {if $attrInRow = $attributes[$row]}
                        <div class="btn btn-mini" title="{echo $attrInRow}" style="max-width: 165px;margin-left: 5px; cursor: default;">
                            <span data-attrnames="{echo $row}" class="attrnameHolder" style="width: 142px;">{echo $attrInRow}</span>
                        </div>
                    {else:}
                        <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown" title="{lang('Skip column','import_export')}" style="max-width: 165px;padding: 4px 6px 0px;">
                            <span data-attrnames="skip" class="attrnameHolder">{lang('Skip column','import_export')}</span>&nbsp;<span class="caret"></span>
                        </button>
                        <ul style="height:213px;overflow:auto;" class="dropdown-menu dropdown-attr">
                            {foreach $attributes as $keyAttr => $attribut}
                                <li>
                                    <a style="line-height: 12px;" data-attName="{echo $keyAttr}">{echo $attribut}</a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                </div>
                <div class="o_h disable">
                    <input style="height:30px!important;min-height:30px!important;" readonly="readonly" class=" readonly disable" id="appendedDropdownButton" type="text" value="{$row}">
                </div>
            </div>
        </div>
    </div>
{/foreach}
