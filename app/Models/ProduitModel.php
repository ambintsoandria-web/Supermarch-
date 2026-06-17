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

    public function getAllProduits()
    {
        return $this->findAll();
    }

    public function getProduit($id_produit)
    {
        return $this->find($id_produit);
    }

    public function hasStock($id_produit, $quantite)
    {
        $produit = $this->find($id_produit);
        return ($produit && $produit->stock >= $quantite);
    }

    public function updateStock($id_produit, $quantite)
    {
        $produit = $this->find($id_produit);
        if ($produit) {
            $nouveau_stock = $produit->stock - $quantite;
            return $this->update($id_produit, ['stock' => $nouveau_stock]);
        }
        return false;
    }
}