<?php 

namespace app\core;

class Request
{

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if($position !== false){
            $path = substr($path, 0, $position);
        }
        
        // Handle subdirectory deployment (e.g. localhost/project/public)
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $scriptName = str_replace('\\', '/', $scriptName); // Normalize slashes
        
        // Remove trailing slash from scriptName if present (for root path)
        if ($scriptName !== '/' && strlen($scriptName) > 1 && strpos($path, $scriptName) === 0) {
           $path = substr($path, strlen($scriptName));
        }
        
        if ($path === '') {
            return '/';
        }
        return $path;
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    
}