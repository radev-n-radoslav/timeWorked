@extends('layouts.app')

@section('content')

<div class="container">
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('status'))
        <div class="alert alert-success alert-dismissable">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Change your password</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" action="/settings">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Old password</label>

                                <div class="col-md-8">
                                    <input type="password" class="form-control" name="old_password" required autofocus>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label">New Password</label>

                                <div class="col-md-8">
                                    <input type="password" class="form-control" name="password" required autofocus>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Confirm Password</label>

                                <div class="col-md-8">
                                    <input type="password" class="form-control" name="password_confirmation" required autofocus>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary pull-right" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection