<div class="saPageHeader">
    <h2>{lang('Editing','admin')}dsffds {lang('Categories','admin')}</h2>
</div>

{if sizeof($tree)==0}
    <div id="notice" class="alert alert-info">{lang('Category list is empty','admin')}.
        <a href="#" onclick="ajaxShop('categories/create'); return false;">{lang('Create','admin')}.</a>
    </div>

    {return}
{/if}

<div id="sortable">
		  <table id="ShopCatsHtmlTable">
		  	<thead>
                <th width="5px">{lang('ID','admin')}</th>
                <th>{lang('Name','admin')}</th>
                <th>{lang('URL','admin')}</th>
                <th>{lang('Active','admin')}</th>
                <th>
                    {lang('Position','admin')}
                    <img src="{$THEME}images/save.png" align="absmiddle" style="cursor:pointer;width:22px;height:22px;" 
                    onclick="SaveCategoriesPositions(); return false;" />  
                </th>
                <th></th>
			</thead>
			<tbody>
		{foreach $tree as $c}
		{setDefaultLanguage($c)}
		<tr {if !$c->getActive()}class="unactiveCategory"{/if}>
			<td>{echo $c->getId()}</td>
			<td onclick="javascript:ajaxShop('categories/edit/{echo $c->getId()}/{echo $c->getLocale()}');">
                {str_repeat('-',$c->getLevel())}
                {if $c->getLevel()==0}
                    <b>{echo ShopCore::encode($c->getName())}</b>
                {else:}
                    {echo ShopCore::encode($c->getName())}
                {/if}
            </td>
			<td><a href="{shop_url('category/' . $c->getFullPath())}" target="_blank">{echo $c->getFullPath()}</a></td>
			<td>{if $c->getActive()} {lang('Yes','admin')} {else:} {lang('No','admin')} {/if}</td>
            <td>
                <input type="text" value="{echo $c->getPosition()}" style="width:26px;" class="SCategoryPos" id="SCat{echo $c->getId()}" /> 
            </td>
            <td style="text-align:right;">
				{if count($languages) > 1}
					<img onclick="translate_list_item({echo $c->getId()}); return false;" src="/application/modules/shop/admin/templates/assets/images/translateable.png" width="16" height="16"/> 	
				{/if}
				<img onclick="confirm_shop_category({echo $c->getId()});" src="{$THEME}images/delete.png"  style="cursor:pointer" width="16" height="16" title="{lang('Delete','admin')}" />
			</td>
		</tr>
		{/foreach}
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
                </tr>
			</tfoot>
		  </table>
</div>

{literal}
		<script type="text/javascript">
			window.addEvent('domready', function(){
				shopCatsTable = new sortableTable('ShopCatsHtmlTable', {overCls: 'over', sortOn: -1 ,onClick: function(){}});
                shopCatsTable.altRow();
			});
			
			function translate_list_item(iId)
			{
				MochaUI.translate_list_item_Window = function() {
					new MochaUI.Window({
						id: 'translate_list_item_Window',
						title: '<img width="16" height="16" align="absmiddle" src="/application/modules/shop/admin/templates/assets/images/translateable.png"/> {/literal}{lang('Translation','admin')} {lang('Categories','admin')}'{literal},
						loadMethod: 'xhr',
						contentURL: shop_url + 'categories/translate/' + iId,
						width: 950,
						height: 540
					});
					$('translate_list_item_Window_content').setStyles({
						'padding-top': 0,
						'padding-bottom': 0,
						'padding-left': 0,
						'padding-right': 0
					});
				}

				MochaUI.translate_list_item_Window();
			}

			function confirm_shop_category(id)
			{
				alertBox.confirm('<h1>{/literal}{lang('Delete','admin')} {lang('Categories','admin')} {lang('ID','admin')}: ' + id + '? </h1>{literal}', {onComplete:
					function(returnvalue) {
						if(returnvalue)
						{
							var req = new Request.HTML({
								method: 'post',
								url: shop_url + 'categories/delete',
								evalResponse: true,
								onComplete: function(response) {  
									ajaxShop('categories/index');
									loadShopSidebarCats();
								}
							}).post({'id': id});
						}
					}
				});
			}
        </script>
{/literal}
