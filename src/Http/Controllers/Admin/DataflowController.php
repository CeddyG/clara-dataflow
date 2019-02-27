<?php

namespace CeddyG\ClaraDataflow\Http\Controllers\Admin;

use CeddyG\Clara\Http\Controllers\ContentManagerController;

use Dataflow;
use CeddyG\ClaraDataflow\Repositories\DataflowRepository;

class DataflowController extends ContentManagerController
{
    public function __construct(DataflowRepository $oRepository)
    {
        $this->sPath = 'clara-dataflow::admin.dataflow';
        $this->sName = 'Dataflow';
        
        $this->oRepository = $oRepository;
        $this->sRequest = 'CeddyG\ClaraDataflow\Http\Requests\DataflowRequest';
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
    public function edit($id)
    {
        $oItem = $this->oRepository
            ->getFillFromView($this->sPath.'/form')
            ->find($id);
        
        $sPageTitle = $this->sName;
        
        $aRepositories = Dataflow::getRepositories();
        
        return view($this->sPath.'/form',  compact('oItem','sPageTitle', 'aRepositories'));
    }
}
