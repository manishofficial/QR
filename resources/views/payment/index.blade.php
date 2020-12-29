@extends('layouts.dashboard')
@section('title',trans('layout.payment_title'))
@section('css')
    <style>
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endsection
@section('main-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{route('payment.process')}}" method="post" id="payment-form">
                    @csrf
                    <input type="hidden" name="plan" value="{{$plan->id}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="card">
                                    <div class="card-header d-block">
                                        <h4 class="card-title">{{trans('layout.payment_method')}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Default accordion -->
                                        <div id="accordion-one" class="accordion accordion-primary">
                                            @php $paymentSetting= json_decode(get_settings('payment_gateway')) @endphp
                                            @if(isset($paymentSetting->paypal_status) && $paymentSetting->paypal_status=='active')
                                                <div class="accordion__item">
                                                    <div class="accordion__header rounded-lg collapsed"
                                                         data-toggle="collapse"
                                                         data-target="#default_collapseOne" aria-expanded="false">
                                                        <div class="d-none">
                                                            <input value="paypal" name="payment_type" type="radio"
                                                                   id="paypalRadio">
                                                        </div>
                                                        <span
                                                            class="accordion__header--text">{{trans('layout.paypal')}}</span>
                                                    </div>
                                                    <div id="default_collapseOne" class="accordion__body collapse"
                                                         data-parent="#accordion-one"
                                                         style="">
                                                        <div class="accordion__body--text">
                                                            {{trans('layout.paypal_des')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isset($paymentSetting->stripe_status) && $paymentSetting->stripe_status=='active')
                                                <div class="accordion__item">
                                                    <div class="accordion__header collapsed rounded-lg"
                                                         data-toggle="collapse"
                                                         data-target="#default_collapseTwo">
                                                        <div class="d-none">
                                                            <input value="card" name="payment_type" type="radio"
                                                                   id="cardRadio">
                                                        </div>
                                                        <span
                                                            class="accordion__header--text">{{trans('layout.credit_or_debit')}}</span>
                                                    </div>
                                                    <div id="default_collapseTwo" class="collapse accordion__body"
                                                         data-parent="#accordion-one">
                                                        <div class="accordion__body--text">
                                                            <div id="card-element"
                                                                 class="border-1-gray p-3 border-radius-1"></div>
                                                            <div id="card-errors" role="alert"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                            @if(isset($paymentSetting->paytm_status) && $paymentSetting->paytm_status=='active')
                                                <div class="accordion__item">
                                                    <div class="accordion__header rounded-lg collapsed"
                                                         data-toggle="collapse"
                                                         data-target="#paytmSection" aria-expanded="false">
                                                        <div class="d-none">
                                                            <input value="paytm" name="payment_type" type="radio"
                                                                   id="paytmRadio">
                                                        </div>
                                                        <span
                                                            class="accordion__header--text">{{trans('layout.paytm')}}</span>
                                                    </div>
                                                    <div id="paytmSection" class="accordion__body collapse"
                                                         data-parent="#accordion-one"
                                                         style="">
                                                        <div class="accordion__body--text">
                                                            {{trans('layout.pay_with_paytm')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(isset($paymentSetting->offline_status) && $paymentSetting->offline_status=='active')
                                                <div class="accordion__item">
                                                    <div class="accordion__header collapsed rounded-lg"
                                                         data-toggle="collapse"
                                                         data-target="#default_collapseOffline">
                                                        <div class="d-none">
                                                            <input value="offline" name="payment_type" type="radio"
                                                                   id="offlineRadio">
                                                        </div>
                                                        <span
                                                            class="accordion__header--text">{{trans('layout.offline')}}</span>
                                                    </div>
                                                    <div id="default_collapseOffline" class="collapse accordion__body"
                                                         data-parent="#accordion-one">
                                                        <div class="accordion__body--text">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="bank_name">{{trans('layout.bank_name')}}
                                                                            *</label>
                                                                        <input type="text" name="bank_name"
                                                                               class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="bank_branch">{{trans('layout.bank_branch')}}
                                                                            *</label>
                                                                        <input type="text" name="bank_branch"
                                                                               class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="account_name">{{trans('Account Name')}}
                                                                            *</label>
                                                                        <input type="text" name="account_name"
                                                                               class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="account_number">{{trans('Account Number')}}
                                                                            *</label>
                                                                        <input type="text" name="account_number"
                                                                               class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="transaction_id">{{trans('Transaction ID')}}
                                                                            *</label>
                                                                        <input type="text" name="transaction_id"
                                                                               class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="reference">{{trans('Reference')}}</label>
                                                                        <input type="text" name="reference"
                                                                               class="form-control">
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="card-header">
                                    <h4 class="card-title">Plan summary</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <ul>
                                                <li><strong>{{trans('layout.pay_plan_title')}}</strong></li>
                                                <li><strong>{{trans('layout.start_date')}}</strong></li>
                                                <li><strong>{{trans('layout.expiry_date')}}</strong></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6">
                                            <ul>
                                                <li>{{$plan->title}}</li>
                                                <li>{{formatDate(now())}}</li>
                                                @if($plan->recurring_type=='onetime')
                                                    <li>{{trans('layout.lifetime')}}</li>
                                                @elseif($plan->recurring_type=='weekly')
                                                    <li>{{formatDate(now()->addWeek())}}</li>
                                                @elseif($plan->recurring_type=='monthly')
                                                    <li>{{formatDate(now()->addMonth())}}</li>
                                                @elseif($plan->recurring_type=='yearly')
                                                    <li>{{formatDate(now()->addYear())}}</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <ul>
                                                <li><strong>{{trans('layout.total_cost')}}</strong></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6">
                                            <ul>
                                                <li>{{formatNumberWithCurrSymbol($plan->cost)}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button disabled type="submit" id="paynow"
                                class="btn btn-sm btn-primary">{{trans('layout.pay_now')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @if(isset($paymentSetting->stripe_status) && $paymentSetting->stripe_status=='active')
        <script src="https://js.stripe.com/v3/"></script>
        <script !src="">
            "use strict";
            // Create a Stripe client.
            var stripe = Stripe('{{get_stripe_publish_key()}}');

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

            // Handle form submission.
            var form = document.getElementById('payment-form');

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                var cardRadio = document.getElementById('cardRadio');
                if (cardRadio.checked) {
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
                    form.submit();
                }
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        </script>
    @endif

    <script>

        function checkRadioButton() {
            let isOneChecked = false;
            let testimonialElements = $('[name="payment_type"]');
            for (let i = 0; i < testimonialElements.length; i++) {
                let element = testimonialElements.eq(i);
                if (element.is(':checked')) {
                    isOneChecked = true;
                    break;
                }

            }
            if (isOneChecked)
                $('#paynow').removeAttr('disabled');
            else
                $('#paynow').attr('disabled', 'true');


            if ($('[name=payment_type]:checked').val() == 'offline') {
                $('#default_collapseOffline input').each(function (index, value) {
                    $(value).attr('required', 'true');
                })
            } else {
                $('#default_collapseOffline input').each(function (index, value) {
                    $(value).removeAttr('required');
                })
            }

            $('[name=reference]').removeAttr('required');



        }

        $('#default_collapseTwo,#default_collapseOne,#default_collapseOffline,#paytmSection').on('show.bs.collapse', function (e) {
            $('[name="payment_type"]').removeAttr('checked');
            let type = $(this).parent().find('[name="payment_type"]');
            type.attr('checked', 'true');
            type.trigger('change');
            checkRadioButton();
        });

        $('#default_collapseTwo,#default_collapseOne,#default_collapseOffline,#paytmSection').on('hide.bs.collapse', function (e) {
            // $('[name="payment_type"]').removeAttr('checked');
            let type = $(this).parent().find('[name="payment_type"]');
            type.removeAttr('checked');
            type.trigger('change');
            checkRadioButton();
        });


    </script>
@endsection
