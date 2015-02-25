<?php

namespace Fourum\Filter;

use Illuminate\Support\Facades\Event;

class BeforeFilter
{
    /**
     * @param $route
     * @param $request
     */
    public function filter($route, $request)
    {
        $path = str_replace("/", ".", $request->path());
        $eventName = $path . ".before";

        Event::fire('filter.before', array($route, $request));
        Event::fire($eventName, array($route, $request));
    }
}
