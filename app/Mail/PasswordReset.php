<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    private $code;
    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code = 000000, $user = null)
    {
        $this->code = $code;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('auth.passwords.reset-by-email', [
            'user' =>  $this->user,
            'code' => $this->code
        ]);
    }
}
