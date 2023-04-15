<?php

namespace App\Jobs;

use App\Mail\MailVoucher;
use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailByVoucher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $customer, $voucherIds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customer, $voucherIds)
    {
        $this->customer = $customer;
        $this->voucherIds = $voucherIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $vouchers = Voucher::whereIn("id", $this->voucherIds)->get();
        Mail::to($this->customer->email)->send(new MailVoucher($vouchers));
        foreach ($vouchers as $voucher) {
            $voucher->customers()->updateExistingPivot($this->customer->id, ['email_status' => 1]);
        }
    }
}
