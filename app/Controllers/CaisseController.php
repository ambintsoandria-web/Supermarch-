<?php

namespace App\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Models\ProduitModel;
use App\Models\CaisseModel;
use App\Models\AchatModel;
use App\Models\LigneAchatModel;

class CaisseController extends BaseController
{
    public function choixCaisse()
    {
        $caisseModel = new CaisseModel();
        $data['listeCaisse'] = $caisseModel->getAllCaisse();
        return view('choix_caisse', $data);
    }

    public function validerCaisse()
    {
        $id_caisse = $this->request->getPost('id_caisse');

        if ($id_caisse) {
            $caisseModel = new CaisseModel();
            if ($caisseModel->estOuverte($id_caisse)) {
                session()->set('id_caisse', $id_caisse);
                session()->set('panier', []);
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
        $produitModel = new ProduitModel();

        $caisse = $caisseModel->getById($id_caisse);
        $produits = $produitModel->getAllProduits();
        $panier = session()->get('panier') ?? [];

        $data = [
            'caisse' => $caisse,
            'produits' => $produits,
            'panier' => $panier
        ];

        return view('saisie_achat', $data);
    }

    public function ajouterProduit()
    {
        $id_produit = $this->request->getPost('id_produit');
        $quantite = (int) $this->request->getPost('quantite');

        $id_caisse = session()->get('id_caisse');
        if (!$id_caisse) {
            return redirect()->to('/')->with('error', 'Veuillez d\'abord choisir une caisse');
        }

        $produitModel = new ProduitModel();

        if (!$produitModel->hasStock($id_produit, $quantite)) {
            return redirect()->back()->with('error', 'Stock insuffisant !');
        }

        $produit = $produitModel->getProduit($id_produit);
        if (!$produit) {
            return redirect()->back()->with('error', 'Produit introuvable !');
        }

        $panier = session()->get('panier') ?? [];

        $trouve = false;
        foreach ($panier as &$item) {
            if ($item['id_produit'] == $id_produit) {
                $item['quantite'] += $quantite;
                $trouve = true;
                break;
            }
        }

        if (!$trouve) {
            $panier[] = [
                'id_produit' => $id_produit,
                'designation' => $produit->designation,
                'prix_unitaire' => $produit->prix_vente,
                'quantite' => $quantite
            ];
        }

        session()->set('panier', $panier);

        return redirect()->to('/saisie-achat')->with('success', 'Produit ajouté au panier !');
    }

    public function supprimerLigne()
    {
        $index = $this->request->getPost('index');

        $panier = session()->get('panier') ?? [];

        if (isset($panier[$index])) {
            unset($panier[$index]);
            $panier = array_values($panier);
            session()->set('panier', $panier);
        }

        return redirect()->to('/saisie-achat')->with('success', 'Ligne supprimée !');
    }

    public function validerAchat()
    {
        $id_caisse = session()->get('id_caisse');
        $id_user = session()->get('id_user');  // ← RÉCUPÉRER L'UTILISATEUR

        if (!$id_caisse) {
            return redirect()->to('/choix-caisse')->with('error', 'Veuillez d\'abord choisir une caisse');
        }

        if (!$id_user) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter');
        }

        $panier = session()->get('panier') ?? [];

        if (empty($panier)) {
            return redirect()->back()->with('error', 'Le panier est vide !');
        }

        $achatModel = new AchatModel();
        $ligneModel = new LigneAchatModel();
        $produitModel = new ProduitModel();

        // Créer l'achat avec l'utilisateur
        $id_achat = $achatModel->creerAchat($id_caisse, $id_user);  // ← PASSER id_user

        $total = 0;
        foreach ($panier as $item) {
            $ligneModel->ajouterProduit(
                $id_achat,
                $item['id_produit'],
                $item['quantite']
            );

            $produitModel->updateStock($item['id_produit'], $item['quantite']);
            $total += $item['quantite'] * $item['prix_unitaire'];
        }

        $achatModel->update($id_achat, ['total' => $total]);
        session()->remove('panier');

        return redirect()->to('/saisie-achat')->with('success', '✅ Achat validé avec succès !');
    }
    public function viderPanier()
    {
        session()->remove('panier');
        return redirect()->to('/saisie-achat')->with('success', 'Panier vidé !');
    }

    // ============================================
    // HISTORIQUE - RAJOUTER CES METHODES
    // ============================================
    public function historique()
    {
        $id_caisse = session()->get('id_caisse');
        if (!$id_caisse) {
            return redirect()->to('/')->with('error', 'Veuillez d\'abord choisir une caisse');
        }

        $achatModel = new AchatModel();
        $caisseModel = new CaisseModel();

        $caisse = $caisseModel->getById($id_caisse);
        $achats = $achatModel->getAllAchats($id_caisse);

        $data = [
            'caisse' => $caisse,
            'achats' => $achats
        ];

        return view('historique', $data);
    }

    public function detail($id_achat)
    {
        $id_caisse = session()->get('id_caisse');
        if (!$id_caisse) {
            return redirect()->to('/')->with('error', 'Veuillez d\'abord choisir une caisse');
        }

        $achatModel = new AchatModel();
        $ligneModel = new LigneAchatModel();
        $caisseModel = new CaisseModel();

        $achat = $achatModel->getAchat($id_achat);
        if (!$achat || $achat->id_caisse != $id_caisse) {
            return redirect()->to('/historique')->with('error', 'Achat introuvable');
        }

        $caisse = $caisseModel->getById($id_caisse);
        $lignes = $ligneModel->getLignesAvecProduits($id_achat);

        $data = [
            'caisse' => $caisse,
            'achat' => $achat,
            'lignes' => $lignes
        ];

        return view('historique_detail', $data);
    }
}