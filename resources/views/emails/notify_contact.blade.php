@extends('emails.layouts.master')

@section('title', 'Täze Habar')

@section('content')
<p>Hormatly Admin,</p>
<p>Bir ulanyjydan täze habar geldi. Habar maglumaty:</p>

<p><strong>Email:</strong> {{ $Email }}</p>

<p><strong>Habar:</strong></p>
<p>{{ $Message }}</p>

<p>Hormatly salam bilen,<br>Siziň Web Sahypaňyz</p>
@endsection
