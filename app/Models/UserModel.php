<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = ['nom', 'email', 'mot_de_passe', 'role'];
    public function loggedIn($email, $mdp)
    {
        $user = $this->where('email', $email)->where('mot_de_passe', $mdp)->first();
        if ($user) {
            return $user;
        }
        return false;
    }
}
