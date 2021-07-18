<?php

namespace AnchorCMS\Nautical\Actions\Auth;

use Ixudra\Curl\Facades\Curl;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPublicKey
{
    use AsAction;

    public function handle(string $bearer_token, string $integration_id)
    {
        $results = false;
        $service_id = env('ANCHOR_CMS_SERVICE_UUID');
        $url = config('nautical.anchor_cms_url')."/api/integrations/{$integration_id}?public_key=true";
        $response = Curl::to($url)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Service' => $service_id,
                'Authorization' => "Bearer {$bearer_token}",
            ])
            ->asJson(true)
            ->get();


        if($response && is_array($response))
        {
            if(array_key_exists('success', $response) && $response['success'])
            {
                if(array_key_exists('public_key', $response))
                {
                    $results = $response['public_key'];
                }

            }
        }

        return $results;
    }
}
