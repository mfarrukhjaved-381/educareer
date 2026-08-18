namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LiveJobController extends Controller
{
    public function fetchLiveJobs()
    {
        // Example: Fetching live job data using ScrapingBee API
        $client = new Client();
        $response = $client->request('GET', 'https://api.scrapingbee.com/v1/', [
            'query' => [
                'api_key' => env('SCRAPINGBEE_API_KEY'),
                'url' => 'https://www.linkedin.com/jobs/search?keywords=software%20developer',
            ]
        ]);
        
        // Assume the response has the live job data in a format that we need.
        $jobs = json_decode($response->getBody()->getContents(), true);

        // Now, we send these jobs to the view.
        return view('user-dashboard.recommended-jobs', ['recommendedJobs' => $jobs]);
    }
}
