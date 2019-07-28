<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Nota;
use Validator;

class NotaController extends BaseController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notas = Nota::all();

        return $this->sendResponse($notas->toArray(), 'Notas retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'access_key' => 'required',
            'value' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $nota = Nota::create($input);

        return $this->sendResponse($nota->toArray(), 'Nota created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $access_key
     * @return \Illuminate\Http\Response
     */
    public function show($access_key)
    {
        $nota = Nota::where('access_key', $access_key)->first();


        if (is_null($nota)) {
            return $this->sendError('Nota not found.');
        }


        return $this->sendResponse($nota->toArray(), 'Nota retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $access_key
     * @param  string  $value
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nota $nota)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'access_key' => 'required',
            'value' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $nota->access_key = $input['access_key'];
        $nota->value = $input['value'];
        $nota->save();

        return $this->sendResponse($nota->toArray(), 'Nota updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $access_key
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();

        return $this->sendResponse($nota->toArray(), 'Nota deleted successfully.');
    }
}
