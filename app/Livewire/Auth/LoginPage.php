<?php

namespace App\Livewire\Auth;
use Livewire\Attributes\Title;

use Livewire\Component;
#[Title('Login')]
class LoginPage extends Component
{
    public $email;
    public $password;
    public function save(){
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required','min:5']
        ]);
        // Logic to authenticate the user and redirect to dashboard
        if(!auth()->attempt(['email'=>$this->email,'password'=>$this->password])){
            session()->flash('error','Invalid credentials');
            return;
        }
        return redirect()->to('/');
    }
    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
