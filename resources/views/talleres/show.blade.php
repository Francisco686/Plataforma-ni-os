@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="mb-3">
            <a href="{{ route('talleres.index') }}" class="btn btn-secondary">
                ← Regresar a Talleres
            </a>
        </div>

        <h2 class="text-center mb-4">Taller: <span class="text-primary">{{ $taller->titulo }}</span></h2>



        <div class="row justify-content-center">
            <div class="col-12">

            @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @foreach ($taller->secciones as $seccion)
                    <div class="card shadow rounded-4 mb-4">
                        <div class="card-body">
                            <h3 class="card-title">{{ $seccion->titulo }}</h3>
                            <p class="text-muted">Tipo: {{ ucfirst($seccion->tipo) }}</p>

                            @if ($seccion->tipo === 'lectura' || $seccion->tipo === 'actividad')
                                <div class="mb-3">
                                    <h5>Contenido</h5>
                                    <p>{{ $seccion->contenido }}</p>
                                </div>
                            @elseif ($seccion->tipo === 'test')
                                <div class="mb-3">
                                    <h5>Preguntas</h5>
                                    @php
                                        // Usar json_decode para compatibilidad con datos JSON
                                        $preguntas = json_decode($seccion->contenido ?? '[]', true);
                                        $opciones = json_decode($seccion->opciones ?? '[]', true);
                                        $respuestas = \App\Models\RespuestaAlumno::where('seccion_id', $seccion->id)
                                            ->where('user_id', Auth::id())
                                            ->get();
                                        $correctas = $respuestas->where('es_correcta', true)->count();
                                        $total = $respuestas->count();
                                        \Illuminate\Support\Facades\Log::debug('Datos en talleres/show.blade.php', [
                                            'seccion_id' => $seccion->id,
                                            'titulo' => $seccion->titulo,
                                            'preguntas' => $preguntas,
                                            'opciones' => $opciones,
                                        ]);
                                    @endphp

                                    @if ($respuestas->isNotEmpty())
                                        <p><strong>Calificación:</strong> {{ $correctas }}/{{ $total }} ({{ $total > 0 ? ($correctas / $total) * 100 : 0 }}%)</p>
                                    @else
                                        @if (is_array($preguntas) && is_array($opciones) && !empty($preguntas) && !empty($opciones))
                                            <form action="{{ route('respuestas.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="seccion_id" value="{{ $seccion->id }}">

                                                @foreach ($opciones as $index => $pregunta)
                                                    <div class="mb-4">
                                                        <p><strong>Pregunta {{ $index + 1 }}:</strong> {{ $pregunta['contenido'] ?? 'Pregunta no disponible' }}</p>
                                                        @if (isset($pregunta['opciones']) && is_array($pregunta['opciones']))
                                                            @foreach ($pregunta['opciones'] as $opcionIndex => $opcion)
                                                                <div class="form-check">
                                                                    <input type="radio" name="respuesta[{{ $index }}]" value="{{ $opcionIndex }}"
                                                                           class="form-check-input" id="opcion{{ $seccion->id }}_{{ $index }}_{{ $opcionIndex }}"
                                                                           required>
                                                                    <label class="form-check-label" for="opcion{{ $seccion->id }}_{{ $index }}_{{ $opcionIndex }}">
                                                                        {{ $opcion }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p class="text-danger">No hay opciones disponibles para esta pregunta.</p>
                                                        @endif
                                                        @error("respuesta.{$index}")
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach

                                                <button type="submit" class="btn btn-primary mt-2">Enviar Respuestas</button>
                                            </form>
                                        @else
                                            <p class="text-danger">No hay preguntas disponibles para este test.</p>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
