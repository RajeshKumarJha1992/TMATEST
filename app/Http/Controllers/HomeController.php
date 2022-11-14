<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repo\HomeService;
use Illuminate\Validation\Validator;
class HomeController extends Controller
{

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function home(Request $request)
    {

        return view('home', ['key'=>"","searchResult"=>[]]);
    }

    public function books(Request $request)
    {
        return view('books', $request);
    }


    //Import XMl
    public function importXMLFile(Request $request){
        if ($request->input('action') == 'Upload') {
            $validated = $request->validate([
                'file' => 'bail|required|mimes:application/xml,xml|max:10000',
            ]);

            $uploadStatus=$this->homeService->importXML($request);
            if(!empty($uploadStatus)){
                return redirect()->route('books')->with('success', print_r($uploadStatus,true));
            }else{
                return redirect()->route('books')->with('fail', "Failed to upload");
            }
        }
        else{
            return redirect()->route('books')->with('fail','File Validation Failed');
        }

    }

    //BookList
    public function bookList(Request $request){
        $response=$this->homeService->bookList($request);
        return response()->json($response);
    }

    //Searching
    public function searchByAuthor(Request $request){
        if ($request->input('action') == 'Search') {
            $validated = $request->validate([
                'searchValue' => 'required',
            ]);

            $searchResult=$this->homeService->searchResult($request);
            if(count($searchResult) > 0){
                return view('home', ['key'=>$request->get('searchValue'),"searchResult"=>$searchResult]);
            }else{
                return redirect()->route('home')->with('fail', "No Books Availiable for Author : ".$request->get('searchValue'));
            }
        }
        else{
            return redirect()->route('home')->with('fail','Enter Any Name');
        }
    }
}
