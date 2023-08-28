<?php
//https://docs.github.com/en/rest?apiVersion=2022-11-28
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;



class GithubController extends Controller {
    public static function getStats() {
//        $response = Http::get('https://api.github.com/users/DarmorGamz');

        // Path to your Python script
        $pythonScriptPath = '../app/Http/Controllers/Scripts/test.py';

        // Create a new Process instance
        $process = new Process(['python3', $pythonScriptPath]);

        try {
            // Run the process
            $process->mustRun();

            // Get the process output
            $output = $process->getOutput();
            echo "Python output: $output";
        } catch (ProcessFailedException $exception) {
            // Handle errors if the process fails
            echo 'An error occurred: ' . $exception->getMessage();
        }
    }
}
