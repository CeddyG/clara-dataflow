<?php

namespace CeddyG\ClaraDataflow;

use CeddyG\ClaraDataflow\Repositories\DataflowRepository;
use CeddyG\ClaraDataflow\Exceptions\FormatException;

class Dataflow
{    
    protected $aIds         = [];
    protected $oFormat      = null;
    
    public $oFlow           = null;
    public $oRepository     = null;

    public static function getRepositories()
    {
        $aRepositories = [];
        
        $aListRepositories = glob(app_path('Repositories'.DIRECTORY_SEPARATOR.'*'));
        foreach ($aListRepositories as $sRepository)
        {
            $sRepository = substr(strrchr($sRepository, DIRECTORY_SEPARATOR), 1);
            $sRepository = strstr($sRepository, '.php', true);
            
            $aRepositories['App\Repositories\\'.$sRepository] = $sRepository;
        }
        
        return $aRepositories;
    }
    
    public function setIds(array $aIds)
    {
        $this->aIds = $aIds;
    }
    
    private function setLimit()
    {
        ini_set('memory_limit','3g');
        set_time_limit(0);
    }
    
    public function flow($sFormat, $sToken, $sParam)
    {
        $this->setLimit();
        $this->setFlow($sToken);
        $this->setFormat($sFormat);
        
        switch ($sParam)
        {
            case 'cache':
                return $this->oFormat->getCache();
                break;
            
            case 'download':
                return $this->oFormat->download();
                break;
            
            default:
                return $this->oFormat->createFlow();
                break;
        }
    }
    
    private function setFormat($sFormat)
    {
        $sClass = __NAMESPACE__.'\\Format\\'.ucfirst($sFormat).'Format';
        
        if (class_exists($sClass))
        {
            $this->oFormat = new $sClass($this);
        }
        else
        {
            throw new FormatException(
                'Format '.$sFormat.' not supported (Class '.  ucfirst($sFormat).'Format missing)'
            );
        }
    }
    
    private function setFlow($sToken)
    {
        $oDataflowRepository    = new DataflowRepository();
        $this->oFlow            = $oDataflowRepository->findByField('token', $sToken)->first();
        
        $this->oRepository = new $this->oFlow->repository();
        $this->oRepository->setReturnCollection(false);
    }
    
    public function getIds()
    {
        if (!empty($this->aIds))
        {
            $oIds = collect($this->aIds);
        }
        else
        {
            $oIds = $this->oRepository
                ->findWhere($this->oFlow->where_clause, [$this->oRepository->getPrimaryKey()])
                ->pluck($this->oRepository->getPrimaryKey());
        }
        
        return $oIds->chunk(1000);
    }
}
