<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatModel extends Model
{
    protected $table = 'achats';
    protected $primaryKey = 'id_achat';
    protected $allowedFields = ['id_caisse', 'total', 'statut'];
    protected $useTimestamps = false;
    protected $returnType = 'object';
}