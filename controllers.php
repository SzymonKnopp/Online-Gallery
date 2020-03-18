<?php

    const PAGE_SIZE = 6;

    const UPL_ERR_NO_ERROR = 0;
    const UPL_ERR_TOO_LARGE_BAD_EXT = 1;
    const UPL_ERR_TOO_LARGE = 2;
    const UPL_ERR_BAD_EXT = 3;

    const REG_ERR_PASS_NON_MATCH = 1;
    const REG_ERR_USER_EXISTS = 2;

    const LOG_ERR_USER_NOT_FOUND = 1;
    const LOG_ERR_INCORRECT_PASS = 2;

    require_once 'business.php';

    function pageNotFound(&$model){ //404
        return 'pageNotFound_view';
    }

    function gallery(&$model){ //INDEX

        if(!isset($_SESSION['savedImages'])) $_SESSION['savedImages'] = [];

        if($_SERVER['REQUEST_METHOD']==='POST'){

            if(isset($_POST['checked']))
                $_SESSION['savedImages'] = $_POST['checked'];
            return 'redirect:/';
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
            
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $imagesCount = GetImageCount($user);
        $lastPage = ceil($imagesCount / PAGE_SIZE);

        $images = GetPage(PAGE_SIZE, $page-1, $user);

        $model['lastPage'] = $lastPage;
        $model['images'] = $images;
        $model['page'] = $page;
        return 'gallery_view';
    }

    function savedGallery(&$model){

        if($_SERVER['REQUEST_METHOD']==='POST'){

            if(isset($_POST['checked']))
                foreach(array_keys($_POST['checked']) as $key){
                    unset($_SESSION['savedImages'][$key]);
                }
            return 'redirect:savedGallery';
        }

        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];

        $imagesCount = count($_SESSION['savedImages']);
        $lastPage = ceil($imagesCount / PAGE_SIZE);

        foreach(array_keys($_SESSION['savedImages']) as $key){
            $images[] = GetImageBySrc($key);
        }

        if(!isset($images)) $images = [];

        $model['lastPage'] = $lastPage;
        $model['images'] = $images;
        $model['page'] = $page;

        return 'savedGallery_view';
    }

    function searchGallery(&$model){
        return 'searchGallery_view';
    }

    function upload(&$model){

        if($_SERVER['REQUEST_METHOD']==='POST'){

            $picture = $_FILES['file'];
            $finfo=finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $picture['tmp_name']);

            if($picture['size']>1024*1024 && $mimeType!=='image/jpeg' && $mimeType!=='image/png')
            
                $error = UPL_ERR_TOO_LARGE_BAD_EXT;

            else if($picture['size']>1024*1024)
            
                $error = UPL_ERR_TOO_LARGE;

            else if($mimeType!=='image/jpeg' && $mimeType!=='image/png')
            
                $error = UPL_ERR_BAD_EXT;

            else{
                //poprawny formularz
                move_uploaded_file($picture['tmp_name'], 'static/images/original/'.$picture['name']);

                $fileName = $picture['name'];

                include 'image_process.php';

                AddImage($picture['name'], $_POST['title'], $_POST['author'], $_POST['user']);

                $error = UPL_ERR_NO_ERROR;

            } 
            return 'redirect:upload?error='.$error; //odswiezenie z parametrem (wynik operacji)
        }

        if(!isset($_GET['error']))
        $model['message'] = '';
        else{
            switch ($_GET['error']) {
                case UPL_ERR_NO_ERROR:
                    $model['message'] = 'Zdjęcie dodano pomyślnie';
                    break;
                case UPL_ERR_BAD_EXT:
                    $model['message'] = "Zły format pliku";
                    break;
                case UPL_ERR_TOO_LARGE:
                    $model['message'] = "Za duży rozmiar pliku";
                    break;
                case UPL_ERR_TOO_LARGE_BAD_EXT:
                    $model['message'] = "Za duży rozmiar i zły format pliku";
                    break;
            }
        }

        if(isset($_SESSION['user'])) $model['user'] = $_SESSION['user'];
        else $model['user'] = NULL;

        return 'upload_view'; //pierwsze wejscie na strone rejestracji lub wyświetlenie wyniku
    }

    function register(&$model){

        if($_SERVER['REQUEST_METHOD']==='POST'){

            if($_POST['pass']!==$_POST['rePass']){
                
                $error = REG_ERR_PASS_NON_MATCH;
            }
            else{
                $user = GetUserByLogin($_POST['login']);
                if($user !== NULL) 

                $error = REG_ERR_USER_EXISTS;

                else{
                    AddUser($_POST['mail'], $_POST['login'], password_hash($_POST['pass'], PASSWORD_DEFAULT));
                    $_SESSION['user'] = $_POST['login'];

                    return 'redirect:/'; //przekierowanie po poprawnym zalogowaniu
                }
            }
            return 'redirect:register?error='.$error; //odswiezenie z parametrem
        }

        if(!isset($_GET['error']))
            $model['message'] = '';
        else{
            switch ($_GET['error']) {
                case REG_ERR_PASS_NON_MATCH:
                    $model['message'] = "Hasła się nie zgadzają";
                    break;
                case REG_ERR_USER_EXISTS:
                    $model['message'] = "Użytkownik o takim loginie już istnieje";
                    break;
            }
        }
        return 'register_view'; //pierwsze wejscie na strone rejestracji lub wyświetlenie błędu
    }

    function login(&$model){

        if($_SERVER['REQUEST_METHOD']==='POST'){

            $user = GetUserByLogin($_POST['login']);
            if($user === NULL)

                $error = LOG_ERR_USER_NOT_FOUND;

            else if(!password_verify($_POST['pass'], $user['pass']))

                $error = LOG_ERR_INCORRECT_PASS;

            else{
                $_SESSION['user'] = $user['login'];

                return 'redirect:/'; //przekierowanie po poprawnym zalogowaniu
            }
            return 'redirect:login?error='.$error; //odswiezenie z parametrem
        }

        if(!isset($_GET['error']))
            $model['message'] = '';
        else{
            switch ($_GET['error']) {
                case LOG_ERR_USER_NOT_FOUND:
                    $model['message'] = "Nie istnieje użytkownik o takim loginie";
                    break;
                case LOG_ERR_INCORRECT_PASS:
                    $model['message'] = "Błędne hasło";
                    break;
            }
        }

        return 'login_view'; //pierwsze wejscie na strone logowania lub wyświetlenie błędu
    }

    function logout(&$model){

        session_destroy();
        $_SESSION = [];

        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
                  $params["path"], $params["domain"],
                  $params["secure"], $params["httponly"]);

        return 'redirect:/';
    }

    function getSearchResults(&$model){
        $query = $_GET['query'];
            
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
        $images = GetImagesByName($user, $query);

        $model['images'] = $images;

        return 'getSearchResults_view';
    }