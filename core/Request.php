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

    public function method()
    {   
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        return $this->method() === 'get';
    }

    public function isPost()
    {
        return $this->method() === 'post';
    }

    public function getBody()
    {
        $body = [];

        if($this->method() === 'get'){
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if($this->method() === 'post'){
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
    
}