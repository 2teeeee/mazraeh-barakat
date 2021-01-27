
    @extends('layouts.admin')

@section('title', 'نمایش کاربر ها')

@section('content')
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <h1>Showing {{ $model->fname }} {{ $model->lname }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $model->fname }} {{ $model->lname }}</h2>
        <p>
            <h3>{{ $model->mobile }}</h3>
            <h3>{{ $model->email }}</h3>
            <h3>{{ $model->uname }}</h3>
        </p>
    </div>

@stop