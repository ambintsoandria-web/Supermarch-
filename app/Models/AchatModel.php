<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatModel extends Model
{
    protected $table = 'achats';
    protected $primaryKey = 'id_achat';
    protected $allowedFields = ['id_caisse', 'id_user', 'total', 'statut']; // ← AJOUTER id_user
    protected $useTimestamps = false;
    protected $returnType = 'object';

    public function creerAchat($id_caisse, $id_user) // ← AJOUTER id_user en paramètre
    {
        $data = [
            'id_caisse' => $id_caisse,
            'id_user' => $id_user,  // ← INSÉRER L'UTILISATEUR
            'total' => 0,
            'statut' => 'cloture'   // ← DIRECTEMENT CLOTURE
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
            return $this->creerAchat($achat->id_caisse, $achat->id_user);
        }
        return false;
    }

    // ============================================
    // HISTORIQUE
    // ============================================
    public function getAllAchats($id_caisse)
    {
        return $this->where('id_caisse', $id_caisse)
            ->where('statut', 'cloture')
            ->orderBy('date_achat', 'DESC')
            ->findAll();
    }
    public function statistique($date){
        return $this->select('SUM(total) as total_ventes, COUNT(*) as nombre_achats')
            ->where('DATE(date_achat)', $date)
            ->where('statut', 'cloture')
            ->first();
    }
}