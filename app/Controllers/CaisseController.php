<?php

namespace App\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Models\CaisseModel;

class CaisseController extends BaseController
{
    public function choixCaisse()
    {
        $caisseModel = new CaisseModel();
        $data['listeCaisse'] = $caisseModel->getAllCaisse(); // Méthode du modèle

        return view('choix_caisse', $data);
    }

    public function validerCaisse()
    {
        $id_caisse = $this->request->getPost('id_caisse');

        if ($id_caisse) {
            $caisseModel = new CaisseModel();
            if ($caisseModel->estOuverte($id_caisse)) {
                session()->set('id_caisse', $id_caisse);
                return redirect()->to('/saisie-achat');
            } else {
                return redirect()->back()->with('error', 'Cette caisse n\'est pas disponible');
            }
        } else {
            return redirect()->back()->with('error', 'Veuillez choisir une caisse');
        }
    }

    public function saisieAchat()
    {
        $id_caisse = session()->get('id_caisse');

        if (!$id_caisse) {
            return redirect()->to('/')->with('error', 'Veuillez d\'abord choisir une caisse');
        }

        $caisseModel = new CaisseModel();
        $data['caisse'] = $caisseModel->getById($id_caisse); // Méthode du modèle

        return view('saisie_achat', $data);
    }
}