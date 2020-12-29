@csrf
<div>
    <section>
        <div class="row">
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.restaurant')}}*</label>
                    <select name="restaurant_id" class="form-control">
                        @foreach($restaurants as $restaurant)
                            <option {{isset($item) && $item->restaurant_id==$restaurant->id?'selected':''}} value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.category')}}*</label>
                    <div class="pull-right"><a class="btn-info btn btn-xs mb-1" href="{{route('category.create')}}">New</a></div>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option {{isset($item) && $item->category_id==$category->id?'selected':''}} value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.item_name')}}*</label>
                    <input value="{{old('name')?old('name'):(isset($item)?$item->name:'')}}" type="text" name="name"
                           class="form-control" placeholder="Ex: Burger" required>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.item_details')}}*</label>
                    <input value="{{old('details')?old('details'):(isset($item)?$item->details:'')}}" type="text" name="details"
                           class="form-control" placeholder="Ex: A great burger" required>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.price')}}*</label>
                    <input value="{{old('price')?old('price'):(isset($item)?$item->price:'')}}" min="0" step="0.001" name="price"
                           class="form-control" placeholder="Ex: 20" required>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.discount_to')}}*</label>
                    <select name="discount_to" class="form-control">
                        <option {{isset($item) && $item->discount_to=='everyone'?'selected':''}} value="everyone">Everyone</option>
                        <option {{isset($item) && $item->discount_to=='premium'?'selected':''}} value="premium">Premium</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.discount')}}*</label>
                    <input value="{{old('discount')?old('discount'):(isset($item)?$item->discount:'')}}" min="0" step="0.001" type="number" name="discount"
                           class="form-control" placeholder="Ex: 5" required>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.discount_type')}}*</label>
                    <select name="discount_type" class="form-control">
                        <option {{isset($item) && $item->discount_type=='flat'?'selected':''}} value="flat">Flat</option>
                        <option {{isset($item) && $item->discount_type=='percent'?'selected':''}} value="percent">Percent</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <label class="text-label">{{trans('layout.item_image')}}</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input name="item_image" type="file" class="custom-file-input">
                        <label class="custom-file-label">{{trans('layout.choose')}}</label>

                    </div>

                </div>
            </div>


            <div class="col-lg-6 mb-2">
                <div class="form-group">
                    <label class="text-label">{{trans('layout.status')}}*</label>
                    <select name="status" class="form-control">
                        <option {{isset($item) && $item->status=='active'?'selected':''}} value="active">Active</option>
                        <option {{isset($item) && $item->status=='inactive'?'selected':''}} value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

        </div>
    </section>

</div>
