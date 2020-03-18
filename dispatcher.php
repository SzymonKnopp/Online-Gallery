<?php

    const REDIRECT_PREFIX = 'redirect:';

    function dispatch($routing, $action){

        if(isset($routing[$action]))
            $controller = $routing[$action];
        else $controller = 'pageNotFound';

        $model = []; //MODEL

        $view = $controller($model); //CONTROLLER

        build_response($view, $model); //VIEW
    }

    function build_response($view, $model){
        if (strpos($view,REDIRECT_PREFIX) === 0) {
            $url = substr($view, strlen(REDIRECT_PREFIX));
            header("Location: " . $url);
            exit;
        } else {
            render($view, $model);
        }
    }

    function render($view_name, $model){
        extract($model);
        include 'views/' . $view_name . '.php';
    }