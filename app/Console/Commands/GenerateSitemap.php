<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Carbon\Carbon;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

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
     * @return int
     */
    public function handle()
    {

            SitemapGenerator::create(config('app.url'))
            ->getSitemap()
            ->writeToFile(public_path('sitemap.xml'));


        /*
        SitemapGenerator::create(config('app.url'))
           ->getSitemap()
           ->add(Url::create('/en')
        ->setLastModificationDate(Carbon::yesterday())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(0.1))

    
        ->writeToFile(public_path('sitemap.xml'));
    */

            
        return 0;
    }
}
