<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendAnyMail extends Command
{
    protected $signature = 'mail:send {class} {--email=} {--model=} {--data=}';

    protected $description = 'Send any Mailable class by name. Usage: php artisan mail:send "App\\Mail\\FiliereCreated" --email=foo@bar --model="App\\Models\\Personnel:MAILTEST1" --data="{\"plainPassword\":\"Secret123\"}"';

    public function handle()
    {
        $class = $this->argument('class');

        if (! class_exists($class)) {
            $this->error("Class {$class} does not exist.");
            return 1;
        }

        if (! is_subclass_of($class, \Illuminate\Mail\Mailable::class)) {
            $this->error("Class {$class} is not a Mailable.");
            return 1;
        }

        $email = $this->option('email') ?? config('mail.from.address');

        // Prepare parameters for constructor
        $params = [];

        // --model=App\\Models\\Personnel:MAILTEST1
        if ($this->option('model')) {
            [$modelClass, $id] = explode(':', $this->option('model')) + [null, null];
            if (! class_exists($modelClass)) {
                $this->error("Model class {$modelClass} not found.");
                return 1;
            }
            $model = $modelClass::find($id);
            if (! $model) {
                $this->error("Model {$modelClass} with id {$id} not found.");
                return 1;
            }
            // Try to add with a reasonable key (lower snake of class short name)
            $short = Str::snake(class_basename($modelClass));
            $params[$short] = $model;
            // also add 'model' key
            $params['model'] = $model;
        }

        if ($this->option('data')) {
            $json = $this->option('data');
            $decoded = json_decode($json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Invalid JSON provided to --data.');
                return 1;
            }
            // merge data into params
            $params = array_merge($params, $decoded);
        }

        try {
            // Let the container resolve the mailable using named parameters
            $mailable = app()->makeWith($class, $params);
        } catch (\Throwable $e) {
            $this->error('Failed to instantiate mailable: ' . $e->getMessage());
            return 1;
        }

        try {
            Mail::to($email)->send($mailable);
            $this->info("Mail sent to {$email} using {$class}");
            return 0;
        } catch (\Throwable $e) {
            $this->error('Mail send failed: ' . $e->getMessage());
            return 1;
        }
    }
}
