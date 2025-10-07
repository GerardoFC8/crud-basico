<?php

namespace App\Http\Controllers;

use App\Exports\PostsExport;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:PostsManager')->except(['listPosts', 'showPublic']);
    }

    public function index(Request $request): View
    {
        $posts = Post::with('category')->latest()->get();
        return view('post.index', ['posts' => $posts]);
    }

    public function listPosts(Request $request): View
    {
        $posts = Post::where('status', 'published')->latest()->get();
        return view('post.list', ['posts' => $posts]);
    }

    public function create(Request $request): View
    {
        $categories = Category::all();
        $categorie = Category::find(1);
        $category_id = $categorie->id;

        $author_name = Auth::user()->name;
        $author_email = Auth::user()->email;
        $author_id = Auth::user()->userType->name;

        $id_cat222 = $request->id_categoria;

        return view('post.create', ['categories' => $categories, 
                                    'id_cat' => $category_id,
                                    'id_cat222' => $id_cat222,
                                    'author_name' => $author_name,
                                    'author_email' => $author_email,
                                    'author_id' => $author_id]);
    }

    public function store(PostStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '-' . Str::slug($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $data['image_path'] = $image->storeAs('posts', $fileName, 'public');
        }

        // Si el estado no es 'published', nos aseguramos que published_at sea null.
        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        }

        $this->handleComplexData($request, $data);

        $data['user_id'] = Auth::id(); // Asignar el ID del usuario autenticado
        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post creado exitosamente.');
    }

    public function show(Request $request, Post $post): View
    {
        return view('post.show', ['post' => $post]);
    }

    public function showPublic(Request $request, Post $post): View
    {
        $post->increment('views_count');
        return view('post.show-public', ['post' => $post]);
    }

    public function edit(Request $request, Post $post): View
    {
        $categories = Category::all();
        return view('post.edit', ['post' => $post, 'categories' => $categories]);
    }

    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $image = $request->file('image');
            $fileName = time() . '-' . Str::slug($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $data['image_path'] = $image->storeAs('posts', $fileName, 'public');
        }
        
        // Si el estado no es 'published', nos aseguramos que published_at sea null.
        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        }

        $this->handleComplexData($request, $data, $post);

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post actualizado exitosamente.');
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        if ($post->gallery_images) {
            foreach ($post->gallery_images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post eliminado exitosamente.');
    }

    private function handleComplexData(Request $request, array &$data, ?Post $post = null): void
    {
        if (!empty($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        } else {
            $data['tags'] = [];
        }

        if (!empty($data['meta_data'])) {
            $data['meta_data'] = array_values(array_filter($data['meta_data'], fn ($meta) => !empty($meta['key']) && !empty($meta['value'])));
        } else {
            $data['meta_data'] = [];
        }

        $galleryPaths = $post->gallery_images ?? [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $fileName = time() . '-' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $galleryPaths[] = $file->storeAs('posts/gallery', $fileName, 'public');
            }
        }
        $data['gallery_images'] = $galleryPaths;
        
        if (empty($data['author_info']['name']) && empty($data['author_info']['role'])) {
            $data['author_info'] = null;
        }
    }

    public function generatePDF()
    {
        // Obtenemos todos los posts con sus relaciones de categoría y usuario
        // Eager loading para optimizar consultas
        $posts = Post::with(['category', 'user'])->get();

        $data = [
            'title' => 'Reporte General de Posts',
            'date' => date('d/m/Y H:i:s'),
            'posts' => $posts
        ];

        // Carga la vista 'posts-pdf' y le pasa los datos
        $pdf = Pdf::loadView('post.posts-pdf', $data);

        // Opcional: Configurar tamaño
        $pdf->setPaper('A4');

        // Descargar el PDF con un nombre de archivo específico
        // return $pdf->download('reporte-posts.pdf');
        
        // O si quieres mostrarlo en el navegador sin descargarlo directamente:
        return $pdf->stream('reporte-posts.pdf');
    }

    public function generatePostPDF(Post $post)
    {
        // Definimos la ruta donde se guardarán los PDFs cacheados
        $pdfPath = "posts_pdf/post-{$post->id}.pdf";
        $disk = Storage::disk('public');

        // Lógica de caché
        // Comparamos el timestamp de actualización del post con el de modificación del archivo PDF
        $postTimestamp = $post->updated_at->timestamp;
        
        // Por defecto, asumimos que hay que regenerar el PDF
        $shouldRegenerate = true;

        if ($disk->exists($pdfPath)) {
            $pdfTimestamp = $disk->lastModified($pdfPath);
            
            // Si el PDF es más reciente o igual de antiguo que el post, no regeneramos
            if ($pdfTimestamp >= $postTimestamp) {
                $shouldRegenerate = false;
            }
        }

        // Si el archivo no existe o está desactualizado, lo generamos y guardamos
        if ($shouldRegenerate) {
            // Cargamos las relaciones para el PDF
            $post->load('user', 'category');

            $data = ['post' => $post];
            
            $pdf = Pdf::loadView('post.post-detail-pdf', $data);
            
            // Guardamos el contenido del PDF en el disco
            $disk->put($pdfPath, $pdf->output());
        }

        // Finalmente, servimos el archivo (ya sea el recién creado o el que ya existía)
        // Usamos la ruta completa del storage para que el response lo encuentre
        $fullPath = storage_path("app/public/{$pdfPath}");
        
        return response()->file($fullPath);
    }

    public function exportExcel() 
    {
        return Excel::download(new PostsExport, 'posts.xlsx');
    }

    public function exportPostExcel(Post $post) 
    {
        return Excel::download(new PostsExport($post->id), 'post-'.$post->id.'.xlsx');
    }
}