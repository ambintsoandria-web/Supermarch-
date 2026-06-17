<?php

namespace App\Models;
error_reporting(E_ALL);
ini_set('display_errors', 1);


use CodeIgniter\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = ['id'];
    protected $returnType = 'array';
    protected $allowedFields = [
        'matricule',
        'nom',
        'prenom',
        'email'
    ];
    protected $useTimestamps = false;
    public function insertion($data, $table)
    {
        $db = \Config\Database::connect();
        $db->table($table)->insert($data);
    }
    function getColomnesFile($file, $separateur)
    {
        $lignes = file($file);
        $ligne_non_split = $lignes[0];
        $colomnes = explode($separateur, $ligne_non_split);
        return $colomnes;
    }
    public function getNomColomnesTables($table)
    {
        $db = \Config\Database::connect();
        $query = $db->query("
        SELECT column_name FROM information_schema.columns WHERE table_name = ?
    ", [$table]);

        return $query->getResultArray();
    }
    public function getColumnValide($table, $file)
    {
        $colomnes_valides = [];
        $liste_colomnes_table = $this->getNomColomnesTables($table);
        $liste_colomnes = $this->getColomnesFile($file, ";");
        for ($i = 0; $i < count($liste_colomnes_table); $i++) {
            for ($j = 0; $j < count($liste_colomnes); $j++) {
                if ($liste_colomnes_table[$i] == $liste_colomnes[$j]) {
                    $colomnes_valides[] = $liste_colomnes_table[$i];
                }
            }
        }
        return $colomnes_valides;
    }
    public function getDataColomnesValides($data, $table)
    {
        $colomnes = $this->getNomColomnesTables($table);
        echo $colomnes[1]['column_name'];
        // var_dump($colomnes);
        // $colomnes = ["matricule", "nom", "prenom", "email"];
        $data_selectionne = array_intersect_key($data, array_flip(array_column($colomnes, 'column_name')));
        return $data_selectionne;
    }
    public function getAlltables()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        $results = $query->getResultArray();
        return $results;
    }
    public function import($full_data)
    {
        $db = \Config\Database::connect();
        $liste_tables = $this->getAlltables();
        var_dump($liste_tables);

        foreach ($liste_tables as $table_row) {
            $table = $table_row['table_name'];

            $data_selectionne_par_table = $this->getDataColomnesValides($full_data, $table);
            if (!empty($data_selectionne_par_table)) {
                $db->table($table)->insert($data_selectionne_par_table);
            }
            // break;
        }
    }
    public function getTableForeignKey($table)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT ");
    }
}