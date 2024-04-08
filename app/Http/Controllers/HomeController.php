<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function cambiarContrasenia(Request $request){
        try{
            $user = Auth::user();   // Obtener el usuario actualmente autenticado
            $user->password = Hash::make($request->contrasenia_nueva);
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'Contraseña cambiada correctamente'], 200);

        }catch(Exception $e){
            return response()->json(['status' => 'error', 'message' => 'Error durante al cambiar la Contraseña: ' . $e->getMessage()]);
        }
    }
}
