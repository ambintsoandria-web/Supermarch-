<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');
$routes->post('/auth/login', 'AuthController::doLogin');

$routes->get('/auth/logout', 'AuthController::logout');
$routes->post('/auth/logout', 'AuthController::logout');

$routes->get('/choix-caisse', 'CaisseController::choixCaisse');
$routes->post('/valider-caisse', 'CaisseController::validerCaisse');

$routes->get('/saisie-achat', 'CaisseController::saisieAchat');
$routes->post('/ajouter-produit', 'CaisseController::ajouterProduit');
$routes->post('/supprimer-ligne', 'CaisseController::supprimerLigne');
$routes->post('/valider-achat', 'CaisseController::validerAchat');
$routes->post('/vider-panier', 'CaisseController::viderPanier');

$routes->get('/historique', 'CaisseController::historique');
$routes->get('/historique/detail/(:num)', 'CaisseController::detail/$1');