<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\TemporaryUse;
use App\User;

use Illuminate\Http\Request;


//Modelos de importacion excel
use App\Imports\InventoryImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB;
use Exception;


class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventario = Inventory::all();
        // dd($inventario);
        return response()->json($inventario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try{
            DB::beginTransaction();
            $inventario = Inventory::create($request->all());
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Artículo guardado correctamente'], 200);

        }catch(Exception $e){
            DB::rollBack(); // Revierte los cambios en caso de excepción
            return response()->json(['status' => 'error', 'message' => 'Error al guardar la información: ' . $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InventoryController  $inventoryController
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InventoryController  $inventoryController
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory){

        $temporary = TemporaryUse::where('id_inventory', $inventory->id)->exists();
        if ($temporary) {
            $user = TemporaryUse::where('id_inventory', $inventory->id)->first();

            if($user->id_user == auth()->id()){
                return response()->json(['status' => 'success', 'message' => 'Usuario actual editando.'], 200);
            }else{
                return response()->json(['status' => 'error', 'message' => $user->name_user.' actualmente esta editando este articulo. Operación cancelada.'], 200);
            }

        }else{
            try{
                DB::beginTransaction();
                $temporary = TemporaryUse::create([
                    "id_user"         => auth()->id(),
                    "name_user"       => auth()->user()->name,
                    "id_inventory"    => $inventory->id,
                ]);
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Uso temporal asignado'], 200);

            }catch(Exception $e){
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Error al asignar : ' . $e->getMessage()], 500);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InventoryController  $inventoryController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory){
        try{
            $inventory->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'Artículo actualizado correctamente'], 200);

        }catch(Exception $e){
            return response()->json(['status' => 'error', 'message' => 'Error durante la actualización: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InventoryController  $inventoryController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory){
        try{
            $inventory->delete();
            return response()->json(['status' => 'success', 'message' => 'Artículo Eliminado.'], 200);

        }catch(Exception $e){
            return response()->json(['status' => 'error', 'message' => 'Error durante la eliminación: ' . $e->getMessage()]);
        }
    }

    //Funcion importa un archivo Excel y sube su informacion a la tabla inventory de la DB.
    public function importExcel(Request $request){
        try{
            DB::beginTransaction(); // Inicia una transacción
            Excel::import(new InventoryImport,  request()->file('excel_inventory') );
            DB::commit(); // Confirma la transacción si no hay excepciones

            return response()->json(['status' => 'success', 'message' => 'Importación exitosa']);

        } catch (Exception $e){
            DB::rollBack(); // Revierte los cambios en caso de excepción
            return response()->json(['status' => 'error', 'message' => 'Error durante la importación: ' . $e->getMessage()]);
        }
    }


    //Eliminar la asignacion del usuario que edita un registro para que quede libre y otro usuario pueda disponer de el apra editar.
    public function eliminarAsignacion($id){
        $inventory = Inventory::find($id);

        // dd($inventory);
        $temporary = TemporaryUse::where('id_inventory', $inventory->id)->first();
        $temporary->delete();
        return response()->json(['status' => 'success', 'message' => 'Asignación Eliminada.'], 200);

    }
}
