<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Book;
use App\Models\User;
use App\Models\RentRequest;
use App\Models\Category;




class RentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function rent(Request $request){
        $rentRequest = RentRequest::where('user_id',auth()->user()->id)->where('book_id',$request->book_id)->first();
        if($rentRequest){
            if(!$rentRequest->returned)
            return response(['message'=>'already rented']);
        }
        else{
            $rentRequest = new RentRequest();
            $rentRequest->user_id = auth()->user()->id;
            $rentRequest->book_id = $request->book_id;
            $rentRequest->status="pending";
            $rentRequest->returned=0;
            
        }
        $rentRequest->save();
        return response()->json($rentRequest);
    }

    public function rentStatus(Request $request){
        $rentStatus  = RentRequest::find($request->id);
        return response()->json($rentStatus->status);
    }

    public function rentRequests(){
        $requests = RentRequest::where('user_id',auth()->user()->id)->get();
        return response()->json($requests);
    }
    public function getCategories(){
        return Category::all();
    }
    public function removeRequest(Request $request){
        $rentRequest = RentRequest::find($request->request_id);
        $rentRequest->delete();
        return response(['message'=>'request removed succesffuly']);
    }
    public function returnBook(Request $request){
        $rentRequest = RentRequest::where('user_id',auth()->user()->id)->where('book_id',$request->book_id)->first();
        $rentRequest->returned = 1;
        $rentRequest->save();
        return $rentRequest;
    }
    //
}
