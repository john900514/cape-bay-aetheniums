<?php

namespace AnchorCMS\Nautical\Http\Controllers;

use AnchorCMS\Nautical\Actions\Auth\GetPublicKey;
use App\Models\User;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JWTAuthController extends Controller
{
    protected $user_model;
    /**
     * Create a new controller instance.
     * @param Request $request
     * @param User $user_model
     * @return void
     */
    public function __construct(Request $request, User $user_model)
    {
        parent::__construct($request);
        $this->user_model = $user_model;
    }

    public function homeRoute()
    {
        $data = $this->request->all();

        $validated = Validator::make($data, [
            'token' => 'bail|required', //the jwt request needing to be decoded
            'session' => 'bail|required', // the auth token for the request to get a public key
            'uuid' => 'bail|required', //uuid of the integration to get a public key for0
        ]);

        if ($validated->fails())
        {
            return view(config('nautical.root_default_route'));
        }


        // Use the Package to get the public key or send to 500
        $key_action = GetPublicKey::make();
        if($public_key = $key_action->run($data['session'], $data['uuid']))
        {
            try
            {
                // Use the Public Key to decrypt the JWT or 401
                $decoded_jwt = JWT::decode($data['token'], $public_key, array('RS256'));

                // Login as the user with backpack
                $user = $this->user_model->find($decoded_jwt->user);

                /**
                 * STEPS
                 * 7. Bring in the Roles Model in the Package and Make Bouncer use em
                 * 8. Get the user's role or 403
                 * 9. Make "sso tunnel" controller in the main project and redirect user there with the destination as custom after logic
                 * 10. Use #9 to Make developer's dashboard (Controller method and) view
                 * 11. Use #9 and If user is developer, redirect the /library if destination is '/' else go to the /destination
                 */

                backpack_auth()->login($user);

                if(!is_null(backpack_user()))
                {
                    session()->put('user_backend_api_token', $data['session']);
                    return redirect('library'.$decoded_jwt->destination);
                }

            }
            catch(BeforeValidException $e)
            {
                \Alert::warning($e->getMessage());
                return view('errors.401', ['exception' => $e]);
            }
        }
        else
        {

        }

    }

    public function login($anchor_side_uuid)
    {

    }
}
