<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ajustes de DomPDF
    |--------------------------------------------------------------------------
    |
    | Aquí puedes establecer valores por defecto para la generación de tus PDFs.
    | Es posible sobreescribir cualquier directiva de configuración de DomPDF.
    |
    */
    'show_warnings' => false,   // Muestra una excepción si DomPDF encuentra advertencias. Desactivado por defecto.

    'public_path' => null,  // Permite sobreescribir la ruta pública si es necesario. Útil en entornos de hosting compartido.

    /*
     * La fuente Dejavu Sans no tiene todos los glifos para entidades convertidas como € y £.
     * Desactívalo si necesitas mostrar estos símbolos correctamente.
     */
    'convert_entities' => true,

    'options' => [
        /**
         * Directorio de fuentes de DOMPDF.
         * Aquí es donde DOMPDF almacenará las fuentes y sus métricas.
         * IMPORTANTE: Este directorio debe existir y tener permisos de escritura para el servidor web.
         *
         * Puedes añadir nuevas fuentes ejecutando `load_font.php` desde la línea de comandos.
         * Las 14 fuentes base de PDF (como Courier, Helvetica, Times-Roman) están siempre disponibles.
         * Cualquier otra fuente debe ser incrustada, lo que puede aumentar el tamaño del archivo PDF.
         */
        'font_dir' => storage_path('fonts'),

        /**
         * Directorio de caché para las fuentes.
         * Contiene las métricas de fuentes cacheadas para acelerar la generación de PDFs.
         * Puede ser el mismo directorio que 'font_dir'.
         * IMPORTANTE: También debe tener permisos de escritura.
         */
        'font_cache' => storage_path('fonts'),

        /**
         * Directorio temporal.
         * Requerido para descargar imágenes remotas o al usar el backend PDFLib.
         * Debe tener permisos de escritura.
         */
        'temp_dir' => sys_get_temp_dir(),

        /**
         * ==== ¡MUY IMPORTANTE! (CHROOT) ====
         *
         * El "chroot" de DomPDF previene que acceda a archivos del sistema fuera de un directorio específico.
         * Todos los archivos locales (imágenes, CSS) deben estar dentro de este directorio.
         * NUNCA lo configures como '/', ya que podría permitir a un atacante leer cualquier archivo del servidor.
         */
        'chroot' => realpath(base_path()),

        /**
         * Lista blanca de protocolos permitidos en las URIs (ej. para imágenes).
         * Por defecto permite data://, file://, http:// y https://.
         */
        'allowed_protocols' => [
            'data://' => ['rules' => []],
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        /**
         * Archivo de log. Si se establece, DomPDF escribirá información de depuración aquí.
         * Déjalo como `null` para desactivarlo.
         */
        'log_output_file' => null,

        /**
         * Habilita o deshabilita el "subsetting" de fuentes.
         * Si está activado, solo se incrustarán los caracteres de la fuente que se usan en el documento,
         * reduciendo significativamente el tamaño del archivo PDF.
         */
        'enable_font_subsetting' => false,

        /**
         * Backend de renderizado de PDF.
         * 'CPDF' es el motor por defecto y funciona bien en la mayoría de los casos.
         * 'PDFLib' es una alternativa comercial más potente.
         * 'GD' se usa para renderizar el PDF como una imagen (uso experimental).
         * 'auto' intentará usar PDFLib y si no, volverá a CPDF.
         */
        'pdf_backend' => 'CPDF',

        /**
         * El "media type" de CSS que se usará para renderizar.
         * 'screen' simula cómo se ve en pantalla.
         * 'print' usa los estilos específicos para impresión.
         * Otros: 'handheld', 'projection', etc.
         */
        'default_media_type' => 'screen',

        /**
         * Tamaño de papel por defecto.
         * "a4" es el estándar internacional.
         * "letter" es el estándar en Norteamérica.
         */
        'default_paper_size' => 'a4',

        /**
         * Orientación del papel por defecto.
         * 'portrait' (vertical) o 'landscape' (horizontal).
         */
        'default_paper_orientation' => 'portrait',

        /**
         * Fuente por defecto.
         * Se usará si no se especifica ninguna otra o si la fuente especificada no se encuentra.
         * Debe ser una de las fuentes base o una que hayas instalado.
         */
        'default_font' => 'serif',

        /**
         * DPI (Puntos por pulgada) para las imágenes.
         * Este valor se usa para calcular el tamaño de las imágenes si se especifican en píxeles (px).
         * 96 es un valor estándar para la web. Aumentarlo puede hacer que las imágenes se vean más pequeñas.
         */
        'dpi' => 96,

        /**
         * ==== ¡RIESGO DE SEGURIDAD! ====
         * Habilita la ejecución de PHP dentro de etiquetas <script type="text/php">.
         * Si procesas HTML de fuentes no confiables, DEBE estar en `false`.
         * Un atacante podría ejecutar código malicioso en tu servidor.
         */
        'enable_php' => false,

        /**
         * Habilita JavaScript en el PDF.
         * Ojo: Este es JavaScript que se ejecuta en el visor de PDF (como Adobe Acrobat),
         * no en el navegador durante la renderización.
         */
        'enable_javascript' => true,

        /**
         * ==== ¡RIESGO DE SEGURIDAD! ====
         * Permite a DomPDF acceder a recursos remotos (imágenes, CSS desde otras webs).
         * Si procesas HTML de fuentes no confiables, es más seguro mantenerlo en `false`.
         * Podría usarse para que tu servidor descargue contenido no deseado.
         */
        'enable_remote' => false,

        /**
         * Lista de hosts remotos permitidos.
         * Si 'enable_remote' es `true`, puedes restringir las descargas a solo ciertos dominios.
         * Déjalo como `null` para permitir cualquier host (menos seguro).
         */
        'allowed_remote_hosts' => null,

        /**
         * Un factor de multiplicación aplicado a la altura de las fuentes para simular mejor el 'line-height' de los navegadores.
         */
        'font_height_ratio' => 1.1,

        /**
         * Usar el parser de HTML5.
         * Es una buena práctica mantenerlo en `true` para un mejor soporte de HTML moderno.
         */
        'enable_html5_parser' => true,
    ],

];
