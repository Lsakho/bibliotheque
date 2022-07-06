<?php


namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidateException;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Country;
use App\Models\People;


class AuthorService {

    public function auteurs(Request $request, $id = null){
        try{

            $validatorRules = [
                'name' => 'required|string|max:50',
                'city' => 'required|string|max:20',
                'birthdate' => 'required|date_format:Y-m-d',
                'country_id' => 'required|string|max:3|exists:countries,iso',
            ];
            
            // Validate fields.
            $validator = Validator::make($request->all(), $validatorRules);
            
            // If validation fails
            // Return error messages and exit.
            if ($validator->fails()) {
                throw (new ValidateException(
                    $validator->errors()
                ));
            }
        $authors = null;
        // $countries = Author::find($request->input('id'));

        if($id){
            $authors = Author::find($id);
            
            if (!$authors){
                throw new ApiException(
                    "Author not found.",
                        404
                    );
                 }
        }
        else{
            $authors = new Author();
        }

        if(!$id){
            $authorsFound = Author::where('id', $request->input('id'))->first();

            if($authorsFound){
                throw new ApiException("Cannot create Author, because a same Author already exists");
            }
            $authors->id = $request->input('id');
        }

     
        $authors->name = $request->input('name');
        $authors->city = $request->input('city');
        $authors->birthdate = $request->input('birthdate');
        $authors->country_id = $request->input('country_id');

        

        $authors->save();
        // die($authors);
        return $authors;


        }catch(\Exception $e) {
            throw $e;
        }
    }

  

    public function delete($id) {

        try {

            // Create or update Author.
            $authors = Author::find($id);

            // Check if Author.
            if (!$authors) {
                throw new ApiException("No Author found");
            }

            // Check if Author is linked to an author.
            $authorsBookFound = Book::where('id', $id)->first();
            if ($authorsAuthorFound) {
                throw new ApiException("Cannot delete, Author is linked to an author.");
            }

            // Check if Author is linked to an author.
            $authorsPersonFound = People::where('id', $id)->first();
            if ($authorsPersonFound) {
                throw new ApiException("Cannot delete, Author is linked to a person.");
            }

            // Delete the Author.
            $authors->delete();

            

        }catch(\Exception $e){
            throw $e;
        }

    }


    
}

