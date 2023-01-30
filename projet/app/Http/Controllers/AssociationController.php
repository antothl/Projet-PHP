<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Association;
use App\Models\Activite;
use App\Models\ActiviteEnfant;
use App\Models\AssociationUser;
use App\Http\Requests\StoreAssociationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;


class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $associationList = Association::orderBy('nom')->get();
        return view('association.list', ['associationList'=>$associationList]);
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
            if (Auth::user()->statut < 3) {
                return redirect('/');
            }
        }
        return view ('association.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssociationRequest $request)
    {
        $request->validated();
        $association = Association::create($request->input());
        $association->save();
        return redirect()->route('association.show', ['association'=>$association]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('association.show', ['association' => Association::findOrFail($id)]);
    }


    public function activite($id)
    {
        return view('association.activite', ['association'=> Association::findorFail($id)]);
    }


    public function adherant($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        }
        else {
            if (Auth::user()->statut == 1) {
                return redirect('/');
            }
        }
        return view('association.adherant', ['association'=> Association::findorFail($id)]);
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
            if (Auth::user()->statut < 3) {
                return redirect('/');
            }
        }
        return view('association.edit', ['association' => Association::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAssociationRequest $request, Association $association)
    {
        $request->validated();
        $association->update($request->input());
        return redirect()->route('association.show', ['association' => $association]);
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
            if (Auth::user()->statut < 3) {
                return redirect('/');
            } else {

                $association = Association::findOrFail($id);

                foreach(Activite::where('association_id', $association->id)->get() as $activite) {
                    Schema::rename('activite_enfant', 'activite_enfants');
                    ActiviteEnfant::where('activite_id', $activite->id)->delete();
                    Schema::rename('activite_enfants', 'activite_enfant');
                    $activite->delete();
                }

                Schema::rename('association_user', 'association_users');
                AssociationUser::where('association_id', $association->id)->delete();
                Schema::rename('association_users', 'association_user');

                $association->delete();
                return redirect()->route('association.index');
            }
        }
    }
}
