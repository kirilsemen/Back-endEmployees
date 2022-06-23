@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Import XML data into Database.') }}</div>
                    <div class="card-body">
                        @if($errors->first('payment_per_hour'))
                            <div class="alert-danger"> {{$errors->first('payment_per_hour')}} </div>
                        @endif
                        @if($errors->first('full_name'))
                            <div class="alert-danger"> {{$errors->first('full_name')}} </div>
                        @endif
                        @if($errors->first('department_id'))
                            <div class="alert-danger"> {{$errors->first('department_id')}} </div>
                        @endif
                        @if($errors->first('hourly_payment'))
                            <div class="alert-danger"> {{$errors->first('hourly_payment')}} </div>
                        @endif
                        @if($errors->first('worked_hours'))
                            <div class="alert-danger"> {{$errors->first('worked_hours')}} </div>
                        @endif
                        @if($errors->first('salary'))
                            <div class="alert-danger"> {{$errors->first('salary')}} </div>
                        @endif
                        @if(isset($pass))
                            <div class="alert" style="color: green"> {{$pass}} </div>
                        @endif
                        <form action="{{url('/import/xml')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <p>If you want to import data from XML to Database. Check that your column name is
                                'row'.</p>
                            <input name="xml" type="file">
                            <button class="btn btn-primary">Import</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
