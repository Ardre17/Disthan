/**
 * Genera un Code128 (subset B) como SVG.
 *
 * $xDimension = ancho de cada módulo en mm.
 * $heightMm   = altura del código de barras en mm.
 */
public static function generateSvg(
    string $data,
    float $xDimension = 0.38,
    float $heightMm = 15.4
): string {

    $values = [104]; // Start B

    foreach (str_split($data) as $char) {

        $ord = ord($char);

        if ($ord < 32 || $ord > 126) {
            throw new \InvalidArgumentException(
                "Carácter no soportado en Code128B: {$char}"
            );
        }

        $values[] = $ord - 32;
    }

    // Checksum
    $checksum = $values[0];

    foreach (array_slice($values, 1) as $i => $val) {
        $checksum += $val * ($i + 1);
    }

    $values[] = $checksum % 103;

    // Stop
    $values[] = 106;

    $x = 0;
    $bars = '';

    foreach ($values as $val) {

        $isBar = true;

        foreach (str_split(self::$patterns[$val]) as $w) {

            /*
             * Cada número del patrón representa módulos.
             *
             * Ejemplo:
             * 2 módulos × 0.38 mm = 0.76 mm
             */
            $width = ((int) $w) * $xDimension;

            if ($isBar && $width > 0) {

                $bars .= sprintf(
                    '<rect x="%.4f" y="0" width="%.4f" height="%.4f" fill="#000"/>',
                    $x,
                    $width,
                    $heightMm
                );
            }

            $x += $width;

            $isBar = !$isBar;
        }
    }

    $totalWidth = $x;

    /*
     * Dejamos el tamaño físico directamente en milímetros.
     */
    return sprintf(
        '<svg xmlns="http://www.w3.org/2000/svg"
            width="%.4fmm"
            height="%.4fmm"
            viewBox="0 0 %.4f %.4f"
            preserveAspectRatio="none">
            %s
        </svg>',
        $totalWidth,
        $heightMm,
        $totalWidth,
        $heightMm,
        $bars
    );
}