<?php

namespace App\Models;
use CodeIgniter\Model;

class FilleulModel extends Model
{
   // Le nom de la table dans la base de données
    protected $table      = 'filleuls';
    
    // La clé primaire
    protected $primaryKey = 'id';

    // Les champs autorisés pour être insérés ou mis à jour
    protected $allowedFields = ['nom', 'prenom', 'photo'];
}
