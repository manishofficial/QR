<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{
    public function index(){
        return view('front.index');
    }

    public function show($slug,Request $request)
    {
        // dd($slug);
        $data['restaurant']=$restaurant=Restaurant::where('slug',$slug)->where('id',$request->id)->first();
        if(!$restaurant) return abort(404);

        $rest_categories=[];
        foreach ($restaurant->items as $item){
            if(!in_array($item->category,$rest_categories)){
                $rest_categories[]=$item->category;
            }
        }
        $data['rest_categories']=$rest_categories;

        $data['categories']=Item::with('category')->where('restaurant_id',$restaurant->id)->get()->groupBy(function ($item,$key){
            return $item->category->name;
        });
      //  dd($data['categories']);

        $data['tables']=$restaurant->tables;

        return view('restaurant.show_restaurant',$data);
    }

    public function setLocale($type){
        $availableLang=get_available_languages();

        if(!in_array($type,$availableLang)) abort(400);

        session()->put('locale', $type);

       // dd(session()->get('locale'));
        return redirect()->back();
    }
}
