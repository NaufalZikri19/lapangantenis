<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class AutoCompleteBooking extends Command
{
    protected $signature = 'booking:auto-complete';
    protected $description = 'Auto update booking menjadi completed';

    public function handle()
    {
        Booking::autoComplete();

        $this->info('Booking updated to completed');
    }
}
