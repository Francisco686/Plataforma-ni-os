<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function show()
    {
        return view('juegos.index'); // Tu vista principal
    }

    public function combine(Request $request)
    {
        $materials = $request->input('materials');
        sort($materials); // Asegura el orden para coincidencia

        $combinations = [
            ['botella', 'cartón']     => [
                'Auto de juguete',
                'Transformaste una botella y cartón en un auto de juguete. ¡Buen trabajo!',
                '/images/auto-juguete.png'
            ],
            ['ropa', 'botella']       => [
                'Estuche ecológico',
                'Convertiste ropa vieja y una botella en un estuche ecológico.',
                '/images/estuche-ecologico.png'
            ],
            ['cartón', 'ropa']        => [
                'Lámpara creativa',
                'Combinaste cartón con ropa para crear una lámpara decorativa.',
                '/images/lampara-creativa.png'
            ],
            ['lata', 'cartón']        => [
                'Portalápices',
                'Usaste una lata y cartón para hacer un portalápices útil.',
                '/images/portalapices.png'
            ],
            ['cd viejo', 'cartón']    => [
                'Reloj reciclado',
                'Creaste un reloj a partir de un CD viejo y cartón. ¡Increíble!',
                '/images/reloj-reciclado.png'
            ]
        ];

        $result = $combinations[$materials] ?? [
            'Creación desconocida',
            'Esta combinación aún no está disponible.',
            '/images/default.png'
        ];

        return response()->json([
            'title' => $result[0],
            'description' => $result[1],
            'image' => asset($result[2])
        ]);
    }
}
