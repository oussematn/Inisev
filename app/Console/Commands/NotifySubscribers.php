<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifySubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {details}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending emails to notify the subscribed users about a newly created post.';

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
     * @return int
     */
    public function handle()
    {
        $details = $this->argument('details');
        Mail::send('emails.notify', $details, function ($message, $details) {

            $message->from('inisev@gmail.com');

            $message->to($details->email)->subject('New post was added, check it out!');
        });
        $this->info('The email was sent successfully!');
    }
}
