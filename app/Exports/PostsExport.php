<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class PostsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithDrawings, WithCustomStartCell
{
    protected $postId;
    private $postsCollection;

    /**
    * @param int|null $postId
    */
    public function __construct(?int $postId = null)
    {
        $this->postId = $postId;
        // Cacheamos la colección para no tener que consultarla de nuevo en los eventos
        if ($this->postId) {
            $this->postsCollection = Post::with('category', 'user')->where('id', $this->postId)->get();
        } else {
            $this->postsCollection = Post::with('category', 'user')->get();
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->postsCollection;
    }

    /**
     * Define la celda donde comenzará la tabla de datos.
     */
    public function startCell(): string
    {
        return 'A7';
    }

    /**
     * Añade imágenes a la hoja de cálculo.
     */
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo de la Empresa');
        // Asegúrate de tener una imagen en esta ruta o cámbiala
        $drawing->setPath(public_path('/vendor/adminlte/dist/img/AdminLTELogo.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('B2');

        return $drawing;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Categoría',
            'Autor',
            'Estado',
            'Tags',
            'Fecha de Creación',
        ];
    }

    public function map($post): array
    {
        return [
            $post->id,
            $post->title,
            $post->category->name ?? 'N/A',
            $post->user->name ?? 'N/A',
            ucfirst($post->status),
            $post->tags ? implode(', ', $post->tags) : '',
            $post->created_at->format('d/m/Y H:i:s'),
        ];
    }

    /**
     * Registra eventos para aplicar estilos dinámicos.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Combinar celdas para el título principal
                $event->sheet->mergeCells('B5:F5');
                $event->sheet->setCellValue('B5', 'REPORTE DE PUBLICACIONES');
                $event->sheet->getStyle('B5')->getFont()->setBold(true)->setSize(16);
                $event->sheet->getStyle('B5')->getAlignment()->setHorizontal('center');

                // Estilo para la cabecera de la tabla (fila 7)
                $event->sheet->getStyle('A7:G7')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '333333']]
                ]);

                // Aplicar estilos condicionales a las filas de datos
                foreach ($this->postsCollection as $index => $post) {
                    $rowNumber = $index + 8; // 7 (startCell) + 1 (header)
                    $color = null;

                    switch ($post->status) {
                        case 'published':
                            $color = 'C6EFCE'; // Verde claro
                            break;
                        case 'draft':
                            $color = 'FFEB9C'; // Amarillo claro
                            break;
                        case 'archived':
                            $color = 'FFC7CE'; // Rojo claro
                            break;
                    }

                    if ($color) {
                        $event->sheet->getStyle("A{$rowNumber}:G{$rowNumber}")->getFill()
                            ->setFillType('solid')->getStartColor()->setRGB($color);
                    }
                }
            },
        ];
    }
}