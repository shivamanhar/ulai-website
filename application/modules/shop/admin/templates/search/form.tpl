<div class="saPageHeader" style="float:left;width:100%;position:relative;">
    <h2 style="float:left;">{lang('Search','admin')}</h2>
    dsfsfssdfdsahrehehertger
    <div style="float:left;clear:right;margin-top:9px;margin-left:48px">
        <a href="#" onclick="toggleShopSearchBox();
                return false;">{lang('Change','admin')} {lang('Options','admin')} &darr;</a>
    </div>

    <div id="shopTopSearchForm"> <!-- begin form block -->
        <form method="get" action="{$ADMIN_URL}search/index"  style="width:100%">
            <input type="hidden" name="s" value="1"> 
            <div class="form_text">{lang('Categories','admin')}:</div>
            <div class="form_input">
                <select name="CategoryId" style="width:285px;" onChange="shopLoadProperiesByCategoryInSearch(this);">
                    <option value="">- {lang('All','admin')} -</option>
                    {foreach $categories as $category}
                        {if isset(ShopCore::$_GET['CategoryId']) && ShopCore::$_GET['CategoryId'] == $category->getId()}
                            {$selected='selected="selected"'}
                        {else:}
                            {$selected = ''}
                        {/if}
                        <option {$selected} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
                    {/foreach}
                </select>
            </div>
            <div class="form_overflow"></div>

            <div class="form_text"></div>
            <div class="form_input">
                <input type="text" name="text" value="{echo encode(ShopCore::$_GET['text'])}" class="textbox_long" />
                <div class="lite">{lang('Specify','admin')} {lang('Name','admin')} {lang('or','admin')} {lang('Item','admin')}</div>
            </div>
            <div class="form_overflow"></div>

            <div class="form_text"></div>
            <div class="form_input">
                <select name="Active" style="margin-left: 100px">
                    <option value="">-</option>
                    <option {if ShopCore::$_GET['Active'] == 'true'} selected="selected" {/if} value="true">{lang('Active','admin')}</option>
                    <option {if ShopCore::$_GET['Active'] == 'false'} selected="selected" {/if} value="false">{lang('inactive','admin')}</option>
                </select>

                <select name="Hit">
                    <option value="">-</option>
                    <option {if ShopCore::$_GET['Hit'] == 'true'} selected="selected" {/if} value="true">{lang('Hit','admin')}</option>
                    <option {if ShopCore::$_GET['Hit'] == 'false'} selected="selected" {/if} value="false">{lang('No','admin')} {lang('Hit','admin')}</option>
                </select>

                <select name="Hot">
                    <option value="">-</option>
                    <option {if ShopCore::$_GET['Hot'] == 'true'} selected="selected" {/if} value="true">{lang('New','admin')}</option>
                    <option {if ShopCore::$_GET['Hot'] == 'false'} selected="selected" {/if} value="false">{lang('No','admin')} {lang('New','admin')}</option>
                </select>

                <select name="Action">
                    <option value="">-</option>
                    <option {if ShopCore::$_GET['Action'] == 'true'} selected="selected" {/if} value="true">{lang('Special offers','admin')}</option>
                    <option {if ShopCore::$_GET['Action'] == 'false'} selected="selected" {/if} value="false">{lang('No','admin')} {lang('Special offers','admin')}</option>
                </select>
            </div>
            <div class="form_overflow"></div>

            <div id="productPropertiesContainer">{$fieldsForm}</div>

            <div class="form_text"></div>
            <div class="form_input">
                <input type="submit" id="footerButton" name="_startSearch" value="{lang('Search start','admin')}" class="active"  onClick="ajaxShopForm(this, 'shopAdminPage');" />
            </div>
            <div class="form_overflow"></div>
        </form>
    </div> <!-- end form block -->
</div>
{literal}
    <style type="text/css">
        #shopTopSearchForm {
            background-color:#fff;
            width:500px;
            margin-left:100px;
            margin-top:35px;
            z-index:99999;
            position:absolute;
            border:1px solid silver;
            clear:both;
            display:none;
        }
    </style>

    <script type="text/javascript">
            function toggleShopSearchBox()
            {
                if ($('shopTopSearchForm').getStyle('display') == 'none')
                {
                    $('shopTopSearchForm').setStyle('display', 'block');
                } else {
                    $('shopTopSearchForm').setStyle('display', 'none');
                }
            }
    </script>
{/literal}