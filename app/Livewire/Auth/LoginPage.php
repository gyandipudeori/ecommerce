<?php

namespace App\Livewire\Auth;


use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attribute\Title;

class LoginPage extends Component
{
    public $email;
    public $password;

    public function save(){
        $this->validate([
            'email'=>'required|email|max:255|exists:users,email',
            'password'=>'required|min:8|max:255',
        ]);
        if (!auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', 'Invalid credentials');
            return;
        }
        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
