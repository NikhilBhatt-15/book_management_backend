<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;



class OrderController extends Controller
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

    public function buy(Request $request){
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->book_id = $request->book_id;
        $order->quantity = $request->quantity;
        $book = Book::findorfail($request->book_id);
        if($request->quantity > $book->quantity){
            return reponse(["message:","Transaction failed"],400);
        }
        $order->amount = $book->price*$request->quantity;
        $order->save();
        $book->quantity -= $request->quantity;
        $book->save();
        return response()->json($order);
    }

    public function getbook(){
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->get();
        $bookIds = $orders->pluck('book_id');
        $books = Book::whereIn('id', $bookIds)->get();

        $booksWithQuantity = $orders->map(function ($order) use ($books) {
            $book = $books->firstWhere('id', $order->book_id);
            if ($book) {
                return [
                    'book_id' => $book->id,
                    'book_name' => $book->name,
                    'book_author' => $book->author,
                    'quantity' => $order->quantity
                ];
            }
            return null;
        })->filter();
        return response()->json($booksWithQuantity);
    }
    public function getOrders(){
        $user = auth()->user();
        $orders = Order::where('user_id',$user->id)->get();
        return response()->json($orders);
    }
    public function getbooks(){
        $books = Book::all();
        return response()->json($books);
    }
    //
}
