<?php

namespace App\Models;
use CodeIgniter\Model;

class BinomeModel extends Model 
{
    protected $table = 'binomes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['parrain_id', 'filleul_id'];
}