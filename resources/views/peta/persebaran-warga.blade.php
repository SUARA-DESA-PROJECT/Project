@extends('layouts.app-warga')

@section('title', 'Peta Persebaran')

@section('content')
<div style="width: 100%; max-width: 900px; margin: 40px auto;">
    <h3 class="mb-4">Peta Persebaran (Google Maps)</h3>
    <div style="width: 100%; height: 500px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.10);">
        <iframe
            width="100%"
            height="500"
            frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.378049976593!2d112.7301463153342!3d-7.263563994747998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbf8c1b1b1b1%3A0x1e1e1e1e1e1e1e1e!2sSurabaya%2C%20Jawa%20Timur!5e0!3m2!1sen!2sid!4v1680000000000!5m2!1sen!2sid"
            allowfullscreen=""
            aria-hidden="false"
            tabindex="0"></iframe>
    </div>
</div>
@endsection 