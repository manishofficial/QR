<?php

namespace App\Http\Controllers;

use App\Models\UserPlan;
use Illuminate\Http\Request;

class UserPlanController extends Controller
{
    public function index(){
        $data['userPlans']=UserPlan::where('plan_id','!=',1)->orderBy('created_at','desc')->get();
        return view('plans.user_plan',$data);
    }

    public function status_change(Request $request){
        if ($request->status=='approved') {
            $id=$request->id;
            $userPlan=UserPlan::find($id);

            if(!$userPlan) abort(404);

            UserPlan::where(['user_id' => $userPlan->user_id, 'is_current' => 'yes'])->update(['is_current' => 'no']);
            $userPlan->status = 'approved';
            $userPlan->is_current = 'yes';
            $userPlan->save();



            notification('plan',$userPlan->id,$userPlan->user_id,"Your plan has been approved");

            return redirect()->back()->with('success', trans('layout.message.userplan_approve_success'));
        }
        elseif($request->status=='rejected') {
            $id=$request->id;
            $userPlan=UserPlan::find($id);
            $userPlan->status = 'rejected';
            $userPlan->is_current = 'no';
            $userPlan->save();
            notification('plan',$userPlan->id,$userPlan->user_id,"Your plan has been rejected");

            return redirect()->back()->with('success', trans('layout.message.userplan_reject_success'));
        }
        elseif ($request->status='pending'){
            $id=$request->id;
            $userPlan=UserPlan::find($id);
            $userPlan->status = 'pending';
            $userPlan->is_current = 'no';
            $userPlan->save();
            notification('plan',$userPlan->id,$userPlan->user_id,"Your plan has been changed to pending");

            return redirect()->back()->with('success', trans('layout.message.userplan_status_change_msg'));
        }
    }
}
