@extends('layouts.xero-auth')

@section('content')        
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Xero Integration</div> -->

                <div class="card-body journal-body">
                     <h1 class="text-center">Sync your Xero Account</h1>
                     <div class="container" style="width: 100%">
                        <a href="{{ route('xero.auth.authorize') }}" class="row btn btn-primary text-center" style="margin-left:27rem;width:150px !important;background-image: url('https://app.thaitax.co/images/connect-blue.svg');height: 50px;width:190px !important;" >
                        </a>
                        <!-- <div class="v-image__image v-image__image--contain" style="background-image: url('https://app.thaitax.co/images/connect-blue.svg'); background-position: center center;">test</div> -->
                    </div>
                    <!-- @if($error)
                        <h1>Your connection to Xero failed</h1>
                        <p>{{ $error }}</p>
                        <a href="{{ route('xero.auth.authorize') }}" class="btn btn-primary">
                            Reconnect to Xero
                        </a>
                    @elseif($connected)
                        <h1>You are connected to Xero</h1>
                        <p>{{ $organisationName }} via {{ $username }}</p>
                        <a href="{{ route('xero.auth.authorize') }}" class="btn btn-primary">
                            Reconnect to Xero
                        </a>
                    @else
                        <h1>You are not connected to Xero</h1>
                        <a href="{{ route('xero.auth.authorize') }}" class="btn btn-primary">
                            Connect to Xero
                        </a>
                    @endif -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection