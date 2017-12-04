<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\ContractNotificationMail;


class ContractNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $user;
    protected $time;

    public function __construct($user,$time)
    {
        $this->user = $user;
        $this->time = $time;

        // dd($time);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         // dd($this->time);

        //php artisan queue:work database
        $email = new ContractNotificationMail($this->user,$this->time);


        // Mail::to($this->user->email)->cc("raihan.zaman@practicalaction.org.bd")->send($email);
         Mail::to("raihan.zaman@practicalaction.org.bd")->send($email);

    }
}
