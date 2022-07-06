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
use App\Http\Resources\BookResource;
use App\Http\Services\BookService;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{

    public function __construct(private BookService $_bookservice){}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/books",
     *      operationId="indexBook",
     *      tags={"Book"},
     *      summary="Get list of books",
     *      description="Returns list of books",
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
        $book = Book::all();

        return new BookCollection($book);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *      path="/books",
     *      operationId="storeBook",
     *      tags={"Book"},
     *      summary="Store new book",
     *      description="Returns book data",
     *      @OA\Parameter(
     *          name="title",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name="year",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name="summary",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name= "etat",
     *          
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string",
     *          enum={"good", "durty"}
     *          )
     *      ),
     *  * @OA\Parameter(
     *          name= "status",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string",
     *           enum={"available", "loan"}
     * )
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
        
            $book =  $this->_bookservice->livres($request, null);
            return response([
                'success' => true,
                'message' => 'Book created successfully.'
            ], 200);
    
        }catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $isbn
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/books/{isbn}",
     *      operationId="showBook",
     *      tags={"Book"},
     *      summary="Get book information",
     *      description="Returns book data",
     *      @OA\Parameter(
     *          name="isbn",
     *          description="book_isbn",
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
    public function show($isbn)
    {
        try {

            $book = Book::where('isbn', $isbn)->first();
            if (!$book){
                throw new ApiException(
                    "Book not found.",
                        404
                    );
                 }
            return $book;
        
    
        }catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $isbn
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *      path="/books/{isbn}",
     *      operationId="updateBook",
     *      tags={"Book"},
     *      summary="update book information",
     *      description="Returns book data",
     *      @OA\Parameter(
     *          name="isbn",
     *          description="book_isbn",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),@OA\Parameter(
     *          name="title",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name="year",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name="summary",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string")
     *      ),
     * @OA\Parameter(
     *          name= "etat",
     *          
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string",
     *          enum={"good", "durty"}
     *          )
     *      ),
     *  * @OA\Parameter(
     *          name= "status",
     *          in="query",
     *          required=true,
     *           @OA\Schema(type="string",
     *           enum={"available", "loan"}
     * )
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
            $book = $this->_bookservice->livres($request, $id);
            return response([
                'success' => true,
                'message' => 'Book updated successfully.'
            ], 200);
        } catch (Exception $e) {
            throw ($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $isbn
     * @return \Illuminate\Http\Response
     */

         /**
     * @OA\Delete(
     *      path="/books/{isbn}",
     *      operationId="destroyBook",
     *      tags={"Book"},
     *      summary="delete book information",
     *      description="Returns book data",
     *      @OA\Parameter(
     *          name="isbn",
     *          description="book_isbn",
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
    public function destroy($isbn)
    {
        $isDeleted = $this->_bookservice->delete($isbn);
        if(!$isDeleted) {
            return response([
                'success' => true,
                'message' => "Your Book has been deleted successfully"
            ], 200);
        } else {
        throw new ApiException("Cannot delete Book.");
        }
    }
}