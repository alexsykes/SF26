@extends('errors::minimal')
{{--@extends('layouts.app')--}}

@section('content')
    <h1>Welcome to Our Website</h1>
    <p>Here's the introduction or any other content you would like to put here.</p>
@endsection


@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Apologies - something appears to have gone wrong! As we are still in the testing stage, this could be due to a number of factors. Please try again later…'))