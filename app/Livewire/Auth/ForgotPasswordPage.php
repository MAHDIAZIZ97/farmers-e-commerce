<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Forget-passrord')]

class ForgotPasswordPage extends Component
{

    public $email;
    public function save(){
        $this->validate([
            'email' => 'required|email|exists:users',
        ]);
        $status = Password::sendResetLink(['email'=>$this->email]); //

        if($status === Password::RESET_LINK_SENT) {
            return session()->flash('success', 'Password reset link sent successfully');
            $this->email = '';
        }

        // Send password reset link to the user's email
    }
    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
