<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activite;
use App\Models\ActiviteEnfant;
use App\Http\Requests\StoreActiviteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class ActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activiteList = Activite::orderBy('dateDebut', 'desc')->get();
        return view('activite.list', ['activiteList'=>$activiteList]);
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
        }
        else {
            if (Auth::user()->statut === 1) {
                return redirect('/');
            }
        }
        return view('activite.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreActiviteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActiviteRequest $request)
    {   
        $request->validated();
        $activite = Activite::create($request->input());
        $activite->save();
    
        return redirect()->route('activite.show', ['activite' => $activite]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('activite.show', ['activite'=> Activite::findorFail($id)]);
    }


    public function inscrit($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        }
        else {
            if (Auth::user()->statut === 1) {
                return redirect('/');
            }
        }
        return view('activite.inscrit', ['activite'=> Activite::findorFail($id)]);
    }


    public function inscription($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
    
            date_default_timezone_set('Europe/Paris');
            $ajd = date( "Y-m-d H:i:s", time());
            $dt = date( "Y-m-d H:i:s", strtotime("+7 day", time()));

            if(Activite::findorFail($id)->dateDebut > $dt) {
                $adhere = 0;
            }

            foreach(Activite::findorFail($id)->association->user as $user)
            if($user->id == Auth::user()->id) {
                $adhere = 1;
            }
            
            if(Activite::findorFail($id)->places <= Activite::findorFail($id)->enfants->count())
            {
                return redirect('/');
            } else {
                if($adhere == 1) {
                    return view('activite.inscription', ['activite'=> Activite::findorFail($id)]);
                } else {
                    return redirect('/');
                }
            }
        }
    }


    public function inscription_admin($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
    
            if (Auth::user()->statut > 2) {

                date_default_timezone_set('Europe/Paris');
                $dt = date( "Y-m-d H:i:s", strtotime("+7 day", time()));
                
                if(Activite::findorFail($id)->places <= Activite::findorFail($id)->enfants->count())
                {
                    return redirect('/');
                } else {

                    if(Activite::findorFail($id)->dateDebut > $dt) {
                        return view('activite.inscription_admin', ['activite'=> Activite::findorFail($id)]);
                    } else {
                        return redirect('/');
                    }

                }
                
            } else {
                return redirect('/');
            }
        }
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
        }
        else {
            if (Auth::user()->statut === 1) {
                return redirect('/');
            }
        }
        return view('activite.edit', ['activite' => Activite::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreActiviteRequest $request, Activite $activite)
    {
        $request->validated();
        $activite->update($request->input());
        return redirect()->route('activite.show', ['activite' => $activite]);
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
        }
        else {
            if (Auth::user()->statut === 1) {
                return redirect('/');
            } else {
                $activite = Activite::findOrFail($id);
                Schema::rename('activite_enfant', 'activite_enfants');
                ActiviteEnfant::where('activite_id', $activite->id)->delete();
                Schema::rename('activite_enfants', 'activite_enfant');
                $activite->delete();
                return redirect()->route('activite.index');
            }
        }
    }

}
