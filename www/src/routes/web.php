<?php

use Controllers\WebController;

//-----------------------------------------------------
// Routes de la vue web
//-----------------------------------------------------

// Routes
$app->get('/', [WebController::class, 'home']);


// Protection des routes avec middleware exemple :
/*

$app->group('/admin', function ($group) {
    $group->get('', AdminController::class . ':index');
})
    ->add(new RoleMiddleware('admin'))
    ->add(new AuthMiddleware());

je peux aussi faire ça pour ajouter plusieurs rôles (utilisation enums) :
->add(new RoleMiddleware([
    RoleEmploye::ADMIN->value,
    RoleEmploye::SUPER_ADMIN->value
]))



$app->group('/delivery', function ($group) {
    $group->get('', DeliveryController::class . ':index');
})
    ->add(new RoleMiddleware('livreur'))
    ->add(new AuthMiddleware());
