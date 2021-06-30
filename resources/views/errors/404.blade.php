@extends('errors.layout')

@php
  $error_number = 404;
@endphp

@section('title')
  Page not found.
@endsection

@section('description')
  @php
    $url = (!is_null(backpack_user())) ? '/library' : 'https://anchor.capeandbay.com';
    $default_error_message = 'Please <a href="javascript:history.back()">go back</a> or return to <a href="'.$url.'">our homepage</a>.';
  @endphp
  {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
@endsection
