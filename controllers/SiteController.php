<?php 

namespace app\controllers;

use app\core\Controller;

class SiteController extends Controllerp
{
    public function home()
    {
        $params = [
            'name' => "Dudu"
        ];
        return $this->render('home', $params);
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function handleContact()
    {
        $body = Application::$app->request->getBody();
        
        echo '<pre>';
        var_dump($body);
        echo '</pre>';

        return 'Handling submitted data';
    }
}
