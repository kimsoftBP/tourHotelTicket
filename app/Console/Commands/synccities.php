<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Country;
use App\City;

class synccities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:cities';

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
        
        $now=now();
/*
        $data = DB::table('pagesyncurl')                                     
            ->where('syncurl','!=','')                 
            ->get();

        
        foreach ($data as $row) {
         */   
            $spreadsheetlonglink="https://docs.google.com/spreadsheets/d/1RrtrYDHzM2EE4nUw2M0aIebNiVTKABt5fE-1wHFukDY/edit?usp=sharing";
            //$spreadsheetlonglink=$row->syncurl;
            //$page=$row->page;
            $spreadsheetseparate=explode("/",$spreadsheetlonglink);
            $spreadsheetId=$spreadsheetseparate[5];
           // $userid=$row->id;
            $client = $this->getClient();
            $service = new \Google_Service_Sheets($client);
            $range = 'Sheet1!A3:J';
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();
            
            
            $now=now();
            if (empty($values)) {
                echo "error";
            }else {
                
                foreach ($values as $row) {
                    if(isset($row[2]) ){
                        $country=trim($row[2]);
                        $city['en']=trim($row[3]);
                        $city['ko']=trim($row[4]);
                        $c=Country::where('name',$country)->first();
                        if($c==NULL){
                            echo "error ".$country." \n";
                        }else{
                        //    echo "up\n";
                            City::updateOrCreate([
                                'name'=>$city['en'],
                                'countryid'=>$c->id],[
                                    'namearray'=>json_encode($city),
                                    'updated_at'=>$now,
                                ]);
                        }

                        //echo $row[2]." ".$row[3]."\n"; 
                    }
                    
                }
            }
  //      }
      
    }

    public function getClient(){
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(\Google_Service_Sheets::SPREADSHEETS);
        //$jsonAuth=getenv('credentials.json');
        //$client->setAuthConfig($jsonAuth);
        $client->setAuthConfig('storage/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token2.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
}
