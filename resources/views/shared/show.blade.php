@extends('app')

@section('title')
{{ studly_case($name) }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route($name.'.index') }}">{{ studly_case($name) }}</a></li>
                <li class="active">Show</li>
            </ol>

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ studly_case($name) }}

                    <form class="action" method="POST" id="deleteForm">
                        <input type="hidden" name="_token" value="{{ Session::token() }}" />
                        <input type="hidden" name="_method" value="DELETE">
                        <a class="btn btn-primary btn-sm pull-right" href="{{ route($name.'.edit', $model->getKey()) }}">Edit</a>
                        <button type="submit" id="deleteButton" class="btn btn-danger btn-sm pull-right">Delete</button>
                    </form>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal">
                        @foreach ($schemas as $name => $element)
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">{{ ucfirst($name) }}</label>
                                <div class="col-sm-10">
                                    {!! $element->formatReadonly($name, $model->$name) !!}
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>

            <div class="modal fade" id="deleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Warning</h4>
                        </div>
                        <div class="modal-body">
                            <p>You're about to delete this record.</p>
                            <p>This action is <strong>irreversible</strong>!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    </div>
</div>
@endsection

@section('customjs')
<script src="{{ asset('/js/show.js') }}"></script>
@endsection
