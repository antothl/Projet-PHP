<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enfant;
use App\Models\ActiviteEnfant;
use App\Http\Requests\StoreEnfantRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class CompteController extends Controller
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
            $compte_enfantList = Enfant::where('user_id', Auth::user()->id)->orderBy('nom')->get();        
            return view('compte/compte_enfant.list', ['compte_enfantList' => $compte_enfantList]);
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
            return view('compte/compte_enfant.create');
        }
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
        $compte_enfant = Enfant::create($request->input());
        $compte_enfant->save();

        return redirect()->route('compte_enfant.show', ['compte_enfant' => $compte_enfant]);
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
            return view('compte/compte_enfant.show', ['compte_enfant' => Enfant::where('user_id', Auth::user()->id)->findOrFail($id)]);
        } 
    }


    public function inscrit($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        }
        return view('compte/compte_enfant.inscrit', ['compte_enfant'=> Enfant::where('user_id', Auth::user()->id)->findOrFail($id)]);
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
            return view('compte/compte_enfant.edit', ['compte_enfant' => Enfant::where('user_id', Auth::user()->id)->findOrFail($id)]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEnfantRequest $request, Enfant $compte_enfant)
    {
        $request->validated();
        $compte_enfant->update($request->input());
        return redirect()->route('compte_enfant.show', ['compte_enfant' => $compte_enfant]);
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
            $compte_enfant = Enfant::findOrFail($id);
            Schema::rename('activite_enfant', 'activite_enfants');
            ActiviteEnfant::where('enfant_id', $compte_enfant->id)->delete();
            Schema::rename('activite_enfants', 'activite_enfant');
            $compte_enfant->delete();
            return redirect()->route('compte_enfant.index');
        }
    }
}
