<div class="form_text">{lang('Select','admin')} {lang('Categories','admin')}:</div>
<div class="form_input">
    <select name="CategoryId" id="moveCategoryId" style="width:285px;">
        {foreach $categories as $category}
            <option {if $category->getId() == $categoryId}selected{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
        {/foreach}
    </select>
</div>
<div class="form_overflow"></div>

<div class="form_text"></div>
<div class="form_input">
    <input id="footerButton" value="{lang('Move','admin')}" type="button" onclick="shopProductsList_moveProducts( $('moveCategoryId').value );" title="{lang('Move','admin')}">
    <input id="footerButton" value="{lang('Cancel','admin')}" type="button" onclick="MochaUI.closeWindow($('productsListMoveWindow'));" title="{lang('Cancel','admin')}">
</div>
<div class="form_overflow"></div>
