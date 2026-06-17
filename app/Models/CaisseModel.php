<?php

namespace App\Models;

use CodeIgniter\Model;

class CaisseModel extends Model
{
    protected $table = 'caisses';
    protected $primaryKey = 'id_caisse';
    protected $allowedFields = ['numero', 'caissier', 'statut'];
    protected $useTimestamps = false;
    protected $returnType = 'object';

    /**
     * Récupérer toutes les caisses ouvertes
     */
    public function getAllCaisse()
    {
        return $this->where('statut', 'ouverte')->findAll();
    }

    /**
     * Récupérer une caisse par son numéro
     */
    public function getByNumero($numero)
    {
        return $this->where('numero', $numero)->first();
    }

    /**
     * Récupérer une caisse par son ID
     */
    public function getById($id_caisse)
    {
        return $this->find($id_caisse);
    }

    /**
     * Ouvrir une caisse
     */
    public function ouvrirCaisse($id_caisse, $caissier = null)
    {
        $data = ['statut' => 'ouverte'];
        if ($caissier) {
            $data['caissier'] = $caissier;
        }
        return $this->update($id_caisse, $data);
    }

    /**
     * Fermer une caisse
     */
    public function fermerCaisse($id_caisse)
    {
        return $this->update($id_caisse, ['statut' => 'fermee']);
    }

    /**
     * Vérifier si une caisse est ouverte
     */
    public function estOuverte($id_caisse)
    {
        $caisse = $this->find($id_caisse);
        return ($caisse && $caisse->statut === 'ouverte');
    }

    public function countOuvertes()
    {
        return $this->where('statut', 'ouverte')->countAllResults();
    }

    public function getAllCaisses()
    {
        return $this->findAll();
    }
    public function getCaissesWithActivite()
    {
        $db = db_connect();
        return $db->table('caisses')
            ->select('caisses.*, COUNT(achats.id_achat) as nb_achats, SUM(achats.total) as total_ventes')
            ->join('achats', 'achats.id_caisse = caisses.id_caisse AND achats.statut = "cloture"', 'left')
            ->where('DATE(achats.date_achat)', date('Y-m-d'))
            ->groupBy('caisses.id_caisse')
            ->get()
            ->getResult();
    }
}