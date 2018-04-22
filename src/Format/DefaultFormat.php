<?php

namespace CeddyG\ClaraDataflow\Format;

use CeddyG\ClaraDataflow\Dataflow;

/**
 * Description of DefaultFormat
 *
 */
abstract class DefaultFormat
{
    protected $oFile            = null;
    protected $oDataflow        = null;
    protected $sFileName        = '';
    protected $sFileTmpName     = '';
    protected $sFormat          = '';
    protected $aLines           = [];

    abstract public function getCache();
    abstract public function createFile();
    abstract public function buildResponse();
    
    public function __construct(Dataflow $oDataflow)
    {
        $this->oDataflow = $oDataflow;
    }
    
    protected function getFile()
    {
        return $this->getPath().'/'.$this->oDataflow->oFlow->name.'.'.$this->sFormat;
    }
    
    protected function getTempFile()
    {
        return $this->getPath().'/'.$this->oDataflow->oFlow->name.'-temp.'.$this->sFormat;
    }
    
    public function createFlow()
    {
        $this->createFile();
        $oIds = $this->oDataflow->getIds();
        
        foreach ($oIds as $oId)
        {
            $oItems = $this->oDataflow->oRepository->findWhereIn(
                $this->oDataflow->oRepository->getPrimaryKey(), 
                $oId->toArray(),
                array_values($this->oDataflow->oFlow->columns)
            );
            
            $this->buildFlow($oItems);
        }
        
        return $this->buildResponse();
    }
    
    public function buildFlow($oItems)
    {
        $aLines = [];
        
        foreach ($oItems as $oItem)
        {
            $aLines[] = $this->buildLine($oItem);
        }
        
        $this->aLines = array_merge($this->aLines, $aLines);
        
        return $aLines;
    }
    
    /**
     * Build a line of the CSV.
     *  
     * @param object $oItem
     * @param string $sFormat
     * 
     * @return array $aLine
     */
    public function buildLine($oItem)
    {
        $aLine = [];
        
        foreach ($this->oDataflow->oFlow->columns as $sHead => $sAttribute)
        {
            $aLine[$sHead] = $this->cleanStr($this->getLastAttribute($oItem, $sAttribute));
        }
        
        return $aLine;
    }
    
    public function download()
    {
        $sFile = $this->getFile();
        
        if (!file_exists($sFile))
        {
            $this->createFlow();
        }
        
        return response()->download($sFile);
    }
    
    protected function cleanStr($sValue)
    {
        $sValue = preg_replace("/\\x0|[\x01-\x1f]/U", "", $sValue);
        $sValue = preg_replace('/<[^>]*>/', ' ', $sValue);
        $sValue = str_replace("\r", '', $sValue);
        $sValue = str_replace("\n", ' ', $sValue);
        
        return str_replace("\t", ' ', $sValue);
    }


    protected function getLastAttribute($oItem, $sAttribute)
    {
        if (strpos($sAttribute, '.') !== false)
        {
            $aAttribute     = explode('.', $sAttribute);
            $sAttributeName = $aAttribute[0];
            $mAttribute     = $oItem->$sAttributeName;
            $this->takeFirstIfArray($mAttribute);

            $iTotalSubAttribute = count($aAttribute);

            for ($i = 1 ; $i < $iTotalSubAttribute ; $i++)
            {
                $sAttributeName = $aAttribute[$i];
                
                if (!is_object($mAttribute))
                {
                    continue;
                }
                
                $mAttribute     = $mAttribute->$sAttributeName;
                $this->takeFirstIfArray($mAttribute);
            }
            
            return $mAttribute;
        }
        else
        {
            return $oItem->$sAttribute;
        }
    }
    
    protected function takeFirstIfArray(&$mValue)
    {
        if (is_array($mValue) && !empty($mValue))
        {
            $mValue = array_values($mValue)[0];
        }
        
        if (is_array($mValue) && empty($mValue))
        {
            $mValue = '';
        }
    }
    
    protected function getPath()
    {
        if (!is_dir(config('clara.dataflow.path')))
        {
            \File::makeDirectory(config('clara.dataflow.path'));
        }
        
        return config('clara.dataflow.path');
    }
}
