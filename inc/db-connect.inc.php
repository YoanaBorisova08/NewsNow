<?php

try{
    $pdo = new PDO('mysql:host=localhost;dbname=news_site_db;', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch(PDOException $e){
    echo 'A problem occured with the databse connection...';
    die();
}