@extends('layouts.xero-auth')

@section('content')        
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="container">
                        <div class="col-md-5 pull-left">
                            {{$username}}
                        </div>
                        <div class="col-md-5  pull-right">
                            <a href="/" class=" pull-right">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>

                     
                        <a href="{{ route('xero.auth.authorize') }}" class="row btn btn-primary text-center" style="margin-left:27rem;width:150px !important;background-image: url('https://app.thaitax.co/images/connect-blue.svg');height: 50px;width:190px !important;margin-top:15px;" >
                        </a>
                <div class="card-body journal-body">
                    <table class="table table-bordered">
                        <tbody>
                            @if($organizations)
                            @foreach($organizations as $key => $organization)
                                <tr>
                                    <td>{{($organization['tenant_name'])}}</td>
                                    <td><a href="/select-org/{{$organization['tenant_id']}}"><button class="btn btn-primary">Select</button></a></td>
                                    <td><a href="/delete-org/{{$organization['id']}}"><i class="fa fa-times"></i></a></td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection