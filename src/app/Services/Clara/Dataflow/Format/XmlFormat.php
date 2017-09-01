<?php

namespace App\Services\Clara\Dataflow\Format;

use XMLWriter;

/**
 * Description of XmlFormat
 *
 * @author Ceddyg
 */
class XmlFormat extends DefaultFormat
{
    protected $sFormat = 'xml';
    
    public function createFile()
    {
        $this->oFile = new XMLWriter();
        $this->oFile->openMemory();
        $this->oFile->startDocument('1.0', 'UTF-8');
        $this->oFile->startElement('Items');
    }
    
    public function getCache()
    {
        $sFile = $this->getFile();
        
        if (file_exists($sFile))
        {
            return response()->file($sFile);
        }
        else
        {
            return $this->createFlow();
        }
    }

    public function buildFlow($oItems)
    {
        foreach ($oItems as $oItem)
        {
            $this->oFile->startElement('Item');
            $this->buildLine($oItem);
            $this->oFile->endElement();
        }
        
        file_put_contents(
            $this->getTempFile(), 
            $this->oFile->flush(true), 
            FILE_APPEND
        );
    }

    /**
     * 
     *  
     * @param object $oItem
     * @param string $sFormat
     * 
     * @return array $aLine
     */
    public function buildLine($oItem)
    {
        foreach ($this->oDataflow->oFlow->columns as $sHead => $sAttribute)
        {
            $this->oFile->writeElement($sHead, $this->getLastAttribute($oItem, $sAttribute));
        }
    }
    
    public function buildResponse()
    {
        $this->endTempFile();
        
        $sXml = $this->getContent();
        
        file_put_contents(
            $this->getFile(), 
            $sXml
        );

        return response($sXml, '200')->header('Content-Type', 'text/xml');
    }
    
    private function endTempFile()
    {
        $this->oFile->endElement();
        file_put_contents(
            $this->getTempFile(), 
            $this->oFile->flush(true), 
            FILE_APPEND
        );
    }
    
    private function getContent()
    {
        $sXml = file_get_contents($this->getTempFile());
        unlink($this->getTempFile());
        
        return $sXml;
    }
}
