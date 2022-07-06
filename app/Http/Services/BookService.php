<?php


namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidateException;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\People;


class BookService {

    public function livres(Request $request, $isbn = null){
        try{

            $validatorRules = [
                'title' => 'required|string|max:50',
                'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
                'summary' => 'required|string',
                'etat' => 'in:good,durty',
                'status' => 'in:available,loan',
                'category_id' => 'integer|exists:categories,id'
            ];
            // $validator = Validator::make(Input::etat(['good', 'dirty']), [
            //     'good' => 'required|max:10',
            //     'dirty' => 'required|max:10',
            // ]);
            // $validator = Validator::make(Input::staut(['avalaible', 'loan']), [
            //     'avalaible' => 'required|max:10',
            //     'loan' => 'required|max:10',
            // ]);
        
            // Validate fields.
            $validator = Validator::make($request->all(), $validatorRules);
        
            // If validation fails
            // Return error messages and exit.
            if ($validator->fails()) {
                throw (new ValidateException(
                    $validator->errors()
                ));
            }
        $book = null;
        // $countries = Book::find($request->input('id'));

        if($isbn){
            $book = Book::where('isbn', $isbn)->first();
            
            if (!$book){
                throw new ApiException(
                    "Book not found.",
                        404
                    );
                 }
        }
        else{
            $book = new Book();
        }

        if(!$isbn){
            $bookFound = Book::where('isbn', $request->input('isbn'))->first();

            if($bookFound){
                throw new ApiException("Cannot create Book, because a same Book already exists");
            }
            $book->isbn = $request->input('isbn');
        }

        // $author = Author::find($request->input('author_id'));
        // if (!$author) {
        //     throw new ApiException("Author not found.");
        // }
        $book->title = $request->input('title');
        $book->year = $request->input('year');
        $book->summary = $request->input('summary');
        $book->etat = $request->input('etat');
        $book->status = $request->input('status');
        $book->category_id = $request->input('category_id');

        

        $book->save();
        // die($book);
        return $book;


        }catch(\Exception $e) {
            throw $e;
        }
    }

  

    public function delete($isbn) {

        try {

            // Create or update Book.
            $book = Book::find($isbn);

            // Check if Book.
            if (!$book) {
                throw new ApiException("No Book found");
            }

            // Check if Book is linked to an Book.
            $bookBookFound = Book::where('id', $isbn)->first();
            if ($bookBookFound) {
                throw new ApiException("Cannot delete, Book is linked to an Book.");
            }

            // Check if Book is linked to an Book.
            $bookPersonFound = People::where('id', $isbn)->first();
            if ($bookPersonFound) {
                throw new ApiException("Cannot delete, Book is linked to a person.");
            }

            // Delete the Book.
            $book->delete();

            

        }catch(\Exception $e){
            throw $e;
        }

    }


    
}