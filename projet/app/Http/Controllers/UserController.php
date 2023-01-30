<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Enfant;
use App\Models\ActiviteEnfant;
use App\Models\AssociationUser;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
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
                $userList = User::orderBy('prenom')->get();
                return view('user.list', ['userList'=>$userList]);
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
        //Pas de create user.
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => ['required'],
            'nom' => ['required'],
            'pseudonyme'=>['required'],
            'statut'=>['required'],
            'email'=>['required']
          ]);
          $user->save();
          return redirect()->route('user.show', ['user' => $user]);
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
        return view('user.show', ['user' => User::findOrFail($id)]);
    }
    

    public function enfant($id)
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            if (Auth::user()->statut == 1) {
                return redirect('/');
            }
        } 
        return view('user.enfant', ['user'=> User::findorFail($id)]);
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
        return view('user.edit', ['user' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, User $user)
    {
        $request->validated();
        $user->update($request->input());
        return redirect()->route('user.show', ['user' => $user]);
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
                $user = User::findOrFail($id);

                //Supprimer les enfants et leurs inscriptions
                Schema::rename('activite_enfant', 'activite_enfants');
                foreach(Enfant::where('user_id', $user->id)->get() as $enfant) {
                    ActiviteEnfant::where('enfant_id', $enfant->id)->delete();
                    $enfant->delete();
                }
                Schema::rename('activite_enfants', 'activite_enfant');

                //Supprimer les adhesions
                Schema::rename('association_user', 'association_users');
                AssociationUser::where('user_id', $user->id)->delete();
                Schema::rename('association_users', 'association_user');

                //Supprimer l'utilisateur
                $user->delete();
                return redirect()->route('user.index');
            }
        }
        
    }
}
