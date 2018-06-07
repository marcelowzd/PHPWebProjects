<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4318ae2f25d6786609775655245185ff
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'PhpOffice\\PhpSpreadsheet\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'PhpOffice\\PhpSpreadsheet\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet',
        ),
    );

    public static $classMap = array (
        'Datamatrix' => __DIR__ . '/../..' . '/include/barcodes/datamatrix.php',
        'PDF417' => __DIR__ . '/../..' . '/include/barcodes/pdf417.php',
        'QRcode' => __DIR__ . '/../..' . '/include/barcodes/qrcode.php',
        'TCPDF' => __DIR__ . '/../..' . '/tcpdf.php',
        'TCPDF2DBarcode' => __DIR__ . '/../..' . '/tcpdf_barcodes_2d.php',
        'TCPDFBarcode' => __DIR__ . '/../..' . '/tcpdf_barcodes_1d.php',
        'TCPDF_COLORS' => __DIR__ . '/../..' . '/include/tcpdf_colors.php',
        'TCPDF_FILTERS' => __DIR__ . '/../..' . '/include/tcpdf_filters.php',
        'TCPDF_FONTS' => __DIR__ . '/../..' . '/include/tcpdf_fonts.php',
        'TCPDF_FONT_DATA' => __DIR__ . '/../..' . '/include/tcpdf_font_data.php',
        'TCPDF_IMAGES' => __DIR__ . '/../..' . '/include/tcpdf_images.php',
        'TCPDF_IMPORT' => __DIR__ . '/../..' . '/tcpdf_import.php',
        'TCPDF_PARSER' => __DIR__ . '/../..' . '/tcpdf_parser.php',
        'TCPDF_STATIC' => __DIR__ . '/../..' . '/include/tcpdf_static.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4318ae2f25d6786609775655245185ff::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4318ae2f25d6786609775655245185ff::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4318ae2f25d6786609775655245185ff::$classMap;

        }, null, ClassLoader::class);
    }
}
