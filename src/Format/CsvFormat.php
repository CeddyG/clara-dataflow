<?php

namespace CeddyG\ClaraDataflow\Format;

/**
 * Description of CsvFormat
 *
 * @author Ceddyg
 */
class CsvFormat extends DefaultFormat
{
    protected $sFormat = 'csv';
    
    public function createFile()
    {
        $hFile = fopen($this->getTempFile(), 'w');
        fputcsv(
            $hFile, 
            array_keys($this->oDataflow->oFlow->columns), 
            "\t"
        );
        fclose($hFile);
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

    public function buildResponse()
    {
        $sCsv = file_get_contents($this->getTempFile());
        unlink($this->getTempFile());
        
        file_put_contents($this->getFile(), $sCsv);
        
        return $sCsv;
    }
    
    public function buildFlow($oItems)
    {
        $aLines = parent::buildFlow($oItems);
                    
        $hFile = fopen($this->getTempFile(), 'a');
        foreach ($aLines as $aLine)
        {
            fputcsv(
                $hFile, 
                $aLine,
                "\t"
            );
        }
        fclose($hFile);
    }
}
