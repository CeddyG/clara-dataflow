<?php

namespace CeddyG\ClaraDataflow\Http\Controllers;

use App\Http\Controllers\Controller;

use Dataflow;

class DataflowController extends Controller
{
    public function index($sFormat, $sToken, $sParam = null)
    {
        return Dataflow::flow($sFormat, $sToken, $sParam);
    }
}
