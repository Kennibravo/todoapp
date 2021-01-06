<?php

namespace App\Console\Commands;

use App\Jobs\SendTodoReminderToUsers;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendReminderOnDeadlineForPendingTodo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pending-todo:send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands runs daily, it checks all pending Todo and check if
    today is their Deadline then sends a reminder email to the Creator
    ';

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
        Todo::whereStatus('pending')
            ->whereDate('deadline_date', Carbon::today()->toDateString())
            ->each(function ($todo) {
                SendTodoReminderToUsers::dispatch($todo->user);
            });
    }
}
