@extends('layouts.app')

@section('content')
    <div class="uk-section-large uk-section" >
        <div class="uk-container uk-container-large">
            @include('partials.alerts')
            <div class="uk-child-width-1-3@l uk-grid-large" uk-grid>
                <div>
                    <div class="uk-card uk-card-primary uk-card-body uk-light">
                        <h3 class="uk-card-title">Send an SMS to one person</h3>
                        <hr>
                        <form action="{{ route('send.one') }}" method="post">
                            @csrf
                            <div class="uk-margin">
                                <div class="uk-inline">
                                    <span class="uk-form-icon" uk-icon="icon: phone"></span>
                                    <input class="uk-input uk-form-width-large"
                                           type="text" name="number"
                                           placeholder="Safaricom Phone Number"
                                           value="{{ old('number') ?? ''}}">
                                </div>

                                @error('number')
                                    <div class="uk-alert-danger" uk-alert>
                                        <a class="uk-alert-close" uk-close></a>
                                        <p>{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline">

                                    <textarea name="message" id="messages" class="uk-textarea uk-form-width-large"
                                              placeholder="Type your message. (max of 140 characters)">
                                        {{ old('message') ?? '' }}
                                    </textarea>

                                    @error('message')
                                        <div class="uk-alert-danger" uk-alert>
                                            <a class="uk-alert-close" uk-close></a>
                                            <p>{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="uk-button uk-button-rounded uk-button-default">Send Sms</button>
                        </form>
                    </div>
                </div>
                <div>

                    <div class="uk-card  uk-card-body uk-margin-large-top " style="background-color: #2e2147; ">
                        <h3 class="uk-card-title" >Lipa na Mpesa</h3>
                        <hr>
                        <form action="{{ route('mpesa.lipa') }}" method="post">
                            @csrf
                            <div class="uk-margin">
                                <div class="uk-inline">
                                    <span class="uk-form-icon" uk-icon="icon: cart"></span>
                                    <input class="uk-input uk-form-width-large uk-disabled"
                                           type="text"
                                           name="paybill"
                                           value="Till number: 175467"
                                    >
                                </div>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline">
                                    <span class="uk-form-icon" uk-icon="icon: phone"></span>
                                    <input class="uk-input uk-form-width-large"
                                           type="text"
                                           name="mchwa"
                                           placeholder="Safaricom Mpesa Number">
                                </div>

                                @error("mchwa")
                                <div class="uk-alert-danger" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline">
                                    <span class="uk-form-icon" uk-icon="icon: credit-card"></span>
                                    <input class="uk-input uk-form-width-large"
                                           type="number"
                                           name="amount"
                                           placeholder="Amount">
                                </div>

                                @error("amount")
                                <div class="uk-alert-danger" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="uk-button uk-button-rounded uk-button-default">Lipa na Mpesa</button>
                        </form>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-secondary uk-card-body ">
                        <h3 class="uk-card-title">Send an SMS To Many Numbers</h3>
                        <p class="uk-text-meta">In the input, enter a comma separated list of numbers</p>
                        <p class="uk-text-meta">Eg: 2547123456,2547123456,2547123457</p>
                        <hr>
                        <form action="{{ route('send.many') }}" method="post">
                            @csrf
                            <div class="uk-margin">
                                <div class="uk-inline">
                                    <span class="uk-form-icon" uk-icon="icon: phone"></span>
                                    <input class="uk-input uk-form-width-large"
                                           type="text"
                                           name="numbers"
                                           placeholder="2547XXX, 2547XXX">
                                </div>

                                @error("numbers")
                                <div class="uk-alert-danger" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline">

                                    <textarea name="messages" id="message" class="uk-textarea uk-form-width-large"
                                              placeholder="Type your message. (max of 140 characters)"></textarea>

                                    @error('messages')
                                    <div class="uk-alert-danger" uk-alert>
                                        <a class="uk-alert-close" uk-close></a>
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="uk-button uk-button-rounded uk-button-default">Send Sms</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
