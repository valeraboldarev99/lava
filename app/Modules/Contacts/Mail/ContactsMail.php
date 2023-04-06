<?php

namespace App\Modules\Contacts\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Modules\Contacts\Models\Contacts as Model;

class ContactsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function build()
    {
        return $this->from(config('mail.from'))
            ->subject(trans('Contacts::index.notice_title', ['app_name' => config('app.name')]))
            ->view('Contacts::email.message');
    }
}