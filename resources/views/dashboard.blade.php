@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('css')
    <style>
        /* Estilos personalizados para el iframe del visor de documentos */
        .document-iframe {
            width: 100%;
            height: 75vh;
            border: none;
        }
        .card-body-iframe {
            padding: 0;
            overflow: hidden;
        }
        
        #docx-container .mammoth-styles {
            padding: 2rem;
            border: 1px solid #dee2e6;
            background-color: #FFFFFF; /* Fondo blanco para mejor legibilidad */
            line-height: 1.7;
            color: #212529; /* Color de texto oscuro estándar */
            font-family: 'Source Sans Pro',-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }
        /* Estilos para Títulos */
        #docx-container .mammoth-styles h1,
        #docx-container .mammoth-styles h2,
        #docx-container .mammoth-styles h3,
        #docx-container .mammoth-styles h4 {
            font-weight: 600;
            margin-top: 1.5em;
            margin-bottom: 0.8em;
            color: #007bff; /* Color primario de AdminLTE */
        }
        #docx-container .mammoth-styles h1 { font-size: 2em; }
        #docx-container .mammoth-styles h2 { font-size: 1.75em; }
        #docx-container .mammoth-styles h3 { font-size: 1.5em; }

        /* Estilos para Párrafos */
        #docx-container .mammoth-styles p {
            margin-bottom: 1.2em;
        }

        /* Estilos para Listas */
        #docx-container .mammoth-styles ul,
        #docx-container .mammoth-styles ol {
            padding-left: 2em;
            margin-bottom: 1.2em;
        }
        #docx-container .mammoth-styles li {
            margin-bottom: 0.6em;
        }

        /* Estilos para Tablas */
        #docx-container .mammoth-styles table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5em;
        }
        #docx-container .mammoth-styles th,
        #docx-container .mammoth-styles td {
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            text-align: left;
        }
        #docx-container .mammoth-styles th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h4>¡Bienvenido, {{ Auth::user()->name }}!</h4>
                    
                    @if(session('active_role_name'))
                        <p class="lead">
                            Has ingresado con el rol: <span class="badge badge-success px-2 py-1">{{ session('active_role_name') }}</span>
                        </p>
                    @else
                        <p class="lead">
                           Tus roles son: 
                           @foreach(Auth::user()->getRoleNames() as $role)
                                <span class="badge badge-primary">{{ $role }}</span>
                           @endforeach
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        @can('posts.index')
        <div class="col-md-4">
            <x-adminlte-info-box title="Publicaciones" text="Gestionar el blog" icon="fas fa-lg fa-newspaper text-primary"
                theme="gradient-primary" url="{{ route('posts.index') }}" url-text="Ver publicaciones"/>
        </div>
        @endcan

        @can('users.index')
        <div class="col-md-4">
            <x-adminlte-info-box title="Usuarios" text="Administrar usuarios" icon="fas fa-lg fa-users-cog text-danger"
                theme="gradient-danger" url="{{ route('users.index') }}" url-text="Administrar usuarios"/>
        </div>
        @endcan
        
        @can('categories.index')
         <div class="col-md-4">
            <x-adminlte-info-box title="Categorías" text="Gestionar categorías" icon="fas fa-lg fa-tags text-info"
                theme="info" url="{{ route('categories.index') }}" url-text="Ver categorías"/>
        </div>
        @endcan
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Sesión</h3>
        </div>
        <div class="card-body">
            <p><strong>ID de Usuario:</strong> {{ Auth::id() }}</p>
            <p><strong>Roles asignados en la BD:</strong> {{ Auth::user()->getRoleNames()->implode(', ') }}</p>
            <p><strong>Rol activo en sesión:</strong> {{ session('active_role_name', 'No aplica (rol único o sin selección)') }}</p>
        </div>
    </div> --}}

    <!-- INICIO: CÓDIGO DEL VISOR DE DOCUMENTOS -->
    <hr>
    <h2 class="my-4">Visor de Documentos Moderno</h2>

    <!-- Sección para visualizar PDF -->
    <div class="card card-primary card-outline mb-5">
        <div class="card-header">
            <h3 class="card-title">1. Visualizar PDF (Método Directo con Iframe)</h3>
        </div>
        <div class="card-body">
             <p>
                Para archivos PDF, esta es la forma correcta. El navegador lo renderiza de forma nativa dentro del iframe.
             </p>
        </div>
        <div class="card-body card-body-iframe">
            <!-- 
              NOTA: Apuntamos directamente a tu archivo en la carpeta /public.
              La función asset() de Laravel genera la URL correcta.
            -->
            <iframe src="{{ asset('Python introduction.pdf') }}" title="Visor de PDF" class="document-iframe"></iframe>
        </div>
    </div>

    <!-- Sección para visualizar DOCX -->
    <div class="card card-primary card-outline">
         <div class="card-header">
            <h3 class="card-title">2. Visualizar DOCX (Soluciones Modernas)</h3>
        </div>
        <div class="card-body">
            <p class="mb-4">
                Los navegadores no pueden mostrar archivos DOCX directamente. Aquí se muestran dos alternativas modernas.
            </p>
            
            <!-- Opción A: Visor de Terceros -->
            <div class="card card-info mb-4">
                 <div class="card-header">
                    <h4 class="card-title">Opción A: Visor de Terceros (Google Docs)</h4>
                </div>
                 <div class="card-body">
                    <p>La solución más rápida. Usamos el servicio de Google para renderizar el documento. Requiere que el archivo sea accesible públicamente en internet.</p>
                </div>
                <div class="card-body card-body-iframe">
                    <iframe src="https://docs.google.com/document/d/1fvC4RXO3KbpOryIHt2cYktcIq0tdvNm_/edit?usp=sharing&ouid=107228515078577135004&rtpof=true&sd=true" title="Visor de DOCX con Google" class="document-iframe"></iframe>
                </div>
            </div>

            <!-- Opción B: Librería JavaScript -->
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Opción B: Renderizado en el Cliente con Mammoth.js (¡Con Estilos!)</h4>
                </div>
                <div class="card-body">
                    <p>
                        Usando la librería <b>Mammoth.js</b> y CSS personalizado, convertimos un archivo <b>.docx</b> a HTML y lo mostramos aquí con un formato legible.
                    </p>
                    <div id="docx-container">
                        <div class="text-center p-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando documento...</span>
                            </div>
                            <p class="mt-2">Cargando previsualización del .docx...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN: CÓDIGO DEL VISOR DE DOCUMENTOS -->

@stop

@section('js')
    <!-- CDN de Mammoth.js -->
    <script src="https://cdn.jsdelivr.net/npm/mammoth@1.6.0/mammoth.browser.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // URL de ejemplo de un archivo .docx. 
            const docxUrl = '{{ asset('Python introduction.docx') }}';
            const container = document.getElementById("docx-container");

            // Usamos fetch para obtener el archivo .docx
            fetch(docxUrl)
                .then(response => response.arrayBuffer())
                .then(arrayBuffer => {
                    // Mammoth.js convierte el buffer del archivo a HTML
                    mammoth.convertToHtml({ arrayBuffer: arrayBuffer })
                        .then(result => {
                            // Mostramos el resultado en el div contenedor
                            container.innerHTML = '<div class="mammoth-styles">' + result.value + '</div>';
                            console.log(result.messages);
                        })
                        .catch(handleError);
                })
                .catch(handleError);

            function handleError(error) {
                console.error(error);
                container.innerHTML = '<div class="alert alert-danger">Error al renderizar el documento .docx.</div>';
            }
        });
    </script>
@stop