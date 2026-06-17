<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table = 'produits';
    protected $primaryKey = 'id_produit';
    protected $allowedFields = ['designation', 'prix_vente', 'stock', 'code_barre', 'categorie'];
    protected $useTimestamps = false;
    protected $returnType = 'object';
}