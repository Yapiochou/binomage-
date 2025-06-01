<?php

namespace App\Models;
use CodeIgniter\Model;

class ParrainModel extends Model
{
   // Le nom de la table dans la base de données
    protected $table      = 'parrains';
    
    // La clé primaire
    protected $primaryKey = 'id';

    // Les champs autorisés pour être insérés ou mis à jour
    protected $allowedFields = ['nom', 'prenom', 'photo'];
}
