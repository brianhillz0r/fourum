<?php

namespace Fourum\Filter;

use Illuminate\Support\Facades\Event;

class AfterFilter
{
    /**
     * @param $route
     * @param $request
     * @param $response
     */
    public function filter($route, $request, $response)
    {
        $path = str_replace("/", ".", $request->path());
        $eventName = $path . ".after";

        Event::fire('filter.after', array($route, $request, $response));
        Event::fire($eventName, array($route, $request, $response));
    }
}
