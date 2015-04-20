@extends('app')

@section('title')
{{ studly_case($name) }} Index
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">{{ studly_case($name) }}</li>
            </ol>

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ studly_case($name) }} Index

                    <div class="action">
                        <a class="btn btn-primary btn-sm pull-right" href="{{ route($name.'.create') }}">Create New</a>
                    </div>
                </div>

                <div class="panel-body">
                    {!! app()->make('Bonoize\Notification')->show() !!}

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                                <tr>
                                    @foreach ($schemas as $field => $element)
                                    <th>{{ studly_case($field) }}</th>
                                    @endforeach
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collection as $model)
                                    <tr>
                                        @foreach ($schemas as $field => $element)
                                            @if (head($schemas) === $element)
                                            <td>
                                                <a href="{{ route($name.'.show', $model->getKey()) }}">{!! $element->formatPlain($model->$field) !!}</a>
                                            </td>
                                            @else
                                            <td>
                                                {!! $element->formatPlain($model->$field) !!}
                                            </td>
                                            @endif
                                        @endforeach

                                        <td>
                                            <span>
                                                <a href="{{ route($name.'.edit', $model->getKey()) }}">Update</a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
