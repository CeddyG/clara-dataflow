<?php

namespace CeddyG\ClaraDataflow\Format;

use Excel;

/**
 * Description of XlsxFormat
 *
 * @author Ceddyg
 */
class XlsxFormat extends DefaultFormat
{
    protected $sFormat = 'xlsx';
    
    public function createFile()
    {
        $this->oFile = Excel::create($this->oDataflow->oFlow->name, function($oExcel)
        {
            $oExcel->sheet('Table', function($oSheet) 
            {
                $oSheet->appendRow(array_keys($this->oDataflow->oFlow->columns));
            });
        });
    }
    
    public function getCache()
    {
        $sFile = $this->getFile();
        
        if (file_exists($sFile))
        {
            return response()->download($sFile);
        }
        else
        {
            $this->createFlow();
            
            return $this->oFile->export($this->sFormat);
        }
    }

    public function buildResponse()
    {
        $this->oFile->store($this->sFormat, $this->getPath());
        
        return 'File generated';
    }
    
    public function buildFlow($oItems)
    {
        $this->oFile->getSheet()->rows(parent::buildFlow($oItems));
    }
}
