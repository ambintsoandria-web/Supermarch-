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

    public function logged_in($login, $mdp)
    {
        return $this->where('login', $login)
            ->where('password', $mdp)
            ->first();
    }

    public function loginExiste($login)
    {
        return $this->where('login', $login)->countAllResults() > 0;
    }

    public function getByLogin($login)
    {
        return $this->where('login', $login)->first();
    }
    public function getCaissiers()
    {
        return $this->where('role', 'caissier')->findAll();
    }
}