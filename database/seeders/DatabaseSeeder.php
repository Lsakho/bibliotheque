<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Country;
use App\Models\Category;
use App\Models\People;
use App\Models\Image;
use Faker\Generator;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // $faker = app(Generator::class);
        //$authors = Author::factory()->count(5)->create();

       // Init faker if needed.
       $faker = app(Generator::class);

       // Create 100 countries.
       $countries = Country::factory()
                       ->count(100)
                       ->make()
                       ->each(function ($country) use ($faker) {
                           do {
                               $country->iso = $faker->countryCode();
                               $countryFound = Country::where('iso', $country->iso)->first();
                           } while($countryFound);
                           $country->save();
                       });
            

            $people = People::factory()->count(10)->make()
            ->each(function($people) use ($countries) {
                $people->country_id = $countries->random()->iso;
                $people->save();
            });

            //$authors = Author::factory()->count(10)->create();
            $authors = Author::factory()->count(10)->make()
            ->each(function($author) use ($countries) {
                $author->country_id = $countries->random()->iso;
                $author->save();
            });

            $categories = Category::factory()->count(10)->create();

            $books = Book::factory()->count(10)->make()
            ->each(function($book) use ($categories) {
                 $book->category_id = $categories->random()->id;
                
                $book->save();
            })
                        ->each(function ($book) use ($authors) {

                            $idAuthor = $authors->random()->id;
                            $isbnBook = $book->isbn;
                            $book->Authors()->attach([$idAuthor],['book_isbn' => $isbnBook]);

                        })
                        ->each(function ($book) use ($people) {

                            $idPeople = $people->random()->id;
                            $isbnBook = $book->isbn;
                            $book->People()->attach([$idPeople],['book_isbn' => $isbnBook]);

                        });
                //         $book = Book::find(1);
                // $image = new Image;
                // $book->image()->save($image);

                // $authors = Author::find(1);
                // $image = new Image;
                // $authors->images()->save($image);

           
            
            
            // $countries = Country::factory()->count(5)->create();

            // // Je crée 10 films et attache aléatoirement une catégorie à chaque film
            // $authors = Author::factory()->count(10)->make()
            //     ->each(function($author) use ($countries) {
            //         $author->country_id = $countries->random()->iso;
            //         $author->save();
            //     });

        // Je crée 10 films et attache aléatoirement une catégorie à chaque film
        
        


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        
    }
}
