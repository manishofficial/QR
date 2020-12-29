@extends('layouts.dashboard')

@section('title',trans('layout.restaurant').' | '.$restaurant->name)

@section('css')
    <link href="{{asset('vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        .dropdown.bootstrap-select.swal2-select {
            display: none !important;
        }
    </style>
@endsection

@section('main-content')
    <div id="restaurant-section">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{$restaurant->name}}</h2>
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        @if($restaurant->cover_image)
                            <div class="photo-content">
                                <div class="cover-wrapper">
                                    <img class="cover-img" src="{{asset('uploads/'.$restaurant->cover_image)}}" alt="">
                                </div>
                            </div>
                        @endif
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img src="{{asset('uploads/'.$restaurant->profile_image)}}"
                                     class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="profile-details flex-row d-flex flex-wrap">
                                @if($restaurant->location)
                                    <div class="flex-1 profile-name px-3 pt-2">
                                        <h4 class="text-muted mb-0">{{$restaurant->location}}</h4>
                                        <p>{{trans('layout.location')}}</p>
                                    </div>
                                @endif
                                @if($restaurant->email)
                                    <div class="flex-1 profile-email px-2 pt-2">
                                        <h4 class="text-muted mb-0">{{$restaurant->email}}</h4>
                                        <p>{{trans('layout.email')}}</p>
                                    </div>
                                @endif
                                @if($restaurant->phone_number)
                                    <div class="flex-1  profile-email px-2 pt-2">
                                        <h4 class="text-muted mb-0">{{$restaurant->phone_number}}</h4>
                                        <p>{{trans('layout.phone_number')}}</p>
                                    </div>
                                @endif
                                @if($restaurant->timing)
                                    <div class="flex-1  profile-email px-2 pt-2">
                                        <h4 class="text-muted mb-0">{{$restaurant->timing}}</h4>
                                        <p>{{trans('layout.timing')}}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h3>{{trans('layout.description')}}</h3>
                        <div class="profile-statistics mb-5">
                            {!! clean($restaurant->description) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="item-lists">

        @foreach($categories as $categoryName=>$categoryItems)
            <div class="category-item-wrapper" id="category-item-wrapper-{{$categoryItems[0]->category_id}}">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="">
                            <h2><span>{{$categoryName}}</span></h2>
                        </div>
                    </div>

                </div>
                <div class="row">
                    @foreach($categoryItems as $item)
                        <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-arrival-product">
                                        <div class="new-arrivals-img-contnent">
                                            <img class="img-fluid" src="{{asset('uploads/'.$item->image)}}" alt="">
                                        </div>
                                        <div class="new-arrival-content text-center mt-3">
                                            <h4>{{$item->name}}</h4>
                                            <span class="d-block text-muted">{{$item->details}}</span>
                                            <ul class="star-rating d-none">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star-half-empty"></i></li>
                                                <li><i class="fa fa-star-half-empty"></i></li>
                                            </ul>
                                            <div class="price">
                                                @if($item->discount>0)
                                                    @if($item->discount_type=='percent')
                                                        <del>{{formatNumberWithCurrSymbol($item->price)}}</del> {{formatNumberWithCurrSymbol(($item->price-(($item->discount*$item->price)/100)))}}
                                                    @elseif($item->discount_type=='flat')
                                                        <del>{{formatNumberWithCurrSymbol($item->price)}}</del> {{formatNumberWithCurrSymbol($item->price-$item->discount)}}
                                                    @endif
                                                @else
                                                    {{formatNumberWithCurrSymbol($item->price)}}
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <button
                                                    data-value="{{json_encode($item->only(['name','id','price','details','discount','discount_type','discount_to']))}}"
                                                    class="btn btn-xxs btn-info add-to-cart">{{trans('layout.add')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="add-overview w-100" id="add-overview">
        <form action="{{route('order.place')}}" method="post" id="orderForm">
            @csrf
            <input type="hidden" name="restaurant" value="{{$restaurant->id}}">
            <div class="row" id="orderOverviewSection">
                <div class="col-xl-8 col-11">
                    <div class="card border-2-blue">
                        <div class="card-header border-0 pb-0">
                            <h5 class="card-title">{{trans('layout.overview')}}</h5>
                            <div id="close-overview" class="pull-right "><i class="fa fa-close"></i></div>
                        </div>
                        <div class="card-body">
                            <div class="order-items">

                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0">
                            <p class="card-text d-inline">Total: <span></span> <span
                                    id="totalAmount">0</span></p>
                            <a id="processCheckout" href="javascript:void(0)"
                               class="btn btn-xs btn-primary float-right">Process</a>
                               <a id="close-overview" style="margin-right:10px" href="javascript:void(0)"
                               class="btn btn-xs btn-primary float-right">Continue</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row" id="paymentOverviewSection">
                <div class="col-xl-8 col-11">
                    <div class="card border-2-blue">
                        <div class="card-header border-0 pb-0">
                            <h5 class="card-title">{{trans('layout.payment')}}</h5>
                            <div id="close-payment-overview" class="pull-right "><i class="fa fa-close"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="order-items-payment">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name">{{trans('layout.name')}}*</label>
                                        <input value="{{auth()->check()?auth()->user()->name:''}}" name="name"
                                               type="text" class="form-control" id="name"
                                               placeholder="Ex: Jone Doe"
                                               required="">
                                    </div>
                                    @if(request()->get('table'))
                                        <div class="col-md-6 mb-3">
                                            <label for="table_id">{{trans('layout.table')}}*</label>
                                            <select
                                                {{request()->get('table')?'disabled="true"':''}} class="form-control">
                                                @foreach($tables as $table)
                                                    <option
                                                        {{request()->get('table')==$table->id?'selected':''}} value="{{$table->id}}">{{$table->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col-md-6 mb-3 {{request()->get('table')?'d-none':''}}">
                                        <label for="table_id">{{trans('layout.table')}}*</label>
                                        <select name="table_id" id="table_id" class="form-control">
                                            @foreach($tables as $table)
                                                <option
                                                    {{request()->get('table')==$table->id?'selected':''}} value="{{$table->id}}">{{$table->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="comment">{{trans('layout.comment')}}</label>
                                        <input name="comment" type="text" class="form-control" id="comment"
                                               placeholder="Ex: Need extra spoon">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-block my-3">
                                            @php
                                                $rest_gateway_credentials=get_restaurant_gateway_settings($restaurant->user_id);
                                                $isPaymentEnable=false;
                                            @endphp
                                            @php $credentials=isset($rest_gateway_credentials)?json_decode($rest_gateway_credentials->value):''; @endphp

                                            @if(isset($credentials->offline_status) && $credentials->offline_status=='active')
                                                @php $isPaymentEnable=true; // to enable submit button @endphp
                                                <div class="custom-control custom-radio mb-2">
                                                    <input value="pay_on_table" id="pay_on_table" name="pay_type"
                                                           type="radio"
                                                           class="custom-control-input" checked="" required="">
                                                    <label class="custom-control-label"
                                                           for="pay_on_table">{{trans('layout.pay_on_table')}}</label>
                                                </div>
                                            @endif

                                            @if((isset($credentials->paypal_status) && $credentials->paypal_client_id && $credentials->paypal_secret_key && $credentials->paypal_status=='active') ||
(isset($credentials->stripe_status) && $credentials->stripe_publish_key && $credentials->stripe_secret_key && $credentials->stripe_status=='active') ||
(isset($credentials->paytm_environment) && $credentials->paytm_mid && $credentials->paytm_secret_key && $credentials->paytm_website && $credentials->paytm_txn_url && $credentials->paytm_status=='active')
)
                                                @php $isPaymentEnable=true; // to enable submit button @endphp

                                                <div class="custom-control custom-radio mb-2">
                                                    <input value="pay_now" id="pay_now"
                                                           name="pay_type"
                                                           type="radio"
                                                           class="custom-control-input" required="">
                                                    <label class="custom-control-label"
                                                           for="pay_now">{{trans('layout.pay_now')}}</label>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="pay-now-section">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="d-block my-3">

                                                @if($rest_gateway_credentials && $credentials)

                                                    @if(isset($credentials->paypal_status) && $credentials->paypal_client_id && $credentials->paypal_secret_key && $credentials->paypal_status=='active')
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input id="paypal" name="paymentMethod" type="radio"
                                                                   class="custom-control-input"
                                                                   required="" checked="" value="paypal">
                                                            <label class="custom-control-label"
                                                                   for="paypal">{{trans('layout.paypal')}}</label>
                                                        </div>
                                                    @endif


                                                    @if(isset($credentials->paytm_environment) && $credentials->paytm_mid && $credentials->paytm_secret_key && $credentials->paytm_website && $credentials->paytm_txn_url && $credentials->paytm_status=='active')
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input id="paytm" name="paymentMethod" type="radio"
                                                                   class="custom-control-input"
                                                                   required="" value="paytm">
                                                            <label class="custom-control-label"
                                                                   for="paytm">{{trans('layout.paytm')}}</label>
                                                        </div>
                                                    @endif

                                                    @if(isset($credentials->stripe_status) && $credentials->stripe_publish_key && $credentials->stripe_secret_key && $credentials->stripe_status=='active')
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input id="credit" name="paymentMethod" type="radio"
                                                                   class="custom-control-input"
                                                                   required="" value="stripe">
                                                            <label class="custom-control-label"
                                                                   for="credit">{{trans('Credit or Debit card')}}</label>
                                                        </div>
                                                    @endif

                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-payment-section">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="card-element"
                                                 class="border-1-gray p-3 border-radius-1"></div>
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0">
                            <p class="card-text d-inline">{{trans('layout.total')}}: <span
                                    id="totalAmountToPayment">0</span>
                            </p>
                            @if($isPaymentEnable)
                                <a id="place-order" href="javascript:void(0)"
                                   class="btn btn-xs btn-primary float-right place-order disabled">{{trans('layout.place_order')}}</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{asset('vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    @if(isset($credentials->stripe_status) && $credentials->stripe_status=='active')
        <script src="https://js.stripe.com/v3/"></script>
        <script !src="">
            "use strict";
            // Create a Stripe client.
            var stripe = Stripe('{{$credentials->stripe_publish_key}}');

            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {style: style});

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.on('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        </script>
    @endif

    <script>

        // Handle form submission.
        var btn = document.getElementById('place-order');
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            var name = document.getElementById('name');
            if (!name.value) return true;
            let credit = document.getElementById('credit');
            if (credit && credit.checked) {
                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            } else {

                $('input[type=radio][name=pay_type]').each(function(index,value){

                    if($(value).is(':checked')) {
                        $('input[type=radio][name=paymentMethod]').each(function(i,v){
                            if($(v).is(':checked'))  $('#orderForm').attr('data-can','true');
                        });
                    }
                    if($(value).val()=='pay_on_table')  $('#orderForm').attr('data-can','true');

                });


                var form =$('#orderForm');
                if(form.attr('data-can')=='true') {
                       form.submit();
                }else{
                    $('#place-order').addClass('disabled')
                }
            }
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('orderForm');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>

    <script !src="">
        const currencySymbol = '{{isset(json_decode(get_settings('local_setting'))->currency_symbol)?json_decode(get_settings('local_setting'))->currency_symbol:'$'}}';

        Number.prototype.number_format = function (decimals, dec_point, thousands_sep) {
            let number = this.valueOf();
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        };
        Number.prototype.formatNumber = function () {
            const decimal_format = '{{isset(json_decode(get_settings('local_setting'))->decimal_format)?json_decode(get_settings('local_setting'))->decimal_format:'.'}}';
            const decimals = '{{isset(json_decode(get_settings('local_setting'))->decimals)?json_decode(get_settings('local_setting'))->decimals:'2'}}';
            const thousand_separator = '{{isset(json_decode(get_settings('local_setting'))->thousand_separator)?json_decode(get_settings('local_setting'))->thousand_separator:','}}';
            return this.valueOf().number_format(decimals, decimal_format, thousand_separator);
        };
        Number.prototype.formatNumberWithCurrSymbol = function () {
            const symbol_position = '{{isset(json_decode(get_settings('local_setting'))->currency_symbol_position)?json_decode(get_settings('local_setting'))->currency_symbol_position:'after'}}';

            if (symbol_position == 'after') {
                return this.valueOf().formatNumber() + currencySymbol;
            } else if (symbol_position == 'before') {
                return currencySymbol + this.valueOf().formatNumber();
            }

        };

        function calculateTotal() {
            let total = 0;
            $('.row-total').each((index, value) => {
                total += parseFloat($(value).text());
            });
            console.log(total);
            $('#totalAmount').text(total.formatNumberWithCurrSymbol());
            $('#totalAmountToPayment').text(total.formatNumberWithCurrSymbol());
        }

        $(document).on('click', '.item-category', function (e) {
            e.preventDefault();
            $('.hamburger').click();
            $('#restaurant-section').hide();
            $('#item-lists').show();
            $('.category-item-wrapper').hide();
            $('#category-item-wrapper-' + $(this).attr('data-id')).show();
        });
        $(document).on('click', '.add-to-cart', function (e) {
            e.preventDefault();
            $('#add-overview').animate({bottom: '0px'});
            $('#orderOverviewSection').show();
            $('#paymentOverviewSection').hide();

            const item = JSON.parse($(this).attr('data-value'));

            let singleItem = $('#single-item-' + item.id).length;
            let singleItemHtml = '';
            let discount = item.discount;
            let discountedPrice = 0;
            if (item.discount_type == 'flat') {
                discountedPrice = item.price - discount;
            } else if (item.discount_type == 'percent') {
                discountedPrice = (item.price * discount) / 100;
                discountedPrice = item.price - discountedPrice;
            }
            if (singleItem <= 0) {
                singleItemHtml = `<div class="single-item" id="single-item-${item.id}">
                                    <div class="item-details">
                                        <div class="item-title">${item.name}</div>
                                            <input type="hidden" name="item_id[]" value="${item.id}">
                                            <input type="hidden" name="item_quantity[]" value="1" id="input-item-quantity-${item.id}">
                                        <div class="item-price"><span class="item-individual-currency-symbol"></span> <span class="item-individual-price d-none">${discountedPrice}</span> <span>${discountedPrice.formatNumberWithCurrSymbol()}</span></div>
                                    </div>
                                    <div class="modify-item">
                                        <span class="d-none row-total">${discountedPrice}</span>
                                        <div data-id="${item.id}" class="minus-quantity">
                                            <i class="fa fa-minus"></i>
                                        </div>
                                        <div id="item-quantity-${item.id}" class="item-quantity">1</div>
                                        <div data-id="${item.id}" class="plus-quantity" id="plus-quantity-${item.id}">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                    </div>
                                </div>`;
            } else {
                $('#plus-quantity-' + item.id).click();
            }
            $('.order-items').append(singleItemHtml);
            calculateTotal();

        });

        $('#close-overview,#close-payment-overview').on('click', function (e) {
            $('#add-overview').animate({bottom: '-1000px'});
        });

        $(document).on('click', '.minus-quantity', function (e) {
            e.preventDefault();
            let price = parseFloat($(this).parent().parent().find('.item-individual-price').first().text());
            let quantity = parseInt($(this).parent().find('.item-quantity').first().text());
            quantity--;
            if (quantity <= 0) $(this).parent().parent().remove();
            $(this).parent().find('.item-quantity').text(quantity);
            const total = quantity * price;
            $(this).parent().find('.row-total').text(total);
            $('#input-item-quantity-' + $(this).attr('data-id')).val(quantity);
            calculateTotal();
        });

        $(document).on('click', '.plus-quantity', function (e) {
            e.preventDefault();
            let price = parseFloat($(this).parent().parent().find('.item-individual-price').first().text());
            let quantity = parseInt($(this).parent().find('.item-quantity').first().text());
            console.log(price, quantity);
            quantity++;
            $(this).parent().find('.item-quantity').text(quantity);
            const total = quantity * price;
            $(this).parent().find('.row-total').text(total);
            $('#input-item-quantity-' + $(this).attr('data-id')).val(quantity);
            calculateTotal();
        });

        $('#processCheckout').on('click', function (e) {
            e.preventDefault();
            $('#orderOverviewSection').hide();
            $('#paymentOverviewSection').show();
        });

        $('input[type=radio][name=pay_type]').change(function () {
            if (this.value == 'pay_on_table') {
                $('.pay-now-section').hide();
                $('.card-payment-section').hide();
            } else if (this.value == 'pay_now') {
                $('.pay-now-section').show();
            }
            checkPayType();
        });

        $('input[type=radio][name=paymentMethod]').change(function () {
            if (this.value == 'paypal') {
                $('.card-payment-section').hide();
            } else if (this.value == 'paytm') {
                $('.card-payment-section').hide();
            } else if (this.value == 'stripe') {
                $('.card-payment-section').show();
            }
            checkPayType();
        });

        /* $('.place-order').on('click', function (e) {
             e.preventDefault();
             $('#orderForm').submit();
         })*/
        function checkPayType(){
            $('input[type=radio][name=pay_type]').each(function(index,value){
                if($(value).is(':checked')) {
                    $('input[type=radio][name=paymentMethod]').each(function(i,v){
                        if($(v).is(':checked')) $('#place-order').removeClass('disabled');
                    });
                }
                if($(value).val()=='pay_on_table') $('#place-order').removeClass('disabled');
            });
        }
        checkPayType();

    </script>
    @if(session()->has('order-success'))
        <script !src="">
            swal("Great!!", '{{session()->get('order-success')}}', "success");
        </script>
    @endif
@endsection
