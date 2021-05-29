<?php

namespace App\Library;

use App\Library\UrlLibrary;
use DOMDocument;

/**
 * Service.
 */
final class MetaLibrary
{
    
    private $urlLibrary;

    
    public function __construct(UrlLibrary $urlLibrary)
    {
        $this->urlLibrary = $urlLibrary;
    }

    public function extractMeta($url){
        $html = $this->urlLibrary->fileGetContentsCurl($url);
        //parsing begins here:
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        
        //
        $webPageMetaData = $doc->getElementsByTagName('meta');
        
        //
        $extractedMeta = $this->extractPropertyFromMeta($webPageMetaData);
        
        //
        return $extractedMeta;
    }

    public function extractPropertyFromMeta($webPageMetaData){
        $extractedMeta = array();

        for ($i = 0; $i < $webPageMetaData->length; $i++)
        {
            $meta = $webPageMetaData->item($i);

            // description
            if($meta->getAttribute('name') === 'description' || $meta->getAttribute('property') === 'og:description'){
                $description = "{$meta->getAttribute('content')}";
                $trimmerSpecialChar = preg_replace("/[^A-Za-z0-9 .]/", "", $description); 
                $extractedMeta['description'] = $trimmerSpecialChar;
            }
            
            // image
            if($meta->getAttribute('property') === 'og:image'){
                $extractedMeta['image'] = "{$meta->getAttribute('content')}";
            }
            

            //key words
            if($meta->getAttribute('name') === 'keywords'){
                $extractedMeta['keywords'] = "{$meta->getAttribute('content')}";
            }
            
            // twitter
            if($meta->getAttribute('name') === 'twitter:site'){
                $extractedMeta['twitterHandle'] = "{$meta->getAttribute('content')}";
            }
            
        }
        

        return $extractedMeta;
    }
}