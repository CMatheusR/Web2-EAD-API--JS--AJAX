<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tablelist extends Component
{
    public $header;
    public $data;

    public function __construct($header, $data, $tipo)
    {
        $this->header = $header;
        $this->data = $data;
        $this->tipo = $tipo;
    }

    public function render()
    {
        return view('components.tablelist');
    }
}
