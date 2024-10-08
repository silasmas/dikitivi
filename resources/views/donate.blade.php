@extends('layouts.welcome')

@section('welcome-content')

            <!-- About Area -->
            <div id="pricing" class="pricing-plan-area section-pt py-5 border-top border-bottom">
                <div class="container-sm container-fluid">
                    <div class="row">
                        <div class="col-lg-6 m-auto">
                            <!-- Section Title -->
                            <div class="section-title mb-3 text-center">
                                <h2>@lang('miscellaneous.public.about.donate.title')</h2>
                                <p>@lang('miscellaneous.public.about.donate.description')</p>
                            </div><!--// Section Title -->
                        </div>
                    </div>

                    <hr class="mt-4 mb-5">

                    <div class="row">
                        <div id="donate" class="col-lg-6 col-sm-7 col-11 mx-auto text-sm-center text-start">
                            <form method="POST" action="{{ route('donation') }}">
                                <input type="hidden" name="app_url" value="{{ getWebURL() }}">
                                <input type="hidden" name="user_id" value="{{ !empty($current_user) ? $current_user->id : null }}">
    @csrf
                                <div id="financialDonation" class="row g-3 mb-4">
                                    <div class="col-12">
                                        <h5 class="h5 m-0 text-uppercase fw-bolder">@lang('miscellaneous.public.about.donate.send_money.title')</h5>
                                        <p class="small m-0 text-muted">@lang('miscellaneous.public.about.donate.send_money.description')</p>
                                    </div>

                                    <div id="paymentMethod">
    @foreach ($transaction_types as $type)
        @if ($type['type_name'] == __('miscellaneous.account.payment.send_money.mobile_money'))
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input mt-2" type="radio" name="transaction_type_id" id="mobile_money" value="{{ $type['id'] }}" />
                                            <label class="form-check-label" for="mobile_money">
                                                <img src="{{ asset('assets/img/payment-mobile-money.png') }}" alt="{{ __('miscellaneous.account.payment.send_money.mobile_money') }}" width="40">
                                                @lang('miscellaneous.account.payment.send_money.mobile_money')
                                            </label>
                                        </div>
        @else
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input mt-2" type="radio" name="transaction_type_id" id="bank_card" value="{{ $type['id'] }}" />
                                            <label class="form-check-label" for="bank_card">
                                                <img src="{{ asset('assets/img/payment-credit-card.png') }}" alt="{{ __('miscellaneous.public.about.donate.send_money.bank_card') }}" width="40">
                                                @lang('miscellaneous.public.about.donate.send_money.bank_card')
                                            </label>
                                        </div>
        @endif
    @endforeach
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="input-group overflow-hidden border border-secondary rounded">
                                            <button type="button" class="btn btn-light shadow-0 disabled" style="text-transform: inherit!important;">
                                                @lang('miscellaneous.public.about.donate.period.title')
                                            </button>

                                            <select name="select_pricing" id="select_pricing" class="form-select border-start border-secondary py-2 border-0">
                                                <option class="small" selected disabled>@lang('miscellaneous.public.about.donate.period.choose')</option>
                                                <option>@lang('miscellaneous.public.about.donate.period.unique')</option>
    @forelse ($pricings as $pricing)
                                                <option value="{{ $pricing['id'] }}">{{ $pricing['deadline'] }}</option>
    @empty
    @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="amountCurrency" class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <div class="form-floating">
                                                <input type="number" name="register_amount" id="register_amount" class="form-control" placeholder="@lang('miscellaneous.amount')" required>
                                                <label for="register_amount">@lang('miscellaneous.amount')</label>
                                            </div>

                                            <div class="input-group-prepend">
                                                <select name="select_currency" id="select_currency" class="form-select input-group-text h-100 shadow-0 text-start">
                                                    <option class="small" selected disabled>@lang('miscellaneous.currency')</option>
                                                    <option value="USD">@lang('miscellaneous.usd')</option>
                                                    <option value="CDF">@lang('miscellaneous.cdf')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="phoneNumberForMoney" class="row g-sm-2 g-3">
                                    <div class="col-sm-5">
                                        <div class="form-floating pt-0">
                                            <select name="select_country" id="select_country1" class="form-select pt-2 shadow-0">
                                                <option class="small" selected disabled>@lang('miscellaneous.choose_country')</option>
    @forelse ($countries as $country)
                                                <option value="{{ $country['country_phone_code'] . '-' . $country['id'] }}">{{ $country['country_name'] }}</option>
    @empty
                                                <option>@lang('miscellaneous.empty_list')</option>
    @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <span id="phone_code_text1" class="input-group-text d-inline-block h-100" style="padding-top: 0.3rem; padding-bottom: 0.5rem; line-height: 1.35;">
                                                <small class="text-muted m-0 p-0" style="font-size: 0.75rem;">@lang('miscellaneous.phone_code')</small><br>
                                                <span class="text-value">xxxx</span> 
                                            </span>

                                            <div class="form-floating">
                                                <input type="hidden" id="phone_code1" name="other_phone_code" value="">
                                                <input type="tel" name="other_phone_number" id="phone_number" class="form-control" placeholder="@lang('miscellaneous.phone')">
                                                <label for="phone_number">@lang('miscellaneous.phone')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-block dktv-btn-green mt-4 py-3 px-5 rounded-pill shadow-0" type="submit">@lang('miscellaneous.send')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--// About Area -->

@endsection
