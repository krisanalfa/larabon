@extends('app')

@section('title')
{{ studly_case($name) }} Create
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route($name.'.index') }}">{{ studly_case($name) }}</a></li>
                <li class="active">Create</li>
            </ol>

            <div class="panel panel-default">
                <div class="panel-heading">{{ studly_case($name) }} Create</div>

                <div class="panel-body">
                    {!! app()->make('Bonoize\Notification')->show() !!}

                    <form class="form-horizontal" action="{{ route($name.'.store') }}" method="POST">
                        @foreach ($schemas as $field => $element)
                        <div class="form-group">
                            <label for="{{ $field }}" class="col-sm-2 control-label">{{ ucfirst($field) }}</label>
                            <div class="col-sm-10">
                                {!! $element->formatInput($field, $model->$field) !!}
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <input type="hidden" name="_token" value="{{ Session::token() }}" />
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a class="btn btn-default btn-md" href="{{ route($name.'.index') }}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
