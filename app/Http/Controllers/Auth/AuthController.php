<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;

use Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     * Also passes a `redirect` query param that can be used
     * in the handleProviderCallback to send the user back to
     * the page they were originally at.
     *
     * @param Request $request
     * @return Response
     */
    public function redirectToProvider(Request $request)
    {
        return Socialite::driver('github')
                          ->with(['redirect_uri' => env('GITHUB_CALLBACK_URL' ) . '?redirect=' . $request->input('redirect')])
                          ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * If a "redirect" query string is present, redirect
     * the user back to that page.
     *
     * @param Request $request
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        $githubUser = Socialite::driver('github')->user();

        //Session::put('user1', $user);
        //$request->session()->put('user2', $user);
        /////return redirect('/activities')->with('user3', $user);
        session(['githubUser' => $githubUser]);

        $redirect = $request['redirect'];
        if($redirect)
        {
            return redirect($redirect);
        }

        return redirect('/activities');
    }
}