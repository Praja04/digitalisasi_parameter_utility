<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoyalCustomerEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    use Queueable, SerializesModels;

    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }


    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->to($this->customer->email)
            ->subject('Selamat Menjadi Loyal Customer!')
            ->view('emails.loyal_customer');
    }
}
