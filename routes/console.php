<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\StreamOutput;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');


Artisan::command('run', function () {
    $this->info("Building project");
    $streamMigrate = fopen("php://output", "w");
    Artisan::call('migrate', [], new StreamOutput($streamMigrate)); // optional arguments
    $streamConfig = fopen("php://output", "w");
    Artisan::call('config:clear', [], new StreamOutput($streamMigrate));
    $streamServe = fopen("php://output", "w");
    Artisan::call('serve', [], new StreamOutput($streamMigrate));
})->describe('Running commands');
