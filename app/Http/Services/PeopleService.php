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


class PeopleService {

    public function personnes(Request $request, $id = null){
        try{

            $validatorRules = [
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:50',
                'birthdate' => 'required|date_format:Y-m-d',
                'address' => 'required|string|max:50',
                'zip' => 'required|string|max:50',
                'city' => 'required|string|max:20',
                'phone' => 'required|string|max:50',
                'email' => 'required|string|max:50',
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
        $people = null;
        // $countries = People::find($request->input('id'));

        if($id){
            $people = People::find($id);
            
            if (!$people){
                throw new ApiException(
                    "People not found.",
                        404
                    );
                 }
        }
        else{
            $people = new People();
        }

        if(!$id){
            $peopleFound = People::where('id', $request->input('id'))->first();

            if($peopleFound){
                throw new ApiException("Cannot create People, because a same People already exists");
            }
            $people->id = $request->input('id');
        }

     
        $people->firstname = $request->input('firstname');
        $people->lastname = $request->input('lastname');
        $people->birthdate = $request->input('birthdate');
        $people->address = $request->input('address');
        $people->zip = $request->input('zip');
        $people->city = $request->input('city');
        $people->phone = $request->input('phone');
        $people->email = $request->input('email');
        $people->country_id = $request->input('country_id');

        

        $people->save();
        // die($people);
        return $people;


        }catch(\Exception $e) {
            throw $e;
        }
    }

  

    public function delete($id) {

        try {

            // Create or update People.
            $people = People::find($id);

            // Check if People.
            if (!$people) {
                throw new ApiException("No People found");
            }

            // Check if People is linked to an People.
            $peopleBookFound = Book::where('id', $id)->first();
            if ($peoplePeopleFound) {
                throw new ApiException("Cannot delete, People is linked to an People.");
            }

            // Check if People is linked to an People.
            $peoplecountryFound = Country::where('id', $id)->first();
            if ($peoplePersonFound) {
                throw new ApiException("Cannot delete, People is linked to a person.");
            }

            // Delete the People.
            $people->delete();

            

        }catch(\Exception $e){
            throw $e;
        }

    }


    
}

