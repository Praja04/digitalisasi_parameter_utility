<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Mail\NewCustomerEmail;
use Illuminate\Support\Facades\Mail;

class SendCustomerEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:customer-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to customers based on their status every hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil semua pelanggan berdasarkan status
        $customers = Customer::whereIn('status', ['NEW CUSTOMER', 'LOYAL CUSTOMER'])->get();

        if ($customers->isEmpty()) {
            $this->info('No customers found with specified statuses.');
            return;
        }

        foreach ($customers as $customer) {
            // Kirim email ke customer
            Mail::to($customer->email)->queue(new NewCustomerEmail($customer));
            $this->info("Email sent to: {$customer->email} ({$customer->status})");
        }
    }
}
