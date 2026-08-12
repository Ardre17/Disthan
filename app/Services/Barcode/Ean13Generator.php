<?php

namespace App\Services\Barcode;

class Ean13Generator
{
    protected static array $lCode = [
        '0001101','0011001','0010011','0111101','0100011',
        '0110001','0101111','0111011','0110111','0001011',
    ];

    protected static array $gCode = [
        '0100111','0110011','0011011','0100001','0011101',
        '0111001','0000101','0010001','0001001','0010111',
    ];

    protected static array $parityTable = [
        'LLLLLL','LLGLGG','LLGGLG','LLGGGL','LGLLGG',
        'LGGLLG','LGGGLL','LGLGLG','LGLGGL','LGGLGL',
    ];

    /**
     * Calcula el dígito de comprobación mod-10 para los primeros 12 dígitos.
     */
    public static function checkDigit(string $digits12): int
    {
        $sum = 0;
        foreach (str_split($digits12) as $i => $d) {
            $sum += (int) $d * ($i % 2 === 0 ? 1 : 3);
        }
        return (10 - ($sum % 10)) % 10;
    }

    /**
     * Genera un EAN-13 como SVG con tamaño físico real en mm.
     * Acepta 12 dígitos (calcula el checksum) o 13 (lo valida).
     */
    public static function generateSvgMm(string $data, float $moduleWidthMm = 0.38, float $heightMm = 22.9): string
    {
        $digits = preg_replace('/\D/', '', $data);

        if (strlen($digits) === 12) {
            $digits .= self::checkDigit($digits);
        }

        if (strlen($digits) !== 13) {
            throw new \InvalidArgumentException("EAN-13 requiere 12 o 13 dígitos numéricos, se recibió: {$data}");
        }

        $leading = (int) $digits[0];
        $left = substr($digits, 1, 6);
        $right = substr($digits, 7, 6);
        $parity = self::$parityTable[$leading];

        $bits = '101'; // guarda inicial

        foreach (str_split($left) as $i => $digit) {
            $bits .= $parity[$i] === 'L'
                ? self::$lCode[(int) $digit]
                : self::$gCode[(int) $digit];
        }

        $bits .= '01010'; // guarda central

        foreach (str_split($right) as $digit) {
            // R-code = complemento de bits de L-code
            $bits .= strtr(self::$lCode[(int) $digit], ['0' => '1', '1' => '0']);
        }

        $bits .= '101'; // guarda final

        $totalModules = strlen($bits);
        $widthMm = round($totalModules * $moduleWidthMm, 3);

        $bars = '';
        foreach (str_split($bits) as $i => $bit) {
            if ($bit === '1') {
                $bars .= "<rect x=\"{$i}\" y=\"0\" width=\"1\" height=\"100\" fill=\"#000\"/>";
            }
        }

        return "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"{$widthMm}mm\" height=\"{$heightMm}mm\" viewBox=\"0 0 {$totalModules} 100\" preserveAspectRatio=\"none\">{$bars}</svg>";
    }
}