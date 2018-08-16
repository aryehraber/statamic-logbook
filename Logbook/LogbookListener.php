<?php

namespace Statamic\Addons\Logbook;

use Statamic\API\User;
use Statamic\API\Nav;
use Statamic\API\Config;
use Statamic\Extend\Listener;

class LogbookListener extends Listener
{
    public $events = [
        'cp.add_to_head' => 'addToHead',
        'cp.nav.created' => 'addNavItem'
    ];
    
    private function isSuper() { 
        $user = User::getCurrent();
        
        return $user && $user->isSuper();
    }

    public function addToHead()
    {
        if ($this->isSuper()) {
          $html = $this->js->tag('logbook');
          $html .= $this->css->tag('logbook');
          
          return $html;
        }
        return null;
    }

    public function addNavItem($nav)
    {
        if (! $this->getConfig('hide_nav', false) && $this->isSuper()) {
            $item = Nav::item('Logbook')->route('logs')->icon('book');

            $nav->addTo('tools', $item);
        }
    }
}
