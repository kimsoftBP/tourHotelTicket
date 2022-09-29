<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerFaildpay extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('tour@kimsoft.at', config('app.name'))
            ->subject( config('app.name').' Payment:faild')
            ->view('emails.customerfaildpay');
    }
}
