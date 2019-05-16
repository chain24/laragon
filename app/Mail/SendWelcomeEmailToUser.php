<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19.5.16
 * Time: 16:32
 */

namespace App\Mail;


use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmailToUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    public function __construct(User $user, $password = null)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Welcome to ' . config('app.name'))->markdown('email.user.welcome')
            ->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'password' => $this->password,
            ]);
    }
}
