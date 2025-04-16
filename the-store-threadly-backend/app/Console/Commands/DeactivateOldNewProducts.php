<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeactivateOldNewProducts extends Command
{
    protected $signature = 'products:deactivate-old-new';
    protected $description = 'Deactivate is_new for products older than 15 days';

    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(15);

        $affected = Product::where('is_new', 1)
            ->where('created_at', '<', $cutoffDate)
            ->update(['is_new' => 0]);

        $this->info("Deactivated 'is_new' for {$affected} product(s).");
    }
}
