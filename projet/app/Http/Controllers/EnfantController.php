<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enfant;
use App\Models\ActiviteEnfant;
use App\Http\Requests\StoreEnfantRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class EnfantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            if (Auth::user()->statut == 1) {
                return redirect('/');
            } else {
                $enfantList = Enfant::orderBy('nom')->get();        
                return view('enfant.list', ['enfantList' => $enfantList]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            if (Auth::user()->statut !== 3) {
                return redirect('/');
            } 
        }
        return view('enfant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreEnfantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEnfantRequest $request)
    {
        $request->validated();
        $enfant = Enfant::create($request->input());
        $enfant->save();

        return redirect()->route('enfant.show', ['enfant' => $enfant]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            if (Auth::user()->statut == 1) {
                return redirect('/');
            }
        } 
        return view('enfant.show', ['enfant' => Enfant::findOrFail($id)]);
    }


    public function inscrit($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            if (Auth::user()->statut == 1) {
                return redirect('/');
            }
        } 
        return view('enfant.inscrit', ['enfant'=> Enfant::findorFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            if (Auth::user()->statut !== 3) {
                return redirect('/');
            } 
        }
        return view('enfant.edit', ['enfant' => Enfant::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEnfantRequest $request, Enfant $enfant)
    {
        $request->validated();
        $enfant->update($request->input());
        return redirect()->route('enfant.show', ['enfant' => $enfant]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            if (Auth::user()->statut !== 3) {
                return redirect('/');
            } else {
                $enfant = Enfant::findOrFail($id);
                

                //Supprimer les inscriptions
                Schema::rename('activite_enfant', 'activite_enfants');
                ActiviteEnfant::where('enfant_id', $enfant->id)->delete();
                Schema::rename('activite_enfants', 'activite_enfant');
                $enfant->delete();
                return redirect()->route('enfant.index');
            }
        }
    }
}
