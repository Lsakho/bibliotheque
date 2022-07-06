<?php


namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidateException;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;


class CategoryService {

    public function save(Request $request, $id = null){
        try{

            $validatorRules = [
                'name' => 'required|string|max:50',
                'description' => 'nullable|string'
                ];
        
                $validator = Validator::make($request->all(),$validatorRules);
        
                if ($validator->fails()){
                    throw (new ValidateException(
                        $validator->errors()
                    ));
                }

        // $countries = Category::find($request->input('id'));

        if($id){
            $category = Category::find($id);
            
            if (!$category){
                throw new ApiException(
                    "Category not found.",
                        404
                    );
                 }
        }
        else{
            $category = new Category();
        }

        if(!$id){
            $categoryFound = Category::where('id', $request->input('id'))->first();

            if($categoryFound){
                throw new ApiException("Cannot create Category, because a same Category already exists");
            }
            $category->id = $request->input('id');
        }
        $category->name = $request->input('name');
        $category->description = $request->input('description');

        

        $category->save();
        // die($category);
        return $category;


        }catch(\Exception $e) {
            throw $e;
        }
    }

  

    public function delete($id) {

        try {

            // Create or update Category.
            $category = Category::find($id);

            // Check if Category.
            if (!$category) {
                throw new ApiException("No Category found");
            }

            // Check if Category is linked to an author.
            $categoryAuthorFound = Author::where('Category_id', $id)->first();
            if ($categoryAuthorFound) {
                throw new ApiException("Cannot delete, Category is linked to an author.");
            }

            // Check if Category is linked to an author.
            $categoryPersonFound = People::where('Category_id', $id)->first();
            if ($categoryPersonFound) {
                throw new ApiException("Cannot delete, Category is linked to a person.");
            }

            // Delete the Category.
            $category->delete();

            

        }catch(\Exception $e){
            throw $e;
        }

    }


    
}