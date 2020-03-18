<?php
require '../../vendor/autoload.php';
$mongo = new MongoDB\Client(
	"mongodb://localhost:27017/wai",
	[
		'username' => 'wai_web',
		'password' => 'w@i_w3b',
	]
);
$db = $mongo->wai;

function AddImage($src, $title, $author, $user){
    global $db;
    $pictureDB = [
        'src' => $src,
        'title' => $title,
        'author' => $author,
        'user' => $user
    ];
    $db->images->insertOne($pictureDB);
}

function GetImageCount($user){
    global $db;

    $query = [
        '$or' => [
            ['user' => ''],
            ['user' => $user]
        ]
    ];

    return $db->images->count($query);
}

function GetPage($size, $page, $user){
    global $db;

    $query = [
        '$or' => [
            ['user' => ''],
            ['user' => $user]
        ]
    ];

    $opts = [
        'skip' => $page*$size,
        'limit' => $size
    ];
    
    $images = $db->images->find($query, $opts);
    return $images;
}

function GetImagesByName($user, $name){
    global $db;

    $query = [
        '$or' => [
            ['user' => ''],
            ['user' => $user]],
        'title' => ['$regex' => $name, '$options' => 'i']
    ];
    
    $images = $db->images->find($query);
    return $images;
}

function GetImageBySrc($src){
    global $db;
    $query = ['src' => $src];
    return $db->images->findOne($query);
}

function GetUserByLogin($login){
    global $db;
    $query['login'] = $login;
    $user = $db->users->findOne($query);
    return $user;
}

function AddUser($mail, $login, $passHashed){
    global $db;
    $userDB = [
        'mail' => $mail,
        'login' => $login,
        'pass' => $passHashed,
    ];
    $db->users->insertOne($userDB);
}