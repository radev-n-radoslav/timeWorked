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
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#see" data-toggle="tab"><i class="fa fa-eye"></i> Display</a></li>
                <li><a href="#add" data-toggle="tab"><i class="fa fa-plus"></i> Add</a></li>
            </ul>
            
            <div class="tab-content">
                <div id="see" class="tab-pane fade in active">
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Note</th>
                                            <th>Added on</th>
                                            <th>Updated on (If ever...)</th>
                                            <th>Edit/Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($records as $val)
                                            <tr>
                                                <th>{{ $val->id }}</th>
                                                <th>{{ $val->from }}</th>
                                                <th>{{ $val->to }}</th>
                                                <th><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#record{{ $val->id }}Note"><i class="fa fa-file-text-o"></i></button></th>
                                                <th>{{ $val->created_at }}</th>
                                                <th>{{ $val->updated_at }}</th>
                                                <th>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#record{{ $val->id }}Edit"><i class="fa fa-pencil"></i></button>
                                                    <button class="btn btn-danger btn-sm" onclick="delRecord({{ $val->id }})"><i class="fa fa-trash"></i></button>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{ $records->links() }}
                        </div>
                    </div>
                </div>
                
                @foreach($records as $val)
                    <div id="record{{ $val->id }}Note" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content panel-primary">
                                <div class="modal-header panel-heading">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3>Record {{ $val->id }}'s note</h3>
                                </div>
                                <div class="modal-body">
                                    @if(empty($val->note))
                                    <h4 class="text-center">There isn't a note written for this record.</h4>
                                    @else
                                        {{ $val->note }}
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="record{{ $val->id }}Edit" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content panel-primary">
                                <div class="modal-header panel-heading">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3>Record {{ $val->id }}'s note</h3>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="/update/{{ $val->id }}" id="edit{{ $val->id }}Form">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">From</label>

                                                <div class="col-md-9">
                                                    <input id="from" type="datetime-local" class="form-control" name="from" value="{{ $val->from }}" required autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">To</label>

                                                <div class="col-md-9">
                                                    <input id="to" type="datetime-local" class="form-control" name="to" value="{{ $val->to }}" required autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Note</label>

                                                <div class="col-md-9">
                                                    <textarea id="note" maxlength="512" rows="6" class="form-control" name="note" autofocus>{{ $val->note }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" onclick="document.getElementById('edit{{ $val->id }}Form').submit()"><i class="fa fa-pencil"></i> Save</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <form method="POST" id="delForm">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" id="delId" name="id">
                </form>
                
                <script>
                    function delRecord(id){
                        var prompt = window.confirm("Are you sure you want to delete the record?");
                        if(prompt == true){
                            $("#delForm").prop('action','/delete/' + id);
                            $("#delId").val(id);
                            $("#delForm").submit();
                        }
                    }
                </script>
                
                
                <div id="add" class="tab-pane fade">
                    <br>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3>Add to schedule</h3>
                                </div>
                                <div class="panel-body">
                                    <form method="post" action="/add">
                                        {{ csrf_field() }}

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">From</label>

                                                <div class="col-md-9">
                                                    <input id="from" type="datetime-local" class="form-control" name="from" required autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">To</label>

                                                <div class="col-md-9">
                                                    <input id="to" type="datetime-local" class="form-control" name="to" required autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Note</label>

                                                <div class="col-md-9">
                                                    <textarea id="note" maxlength="512" rows="6" class="form-control" name="note" autofocus>{{ old('note') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <button class="btn btn-primary pull-right" type="submit">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
