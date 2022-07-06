<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $books = $this->isbn;
        return [

            'isbn' =>$this->isbn,
            'title' =>$this->title,
            'summary' =>$this->summary,
            'etat' =>$this->etat,
            'statut' =>$this->statut,
            'categories' => Category::find($this->category_id, 'name'),
            'author' => Author::whereHas('books', function ($livre) use ($books){
                $livre->where('book_isbn', $books);
            })->get('name')
            
        ];
    }
}
