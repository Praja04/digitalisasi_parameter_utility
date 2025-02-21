<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCustomerEmail extends Mailable
{
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
            ->subject('Welcome to our store!')
            ->view('emails.new_customer');  // Pastikan view ini ada
    }
}

