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


class CountryService {

    public function save(Request $request, $iso = null){
        try{

            $validatorRules = [
                'iso' => 'nullable|string|max:3',
                'name' => 'required|string|max:50',
                'description' => 'nullable|string'
                ];
        
                $validator = Validator::make($request->all(),$validatorRules);
        
                if ($validator->fails()){
                    throw (new ValidateException(
                        $validator->errors()
                    ));
                }

        // $countries = Country::find($request->input('iso'));

        if($iso){
            $country = Country::find($iso);
            
            if (!$country){
                throw new ApiException(
                    "Country not found.",
                        404
                    );
                 }
        }
        else{
            $country = new Country();
        }

        if(!$iso){
            $countryFound = Country::where('iso', $request->input('iso'))->first();

            if($countryFound){
                throw new ApiException("Cannot create country, because a same country already exists");
            }
            $country->iso = $request->input('iso');
        }
        $country->name = $request->input('name');
        $country->description = $request->input('description');

        

        $country->save();
        // die($country);
        return $country;


        }catch(\Exception $e) {
            throw $e;
        }
    }

  

    public function delete($iso) {

        try {

            // Create or update country.
            $country = Country::find($iso);

            // Check if country.
            if (!$country) {
                throw new ApiException("No country found");
            }

            // Check if country is linked to an author.
            $countryAuthorFound = Author::where('country_id', $iso)->first();
            if ($countryAuthorFound) {
                throw new ApiException("Cannot delete, country is linked to an author.");
            }

            // Check if country is linked to an author.
            $countryPersonFound = People::where('country_id', $iso)->first();
            if ($countryPersonFound) {
                throw new ApiException("Cannot delete, country is linked to a person.");
            }

            // Delete the country.
            $country->delete();

            

        }catch(\Exception $e){
            throw $e;
        }

    }


    
}