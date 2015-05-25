<?php

class SAdminSidebarRenderer
{
    /**
     * Create and display ul list of shop categories.
     *
     * @access public
     */
    public function render()
    {
        ob_start();
        $this->_walkArrayAdmin(ShopCore::app()->SCategoryTree->getTree(SCategoryTree::MODE_MULTI));
        $tree = ob_get_clean();

        if ($tree=='')
            echo '<a href="javascript:ajaxShop(\'categories/create\')">Создать категорию</a>';

        echo '<div class="rdTreeFirebug demotree">
        <ul id="desktop_tree">';
        echo $tree;
        echo '
        </ul>
        </div>
        <script type="text/javascript">
        var ShopCatsTree = new rdTree(\'desktop_tree\');
        ShopCatsTree.expandAll();
        </script>';
    }

    /**
     * Display categories ul list.
     *
     * @param mixed $array categories tree
     * @access protected
     * @return void
     */
    protected function _walkArrayAdmin($array)
    {
        foreach($array as $key)
        {
            if (!$key->getActive())
                $style = 'style="color:silver;"';
            else
                $style = '';

            echo '<li><a href="#" '.$style.' onclick="ajaxShop(\'products/index/'.$key->getId().'\'); return false;">'.ShopCore::encode($key->getName()).'</a>';
            if(sizeof($key->getSubtree()))
            {
                echo '<ul>';
                $this->_walkArrayAdmin($key->getSubtree());
                echo '</ul>';
            }
            echo '</li>';
        }
    }
}
