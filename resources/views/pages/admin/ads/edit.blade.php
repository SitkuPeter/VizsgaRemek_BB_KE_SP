@extends('layouts.app')

@section('pageTitle', 'Edit Advertisement')

@section('content')
    @include('pages.admin.ads.form', ['ad' => $ad])
@endsection
