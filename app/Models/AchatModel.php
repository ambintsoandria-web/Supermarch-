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

    public function creerAchat($id_caisse)
    {
        $data = [
            'id_caisse' => $id_caisse,
            'total' => 0,
            'statut' => 'en_cours'
        ];
        $this->insert($data);
        return $this->getInsertID();
    }

    public function getAchatEnCours($id_caisse)
    {
        return $this->where('id_caisse', $id_caisse)
            ->where('statut', 'en_cours')
            ->orderBy('id_achat', 'DESC')
            ->first();
    }

    public function getAchat($id_achat)
    {
        return $this->find($id_achat);
    }

    public function calculerTotal($id_achat)
    {
        $ligneModel = new LigneAchatModel();
        $lignes = $ligneModel->getLignesByAchat($id_achat);

        $total = 0;
        foreach ($lignes as $ligne) {
            $total += $ligne->quantite * $ligne->prix_unitaire;
        }

        $this->update($id_achat, ['total' => $total]);
        return $total;
    }

    public function cloturerAchat($id_achat)
    {
        $this->update($id_achat, ['statut' => 'cloture']);
        $achat = $this->find($id_achat);
        if ($achat) {
            return $this->creerAchat($achat->id_caisse);
        }
        return false;
    }

    // ============================================
    // NOUVELLE METHODE POUR L'HISTORIQUE
    // ============================================
    public function getAllAchats($id_caisse)
    {
        return $this->where('id_caisse', $id_caisse)
            ->where('statut', 'cloture')
            ->orderBy('date_achat', 'DESC')
            ->findAll();
    }
}