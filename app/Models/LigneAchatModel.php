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

    public function ajouterProduit($id_achat, $id_produit, $quantite = 1)
    {
        $existant = $this->where('id_achat', $id_achat)
            ->where('id_produit', $id_produit)
            ->first();

        if ($existant) {
            $nouvelle_quantite = $existant->quantite + $quantite;
            return $this->update($existant->id_ligne, ['quantite' => $nouvelle_quantite]);
        } else {
            $produitModel = new ProduitModel();
            $produit = $produitModel->find($id_produit);

            if ($produit) {
                $data = [
                    'id_achat' => $id_achat,
                    'id_produit' => $id_produit,
                    'quantite' => $quantite,
                    'prix_unitaire' => $produit->prix_vente
                ];
                return $this->insert($data);
            }
            return false;
        }
    }

    public function getLignesByAchat($id_achat)
    {
        return $this->where('id_achat', $id_achat)->findAll();
    }

    public function getLignesAvecProduits($id_achat)
    {
        return $this->select('lignes_achat.*, produits.designation')
            ->join('produits', 'produits.id_produit = lignes_achat.id_produit')
            ->where('id_achat', $id_achat)
            ->findAll();
    }

    public function supprimerLigne($id_ligne)
    {
        return $this->delete($id_ligne);
    }

    public function getLigne($id_ligne)
    {
        return $this->find($id_ligne);
    }
}