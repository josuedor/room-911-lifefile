
@extends('layout')

@section('styles')
<style>
    .content-input{
        margin-top: 120px;
        max-width: 600px;
        height: 320px;
    }
</style>
@endsection

@section('content')
<div style="margin-top: 60px;"></div>
<div class="container-fluid content-input">
    <h2>Grant access to Room 911</h2>
    <form action="/createaccess" method="post">
        @csrf
        <input class="form-control form-control-lg" type="text" placeholder="Employed ID" aria-label="Identification" name="identification" id="identification">
        <br>
        <input type="submit" name="submit" class="btn btn-info btn-md" value="Submit">
    </form>
    @error('error')
        <br>
        <div class="alert alert-danger" role="alert">
            {{ $message }}
       </div>
    @enderror
    @if(session('ok'))
        <br>
        <div class="alert alert-success" role="alert">
            {{ session('ok') }}
       </div>
    @endif
</div>
@endsection