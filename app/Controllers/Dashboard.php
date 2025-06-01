<?php

namespace App\Controllers;

// Importer les modèles nécessaires
use App\Models\ParrainModel;
use App\Models\FilleulModel;
use App\Models\BinomeModel;


class Dashboard extends BaseController 
{
   
    //   Affiche la page principale des binômes.
    //   Cette page montre les binômes déjà générés et permet d'en générer ou réinitialiser.
    //   Appelée via la route GET /binomes
     
    public function index()
    {
        $parrainModel = new ParrainModel();
        $filleulModel = new FilleulModel();
        $binomeModel  = new BinomeModel();

      
        // Récupération des binômes existants avec les informations jointes
        $data['binomes']  = $binomeModel
            ->select('binomes.id as binome_id, binomes.parrain_id, binomes.filleul_id, parrains.nom AS parrain_nom, parrains.prenom AS parrain_prenom, parrains.photo AS parrain_photo, filleuls.nom AS filleul_nom, filleuls.prenom AS filleul_prenom, filleuls.photo AS filleul_photo') 
            ->join('parrains', 'parrains.id = binomes.parrain_id', 'left') 
            ->join('filleuls', 'filleuls.id = binomes.filleul_id', 'left') 
            ->findAll();

        return view('binome', $data);
    }

    /*
     * Génère de nouveaux binômes.
     * Logique : Associe aléatoirement des parrains à des filleuls
     * n'ayant pas encore atteint leur limite (2 parrains).
     * Appelée via la route POST /binomes/generate
     */
    public function genererBinomes()
    {
        $parrainModel = new ParrainModel();
        $filleulModel = new FilleulModel();
        $binomeModel = new BinomeModel();

        // --- 1. Récupérer les Parrains qui n'ont PAS ENCORE de binôme ---
        // On ne sélectionne que les parrains qui n'apparaissent pas dans la table 'binomes'
        $parrainsDisponibles = $parrainModel
            ->select('parrains.id, parrains.nom, parrains.prenom') // Select specific fields needed
            ->join('binomes', 'binomes.parrain_id = parrains.id', 'left')
            ->where('binomes.id IS NULL') // Condition clé: le parrain n'est pas dans binomes
            ->findAll();

        // --- 2. Récupérer les Filleuls qui ont MOINS DE 2 parrains ---
        // On sélectionne les filleuls qui apparaissent moins de 2 fois dans la table 'binomes'
        $subQueryCount = '(SELECT COUNT(*) FROM binomes WHERE binomes.filleul_id = filleuls.id)';
        $filleulsDisponibles = $filleulModel
            ->select('filleuls.id, filleuls.nom, filleuls.prenom') // Select specific fields needed
            ->groupBy('filleuls.id') // Important pour que HAVING fonctionne correctement
            ->having($subQueryCount . ' <', 2) // Condition clé: moins de 2 parrains associés
            ->findAll();

        // --- Vérifications initiales ---
        if (empty($parrainsDisponibles)) {
             return redirect()->to('binomes')->with('warning', 'Aucun parrain n\'est actuellement disponible pour former un nouveau binôme.');
        }
        if (empty($filleulsDisponibles)) {
            return redirect()->to('binomes')->with('warning', 'Aucun filleul disponible (soit tous déjà pris, soit tous ont atteint leur limite de 2 parrains).');
        }

        // --- 3. Mélanger pour l'aléatoire ---
        shuffle($parrainsDisponibles);
        shuffle($filleulsDisponibles); // Cette liste sera modifiée ("sans remise")

        $associationsCrees = 0;
        $parrainsDejaAssociesCeTour = []; // Pour suivre qui a été assigné dans cette exécution

        log_message('info', 'Génération de binômes démarrée. Parrains dispo: ' . count($parrainsDisponibles) . ', Filleuls dispo: ' . count($filleulsDisponibles));

        // --- 4. Processus d'Assignation (Tirage sans remise pour filleuls) ---
        foreach ($parrainsDisponibles as $parrain) {

            // Si la liste des filleuls est vide, on arrête
            if (empty($filleulsDisponibles)) {
                log_message('info', 'Plus de filleuls disponibles dans la liste. Arrêt de la boucle des parrains.');
                break;
            }

            // On cherche un filleul pour ce parrain
            foreach ($filleulsDisponibles as $key => $filleul) {

                // On peut ajouter une vérification (optionnelle, normalement déjà filtré)
                // que ce binôme spécifique n'existe pas DÉJÀ dans la BDD
                $existeDeja = $binomeModel->where('parrain_id', $parrain['id'])
                                          ->where('filleul_id', $filleul['id'])
                                          ->first();

                if (!$existeDeja) {
                    // Créer l'association
                    $nouvelleAssociation = [
                        'parrain_id' => $parrain['id'],
                        'filleul_id' => $filleul['id']
                    ];

                    if ($binomeModel->save($nouvelleAssociation)) {
                        $associationsCrees++;
                        $parrainsDejaAssociesCeTour[] = $parrain['id']; // Note que ce parrain est pris
                        log_message('debug', 'Association créée : Parrain #' . $parrain['id'] . ' -> Filleul #' . $filleul['id']);

                        // === LA PARTIE CLÉ : TIRAGE SANS REMISE ===
                        // On retire ce filleul de la liste des disponibles pour ce tour
                        unset($filleulsDisponibles[$key]);

                        // On passe au parrain suivant (1 parrain -> 1 filleul par tour)
                        break; // Sort de la boucle des filleuls pour ce parrain

                    } else {
                        // Erreur lors de la sauvegarde (rare, mais possible)
                        log_message('error', 'Impossible d\'enregistrer le binôme Parrain #' . $parrain['id'] . ' - Filleul #' . $filleul['id'] . '. Erreurs: ' . json_encode($binomeModel->errors()));
                        // Que faire ici ? Pour l'instant, on continue d'essayer avec d'autres filleuls pour ce parrain.
                    }
                } else {
                    // Ce cas ne devrait pas arriver si les filtres initiaux sont corrects
                     log_message('warning', 'Tentative d\'associer un binôme déjà existant (ignoré) : Parrain #' . $parrain['id'] . ' - Filleul #' . $filleul['id']);
                }

            } // Fin de la boucle des filleuls pour un parrain donné

        } // Fin de la boucle des parrains

        // --- 5. Redirection avec Message ---
        if ($associationsCrees > 0) {
            $message = $associationsCrees . " nouvelle(s) association(s) créée(s) !";
            return redirect()->to('binomes')->with('success', $message);
        } else {
             $message = "Aucune nouvelle association n'a pu être créée (peut-être pas assez de parrains ou filleuls disponibles).";
            // Utiliser 'info' ou 'warning' selon la préférence
             return redirect()->to('binomes')->with('info', $message);
        }
    }

    /**
     * Réinitialise (supprime) tous les binômes existants.
     * Appelée via la route POST /binomes/reset
     */
     public function resetBinomes()
     {
         $binomeModel = new BinomeModel(); // Pas besoin de \App\Models si le namespace est bien importé en haut
         $binomeModel->truncate(); // Supprime tous les enregistrements de la table binomes
         // Redirection vers la page des binômes avec message de succès
         return redirect()->to('binomes')->with('success', 'Tous les binômes ont été réinitialisés.');
     }

    /**
     * Supprime un binôme spécifique par son ID.
     *
     * @param int $id L'ID du binôme à supprimer (vient de l'URL)
     */
     public function deleteBinome($id = null)
     {
         if ($id === null) {
             return redirect()->to('binomes')->with('error', 'ID du binôme manquant.');
         }

         $binomeModel = new BinomeModel();
         $binome = $binomeModel->find($id); // Vérifier si le binôme existe

         if ($binome) {
             $binomeModel->delete($id);
             // Redirection vers la page des binômes avec message de succès
             return redirect()->to('binomes')->with('success', 'Binôme supprimé avec succès.');
         } else {
              // Redirection vers la page des binômes avec message d'erreur
             return redirect()->to('binomes')->with('error', 'Binôme non trouvé.');
         }
     }

    /**
     * Affiche la liste combinée des parrains et des filleuls.
     * Appelée via la route GET /liste
     */
    // public function listeEtudiants()
    // {
    //     $parrainModel = new ParrainModel();
    //     $filleulModel = new FilleulModel();

    //     // Récupérer tous les parrains et filleuls
    //     $data['parrains'] = $parrainModel->orderBy('nom', 'ASC')->findAll(); // Trier par nom
    //     $data['filleuls'] = $filleulModel->orderBy('nom', 'ASC')->findAll(); // Trier par nom

    //     // Passer les données à la vue 'liste_etud.php'
    //     return view('liste_etud', $data);
    // }
    public function listeEtudiants()
    {
        $parrainModel = new ParrainModel();
        $filleulModel = new FilleulModel();

        // Récupérer tous les parrains et filleuls
        $data['parrains'] = $parrainModel->orderBy('nom', 'ASC')->findAll(); // Trier par nom
        $data['filleuls'] = $filleulModel->orderBy('nom', 'ASC')->findAll(); // Trier par nom

        // Passer les données à la vue 'liste_etud.php'
        return view('liste_etud', $data);
    }


    /**
     * Supprime TOUS les parrains, filleuls, binômes et leurs photos.
     * ATTENTION : ACTION DESTRUCTIVE.
     * Appelée via POST /etudiants/reset_all
     */
    public function resetAllEtudiants()
    {
        $parrainModel = new ParrainModel();
        $filleulModel = new FilleulModel();
        $binomeModel  = new BinomeModel();
        $uploadsPath = FCPATH . 'uploads/'; // Chemin vers votre dossier public/uploads

        $errors = []; // Pour stocker les erreurs éventuelles (ex: photo non trouvée)

        log_message('warning', 'Starting FULL RESET: Deleting all students and photos.');

        // --- 1. Supprimer les Photos ---
        $parrains = $parrainModel->select('id, photo')->findAll(); // Sélectionne id et photo
        $filleuls = $filleulModel->select('id, photo')->findAll(); // Sélectionne id et photo

        $photosToDelete = array_merge(array_column($parrains, 'photo'), array_column($filleuls, 'photo'));

        foreach ($photosToDelete as $photo) {
            if (!empty($photo)) {
                $filePath = $uploadsPath . $photo;
                if (is_file($filePath)) {
                    try {
                        if (!unlink($filePath)) {
                            $errors[] = "Impossible de supprimer la photo : " . $filePath;
                            log_message('error', "Failed to delete photo (unlink false): " . $filePath);
                        } else {
                            log_message('info', "Deleted photo: " . $filePath);
                        }
                    } catch (\Throwable $e) {
                        $errors[] = "Erreur lors de la suppression de la photo " . $filePath . ": " . $e->getMessage();
                        log_message('error', "Error deleting photo " . $filePath . ": " . $e->getMessage());
                    }
                } else {
                     log_message('warning', "Photo file not found, skipping delete: " . $filePath);
                    // Optionnel: ajouter aux erreurs si vous voulez être notifié
                    // $errors[] = "Fichier photo non trouvé : " . $filePath;
                }
            }
        }

        // --- 2. Vider les Tables ---
        // Il est généralement plus sûr de vider les tables qui dépendent des autres en premier (binomes)
        // ou d'utiliser deleteAll qui gère mieux certaines contraintes que truncate.
        try {
            log_message('info', 'Truncating/Deleting table: binomes');
            $binomeModel->truncate(); // ou $binomeModel->deleteAll();

            log_message('info', 'Truncating/Deleting table: filleuls');
            $filleulModel->truncate(); // ou $filleulModel->deleteAll();

            log_message('info', 'Truncating/Deleting table: parrains');
            $parrainModel->truncate(); // ou $parrainModel->deleteAll();

            log_message('warning', 'All student tables have been truncated/deleted.');

        } catch (\Throwable $e) {
            $dbError = 'Erreur Base de Données lors de la réinitialisation totale : ' . $e->getMessage();
            log_message('critical', $dbError); // Erreur critique
            // Rediriger avec l'erreur même si les photos ont eu des soucis
            return redirect()->to('liste')->with('error', $dbError);
        }

        // --- 3. Redirection ---
        if (empty($errors)) {
            return redirect()->to('liste')->with('success', 'Réinitialisation complète réussie : Tous les étudiants, binômes et photos ont été supprimés.');
        } else {
            // S'il y a eu des erreurs (photos non supprimées), on le signale
            $errorMessage = 'Réinitialisation terminée, mais avec des erreurs lors de la suppression des photos : ' . implode('; ', $errors);
             return redirect()->to('liste')->with('warning', $errorMessage);
        }
    }

}