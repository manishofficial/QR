<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\UserPlan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function planList(){
        $data['plans']=Plan::where('status','active')->where('id','!=',1)->get();
        return view('plans.index',$data);
    }
    public function index(){
        $data['plans']=Plan::where('id','!=',1)->get();
        return view('plans.plan_table',$data);
    }
    public function create(){
        return view('plans.create');
    }
    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'cost'=>'required|numeric|gt:-1',
            'recurring_type'=>'required|in:onetime,monthly,weekly,yearly',
            'table_limit'=>'required|numeric|gt:-1',
            'restaurant_limit'=>'required|numeric|gt:-1',
            'item_limit'=>'required|numeric|gt:-1',
        ]);
        Plan::create($request->all());

        return redirect()->route('plan.index');
    }
    public function edit(Plan $plan){
        $data['plan'] = $plan;
        if($plan->id==1) return redirect()->route('plan.index')->withErrors(['msg'=>trans('layout.message.invalid_request')]);

        return view('plans.edit',$data);
    }
    public function update(Request $request, Plan $plan){
        $request->validate([
            'title'=>'required',
            'cost'=>'required|numeric|gt:-1',
            'recurring_type'=>'required|in:onetime,monthly,weekly,yearly',
            'table_limit'=>'required|numeric|gt:-1',
            'restaurant_limit'=>'required|numeric|gt:-1',
            'item_limit'=>'required|numeric|gt:-1',
        ]);
        if($plan->id==1) return redirect()->route('plan.index')->withErrors(['msg'=>trans('layout.message.invalid_request')]);

        $plan->update($request->all());

        return redirect()->route('plan.index')->with('success', trans('layout.message.plan_update'));
    }
    public function destroy(Plan $plan){
        if($plan->id==1) return redirect()->route('plan.index')->withErrors(['msg'=>trans('layout.message.invalid_request')]);

        $user_plan=UserPlan::where('plan_id',$plan->id)->first();
        if($user_plan) return redirect()->back()->withErrors(['msg'=>trans('layout.message.plan_not_delete')]);

        $plan->delete();
        return redirect()->back()->with('success', trans('layout.message.plan_delete_msg'));
    }
}
