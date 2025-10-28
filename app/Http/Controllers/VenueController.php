<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //METODO WITH PARA CARGAR RELACIONES
        //RETORNAR UNA COLECCIÓN DE VENUES CON SUS EVENTOS
        return Venue::with('events')
        ->where('venue_max_capacity', '>', $request->input('capacity')) //FILTRAR POR CAPACIDAD
        ->orWhere('venue_status', true) //FILTRAR POR STATUS
        ->get();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVenueRequest $request)
    {
        //PARA NO LLAMAR CADA UNA DE LAS PROPIEDADES DE LA TABLA
        $venue = Venue::create($request->validated());
        $venue->save();
        return response()->json(['success' => true, 'venue' => $venue]);
    }

    /**
     * Display the specified resource.
     */

    //SE RETORNA LO QUE SE RECIBE PORQUE LARAVEL HACE EL TRABAJO DE BUSCARLO
    //SI NO LO ENCUENTRA, DEVUELVE UN ERROR 404
    public function show(Venue $venue)
    {
        //TODAS LAS RUTAS PUEDEN TENER EL MISMO RETURN 
        return response()->json([
            'success' => true,
            'venue' => $venue,
            //ELIMINAR EL DUPLICADO DE CARGAR LOS EVENTOS
            'events' => $venue->events()->get()
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVenueRequest $request, Venue $venue)
    {
        if($venue->update($request->validated())) {
            return response()->json(['success' => true, 'venue' => $venue]);
        } else {
            return response()->json(['success' => false, 'venue' => $venue]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        //DESTROY DEVULEVE UN ENTERO
        //DELETE DEVUELVE TRUE O FALSE
        if($venue->delete()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}

