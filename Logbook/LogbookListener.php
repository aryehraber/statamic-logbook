<?php

namespace Statamic\Addons\Logbook;

use Statamic\API\Nav;
use Statamic\Extend\Listener;

class LogbookListener extends Listener
{
    public $events = [
        'cp.add_to_head' => 'addToHead',
        'cp.nav.created' => 'addNavItem'
    ];

    public function addToHead()
    {
        if ($this->isSuper()) {
            $html = $this->js->tag('logbook');
            $html .= $this->css->tag('logbook');

            return $html;
        }
    }

    public function addNavItem($nav)
    {
        if ($this->isSuper() && ! $this->getConfig('hide_nav', false)) {
            $item = Nav::item('Logbook')->route('logs')->icon('book');

            $nav->addTo('tools', $item);
        }
    }

    private function isSuper() {
        return ($user = auth()->user()) && $user->isSuper();
    }
}
