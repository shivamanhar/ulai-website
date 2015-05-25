{foreach $categories as $category}
    <option {if $selected_id == $category->getId()}selected="selected"{/if} {if $category->getLevel() == 0}style="font-weight: bold;"{/if} value="{echo $category->getId()}">{str_repeat('-',$category->getLevel())} {echo ShopCore::encode($category->getName())}</option>
{/foreach}