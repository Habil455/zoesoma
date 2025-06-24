<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Notifications\EmailRequests;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employees;
    protected $email_data;

    /**
     * Create a new job instance.
     */
    public function __construct($email_data, $employees)
    {
        $this->employees = $employees;
        $this->email_data = $email_data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        
        foreach ($this->employees as $item) {
            $this->email_data['email'] = $item->email;
            $this->email_data['full_name'] = $item->fname . ' ' . $item->lname;
            Notification::route('mail', $this->email_data['email'])->notify(new EmailRequests($this->email_data));
        }
        // For Admin  Email
        // Notification::route('mail', 'baltazar.christian@cits.co.tz')->notify(new EmailRequests($this->email_data));
        $command = 'php artisan queue:work --stop-when-empty';

        //  $process = Process::fromShellCommandline($command);
        //  $process->run();
        // $process=
        exec('php artisan queue:listen  2>&1');

        // Get the output
        //  $output = $process->getOutput();

        // Sendinding Multiple Queus Mails
        // Notification::route('mail', $this->email_data['email'])->notify(new EmailRequests($this->email_data));
    }
}
