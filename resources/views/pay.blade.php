<!DOCTYPE html>
<html>

<head>
    <title>Qruz Wallet</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- INCLUDE SESSION.JS JAVASCRIPT LIBRARY -->
    <script src="https://api.vapulus.com:1338/app/session/script?appId={{config('custom.valulus_app_id')}}"></script>
    <!-- APPLY CLICK-JACKING STYLING AND HIDE CONTENTS OF THE PAGE -->
    <style id="antiClickjack">
        body {
            display: none !important;
        }
    </style>
    <style>
        .card, .alert {
            border-radius: 1rem !important;
        }
        .placeholder {
            width: 75px;
            height: 75px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
        }
        .form-control {
            border: 2px solid #f2f2f2 !important;
            background-color: #f2f2f2 !important;
            border-radius: 1.5rem !important;
        }
        #cardNumber, #cardCVC {
            background-color: #f2f2f2 !important;
        }
        .form-control:focus, .btn:focus {
            outline: none !important;
            box-shadow: none !important;
        }
        .bg-nav {
            background-color: #422597;
        }
        input[type=text] {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
        }
        .spinner {
            animation: outerSpinner 2s linear infinite;
        }
        .spinner circle {
            stroke-dasharray: 1,150;
            stroke-dashoffset: 0;
            stroke-linecap: round;
            animation: innerSpinner 1.5s ease-in-out infinite;
        }

        @keyframes innerSpinner {
            0% {
                stroke-dasharray: 1,150;
                stroke-dashoffset: 0;
            }
            50% {
                stroke-dasharray: 90,150;
                stroke-dashoffset: -35;
            }
            100% {
                stroke-dasharray: 90,150;
                stroke-dashoffset: -124;
            }
        }
        @keyframes outerSpinner {
            100% {
                transform: rotate(1turn);
            }
        }
        #payButton {
            display: inline-block;
            line-height: 40px;
            height: 40px;
            margin: 5px auto;
            min-width: 200px;
            cursor: pointer;
            color: rgb(255, 255, 255);
            font-weight: bold;
            font-size: 1.2rem;
            white-space: nowrap;
            text-align: left;
            padding-left: 20%;
            background: url(https://app.vapulus.com/website/assets/images/btn.svg) center center no-repeat;
        }
    </style>
</head>

<body>
    <nav class="py-4 bg-nav text-white text-center">
        <h4 class="jumbotron-heading mb-0"><span class="font-weight-light">Qruz</span> <span class="font-weight-bold">Wallet</span></h4>
    </nav>
    <!-- CREATE THE HTML FOR THE PAYMENT PAGE -->
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-md-4" id="card-content">
                <div id="loader">
                    <div class="my-4 py-4 text-center">
                        <svg class="spinner" width="45" height="45" viewBox="0 0 43 43">
                            <circle cx="21.5" cy="21.5" r="20" fill="none" stroke="#422597" stroke-width="3"></circle>
                        </svg>
                    </div>
                    <p class="text-muted text-center" id="loaderStatus">Initializing..</p>
                </div>
                <div class="card border-0" id="cardForm">
                    <div class="card-body">
                        <div id="feedback"></div>
                        <div class="form-row">
                            <input type="hidden" id="token" value="{{ app('request')->input('token') }}">
                            <div class="form-group col-12">
                                <label for="cardNumber" class="font-weight-bold">Card Number</label>
                                <input type="number" id="cardNumber" class="form-control" value="" readonly  />
                            </div>
                            <div class="form-group col-6">
                                <select class="form-control" id="cardMonth">
                                    <option value="">Exp. Month</option>
                                    @for ($i = 01; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <select class="form-control" id="cardYear">
                                    <option value="">Exp. Year</option>
                                    @for ($i = now()->year; $i <= now()->year+5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label for="cardCVC" class="font-weight-bold">CVC</label>
                                <input type="number" id="cardCVC" class="form-control" value="" readonly />
                            </div>
                            <div class="d-inline-flex font-weight-bold mb-4">
                                <p class=" mb-0 align-self-center">Add</p>
                                <input type="number" id="amount" class="form-control mx-2" autocomplete="off" style="width: 35%" />
                                <p class="mb-0 align-self-center">EGP to my wallet</p>
                            </div>
                            <!-- <div class="form-group col-12">
                                <label for="amount" class="mb-0 font-weight-bold">Amount</label>
                                <input type="number" placeholder="EGP" id="amount" class="form-control" value="" autocomplete="off" />
                            </div> -->
                            <div id="payButton" onclick="pay();">Pay</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto mb-4 text-center">
        <a href="https://www.vapulus.com" target="_blank" class="d-flex justify-content-center text-decoration-none">
            <small class="text-muted mr-1">Powered by</small>
            <img src="{{ asset('assets/vapulus-logo-sm.svg') }}" />
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- JAVASCRIPT FRAME-BREAKER CODE TO PROVIDE PROTECTION AGAINST IFRAME CLICK-JACKING -->
    <script type="text/javascript">
        const token = $("#token").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer '+token
            }
        });
        $("#cardForm").hide();
        // $("#amount").on('keyup', function() {
        //     $("#payAmount").text($(this).val()+' EGP');
        //     if ($(this).val() === '') $("#payAmount").text('');
        // })
        // Your code to run since DOM is loaded and ready
        if(window.PaymentSession){
            PaymentSession.configure({
                fields: {
                    // ATTACH HOSTED FIELDS IDS TO YOUR PAYMENT PAGE FOR A CREDIT CARD
                    card: {
                        cardNumber: "cardNumber",
                        securityCode: "cardCVC",
                        expiryMonth: "cardMonth",
                        expiryYear: "cardYear"
                    }
                },
                callbacks: {
                    initialized: function (err, response) {
                        $("#cardForm").show();
                        $("#loader").hide();
                    },
                    formSessionUpdate: function (err,response) {
                        // HANDLE RESPONSE FOR UPDATE SESSION
                        if (response.statusCode) {
                            if (200 == response.statusCode) {
                                $("#loaderStatus").text('Payment processing...');
                                $.ajax({
                                    type:'POST',
                                    url:'/api/user/pay',
                                    data: { 
                                        session_id: response.data.sessionId,
                                        amount: $("#amount").val()
                                    },
                                    success: function(data) {
                                        $("#loader").hide();
                                        if (data.statusCode === 200) {
                                            $("#card-content").html('<div class="mt-4 text-center text-success"><div class="placeholder rounded-circle bg-success"><svg viewBox="0 0 512 512" width="35" height="35" fill="#fff"><path d="M504.502,75.496c-9.997-9.998-26.205-9.998-36.204,0L161.594,382.203L43.702,264.311c-9.997-9.998-26.205-9.997-36.204,0 c-9.998,9.997-9.998,26.205,0,36.203l135.994,135.992c9.994,9.997,26.214,9.99,36.204,0L504.502,111.7 C514.5,101.703,514.499,85.494,504.502,75.496z"/></svg></div><h4 class="font-weight-bold mb-1 mt-4">Successfull Payment</h4><p class="mb-0"><span class="font-weight-bold">'+$("#amount").val()+' EGP</span> has been added to your wallet</p></div>')
                                        } else {
                                            $("#feedback").html('<div class="mb-3 alert alert-danger border-0">'+data.message+'</div>');
                                            $('#cardForm').show();
                                        }
                                    }
                                });
                            } else if (201 == response.statusCode) {
                                $("#loader").hide();
                                $("#feedback").html('<div class="mb-3 alert alert-danger border-0">Something went wrong! Please try again</div>');
                                $('#cardForm').show();
                                if (response.message) {
                                    var field = response.message.indexOf('valid')
                                    field = response.message.slice(field + 5, response.message.length);
                                    $("#feedback").html('<div class="mb-3 alert alert-danger border-0">'+field + ' is invalid or missing.</div>')
                                }
                            } else {
                                $("#loader").hide();
                                $("#feedback").html('<div class="mb-3 alert alert-danger border-0">Something went wrong! Please try again</div>');
                                $('#cardForm').show();
                            }
                        }
                    }
                }                
            });
        } else {
            alert('Fail to get app/session/script !\n\nPlease check if your appId added in session script tag in head section?')
        }
        function pay() {
            // UPDATE THE SESSION WITH THE INPUT FROM HOSTED FIELDS
            PaymentSession.updateSessionFromForm();
            $("#cardForm").hide();
            $("#loader").show();
            $("#loaderStatus").text('Validating your input...');
        }
    </script>

</body>
</html>