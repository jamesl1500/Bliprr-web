<?php

namespace App\View\Components;

use Illuminate\View\Component;

use App\Models\User;
use App\Models\Blips;

class Blip extends Component
{
    public $blip;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($blip)
    {
        $this->blip = $blip;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Fetch the blip from the database
        $blip = Blips::find($this->blip)->toArray();
        
        // Return the view with the blip if it exists
        if ($blip)
        {
            // Get the blip's author
            $user = User::find($blip['blip_author'])->toArray();

            return view('components.blip', ['blip_info' => $blip, 'user' => $user]);
        }
    }
}
