<ul class="metismenu sidebar-height" id="menu">
    @can('restaurant_manage')
        <li><a class="ai-icon" href="{{route('dashboard')}}" aria-expanded="false">
                <i class="flaticon-381-networking"></i>
                <span class="nav-text">{{trans('layout.dashboard')}}</span>
            </a>
        </li>
    @endcan
    @can('restaurant_manage')
        <li class="{{isSidebarActive('restaurant*')}} active-no-child"><a class="ai-icon"
                                                                          href="{{route('restaurant.index')}}"
                                                                          aria-expanded="false">
                <i class="flaticon-381-television"></i>
                <span class="nav-text">{{trans('layout.restaurant')}}</span>
            </a>
        </li>
    @endcan

    @can('category_manage')
        <li class="{{isSidebarActive('category*')}} active-no-child"><a class="ai-icon"
                                                                        href="{{route('category.index')}}"
                                                                        aria-expanded="false">
                <i class="flaticon-381-television"></i>
                <span class="nav-text">{{trans('layout.category')}}</span>
            </a>
        </li>
    @endcan
    @can('item_manage')
        <li class="{{isSidebarActive('item*')}} active-no-child"><a class="ai-icon" href="{{route('item.index')}}"
                                                                    aria-expanded="false">
                <i class="flaticon-381-network"></i>
                <span class="nav-text">{{trans('layout.items')}}</span>
            </a>
        </li>
    @endcan
    @can('order_list')
        <li class="{{isSidebarActive('order*')}} active-no-child"><a class="ai-icon" href="{{route('order.index')}}"
                                                                     aria-expanded="false">
                <i class="flaticon-381-notepad "></i>
                <span class="nav-text">{{trans('layout.orders')}}</span>
            </a>

        </li>
    @endcan

    @can('qr_manage')
        <li class="{{isSidebarActive('qr*')}} active-no-child"><a class="ai-icon" href="{{route('qr.maker')}}"
                                                                  aria-expanded="false">
                <i class="flaticon-381-notepad "></i>
                <span class="nav-text">{{trans('layout.qr_maker')}}</span>
            </a>

        </li>

    @endcan
    @can('billing')
        <li><a class="ai-icon" href="{{route('plan.list')}}" aria-expanded="false">
                <i class="flaticon-381-network "></i>
                <span class="nav-text">{{trans('layout.billings')}}</span>
            </a>

        </li>

    @endcan
    @can('plan_manage')
        <li><a class="ai-icon" href="{{route('plan.index')}}" aria-expanded="false">
                <i class="flaticon-381-network "></i>
                <span class="nav-text">{{trans('layout.plan')}}</span>
            </a>

        </li>
    @endcan
    @can('user_plan_change')
        <li><a class="ai-icon" href="{{route('user.plan')}}" aria-expanded="false">
                <i class="flaticon-381-network "></i>
                <span class="nav-text">{{trans('layout.user_plan')}}</span>
            </a>

        </li>

    @endcan
    @can('table_manage')
        <li><a class="ai-icon" href="{{route('table.index')}}" aria-expanded="false">
                <i class="flaticon-381-layer-1 "></i>
                <span class="nav-text">{{trans('layout.table')}}</span>
            </a>

        </li>
    @endcan
    {{--    @can('restaurant_manage')--}}
    <li><a href="{{route('settings')}}" class="ai-icon" aria-expanded="false">
            <i class="flaticon-381-settings-2"></i>
            <span class="nav-text">{{trans('layout.settings')}}</span>
        </a>
    </li>
    {{--    @endcan--}}
</ul>


<div class="copyright">
    <p><strong>{{json_decode(get_settings('site_setting'))->name}} </strong> © {{date('Y')}} {{trans('layout.all_right_reserved')}}</p>
</div>
