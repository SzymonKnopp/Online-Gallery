<?php

    session_start();

    require_once '../dispatcher.php';
    require_once '../controllers.php';
    require_once '../routing.php';

    $action = $_GET['action'];

    dispatch($routing, $action);