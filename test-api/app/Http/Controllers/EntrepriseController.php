<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function index()
    {
        return response()->json(Entreprise::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:entreprises,email',
            'telephone' => 'required|max:20',
            'adresse' => 'required',
            'type' => 'required|integer',
            'rccm' => 'nullable|max:20',
            'idnat' => 'nullable|max:20',
            'f92' => 'nullable|max:20',
        ]);

        try {
            $entreprise = Entreprise::create($request->all());

            return response()->json([
                'id_entreprise' => $entreprise->id,
                'status' => 'success',
                'message' => 'Entreprise créée avec succès.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Erreur lors de la création de l\'entreprise.',
            ], 500);
        }
    }

    public function show(Entreprise $entreprise)
    {
        return response()->json($entreprise);
    }

    public function update(Request $request, Entreprise $entreprise)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:entreprises,email,' . $entreprise->id,
            'telephone' => 'required|max:20',
            'adresse' => 'required',
            'type' => 'required|integer',
            'rccm' => 'nullable|max:20',
            'idnat' => 'nullable|max:20',
            'f92' => 'nullable|max:20',
        ]);

        try {
            $entreprise->update($request->all());

            return response()->json([
                'id_entreprise' => $entreprise->id,
                'status' => 'success',
                'message' => 'Entreprise mise à jour avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Erreur lors de la mise à jour de l\'entreprise.',
            ], 500);
        }
    }

    public function destroy(Entreprise $entreprise)
    {
        try {
            $entreprise->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Entreprise supprimée avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Erreur lors de la suppression de l\'entreprise.',
            ], 500);
        }
    }
}
