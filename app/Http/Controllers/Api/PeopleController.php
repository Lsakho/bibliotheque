<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidateException;
use App\Models\People;
use App\Models\Author;
use App\Models\Book;
use App\Http\Resources\PeopleResource;
use App\Http\Services\PeopleService;
use App\Http\Resources\PeopleCollection;

class PeopleController extends Controller
{

    public function __construct(private PeopleService $_peopleservice){}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = People::all();

        return new PeopleCollection($people);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
        
            $peoples =  $this->_peopleservice->personnes($request, null);
            return response([
                'success' => true,
                'message' => 'People created successfully.'
            ], 200);
    
        }catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $peoples = People::where('id', $id)->first();
            if (!$peoples){
                throw new ApiException(
                    "People not found.",
                        404
                    );
                 }
            return $peoples;
        
    
        }catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $peoples = $this->_peopleservice->personnes($request, $id);
            return response([
                'success' => true,
                'message' => 'People updated successfully.'
            ], 200);
        } catch (Exception $e) {
            throw ($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = $this->_peopleservice->delete($id);
        if(!$isDeleted) {
            return response([
                'success' => true,
                'message' => "Your People has been deleted successfully"
            ], 200);
        } else {
        throw new ApiException("Cannot delete People.");
        }
    }
}