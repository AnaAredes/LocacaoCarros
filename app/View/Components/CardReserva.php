<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardReserva extends Component
{
    public $bem;
    public $caracteristicas;

    /**
     * Create a new component instance.
     */
    public function __construct($bem, $caracteristicas = [])
    {
        $this->bem = $bem;
        $this->caracteristicas = $caracteristicas;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-reserva');
    }
}
