<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
Use Alert;
Use Session;

class OtaUpdateController extends Controller
{
    public function update(Request $request)
    {

        Artisan::call('migrate');

        \Artisan::call('migrate --path=database/migrations/update2_2');

        \Artisan::call('migrate --path=database/migrations/update2_3');

        \Artisan::call('migrate --path=database/migrations/update2_4');


        Artisan::call('migrate', [
            '--path' => 'vendor/laravel/passport/database/migrations',
            '--force' => true,

        ]);

        \Artisan::call('passport:install');

        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');


        Alert::success('Updated to ' . config('app.version'), 'Your App Updated Successfully !')->persistent('Close')->autoclose(8000);;
        

        
        return redirect('/');

    }

    public function getotaview()
    {
        return view('ota.update');
    }

    protected function changeEnv($data = array())
    {
        {
            if (count($data) > 0) {

                // Read .env-file
                $env = file_get_contents(base_path() . '/.env');

                // Split string on every " " and write into array
                $env = preg_split('/\s+/', $env);

                // Loop through given data
                foreach ((array) $data as $key => $value) {
                    // Loop through .env-data
                    foreach ($env as $env_key => $env_value) {
                        // Turn the value into an array and stop after the first split
                        // So it's not possible to split e.g. the App-Key by accident
                        $entry = explode("=", $env_value, 2);

                        // Check, if new key fits the actual .env-key
                        if ($entry[0] == $key) {
                            // If yes, overwrite it with the new one
                            $env[$env_key] = $key . "=" . $value;
                        } else {
                            // If not, keep the old one
                            $env[$env_key] = $env_value;
                        }
                    }
                }

                // Turn the array back to an String
                $env = implode("\n\n", $env);

                // And overwrite the .env with the new data
                file_put_contents(base_path() . '/.env', $env);

                return true;

            } else {

                return false;
            }
        }
    }
}
