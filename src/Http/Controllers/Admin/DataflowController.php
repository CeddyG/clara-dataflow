<?php

namespace CeddyG\ClaraDataflow\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use Dataflow;
use Illuminate\Http\Request;

class DataflowController extends ContentManagerController
{
    public function __construct()
    {
        $this->sPath = 'clara-dataflow::admin.dataflow';
        $this->sName = 'Dataflow';
        
        $this->oRepository  = app(config('clara.dataflow.repository'));
        $this->sRequest     = config('clara.dataflow.formrequest');
    } 
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sPageTitle = $this->sName;
        
        $aRepositories = Dataflow::getRepositories();
        
        return view($this->sPath.'/form', compact('sPageTitle', 'aRepositories'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $oRequest)
    {
        $oItem = $this->oRepository
            ->getFillFromView($this->sPath.'/form')
            ->find($id);
        
        $sPageTitle = $this->sName;
        
        $aRepositories = Dataflow::getRepositories();
        
        return view($this->sPath.'/form',  compact('oItem','sPageTitle', 'aRepositories'));
    }
}
