<?php

namespace App\Models;

use CodeIgniter\Model;

class LigneAchatModel extends Model
{
    protected $table = 'lignes_achat';
    protected $primaryKey = 'id_ligne';
    protected $allowedFields = ['id_achat', 'id_produit', 'quantite', 'prix_unitaire'];
    protected $useTimestamps = false;
    protected $returnType = 'object';
}