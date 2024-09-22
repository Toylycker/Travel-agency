@extends('emails.layouts.master')

@section('title', 'Syýahat üçin ýüz tutma')

@section('content')
<p>Hormatly Admin,</p>
<p>Bir ulanyjy syýahat üçin ýüz tutma tabşyrdy. Maglumatlar aşakda görkezilen:</p>

<p><strong>Ady:</strong> {{ $name }}</p>
<p><strong>Familiýasy:</strong> {{ $surname }}</p>
<p><strong>Ýurdy:</strong> {{ $country_name }}</p>
<p><strong>Email Salgysy:</strong> {{ $email }}</p>
<p><strong>Telefon Belgisi:</strong> {{ $phone }}</p>
<p><strong>Saýlan Turynyň ady:</strong> {{ $tour_name }}</p>
<p><strong>Adamlaryň Sany:</strong> {{ $quantity }}</p>
<p><strong>Geljek bolýan Senesi:</strong> {{ $arrival }}</p>
<p><strong>TKM-dan yzyna gitjek bolýan senesi:</strong> {{ $departure }}</p>
<p><strong>Bellik:</strong> {{ $note }}</p>
<p><strong>IP Salgy:</strong> {{ $ip }}</p>

<p>Hormatly salam bilen,<br>Siziň Web Sahypaňyz</p>
@endsection
