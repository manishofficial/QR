<ul class="metismenu sidebar-height" id="menu">
    @foreach($rest_categories as $cat)
        <li><a data-id="{{$cat->id}}" class="ai-icon item-category" href="javascript:void(0)" aria-expanded="false">
                <i class="flaticon-381-networking"></i>
                <span class="nav-text">{{$cat->name}}</span>
            </a>
        </li>
    @endforeach
    @if(!auth()->check())
        <li><a class="ai-icon" href="{{route('registration',['type'=>'customer'])}}"
               aria-expanded="false">
                <i class="flaticon-381-add"></i>
                <span class="nav-text">{{trans('layout.signup')}}</span>
            </a>
        </li>
    @endif
</ul>

<div class="copyright mt-4">
    <p><strong>{{json_decode(get_settings('site_setting'))->name}} </strong> © {{date('Y')}} All Rights Reserved</p>
</div>
