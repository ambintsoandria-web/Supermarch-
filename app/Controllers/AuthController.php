<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/choix-caisse');
        }
        return view('login');
    }

    public function doLogin()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        if (empty($login) || empty($password)) {
            return redirect()->back()->with('error', 'Veuillez remplir tous les champs');
        }

        $userModel = new UtilisateurModel();
        $user = $userModel->logged_in($login, $password);

        if ($user) {
            session()->set([
                'id_user' => $user->id_user,
                'login' => $user->login,
                'nom_complet' => $user->nom_complet,
                'role' => $user->role,
                'isLoggedIn' => true
            ]);

            return redirect()->to('/')->with('success', 'Bienvenue ' . $user->nom_complet . ' !');
        } else {
            return redirect()->back()->with('error', 'Login ou mot de passe incorrect');
        }
    }

    public function logout()
    {
        // Détruire la session
        session()->destroy();
        
        // Rediriger vers la page de login avec message
        return redirect()->to('/')->with('success', 'Déconnexion réussie');
    }
}