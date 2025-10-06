<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComponenteAsd extends Component
{
    public ?User $usuario;
    public $idModal;

    public function __construct($id = '', $idModal = '')
    {
        $this->usuario = User::find($id);
        $this->idModal = $idModal;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.componente-asd');
    }
}
