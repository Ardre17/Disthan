<?php

namespace App\Services;

use RuntimeException;

class PedidoSpsaPdfParser
{
    public function parse(string $path): array
    {
        $pdf = @file_get_contents($path);

        if ($pdf === false) {
            throw new RuntimeException(
                'No se pudo leer el PDF SPSA.'
            );
        }

        $stream = $this->getFlateStream($pdf);

        if ($stream === null) {
            throw new RuntimeException(
                'No se encontró el contenido de texto del PDF SPSA.'
            );
        }

        $content = @gzuncompress($stream);

        if ($content === false) {
            throw new RuntimeException(
                'No se pudo descomprimir el PDF SPSA.'
            );
        }

        $items = $this->extractTextItems($content);

        if (count($items) < 20) {
            throw new RuntimeException(
                'El PDF no parece corresponder a la plantilla SPSA.'
            );
        }

        $productos = $this->extractProducts($items);

        if (count($productos) === 0) {
            throw new RuntimeException(
                'No se encontraron productos en el pedido SPSA.'
            );
        }

        return [
            'plantilla' => 'SPSA',

            'numero_orden' =>
                $this->textNear(
                    $items,
                    150,
                    66
                ),

            'cliente' =>
                'SUPERMERCADOS PERUANOS SA',

            'ruc_cliente' =>
                '20100070970',

            'receptor' =>
                $this->textNear(
                    $items,
                    116,
                    83
                ),

            'fecha_pedido' =>
                $this->textNear(
                    $items,
                    116,
                    119
                ),

            'fecha_entrega' =>
                $this->textNear(
                    $items,
                    319,
                    119
                ),

            'order_interna' => null,

            'productos' => $productos,
        ];
    }


    /**
     * Encontrar el primer stream FlateDecode.
     */
    private function getFlateStream(
        string $pdf
    ): ?string {

        $pos = 0;

        while (
            ($filter = strpos(
                $pdf,
                '/FlateDecode',
                $pos
            )) !== false
        ) {

            $streamPos = strpos(
                $pdf,
                'stream',
                $filter
            );

            if ($streamPos === false) {
                return null;
            }

            $start = $streamPos + 6;

            if (
                substr($pdf, $start, 2)
                === "\r\n"
            ) {
                $start += 2;
            }
            elseif (
                substr($pdf, $start, 1)
                === "\n"
            ) {
                $start += 1;
            }
            elseif (
                substr($pdf, $start, 1)
                === "\r"
            ) {
                $start += 1;
            }

            $end = strpos(
                $pdf,
                'endstream',
                $start
            );

            if ($end === false) {
                return null;
            }

            $raw = substr(
                $pdf,
                $start,
                $end - $start
            );

            $raw = rtrim(
                $raw,
                "\r\n"
            );

            if (
                @gzuncompress($raw)
                !== false
            ) {
                return $raw;
            }

            $pos = $end + 9;
        }

        return null;
    }


    /**
     * Extraer textos y coordenadas.
     */
    private function extractTextItems(
        string $content
    ): array {

        $pattern = '/
            1\s+0\s+0\s+1
            \s+
            (-?\d+(?:\.\d+)?)
            \s+
            (-?\d+(?:\.\d+)?)
            \s+
            Tm
            (?:(?!1\s+0\s+0\s+1).)*?
            \(
                ((?:\\\\.|[^\\\\])*)
            \)
            Tj
        /sx';

        preg_match_all(
            $pattern,
            $content,
            $matches,
            PREG_SET_ORDER
        );

        $items = [];

        foreach ($matches as $match) {

            $text = $this->decodePdfString(
                $match[3]
            );

            if ($text === '') {
                continue;
            }

            $items[] = [
                'x' => (float) $match[1],
                'y' => (float) $match[2],
                'text' => trim($text),
            ];
        }

        return $items;
    }


    /**
     * Decodificar texto PDF.
     */
    private function decodePdfString(
        string $text
    ): string {

        return strtr(
            $text,
            [
                '\\n' => "\n",
                '\\r' => "\r",
                '\\t' => "\t",
                '\\b' => "\x08",
                '\\f' => "\x0C",
                '\\(' => '(',
                '\\)' => ')',
                '\\\\' => '\\',
            ]
        );
    }


    /**
     * Buscar texto por coordenada.
     */
    private function textNear(
        array $items,
        float $x,
        float $y,
        float $tol = 5
    ): ?string {

        foreach ($items as $item) {

            if (
                abs($item['x'] - $x) <= $tol
                &&
                abs($item['y'] - $y) <= $tol
            ) {
                return trim(
                    $item['text']
                );
            }
        }

        return null;
    }


    /**
     * Extraer productos SPSA.
     *
     * Cada fila tiene:
     *
     * Código SPSA
     * Código EAN
     * Descripción
     * Cantidad
     * Empaque
     * SKU / Empaque
     * Precio Neto
     */
    private function extractProducts(
        array $items
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Identificar filas usando el EAN
        |--------------------------------------------------------------------------
        |
        | El EAN tiene 13 dígitos y aparece siempre en la misma columna.
        |
        */

        $filas = [];

        foreach ($items as $item) {

            $texto = trim(
                $item['text']
            );

            if (
                !preg_match(
                    '/^\d{13}$/',
                    $texto
                )
            ) {
                continue;
            }

            /*
             * EAN.
             */
            if (
                $item['x'] < 75
                ||
                $item['x'] > 140
            ) {
                continue;
            }

            $filas[] = [
                'ean' => $texto,
                'y' => $item['y'],
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Ordenar por posición vertical
        |--------------------------------------------------------------------------
        */

        usort(
            $filas,
            function ($a, $b) {
                return $a['y'] <=> $b['y'];
            }
        );


        $productos = [];

        foreach (
            $filas as $indice => $fila
        ) {

            $ean = $fila['ean'];
            $y = $fila['y'];


            /*
            |--------------------------------------------------------------------------
            | Buscar datos de la misma fila
            |--------------------------------------------------------------------------
            */

            $cantidad = null;
            $skuEmpaque = null;
            $precioNeto = null;


            foreach ($items as $item) {

                $x = $item['x'];
                $iy = $item['y'];

                /*
                 * Cantidad.
                 */
                if (
                    $x >= 260
                    &&
                    $x <= 320
                    &&
                    abs($iy - $y) <= 2
                ) {

                    if (
                        preg_match(
                            '/^\d+(?:\.\d+)?$/',
                            trim($item['text'])
                        )
                    ) {
                        $cantidad =
                            $item['text'];
                    }
                }


                /*
                 * SKU / Empaque.
                 */
                if (
                    $x >= 350
                    &&
                    $x <= 400
                    &&
                    abs($iy - $y) <= 2
                ) {

                    if (
                        preg_match(
                            '/^\d+(?:\.\d+)?$/',
                            trim($item['text'])
                        )
                    ) {
                        $skuEmpaque =
                            $item['text'];
                    }
                }


                /*
                 * Precio Neto.
                 */
                if (
                    $x >= 395
                    &&
                    $x <= 435
                    &&
                    abs($iy - $y) <= 2
                ) {

                    if (
                        preg_match(
                            '/^\d+(?:[.,]\d+)?$/',
                            trim($item['text'])
                        )
                    ) {
                        $precioNeto =
                            $item['text'];
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Descripción
            |--------------------------------------------------------------------------
            |
            | En SPSA la descripción puede ocupar dos líneas.
            |
            */

            $descripcionPartes = [];

            foreach ($items as $item) {

                $x = $item['x'];
                $iy = $item['y'];

                if (
                    $x >= 130
                    &&
                    $x <= 270
                    &&
                    $iy >= ($y - 10)
                    &&
                    $iy <= ($y + 3)
                ) {

                    $texto = trim(
                        $item['text']
                    );

                    if ($texto !== '') {

                        $descripcionPartes[] = [
                            'y' => $iy,
                            'texto' => $texto,
                        ];
                    }
                }
            }


            usort(
                $descripcionPartes,
                function ($a, $b) {
                    return $a['y']
                        <=> $b['y'];
                }
            );


            $descripcion = implode(
                ' ',
                array_map(
                    fn ($parte) =>
                        $parte['texto'],
                    $descripcionPartes
                )
            );


            /*
            |--------------------------------------------------------------------------
            | Validar fila
            |--------------------------------------------------------------------------
            */

            if (
                $cantidad === null
                ||
                $skuEmpaque === null
                ||
                $precioNeto === null
                ||
                $descripcion === ''
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Crear producto normalizado
            |--------------------------------------------------------------------------
            */

            $productos[] = [

                /*
                 * El código principal será el EAN.
                 * Esto permite buscar directamente
                 * contra products.barcode.
                 */
                'codigo' => $ean,

                'codigo_ean' => $ean,

                'descripcion' =>
                    $descripcion,

                'cantidad' =>
                    (float) str_replace(
                        ',',
                        '.',
                        $cantidad
                    ),

                /*
                 * SPSA trabaja por Caja.
                 */
                'unidad' => 'Caja',

                /*
                 * SKU / Empaque.
                 */
                'sku_empaque' =>
                    (float) str_replace(
                        ',',
                        '.',
                        $skuEmpaque
                    ),

                /*
                 * Precio Neto.
                 */
                'precio_unitario' =>
                    (float) str_replace(
                        ',',
                        '.',
                        $precioNeto
                    ),

                /*
                 * No utilizaremos los totales
                 * de SPSA.
                 */
                'total_pdf' => null,
            ];
        }


        return $productos;
    }
}