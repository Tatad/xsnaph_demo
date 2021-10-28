@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Sales Journal</div>

                <div class="card-body journal-body">
                   <sales-journal></sales-journal>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
