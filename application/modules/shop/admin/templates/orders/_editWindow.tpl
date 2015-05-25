<form>
    {if $product == null}
        <div class="form_text"></div><div class="form_input" style="color: #DD6464;font-size: 11px;">{lang(' This product has been deleted from the shop! You can only change the quantity or replace by another product','admin')}</div>
    {/if}
    <div class="form_text">{lang('Categories','admin')}:</div>
    <div class="form_input">
        <select id="Categories" onchange="clearProductField();">
            <option value="-">-</option>
            {foreach ShopCore::app()->SCategoryTree->getTree() as $category}
                <option {if $product != null}{if $product->getCategoryId() == $category->getId()}selected="selected"{/if}{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
            {/foreach}
        </select>
    </div>
    <div class="form_overflow"></div>
    
    <div class="form_text">{lang('Product','admin')}:</div>
    <div class="form_input">
        <input id="product_name" type="text" value="{if $product != null}{echo ShopCore::encode($product->getName())}{else:}{echo ShopCore::encode($orderedProduct->getProductName())}{/if}" class="textbox_long" name="product_name"/>
    </div>
    
    <input id="product_id" type="hidden" value="{echo $orderedProduct->getProductId()}" name="product_id"/>
    <div class="form_overflow"></div>
    
    <div class="form_text">{lang('Variant','admin')}:</div>
    <div class="form_input">
        <select id="product_variant_name" class="textbox_long" name="product_variant" >
		{if $product != null}
                {foreach $product->getProductVariants() as $variant}
			<option  {if $orderedProduct->getVariantId() == $variant->getId()}selected="selected"{$vPrice=$variant->getPrice()}{/if} value="{echo $variant->getId()}">{echo ShopCore::encode($variant->getName())} {echo $variant->getPrice()} {$CS}</option>
		{/foreach}
                {else:}
                    <option selected="selected" value="{echo $orderedProduct->getVariantId()}">{echo ShopCore::encode($orderedProduct->getVariantName())} {echo $orderedProduct->getPrice()} {$CS}</option>
                {/if}
        </select>
    </div>
    <div class="form_overflow"></div>

    {if $orderedProduct->getPrice() != $vPrice && $product != null}
    <div class="form_text" style="color: #DD6464">{lang('Product price has been changed. Old product price','admin')} {echo $orderedProduct->getPrice()}{$CS} {lang('Save the old price ?','admin')}</div>
    <div class="form_input">
        <input type="radio" name="SavePrice" value="yes" checked>{lang('Yes','admin')}
        <input type="radio" name="SavePrice" value="no">{lang('No','admin')} 
    </div>
    <div class="form_overflow"></div>
    {/if}
    
    <div class="form_text">{lang('Total','admin')}:</div>
    <div class="form_input">
        <input id="product_quantity" type="text" value="{echo $orderedProduct->getQuantity()}" class="textbox_long" name="product_name"/>
    </div>
    <div class="form_overflow"></div>
    
    <div class="form_text"></div>
    <div class="form_input">
        <input id="footerButton" value="{lang('Save','admin')}" type="button" onclick="shopOrderCartEditProducts({echo $orderedProduct->getId()});" title="{lang('Save','admin')}">
        <input id="footerButton" value="{lang('Cancel','admin')}" type="button" onclick="MochaUI.closeWindow($('productsListMoveWindow'));" title="{lang('Cancel','admin')}">
    </div>
    <div class="form_overflow"></div>
</form>
<div id="auto_container"></div>