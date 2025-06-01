<?php
namespace App\Controllers;
use App\Models\FilleulModel;
use CodeIgniter\Controller;
use CodeIgniter\Files\Exceptions\FileException; // Importer l'exception

class Filleul extends Controller
{
    public function creer_filleul()
    {
        return view('filleuls_creer');
    }

    public function ajout_f()
    {
        helper(['form', 'url']);

        // Règles de validation du formulaire
        $validationRule = 
        [
        'nom'   => 'required|min_length[3]',
        'prenom'=> 'required|min_length[3]', // Ajout de validation pour le prénom si nécessaire
        'photo' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[photo,2048]'
        ];

        // Valider les données du formulaire
        if (!$this->validate($validationRule)) {
             // Si la validation échoue, on retourne avec les erreurs de validation
             return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
             // OU: return view('filleuls_creer', ['validation' => $this->validator]);
        }

        // Récupération des données envoyées par le formulaire
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $photo = $this->request->getFile('photo');

        // Vérification si la photo est valide et n'a pas été déplacée
        if ($photo->isValid() && !$photo->hasMoved()) {
            // Générer un nom unique pour la photo
            $newName = $photo->getRandomName();

            try {
                // Déplacer la photo dans le dossier 'uploads' (chemin ajusté)
                $photo->move(WRITEPATH . '../public/uploads', $newName);

                // Enregistrer les données dans la base de données
                $filleulModel = new FilleulModel();
                $filleulModel->save([
                    'nom'    => $nom,
                    'prenom' => $prenom,
                    'photo'  => $newName  // Le nom de fichier unique de la photo
                ]);

                // Redirection avec un message de succès
                return redirect()->to('filleuls/creer')->with('success', 'Filleul ajouté avec succès !');

            } catch (FileException $e) {
                 // Gérer l'erreur si le déplacement échoue
                 log_message('error', 'Erreur lors du déplacement du fichier Filleul : ' . $e->getMessage());
                 return redirect()->back()->withInput()->with('error', 'Erreur technique lors de l\'enregistrement de la photo.');
            }

        } else {
            // Si l'upload initial échoue
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l’upload de la photo : ' . $photo->getErrorString().' ('.$photo->getError().')');
        }
    }
}