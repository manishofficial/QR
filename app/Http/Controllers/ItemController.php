<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\OrderDetails;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{

    public function index()
    {
        $data['items'] = auth()->user()->items;
        return view('item.index', $data);
    }

    public function create()
    {
        $data['restaurants'] = auth()->user()->active_restaurants;
        $data['categories'] = auth()->user()->active_categories;

        $data['extend_message'] = '';

        $user = auth()->user();
        if ($user->type != 'admin') {
            $userPlan = isset($user->current_plans[0]) ? $user->current_plans[0] : '';
            $userItems = $user->items()->count();
            if (!$userPlan || $userItems >= $userPlan->item_limit) {
                $data['extend_message']=trans('layout.item_extends');
            }
        }

        return view('item.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            "restaurant_id" => "required",
            "category_id" => "required",
            "name" => "required",
            "price" => "required | numeric|gt:-1",
            "discount_to" => "in:everyone,premium",
            "discount" => "numeric|gt:-1",
            "discount_type" => "in:flat,percent",
            "status" => "required|in:active,inactive",
            'item_image' => 'image'
        ]);
        $user = auth()->user();
        if ($user->type != 'admin') {
            $userPlan = isset($user->current_plans[0]) ? $user->current_plans[0] : '';
            $userItems = $user->items()->count();
            if (!$userPlan || $userItems >= $userPlan->item_limit) {
                return redirect()->back()->withErrors(['msg' => trans('layout.item_extends')]);
            }
        }

        if ($request->hasFile('item_image')) {
            $file = $request->file('item_image');
            $imageName = time() . '.' . $file->extension();
            $file->move(public_path('/uploads'), $imageName);
            $request['image'] = $imageName;
        }

        $user->items()->create($request->all());

        return redirect()->route('item.index')->with('success', trans('layout.message.item_create'));

    }

    public function edit(Item $item)
    {
        $data['item'] = $item;
        $data['restaurants'] = auth()->user()->active_restaurants;
        $data['categories'] = auth()->user()->active_categories;
        return view('item.edit', $data);
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            "restaurant_id" => "required",
            "category_id" => "required",
            "name" => "required",
            "price" => "required | numeric|gt:-1",
            "discount_to" => "in:everyone,premium",
            "discount" => "numeric|gt:-1",
            "discount_type" => "in:flat,percent",
            "status" => "required|in:active,inactive",
            'item_image' => 'image'
        ]);

        if ($request->hasFile('item_image')) {

            $this->deleteItemImage($item);

            $file = $request->file('item_image');
            $imageName = time() . '.' . $file->extension();
            $file->move(public_path('/uploads'), $imageName);
            $request['image'] = $imageName;
        }

        $item->update($request->all());

        return redirect()->route('item.index')->with('success', trans('layout.message.item_update'));
    }


    public function destroy(Item $item)
    {
        $order_details = OrderDetails::where('item_id', $item->id)->first();
        if ($order_details) return redirect()->back()->withErrors(['msg' => trans('layout.message.item_not_delete')]);

        $this->deleteItemImage($item);

        $item->delete();
        return redirect()->back()->with('success', trans('layout.message.item_delete'));
    }

    function deleteItemImage(Item $item)
    {
        if ($item->image) {
            $fileN = public_path('uploads') . '/' . $item->image;
            if (File::exists($fileN))
                unlink($fileN);
        }
    }

}
