<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('frontend.auth.login');
        }

        $wishlists = Wishlist::with(['product.productTranslation','product.baseImage'=> function ($query){
            $query->where('type','base');
        }])->get();

        return view('frontend.pages.wishlist',compact('wishlists'));
    }

    public function addToWishlist(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $wishlist = new Wishlist();
                $user_id = Auth::user()->id;

                $unique_check = Wishlist::where('user_id',$user_id)
                                        ->where('product_id',$request->product_id)
                                        ->where('category_id',$request->category_id)
                                        ->exists();
                if(!$unique_check){
                    $wishlist->user_id = $user_id;
                    $wishlist->product_id = $request->product_id;
                    $wishlist->category_id = $request->category_id;
                    $wishlist->save();
                }
                $wishlist_count = Wishlist::count();
                return response()->json(['type'=>'success','message'=>'Successfully added in wishlist','wishlist_count'=>$wishlist_count]);
            }else {
                $wishlist_count = Wishlist::count();
                return response()->json(['type'=>'not_authorized','message'=>'Please Login First','wishlist_count'=>$wishlist_count]);
            }
        }
    }

    public function removeToWishlist(Request $request)
    {
        if ($request->ajax()) {
            Wishlist::find($request->wishlist_id)->delete();
            $wishlist_count = Wishlist::count();
            return response()->json(['type'=>'success','message'=>'Successfully Deleted','wishlist_count'=>$wishlist_count]);
        }
    }
}
