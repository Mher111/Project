@extends('layouts.app')
@section('content')
<div class="col-md-6 col-lg-6 col-md-offset-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Companies <a  class="pull-right btn btn-primary btn-sm" href="/companies/create"><i class="fa fa-plus-square" aria-hidden="true"></i>  Create a new Company</a> </div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($companies as $company)
                    <li class="list-group-item"><a href="/companies/{{$company->id}}">{{$company->name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection

