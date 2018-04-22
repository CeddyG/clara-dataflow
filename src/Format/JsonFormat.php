<?php

namespace CeddyG\ClaraDataflow\Format;

/**
 * Description of JsonFormat
 *
 * @author Ceddyg
 */
class JsonFormat extends DefaultFormat
{    
    protected $sFormat = 'json';

    public function createFile()
    {
        
    }
    
    public function getCache()
    {
        $sFile = $this->getFile();
        
        if (file_exists($sFile))
        {
            $sJson = file_get_contents($sFile);
            return response()->json(json_decode($sJson));
        }
        else
        {
            return $this->createFlow();
        }
    }

    public function buildResponse()
    {
        file_put_contents(
            $this->getFile(), 
            json_encode($this->aLines)
        );
                
        return response()->json($this->aLines);
    }
}
