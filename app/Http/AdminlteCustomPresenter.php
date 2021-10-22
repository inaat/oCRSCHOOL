<?php

namespace App\Http;

use Nwidart\Menus\Presenters\Presenter;

class AdminlteCustomPresenter extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<ul class="metismenu" id="menu">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</ul>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
//     <a href="{{ url('widgets') }}">
//     <div class="parent-icon"><i class='bx bx-home'></i>
//     </div>
//     <div class="menu-title">Dashboard</div>
// </a>
    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<li' . $this->getActiveState($item) . '><a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' .'<div class="parent-icon">'. $item->getIcon() .'</div>'. ' <div class="menu-title">' . $item->title . '</div></a></li>' . PHP_EOL;
    }
    public function getChild_Menu($item){

        return '<li'. $this->getActiveState($item) . '><a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>'. $item->getIcon().$item->title .' </a></li>';
    }
    /**
     * {@inheritdoc }.
     */
    public function getActiveState($item, $state = ' class="active"')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = 'active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc }.
     */
    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getHeaderWrapper($item)
    {
        return '<li class="menu-label">' . $item->title . '</li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        return '<li class="' . $this->getActiveStateOnChild($item, ' active') . '" ' . $item->getAttributes() . '>
		          <a href="#" class="has-arrow">
                  <div class="parent-icon">'
                  . $item->getIcon() . '
                       </div>
                    <div class="menu-title">' . $item->title . '</div>
					
			      </a>
			      <ul>
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
        . PHP_EOL;
    }

 

    public function getChildMenuItems($item){
        $results = '';
        foreach ($item->getChilds() as $child) {
            if ($child->hidden()) {
                continue;
            }

            if ($child->hasSubMenu()) {
                $results .= $this->getMultiLevelDropdownWrapper($child);
             } elseif ($child->isHeader()) {
                 $results .= $this->getHeaderWrapper($child);
             } elseif ($child->isDivider()) {
                $results .= $this->getDividerWrapper();
             } else {
                $results .= $this->getChild_Menu($child);
             }
        }

        return $results;
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param \Nwidart\Menus\MenuItem $item
     *
     * @return string`
     */
    public function getMultiLevelDropdownWrapper($item)
    {
        return '<li class="treeview' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#">
					' . $item->getIcon() . ' <span>' . $item->title . '</span>
			      	<span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
			      </a>
			      <ul class="treeview-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
        . PHP_EOL;
    }
}
