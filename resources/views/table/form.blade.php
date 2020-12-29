@csrf
<div>
    <section>
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.restaurant')}}*</label>
                    <select name="restaurant_id" class="form-control">
                        @foreach($restaurants as $restaurant)
                            <option
                                {{isset($table) && $table->restaurant_id==$restaurant->id?'selected':''}} value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.name')}}*</label>
                    <input value="{{old('name')?old('name'):(isset($table)?$table->name:'')}}" type="text" name="name"
                           class="form-control" placeholder="Ex: Table-1" required>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.no_of_capacity')}}*</label>
                    <input
                        value="{{old('no_of_capacity')?old('no_of_capacity'):(isset($table)?$table->no_of_capacity:'')}}"
                        type="number" name="no_of_capacity"
                        class="form-control" placeholder="Ex: 6" required>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.position')}}*</label>
                    <input
                        value="{{old('position')?old('position'):(isset($table)?$table->position:'')}}"
                        type="text" name="position"
                        class="form-control" placeholder="Ex: right-corner" required>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.status')}}*</label>
                    <select name="status" class="form-control">
                        <option {{isset($table) && $table->status=='active'?'selected':''}}
                            value="active">{{trans('layout.active')}}</option>
                        <option {{isset($table) && $table->status=='inactive'?'selected':''}}
                            value="inactive">{{trans('layout.inactive')}}</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

</div>
