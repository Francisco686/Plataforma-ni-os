@extends('layouts.app')

@section('content')
<h2>Taller: {{ $asigna->taller->nombre }}</h2>

<ul>
@foreach($secciones as $sec)
    <li>
        <strong>{{ $sec->nombre }}</strong><br>
        {{ $sec->descripcion ?? '' }}<br>

        @if(in_array($sec->id, $progreso))
            ✅ Completado
        @else
            <form method="POST" action="{{ route('talleres.completar') }}">
                @csrf
                <input type="hidden" name="asigna_taller_id" value="{{ $asigna->id }}">
                <input type="hidden" name="seccion_taller_id" value="{{ $sec->id }}">
                <button type="submit">Marcar como completado</button>
            </form>
        @endif

        <hr>
    </li>
@endforeach
</ul>
@endsection
