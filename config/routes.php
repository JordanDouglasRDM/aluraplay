<?php

use Alura\Mvc\Controller\{DeleteImageFrameController,
    DeleteVideoController,
    EditVideoController,
    LoginController,
    LoginFormController,
    LogoutController,
    NewVideoController,
    VideoFormController,
    VideoListController};

return [
    'GET|/' => VideoListController::class,
    'GET|/novo-video' => VideoFormController::class,
    'POST|/novo-video' => NewVideoController::class,
    'GET|/editar-video' => VideoFormController::class,
    'POST|/editar-video' => EditVideoController::class,
    'GET|/remover-video' => DeleteVideoController::class,
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginController::class,
    'GET|/logout' => LogoutController::class,
    'GET|/remover-frame' => DeleteImageFrameController::class
];