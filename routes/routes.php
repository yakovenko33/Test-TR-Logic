<?php
// Create docs
// "GET/path" => "App\UserModule\UI\Controllers\NameController@nameAction@$1@$2"
// {GET} - Метод запроса,
// {/path} - URL запроса,
// {App\UserModule\UI\Controllers\NameController} - название класса контроллера с полным NAMESPACE
// {nameAction} - название action
// {@$1@$2} - дополнительные параметры

return [
    "GET/user/([a-z]+)/([0-9]+)" => 'App\UserModule\UI\Controllers\UserController@test@$1@$2',
    "GET/user" => 'App\UserModule\UI\Controllers\UserController@index'
];