<?php
require_once __DIR__.'/../../bootstrap/app.php';
//require_once base_path('Controller/RoomsController.php');

// Auth
Auth::isAuthOrRedirect();

if (!empty($_POST['action'])) {
    $controller = new App\Controllers\admin\GameController();

    if ($_POST['action'] === 'update') {
        $controller->update();
    } elseif ($_POST['action'] === 'delete') {
        $controller->delete();
    } elseif ($_POST['action'] === 'store') {
        $controller->store();
    } elseif ($_POST['action'] === 'deleteGameMode') {
        $controller->deleteGameMode();
    }
}

// Remove errors, success and old data
App::terminate();

// Unknown action
redirectAndExit(App\Controllers\admin\GameController::URL_INDEX);
