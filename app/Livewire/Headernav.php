<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Headernav extends Component
{
   
    
 
    
  /*   #[On('profileUpdated')] */
    public function render()
    {
      /*   $imgUrl = Auth::user()->img_url ? asset('storage/' . Auth::user()->img_url) : null; */
        return view('livewire.headernav');
    }
}
