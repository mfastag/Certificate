<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\EventLog;


class CertificateReadyGeneric extends Mailable
{
    use Queueable, SerializesModels;


    public $subject;
    public $body;

    /** 
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject_in, $body_in)
    {
        $this->subject = $subject_in;
        $this->body = $body_in;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails/certificate_ready_generic');
    }

/*

pph artisan tinker

use App\Mail\CertificateReadyGeneric
Mail::to('kbush@elemcosoftware.com')->send(new CertificateReadyGeneric());

*/


}
