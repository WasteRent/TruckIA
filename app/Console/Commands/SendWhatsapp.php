<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendWhatsapp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:whatsapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $sid = ""; // Your Account SID from www.twilio.com/console
        $token = ""; // Your Auth Token from www.twilio.com/console

        $client = new \Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
            'whatsapp:34699559550', // Text this number
            [
                'from' => 'whatsapp:+14155238886', // From a valid Twilio number
                'body' => 'Hello there!'
            ]
        );

        print $message->sid;
    }
}
