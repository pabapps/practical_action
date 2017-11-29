<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserControllerHelperClass\UserContractHelper;

class SendContractNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PracticalAction:ContractNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends an email daily to the Hr, letting them know which person contract is going to end';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       
       UserContractHelper::contract_check();

        //need to send mail to the users who's contract is going to end given that 2 months(60 days) time 
        //left
       UserContractHelper::sendmail_to_active_users();
   }
}
