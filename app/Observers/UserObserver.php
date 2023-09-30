<?php

namespace App\Observers;

use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        // Enviar o e-mail de boas-vindas
        Mail::to($user->email)->send(new WelcomeEmail($user));

    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
