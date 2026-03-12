<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;


class DownloadS3Bucket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 's3:download-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk('s3')->allFiles();

        foreach ($files as $file) {

            $content = Storage::disk('s3')->get($file);

            Storage::disk('local')->put('s3-download/' . $file, $content);

            $this->info("Downloaded: " . $file);
        }

        $this->info("All files downloaded successfully!");
    }
}
