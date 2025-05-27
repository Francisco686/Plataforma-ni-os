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

        if (!is_array($materials) || count($materials) !== 2) {
            return response()->json(['error' => 'Se requieren dos materiales'], 400);
        }

        sort($materials);
        $key = implode(',', $materials);

        $combinations = [
            'botella,carton' => [
                'Auto de juguete',
                'Transformaste una botella y cartón en un auto de juguete. ¡Buen trabajo!',
                'assets/images/auto-juguete.png'
            ],
            'botella,ropa' => [
                'Estuche ecológico',
                'Convertiste ropa vieja y una botella en un estuche ecológico.',
                'assets/images/estuche-ecologico.png'
            ],
            'botella,lata' => [
                'Maceta reciclada',
                'Usaste una botella y una lata para crear una maceta original.',
                'assets/images/maceta-reciclada.png'
            ],
            'botella,cd' => [
                'Flor decorativa',
                'Diste nueva vida a una botella y un CD creando una flor decorativa reciclada.',
                'assets/images/flor-decorativa.png'
            ],

            'carton,ropa' => [
                'Lámpara creativa',
                'Combinaste cartón con ropa para crear una lámpara decorativa.',
                'assets/images/lampara-creativa.png'
            ],
            'carton,lata' => [
                'Portalápices',
                'Usaste una lata y cartón para hacer un portalápices útil.',
                'assets/images/portalapices.png'
            ],
            'carton,cd' => [
                'Reloj reciclado',
                'Creaste un reloj a partir de un CD viejo y cartón. ¡Increíble!',
                'assets/images/reloj-reciclado.png'
            ],
            'lata,ropa' => [
                'Bolsa reutilizable',
                'Transformaste ropa vieja y una lata en una bolsa reutilizable con soporte.',
                'assets/images/bolsa-reutilizable.png'
            ],
            'ropa,cd' => [
                'Collar original',
                'Hiciste un collar único usando ropa y un CD reciclado.',
                'assets/images/collar-original.png'
            ],
            'lata,cd' => [
                'Portavelas creativo',
                'Combinaste una lata y un CD para hacer un portavelas creativo.',
                'assets/images/portavelas-creativo.png'
            ],
            'cd,lata' => [
                'Portavelas creativo',
                'Combinaste una lata y un CD para hacer un portavelas creativo.',
                'assets/images/portavelas-creativo.png'
            ],
        ];

        $result = $combinations[$key] ?? [
            'Creación desconocida',
            'Esta combinación aún no está disponible.',
            '/images/default.png'
        ];

        return response()->json([
            'title' => $result[0],
            'description' => $result[1],
            'image' => asset($result[2]),
        ]);
    }


}
