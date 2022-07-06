<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidateException;
use App\Models\Author;
use App\Models\People;
use App\Models\Book;
use App\Http\Resources\AuthorResource;
use App\Http\Services\AuthorService;
use App\Http\Resources\AuthorCollection;

class AuthorController extends Controller
{
    

    public function __construct(private AuthorService $_authorservice){}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/authors",
     *      operationId="index",
     *      tags={"Author"},
     *      summary="Get list of authors",
     *      description="Returns list of authors",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *           @OA\PathItem
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        $author = author::all();

        return new authorCollection($author);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *      path="/authors",
     *      operationId="store",
     *      tags={"Author"},
     *      summary="Store new author",
     *      description="Returns project data",
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name="city",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name="birthdate",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name="country_id",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *           @OA\PathItem
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request)
    {
        try {
        
            $authors =  $this->_authorservice->auteurs($request, null);
            return response([
                'success' => true,
                'message' => 'author created successfully.'
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

     /**
     * @OA\Get(
     *      path="/authors/{id}",
     *      operationId="show",
     *      tags={"Author"},
     *      summary="Get Author information",
     *      description="Returns Author data",
     *      @OA\Parameter(
     *          name="id",
     *          description="author_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\PathItem(ref="#/components/schemas/Author")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id)
    {
        try {

            $authors = author::where('id', $id)->first();
            if (!$authors){
                throw new ApiException(
                    "author not found.",
                        404
                    );
                 }
            return $authors;
        
    
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

      /**
     * @OA\Put(
     *      path="/authors/{id}",
     *      operationId="update",
     *      tags={"Author"},
     *      summary="Get Author information",
     *      description="Returns Author data",
     *      @OA\Parameter(
     *          name="id",
     *          description="author_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="city",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="birthdate",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="country_id",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\PathItem(ref="#/components/schemas/Author")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $authors = $this->_authorservice->auteurs($request, $id);
            return response([
                'success' => true,
                'message' => 'author updated successfully.'
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

         /**
     * @OA\Delete(
     *      path="/authors/{id}",
     *      operationId="destroy",
     *      tags={"Author"},
     *      summary="Get Author information",
     *      description="Returns Author data",
     *      @OA\Parameter(
     *          name="id",
     *          description="author_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\PathItem(ref="#/components/schemas/Author")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy($id)
    {
        $isDeleted = $this->_authorservice->delete($id);
        if(!$isDeleted) {
            return response([
                'success' => true,
                'message' => "Your author has been deleted successfully"
            ], 200);
        } else {
        throw new ApiException("Cannot delete author.");
        }
    }
}