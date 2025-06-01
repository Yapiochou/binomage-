<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Pages Principales ---
$routes->get('/', 'Home::index'); // Page d'accueil
$routes->get('/page', 'Home::index'); // Gardé pour compatibilité si déjà utilisé

// --- Parrains ---
$routes->get('parrains/creer', 'Parrain::creer_parrain');   // Afficher formulaire création parrain
$routes->post('parrains', 'Parrain::ajout_p');           // Enregistrer nouveau parrain (RESTful)

// --- Filleuls ---
$routes->get('filleuls/creer', 'Filleul::creer_filleul'); // Afficher formulaire création filleul
$routes->post('filleuls', 'Filleul::ajout_f');          // Enregistrer nouveau filleul (RESTful)
// --- Réinitialisation Complète ---
$routes->post('etudiants/reset_all', 'Dashboard::resetAllEtudiants'); // Route pour supprimer TOUS les étudiants et binômes
// --- Liste Étudiants (Parrains + Filleuls) ---
$routes->get('liste', 'Dashboard::listeEtudiants'); // Nouvelle route pour afficher la liste

// --- Binômes ---
$routes->get('binomes', 'Dashboard::index');             // Afficher la page des binômes (avec résultats et bouton génération)
$routes->post('binomes/generate', 'Dashboard::genererBinomes'); // Générer les binômes (action POST)
$routes->post('binomes/reset', 'Dashboard::resetBinomes');     // Réinitialiser tous les binômes (action POST)
$routes->delete('binomes/(:num)', 'Dashboard::deleteBinome/$1'); // Supprimer un binôme spécifique (action DELETE) - Optionnel si besoin

// --- Test ---
$routes->get('test', 'Test::index');

// Note: La route '/dashboard/(:num)' a été modifiée ou supprimée car elle semblait incorrecte pour la suppression de binômes.
// La route '/binome' (GET) a été supprimée car la génération doit se faire via POST.
// Les routes '/adparrain' et '/adfilleul' sont remplacées par POST '/parrains' et '/filleuls'. Mettez à jour les actions de vos formulaires.

// PAS d'accolade fermante supplémentaire ici

