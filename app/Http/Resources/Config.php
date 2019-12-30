<?php



namespace App\Http\Resources;

class Config
{
    function __construct()
    {
      define('GCM_API_KEY','AIzaSyDdhNJaVJkIjBJKnaY15hTHYbK-Va-PvoE'); 
      define('GCM_SEND_URL','https://gcm-http.googleapis.com/gcm/send'); 	  
    }

}

