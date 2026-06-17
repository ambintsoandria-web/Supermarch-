<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Page d'accueil - Choix de la caisse
$routes->get('/', 'CaisseController::choixCaisse');
$routes->post('/valider-caisse', 'CaisseController::validerCaisse');

// Saisie des achats - GARDER CE QUI MARCHAIT
$routes->get('/saisie-achat', 'CaisseController::saisieAchat');
$routes->post('/ajouter-produit', 'CaisseController::ajouterProduit');
$routes->post('/supprimer-ligne', 'CaisseController::supprimerLigne');
$routes->post('/valider-achat', 'CaisseController::validerAchat');
$routes->post('/vider-panier', 'CaisseController::viderPanier');

// ============================================
// HISTORIQUE - RAJOUTER CES LIGNES
// ============================================
$routes->get('/historique', 'CaisseController::historique');
$routes->get('/historique/detail/(:num)', 'CaisseController::detail/$1');