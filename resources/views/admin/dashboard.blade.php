@extends('layouts.app')
@section('content')
    <h1>
        Hello {{ Auth::user()->name }}
        User Role ID {{ Auth::user()->role_id }}
    </h1>
@endsection
