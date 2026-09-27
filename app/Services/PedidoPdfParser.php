<?php

namespace App\Services;

use RuntimeException;

class PedidoPdfParser
{
    public function parse(string $path): array
    {
        $pdf = @file_get_contents($path);

        if ($pdf === false) {
            throw new RuntimeException(
                'No se pudo leer el PDF.'
            );
        }

        $stream = $this->getFlateStream($pdf);

        if ($stream === null) {
            throw new RuntimeException(
                'No se encontró el contenido de texto del PDF.'
            );
        }

        $content = @gzuncompress($stream);

        if ($content === false) {
            throw new RuntimeException(
                'No se pudo descomprimir el contenido del PDF.'
            );
        }

        $items = $this->extractTextItems($content);

        if (count($items) < 20) {
            throw new RuntimeException(
                'El PDF no parece corresponder a la plantilla de pedido esperada.'
            );
        }

        return [

            'numero_orden' =>
                $this->textNear($items, 434, 770),

            'cliente' =>
                $this->textNear($items, 79, 711),

            'ruc_cliente' =>
                $this->textNear($items, 79, 678),

            'fecha_pedido' =>
                $this->textNear($items, 79, 733),

            'fecha_entrega' =>
                $this->textNear($items, 354, 689),

            'hora_entrega' =>
                $this->textNear($items, 468, 689),

            'order_interna' =>
                $this->textNear($items, 384, 641),

            'productos' =>
                $this->extractProducts($items),
        ];
    }


    /**
     * Encontrar el stream de texto comprimido.
     */
    private function getFlateStream(string $pdf): ?string
    {
        $pos = 0;

        while (
            ($filter = strpos(
                $pdf,
                '/Filter/FlateDecode',
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

            /*
             * Verificamos que realmente sea
             * un stream que PHP puede descomprimir.
             */
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
     * Extraer textos y coordenadas del PDF.
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
            ((?:\\\\.|[^\\\\)])*)
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

            'text' => $text,

        ];
    }

    return $items;
}

    /**
     * Decodificar texto encerrado en (...)
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
     * Buscar texto por posición.
     */
    private function textNear(
        array $items,
        float $x,
        float $y,
        float $tol = 1.2
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
     * Extraer productos de la tabla.
     */
    private function extractProducts(
        array $items
    ): array {

        $rows = [];

        foreach ($items as $item) {

            /*
             * En esta plantilla las líneas
             * de productos están alrededor
             * de estas coordenadas.
             */
            if (
                $item['y'] < 540
                ||
                $item['y'] > 580
            ) {
                continue;
            }

            if (
                $item['x'] < 30
                ||
                $item['x'] > 570
            ) {
                continue;
            }

            $key = number_format(
                $item['y'],
                2,
                '.',
                ''
            );

            $rows[$key][] = $item;
        }


        /*
         * Ordenar filas de arriba hacia abajo.
         */
        usort(
            $rows,
            function ($a, $b) {

                return
                    $b[0]['y']
                    <=>
                    $a[0]['y'];
            }
        );


        $products = [];


        foreach ($rows as $row) {

            usort(
                $row,
                function ($a, $b) {

                    return
                        $a['x']
                        <=>
                        $b['x'];
                }
            );


            $get = function (
                float $x,
                float $tol = 8
            ) use ($row) {

                foreach ($row as $item) {

                    if (
                        abs(
                            $item['x'] - $x
                        ) <= $tol
                    ) {

                        return trim(
                            $item['text']
                        );
                    }
                }

                return null;
            };


            $itemNo =
                $get(36.78, 6);

            $cantidad =
                $get(58.54, 8);

            $unidad =
                $get(90.34, 8);

            $codigo =
                $get(119, 10);

            $descripcion =
                $get(196, 25);

            $precio =
                $get(489, 12);

            $total =
                $get(540, 15);


            /*
             * Si no tenemos los datos esenciales,
             * no consideramos esta fila como producto.
             */
            if (
                $itemNo === null
                ||
                $codigo === null
                ||
                $descripcion === null
                ||
                $cantidad === null
                ||
                $precio === null
            ) {
                continue;
            }


            $products[] = [

                'linea' =>
                    (int) $itemNo,

                'cantidad' =>
                    (float) str_replace(
                        ',',
                        '.',
                        $cantidad
                    ),

                'unidad' =>
                    $unidad,

                'codigo' =>
                    $codigo,

                'descripcion' =>
                    $descripcion,

                'precio_unitario' =>
                    (float) str_replace(
                        ',',
                        '.',
                        $precio
                    ),

                /*
                 * SOLO PARA LA VISTA PREVIA.
                 * NO SE GUARDARÁ.
                 */
                'total_pdf' =>
                    $total !== null
                        ? (float) str_replace(
                            ',',
                            '.',
                            $total
                        )
                        : null,
            ];
        }


        return $products;
    }
}