<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['login', 'password', 'nom_complet', 'role'];
    protected $useTimestamps = false;
    protected $returnType = 'object';
}