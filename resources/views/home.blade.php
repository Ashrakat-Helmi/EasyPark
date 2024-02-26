@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              
                {{ phpversion() }}
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1> {{ __('Users')}}</h1>
                       
                    <table class="table table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th colspan="3">Action</th>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <th>{{$user->id}}</th>
                            <th>{{$user->name}}</th>
                            <th><a href=""><i class="fas text-info fa-eye" style="font-size: 20px;"></i></a></th>
                            <th><a href=""><i class="fas text-primary fa-edit" style="font-size: 20px;"></i></a></th>
                            <th><a href=""><i class="fas text-danger fa-trash-alt" style="font-size: 20px;"></i></a></th>
                        </tr>
                        @endforeach
                       
                    </table>    
                    <h1> {{ __('Garages')}}</h1>
                       
                    <table class="table table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th colspan="3">Action</th>
                        </tr>
                        @foreach ($data['garage'] as $grage)
                        <tr>
                            <th>{{$grage->id}}</th>
                            <th>{{$grage->name}}</th>
                            <th><a href=""><i class="fas text-info fa-eye" style="font-size: 20px;"></i></a></th>
                            <th><a href=""><i class="fas text-primary fa-edit" style="font-size: 20px;"></i></a></th>
                            <th><a href=""><i class="fas text-danger fa-trash-alt" style="font-size: 20px;"></i></a></th>
                        </tr>
                        @endforeach
                       
                    </table>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
