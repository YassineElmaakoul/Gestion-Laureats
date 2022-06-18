<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use AuthenticatesUsers;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etudiants = User::where('isAdmin', '!=', true)->paginate(3);
        return view('admin.index',['etudiants' => $etudiants]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'digits:10'],
            'dateNaissance' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'promo' => ['required', 'string', 'max:255'],
            'dd' => ['required', 'boolean']
        ]);

        $user = new User();

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->dateNaissance = $request->dateNaissance;
        $user->telephone = $request->telephone;
        $user->filiere = $request->filiere;
        $user->email = $request->email;
        $user->promo = $request->promo;
        $user->dd = $request->dd;
        $user->password = Hash::make($request->nom . '_2021');

        $user->save();

        return redirect()->back()->with('success', 'Le laureat a été bien ajouté !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'digits:10'],
            'dateNaissance' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'promo' => ['required', 'string', 'max:255'],
            'dd' => ['required', 'boolean']
        ]);


        $user = User::find($request->id);

        if($user->email == $request->email){
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->dateNaissance = $request->dateNaissance;
            $user->telephone = $request->telephone;
            $user->filiere = $request->filiere;
            $user->promo = $request->promo;
            $user->dd = $request->dd;
        }else{
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255','unique:users']
            ]);
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->dateNaissance = $request->dateNaissance;
            $user->telephone = $request->telephone;
            $user->filiere = $request->filiere;
            $user->email = $request->email;
            $user->promo = $request->promo;
            $user->dd = $request->dd;
        }   

        

        $user->save();

        return redirect()->back()->with('success', 'Le laureat a été bien modifié !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'Le laureat a été bien supprimé !!');
    }

    public function delete2($id){
        $etudiants = User::where('isAdmin', '!=', true)->paginate(3);
        User::destroy($id);
        return redirect('/admin');
    }

}
