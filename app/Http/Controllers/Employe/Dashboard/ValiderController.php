<?php

namespace App\Http\Controllers\Employe\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use App\Models\LigneVente;
use App\Models\Produit;
use App\Models\MouvementStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ValiderController extends Controller
{
    public function valider(Request $request)
    {
                // Validation de base
                $request->validate([
                    'somme_recue' => 'required|numeric|min:0',
                    'produits_selectionnes' => 'required|json',
                ]);

                $produitsSelectionnes = json_decode($request->produits_selectionnes, true);

                if (empty($produitsSelectionnes)) {
                    return back()->with('error', 'Aucun produit sélectionné.');
                }

                // Calcul total pour vérification côté serveur
                $totalCalculé = 0;
                foreach ($produitsSelectionnes as $p) {
                    $totalCalculé += $p['prix'] * $p['quantite'];
                }

                if ($request->somme_recue < $totalCalculé) {
                    return back()->with('error', 'Somme reçue insuffisante.');
                }

                // Création de la vente
                $vente = Vente::create([
                    'client_id' => null, // Si pas de client, sinon tu mets l'id du client ici
                    'administrateur_id' => null, // Ou Auth::id() si l'admin est connecté
                    'employe_id' => Auth::id(), // On suppose que l’employé est connecté
                    'date_vente' => Carbon::now(),
                    'mode_paiement' => 'Espèce', // À adapter si tu as plusieurs modes
                ]);

                // Création des lignes de vente et mise à jour du stock
                foreach ($produitsSelectionnes as $p) {
                    // Recherche du produit
                    $produit = Produit::where('nom', $p['nom'])->first();

                    if (!$produit) {
                        continue; // Si produit introuvable, on saute (ou on peut faire abort() si tu préfères)
                    }

                    // Création de la ligne de vente
                    LigneVente::create([
                        'vente_id' => $vente->id,
                        'produit_id' => $produit->id,
                        'quantite' => $p['quantite'],
                        'prix_unitaire' => $p['prix'],
                    ]);

                    // Mise à jour du stock
                    MouvementStock::create([
                        'produit_id' => $produit->id,
                        'type_mouvement' => 'sortie', // Sortie du stock
                        'quantite' => $p['quantite'],
                        'date_mouvement' => Carbon::now(),
                        'source' => 'vente',
                        'commentaire' => 'Sortie de stock pour vente',
                    ]);
                    }

                    session(['vente_id' => $vente->id]);

                return redirect()->route('employe.dashboard')->with('commande_validee', true)->with('produits_ticket', $produitsSelectionnes)
                ->with('vente_id', $vente->id);


    }


    public function annuler(Vente $vente)
{
    // Charger les lignes de vente et les produits associés
    $vente->load('lignes_ventes.produit');
    
    // Convertir date_vente en Carbon pour s'assurer que c'est bien un objet Carbon
    $dateVente = Carbon::parse($vente->date_vente);
    
    // Restaurer le stock à l'état initial avant la vente
    foreach ($vente->lignes_ventes as $ligne) {
        $produit = $ligne->produit;

        // Récupérer la quantité totale des entrées pour ce produit avant la vente
        $stockInitial = MouvementStock::where('produit_id', $produit->id)
            ->where('type_mouvement', 'entrée') // Considérer uniquement les entrées
            ->where('date_mouvement', '<', $dateVente) // Avant la date de la vente
            ->sum('quantite');
        
        // Si le stock initial est déjà calculé, il faudra ajuster en fonction de la vente annulée
        $nouveauStock = $stockInitial + $ligne->quantite;

        // Créer un mouvement d'entrée pour restaurer le stock
        MouvementStock::create([
            'produit_id' => $produit->id,
            'type_mouvement' => 'entrée', // Mouvement d'entrée pour restaurer le stock
            'quantite' => $ligne->quantite,
            'date_mouvement' => Carbon::now(),
            'source' => 'annulation', // Source spécifique pour l'annulation
            'commentaire' => 'Restaurer le stock après annulation de la vente',
        ]);

        // Supprimer le mouvement de stock de sortie pour cette vente
        MouvementStock::where('produit_id', $produit->id)
            ->where('type_mouvement', 'sortie')
            ->where('source', 'vente')
            ->whereDate('date_mouvement', $dateVente->toDateString())
            ->latest()
            ->take(1)
            ->delete();
    }

    // Suppression des lignes de vente
    $vente->lignes_ventes()->delete();
    
    // Suppression de la vente elle-même
    $vente->delete();

    // Rediriger avec un message de succès
    return redirect()->route('employe.dashboard')->with('success', 'Commande annulée et stock rétabli à son état initial.');
}

    
    
    




}