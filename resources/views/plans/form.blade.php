@csrf
<div>
    <section>
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.title')}}*</label>
                    <input value="{{old('title')?old('title'):(isset($plan)?$plan->title:'')}}" type="text" name="title"
                           class="form-control" placeholder="Ex: Basic" required>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.recurring_type')}}*</label>
                    <select name="recurring_type" class="form-control">
                        <option
                            {{isset($plan) && $plan->recurring_type=='onetime'?'selected':''}} value="onetime">{{trans('layout.onetime')}}</option>
                        <option
                            {{isset($plan) && $plan->recurring_type=='weekly'?'selected':''}} value="weekly">{{trans('layout.weekly')}}</option>
                        <option
                            {{isset($plan) && $plan->recurring_type=='monthly'?'selected':''}} value="monthly">{{trans('layout.monthly')}}</option>
                        <option
                            {{isset($plan) && $plan->recurring_type=='yearly'?'selected':''}} value="yearly">{{trans('layout.yearly')}}</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.status')}}*</label>
                    <select name="status" class="form-control">
                        <option
                            {{isset($plan) && $plan->status=='active'?'selected':''}} value="active">{{trans('layout.active')}}</option>
                        <option
                            {{isset($plan) && $plan->status=='inactive'?'selected':''}} value="inactive">{{trans('layout.inactive')}}</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.cost')}}*</label>
                    <input value="{{old('cost')?old('cost'):(isset($plan)?$plan->cost:'')}}" min="0" step="0.001" type="number" name="cost"
                           class="form-control" placeholder="Ex: 200" required>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.table_limit')}}*</label>
                    <input value="{{old('table_limit')?old('table_limit'):(isset($plan)?$plan->table_limit:'')}}"
                           type="number" name="table_limit"
                           class="form-control" placeholder="Ex: 5" required min="0" step="0.001">
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.restaurant_limit')}}*</label>
                    <input
                        value="{{old('restaurant_limit')?old('restaurant_limit'):(isset($plan)?$plan->restaurant_limit:'')}}"
                        type="number" name="restaurant_limit"
                        class="form-control" placeholder="Ex: 5" required min="0" step="0.001">
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.item_limit')}}*</label>
                    <input value="{{old('item_limit')?old('item_limit'):(isset($plan)?$plan->item_limit:'')}}"
                           type="number" name="item_limit"
                           class="form-control" placeholder="Ex: 5" required>
                </div>
            </div>

        </div>
    </section>

</div>
