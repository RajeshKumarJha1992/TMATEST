<?php

namespace App\Repo;

use App\Models\author;
use App\Models\books;
use Illuminate\Http\Request;

class HomeService
{

    public function findAuthorId($authorName)
    {
        $authorDetails = author::select('id')
            ->where('name', $authorName)
            ->first();
        if ($authorDetails != Null) {
            return $authorDetails->id;
        } else {
            return null;
        }
    }

    public function findBookId($authorId, $bookName)
    {
        $bookDetails = books::select('id')
            ->where('name', $bookName)
            ->where('author_id', trim($authorId))
            ->first();
        if ($bookDetails != Null) {
            return $bookDetails->id;
        } else {
            return null;
        }
    }

    public function importXML(Request $request)
    {
        $countOfAuthor = 0;
        $countOfBooks = 0;
        $file = $request->file('file');
        $inputFileName = $file->getRealPath();
        $xmlString = file_get_contents($inputFileName);
        $xmlObject = simplexml_load_string($xmlString);
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);
        if (!empty($phpArray)) {
            foreach ($phpArray as $singleArray) {
                foreach ($singleArray as $data) {
                    if (!empty($data['author'])) {
                        $authorExists = $this->findAuthorId($data['author']);
                    } else {
                        $authorExists = null;
                    }
                    if ($authorExists == Null && !empty($data['author'])) {
                        $newAuthor = new author();
                        $newAuthor->name = $data['author'];
                        $newAuthor->status = "active";
                        $newAuthor->save();
                        $authorExists = $newAuthor->id;
                        $countOfAuthor++;
                        if (!empty($data['name'])) {
                            $bookExists = $this->findBookId($authorExists, $data['name']);
                        } else {
                            $bookExists = null;
                        }
                        if (!empty($data['name']) && $bookExists == null) {
                            $newBook = new books();
                            $newBook->author_id = $authorExists;
                            $newBook->name = $data['name'];
                            $newBook->status = "active";
                            $newBook->save();
                            $bookExists = $newBook->id;
                            $countOfBooks++;
                        } else {
                            if (!empty($data['name'])) {
                                $newBookToUpdate = books::find($bookExists);
                                $newBookToUpdate->updated_at = date('Y-m-d h:m:s');
                                $newBookToUpdate->update();
                            }
                        }
                    } else {
                        if (!empty($data['name'])) {
                            $bookExists = $this->findBookId($authorExists, $data['name']);
                        } else {
                            $bookExists = null;
                        }

                        if ($bookExists == Null && !empty($data['name'])) {
                            $newBook = new books();
                            $newBook->author_id = $authorExists;
                            $newBook->name = $data['name'];
                            $newBook->status = "active";
                            $newBook->save();
                            $bookExists = $newBook->id;
                            $countOfBooks++;
                        } else {
                            if (!empty($data['name'])) {
                                $newBookToUpdate = books::find($bookExists);
                                $newBookToUpdate->updated_at = date('Y-m-d h:m:s');
                                $newBookToUpdate->update();
                            }
                        }
                        if (!empty($data['author'])) {
                            $authorToUpdate = author::find($authorExists);
                            $authorToUpdate->updated_at = date('Y-m-d h:m:s');
                            $authorToUpdate->update();
                        }
                    }
                }
            }
        }

        return array(
            "countOfAuthor" => $countOfAuthor,
            "countOfBooks" => $countOfBooks
        );
    }

    //Get the List Of Books
    public function bookList(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $bookDetails = author::select('books.id', 'books.name', 'authors.name as author_id')
            ->leftJoin('books', 'authors.id', 'books.author_id')
            ->where('authors.status', "active")
            ->where(function ($query) use ($searchValue) {
                if (!empty($searchValue)) {
                    $query->where('books.name', 'LIKE', '%' . $searchValue . '%');
                    $query->orWhere('authors.name', 'LIKE', '%' . $searchValue . '%');
                }
            })
            ->orderBy($columnName, $columnSortOrder);


        if ($bookDetails != null) {
            $totalCount = $bookDetails->count();
        } else {
            $totalCount = 0;
        }
        $data_arr = [];
        if ($bookDetails != null) {
            $bookData = $bookDetails->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            $bookData = [];
        }

        $i = 1;
        foreach ($bookData as $singleData) {
            $data_arr[] = array(
                "id" => $i++,
                "author_id" => $singleData['author_id'],
                "name" => (empty($singleData['name'])) ? "NA" : $singleData['name']
            );
        }
        return array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalCount,
            "iTotalDisplayRecords" => $totalCount,
            "aaData" => $data_arr
        );
    }

    //Searcing
    public function searchResult(Request $request){
        return books::select('books.id', 'books.name', 'a.name as author_id')
            ->join('authors as a', 'a.id', 'books.author_id')
            ->where('books.status', "active")
            ->where('a.name', $request->get('searchValue'))
            ->get();
    }
}
