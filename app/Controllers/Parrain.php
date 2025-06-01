<?php
namespace App\Controllers;
use App\Models\ParrainModel;
use CodeIgniter\Controller;
use CodeIgniter\Files\Exceptions\FileException; // Importer l'exception pour la gestion d'erreur de fichier

class Parrain extends Controller
{
    // Méthode pour afficher le formulaire de création
    public function creer_parrain()
    {
        return view('parrains_creer');
    }

    // Méthode pour enregistrer le parrain dans la base de données
    public function ajout_p()
    {
        // Charger les helpers nécessaires
        helper(['form', 'url']);

        // Définition des règles de validation
        $validationRule = [
            'nom'   => 'required|min_length[3]',
            'prenom'=> 'required|min_length[3]', // Ajout de validation pour le prénom si nécessaire
            'photo' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[photo,2048]'
        ];

        // Validation des données du formulaire
        if (!$this->validate($validationRule)) {
            // Si la validation échoue, on retourne avec les erreurs de validation
            // La vue affichera les erreurs via $validation->listErrors()
             return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            // OU si vous préférez passer l'objet validator complet :
            // return view('parrains_creer', ['validation' => $this->validator]);
        }

        // Récupération des données envoyées via le formulaire
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $photo = $this->request->getFile('photo');

        // Vérification si la photo est valide et n'a pas été déplacée
        if ($photo->isValid() && !$photo->hasMoved()) {
            // Générer un nom unique pour la photo
            $newName = $photo->getRandomName();

            try {
                // Déplacer la photo dans le dossier 'uploads'
                $photo->move(WRITEPATH . '../public/uploads', $newName); // Utiliser WRITEPATH pour la sécurité, puis ajuster le chemin vers public/uploads

                // Créer une instance du modèle et enregistrer les données dans la base de données
                $parrainModel = new ParrainModel();
                $parrainModel->save([
                    'nom'    => $nom,
                    'prenom' => $prenom,
                    'photo'  => $newName  // Le nom de fichier unique de la photo
                ]);

                // Redirection avec un message de succès
                return redirect()->to('parrains/creer')->with('success', 'Parrain ajouté avec succès !');

            } catch (FileException $e) {
                // Gérer l'erreur si le déplacement échoue (ex: permissions)
                log_message('error', 'Erreur lors du déplacement du fichier Parrain : ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Erreur technique lors de l\'enregistrement de la photo.');
            }

        } else {
            // Si l'upload initial échoue (selon CodeIgniter isValid/hasMoved)
             return redirect()->back()->withInput()->with('error', 'Erreur lors de l’upload de la photo : ' . $photo->getErrorString().' ('.$photo->getError().')');
        }
    }
}