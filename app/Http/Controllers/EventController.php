<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Listado de todos los registros
        return Event::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        //Crear un objeto
        $event = new Event();
        //Input, se saca el valor de la clave de la peticion, para asignar valor a cada atributo
        $event->event_name = $request->input('event_name');
        $event->event_date = $request->input('event_date');
        $event->event_max_capacity = $request->input('event_max_capacity');
        $event->event_is_virtual = $request->input('event_is_virtual');

        if ($request->hasFile('event_image')) {
            $imagePath = $request->file('event_image')->store('events', 'public');
            $event->event_image = $imagePath;
        }

        $event->save();

        return $event;
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return $event;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->all();

        if ($request->hasFile('event_image')) {
            // Eliminar imagen anterior si existe
            if ($event->event_image) {
                Storage::disk('public')->delete($event->event_image);
            }
            $imagePath = $request->file('event_image')->store('events', 'public');
            $data['event_image'] = $imagePath;
        }

        if ($event->update($data)) {
            return response()->json(['success' => true, 'event' => $event]);
        }
        return response()->json(['success' => false]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        #FORMA 1
        if($event->delete()){
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);

        # FORMA 2
        //Event::destroy($event->id);
    }
}
