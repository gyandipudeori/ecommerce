<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Success - GyandipuisCoding')]
class SuccessPage extends Component
{
    public function render()
    {
        $latest_order = Order::with('address')->where('user_id', Auth::user()->id)->latest()->first();
        return view('livewire.success-page',[
            'order' => $latest_order,
        ]);
      }
}
