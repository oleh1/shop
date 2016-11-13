<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);

    }

    /**
     * метод возвращает строку запроса
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
            // trim — Удаляет пробелы (или другие символы) из начала и конца строки
        }
    }

    public function run()
    {
        // получить строку запроса
        $uri = $this->getURI();

        // $this->routes = array (size=2)
        //                  'site/([a-z]+)/([0-9]+)' => 'site/view/$1/$2'
        foreach ($this->routes as $uriPattern => $path) {

            // $uriPattern = 'site/([a-z]+)/([0-9]+)'

            // $path = 'site/view/$1/$2'


            if (preg_match("~$uriPattern~", $uri)) {
                // preg_match — Выполняет проверку на соответствие регулярному выражению

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                // preg_replace — Выполняет поиск и замену по регулярному выражению

                $segments = explode('/', $internalRoute);
                // explode -- Разбивает строку на подстроки

                $controllerName = array_shift($segments).'Controller';
                // array_shift — Извлекает первый элемент массива

                $controllerName = ucfirst($controllerName);
                // ucfirst — Преобразует первый символ строки в верхний регистр

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters = $segments;

                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if (file_exists($controllerFile)){
                    // file_exists -- Проверить наличие указанного файла или каталога
                include_once($controllerFile);
                }

                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                // call_user_func_array — Вызывает пользовательскую функцию с массивом параметров

                if (!$result == null){
                    break;
                }

            }
        }


    }

}