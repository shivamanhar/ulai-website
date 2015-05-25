{foreach $brands as $brand}
    <option {if $selected_id == $brand->getId()}selected="selected"{/if} value="{echo $brand->getId()}">{echo ShopCore::encode($brand->getName())}</option>
{/foreach}