<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusEmail;

class SendStatusEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:status-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send status email to customers every hour';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Ambil semua pelanggan dengan status yang diinginkan
        $customers = Customer::all();

        foreach ($customers as $customer) {
            // Kirim email kepada masing-masing pelanggan
            Mail::to($customer->email)->send(new StatusEmail($customer));
        }

        $this->info('Status email has been sent successfully!');
    }
}
