<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use Exception;
use Illuminate\Http\Request;

class MultimediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: completar filtrado
        return view('multimedia.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
        return view('multimedia.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: agregar validaciones a entradas
        try {
            $request->file('media')->storeAs('', );
        } catch (Exception $e){

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Multimedia $multimedia)
    {
        //
        return view('multimedia.show', compact('multimedia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Multimedia $multimedia)
    {
        //
        return view('multimedia.edit', compact('multimedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Multimedia $multimedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Multimedia $multimedia)
    {
        //
    }
}
