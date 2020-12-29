<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RestaurantController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        if ($user->type == 'admin') {
            $data['restaurants'] = Restaurant::all();
        } else {
            $data['restaurants'] = auth()->user()->restaurants;
        }
        return view('restaurant.index', $data);
    }


    public function create()
    {
        $user = auth()->user();
        if ($user->type == 'admin') {
            return redirect()->back()->withErrors(['msg' => trans('layout.message.invalid_request')]);
        }

        $data['extend_message']='';
        $userPlan = isset($user->current_plans[0]) ? $user->current_plans[0] : '';
        $userRestaurants = $user->restaurants()->count();
        if (!$userPlan || $userRestaurants >= $userPlan->restaurant_limit) {
            $data['extend_message']=trans('layout.restaurant_extends');
        }


        return view('restaurant.create',$data);
    }


    public function store(Request $request)
    {
        if (auth()->user()->type == 'admin') return redirect()->back()->withErrors(['msg' => trans('layout.message.invalid_request')]);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'profile_file' => 'image',
            'cover_file' => 'image',
        ]);

        $user = auth()->user();
        if ($user->type != 'admin') {
            $userPlan = isset($user->current_plans[0])?$user->current_plans[0]:'';
            $userRestaurants = $user->restaurants()->count();
            if (!$userPlan || $userRestaurants >= $userPlan->restaurant_limit) {
                return redirect()->back()->withErrors(['msg' => trans('layout.restaurant_extends')]);
            }
        }



        if ($request->hasFile('profile_file')) {
            $file = $request->file('profile_file');
            $imageName = time() . 'p.' . $file->extension();
            $file->move(public_path('/uploads'), $imageName);
            $request['profile_image'] = $imageName;
        }

        if ($request->hasFile('cover_file')) {
            $file = $request->file('cover_file');
            $imageName = time() . 'c.' . $file->extension();
            $file->move(public_path('/uploads'), $imageName);
            $request['cover_image'] = $imageName;
        }
        $request['slug'] = Str::slug($request->name);
        $request['description'] = clean($request->description);
        auth()->user()->restaurants()->create($request->all());

        return redirect()->route('restaurant.index')->with('success', trans('layout.message.restaurant_create'));

    }


    public function edit(Restaurant $restaurant)
    {
        $data['restaurant'] = $restaurant;
        return view('restaurant.edit', $data);
    }

    public function show(Restaurant $restaurant){

    }


    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'profile_file' => 'image',
            'cover_file' => 'image',
        ]);



        if ($request->hasFile('profile_file')) {

            if ($restaurant->profile_image) {
                $fileN = public_path('uploads') . '/' . $restaurant->profile_image;
                if (File::exists($fileN))
                    unlink($fileN);
            }

            $file = $request->file('profile_file');
            $imageName = time() . 'p.' . $file->extension();
            $file->move(public_path('/uploads'), $imageName);
            $request['profile_image'] = $imageName;
        }

        if ($request->hasFile('cover_file')) {
            if ($restaurant->cover_image) {
                $fileN = public_path('uploads') . '/' . $restaurant->cover_image;
                if (File::exists($fileN))
                    unlink($fileN);
            }
            $file = $request->file('cover_file');
            $imageName = time() . 'c.' . $file->extension();
            $file->move(public_path('/uploads'), $imageName);
            $request['cover_image'] = $imageName;
        }
        $request['slug'] = Str::slug($request->name);
        $request['description'] = clean($request->description);

        $restaurant->update($request->all());

        return redirect()->route('restaurant.index')->with('success', trans('layout.message.restaurant_update'));
    }


    public function destroy(Restaurant $restaurant)
    {
        $item = Item::where('restaurant_id', $restaurant->id)->first();
        if ($item) return redirect()->back()->withErrors(['msg' => trans('layout.message.restaurant_not_delete')]);

        $this->deleteRestaurantImage($restaurant);

        $restaurant->delete();
        return redirect()->back()->with('success', trans('layout.message.restaurant_delete'));
    }

    function deleteRestaurantImage(Restaurant $restaurant)
    {
        if ($restaurant->profile_image) {
            $fileN = public_path('uploads') . '/' . $restaurant->profile_image;
            if (File::exists($fileN))
                unlink($fileN);
        }

        if ($restaurant->cover_image) {
            $fileN = public_path('uploads') . '/' . $restaurant->cover_image;
            if (File::exists($fileN))
                unlink($fileN);
        }

    }

    public function showQr()
    {
        //return view('');
        $data['qr'] = $qr = QrCode::format('png')->generate(request()->fullUrl());

        //    return response($qr)->header('Content-type','image/png');

        return view('showQR', $data);
    }

}
