<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'CaisseController::choixCaisse');
$routes->post('/valider-caisse', 'CaisseController::validerCaisse');
$routes->get('/saisie-achat', 'CaisseController::saisieAchat');