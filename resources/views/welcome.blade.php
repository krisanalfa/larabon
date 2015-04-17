@extends('app')

@section('navbar')
@endsection

@section('customcss')
<style>
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        color: #747F84;
        display: table;
        font-weight: 400;
    }

    .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
    }

    .content {
        text-align: center;
        display: inline-block;
    }

    .title {
        font-size: 100px;
        margin-bottom: 20px;
    }

    .quote {
        font-size: 25px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="content">
        <div class="title">Laravel 5</div>
        <div class="quote">
            <p>{{ Inspiring::quote() }}</p>
            <small>Click <a href="{{ url('/home') }}">here</a> to go to Application.</small>
        </div>
    </div>
</div>
@endsection
