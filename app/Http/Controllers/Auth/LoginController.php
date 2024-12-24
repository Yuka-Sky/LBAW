<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\View\View;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/posts');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:100'], 
            'password' => ['required', 'string', 'min:8', 'max:200'], 
        ]);
        
 
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
        
            $userId = Auth::id();
            
            $ban = DB::table('ban')
                ->where('id_user', $userId)
                ->where(function ($query) {
                    $query->where('permanent_bool', true)
                        ->orWhere(function ($subquery) {
                            $subquery->where('permanent_bool', false)
                                    ->where('end_date', '>=', now());
                        });
                })
                ->first();

            if ($ban) {
                Auth::logout();
            
                if ($ban->permanent_bool) {
                    $banMessage = '<i>A sua conta foi banida permanentemente.</i><br>Motivo: ' . $ban->reason . '<br>';
                } else {
                    $banMessage = '<i>A sua conta foi banida temporariamente.</i><br>Motivo: ' . $ban->reason . '<br>';
                }

                if ($ban->end_date && !$ban->permanent_bool) {
                    \Carbon\Carbon::setLocale('pt');
                    $endDate = \Carbon\Carbon::parse($ban->end_date);
                    $timeLeft = $endDate->diffForHumans();
                    $banMessage .= 'A suspensão será removida ' . $timeLeft . '.';
                }
            
                return back()->withErrors([
                    'email' => $banMessage, 
                ])->onlyInput('email');
            }
            return redirect('/posts');
        }
 
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registos.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('Deste logout com sucesso!');
    }
}
