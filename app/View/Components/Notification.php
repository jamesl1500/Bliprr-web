<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class Notification extends Component
{
    public $notification;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        //
        $this->notification = $notification;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Fetch user notification by ID from database without model
        $note = DB::table('notifications')->where('id', $this->notification)->first();

        // Make sure notification exists
        if ($note) {
            return view('components.notification', [
                'note_data' => $note
            ]);
        }    
    }
}
