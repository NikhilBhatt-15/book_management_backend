<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\RentRequest;
use App\Models\RentStatus;
use App\Models\Order;

class AdminController extends Controller
{
    /*
     *
     * Create a new controller instance.
     *
     * @return void
     *
     * */

    public function __construct()
    {
        // $this->middleware('auth:admin');
    }
    
    public function addCategory(Request $request){
        $category = new Category();
        $category->title = $request->title;
        $category->save();
        return response()->json($category,201);
    }

    public function deleteCategory(Request $request){
        $category = Category::findorfail($request->id);
        $category->delete();
        $books = Book::all();
        Redis::set("books",$books);
        return response()->json(['message'=>'deleted']);
    }
    public function modifyCategory(Request $request){
        $category = Category::findorfail($request->id);
        $category->title = $request->title;
        $category->save();
        $books = Book::all();
        Redis::set("books",$books);
        return response()->json($category);
    }


    public function addBook(Request $request){
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->price = $request->price;
        $book->rent_price = $request->rent_price;
        $book->category_id = $request->category_id;
        $book->quantity = $request->quantity;
        $book->save();
        $books = Book::all();
        Redis::set("books",$books);
        return response()->json($book,201);
    }

    public function deleteBook(Request $request){
        $book = Book::findorfail($request->id);
        $book->delete();
        $books = Book::all();
        Redis::set("books",$books);
        return response()->json(['message'=>'sucessfully deleted ']);
    }

    public function modifyBook(Request $request){
        $book = Book::findorfail($request->book_id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->price = $request->price;
        $book->rent_price = $request->rent_price;
        $book->category_id = $request->category_id;
        $book->quantity = $request->quantity;
        $book->save();
        $books = Book::all();
        Redis::set("books",$books);
        return response()->json($book);
    }

    public function books(){
        $books = Book::all();
        Redis::set("books",$books);
        return response()->json($books);
    }
    public function categories(){
        return response()->json(Category::all());
    }

    public function users(){
        $users = User::all();
        return response()->json($users);
    }

    public function removeUser(Request $request){
        $user = User::findorfail($request->user_id);
        $user->delete();

        return response()->json(['message'=>'sucessfully deleted']);
    }
    public function getbook(Request $request){
        $books = Book::where('category_id',($request->category_id))->get();
        
        return response()->json($books);
    }

    public function getRequests(){
        $rentRequests = RentRequest::all();
        return response()->json($rentRequests);
    }
    //
    public function getOrders(){
        $orders = Order::all();
        return response()->json($orders);
    }
    public function removeRequest(Request $request){
        $rentRequest = RentRequest::find($request->request_id);
        $rentRequest->delete();
        return response()->json(['message'=>'removed succesfully']);
    }
    public function handleRequest(Request $request){
        $rentRequest = RentRequest::findorfail($request->rent_request_id);
        $rentRequest->status = $request->status;
        if($rentRequest->status == 'approved'){
            // reduced book quantity by 1
        }
        $rentRequest->save();
        return response()->json(['message'=>$rentRequest->status]);
    }

}
