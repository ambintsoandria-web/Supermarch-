<?php

namespace App\Models;

use CodeIgniter\Model;
class User extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'email', 'password'];
}