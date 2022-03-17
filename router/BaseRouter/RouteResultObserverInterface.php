<?php

namespace Router\BaseRouter;

/**
 * An object that is interested in the route results.
 */
interface RouteResultObserverInterface
{
    /**
     * Observe a route result.
     *
     * @param RouteResult $result
     */
    public function update(RouteResult $result);
}
