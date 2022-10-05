<?php

namespace App\Jobs;

use App\Tasks\ProductTask;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// use InApps\IAModules\Helpers\LogHelper;
use App\Tasks\FashionAccessoriesTask;
use Illuminate\Support\Facades\Log;

class ProcessImportData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $productTask;
    private $excel_path;

    public function __construct($excel_path = '')
    {
        $this->excel_path = $excel_path;
        $this->productTask = new ProductTask();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $excel_path = $this->excel_path;

            $this->productTask->getData($excel_path);
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            // LogHelper::error('Import error', ['message' => $e->getMessage()]);
        }
    }
}
