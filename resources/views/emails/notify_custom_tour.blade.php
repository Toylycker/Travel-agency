@extends('emails.layouts.master')

@section('title', 'Düzülüp ýüz tutulan syýahat barada maglumat')

@section('content')
<p>Hormatly Admin,</p>
<p>Bir ulanyjy özelleşdirilen syýahat barada sorag berdi.</p>

<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Yurt:</strong> {{ $country_name }}</p>
<p><strong>Islenilýän Ýerler:</strong></p>
<ul>
    @foreach($places as $place)
        <li>{{ $place->name }}</li>
    @endforeach
</ul>
<p><strong>Bellik:</strong> {{ $note }}</p>

<p>Hormatly salam bilen,<br>Siziň Web Sahypaňyz</p>
@endsection
