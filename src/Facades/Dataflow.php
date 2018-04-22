<?php

namespace CeddyG\ClaraDataflow\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CeddyG\ClaraDataflow\Dataflow
 */
class Dataflow extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'clara.dataflow';
    }
}
