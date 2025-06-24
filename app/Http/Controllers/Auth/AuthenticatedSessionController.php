<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        if($this->password_set(Auth::user()->user_code) == 0){

            return redirect()->route('profile.change-password');

        }
        else{
            // $this->setPermissions(Auth::user()->emp_id);
            // $result=$this->dateDiffCalculate();
            // if($result >= 90){
            //     return redirect('/change-password')->with('status', 'You password has expired');
            // }
            $request->session()->regenerate();
            // dd(session()->all());
            if (session('pass_age') >= 90) {

                return redirect('/change-password')->with('status', 'You password has expired');

            }else{
                $employeeName = Auth::user()->fname.' '.Auth::user()->mname;

                // SysHelpers::AuditLog(1, 'Logged in with '.$employeeName , $request);

                // redirect to specific page if $request->next is set
                if($request->next){
                    return redirect($request->next);
                }
                return redirect()->intended(RouteServiceProvider::HOME);
            // }
        }
    }

    }

    public function password_set($empID)
    {
        $query = DB::table('employees')
            ->select('password_set')
            ->where('user_code', $empID)
            ->limit(1)
            ->first();

        if($query){
            return $query->password_set;
        }else{
            return 'UNKNOWN';
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function checkActiveAccount($emp_id)
    {
        $status = DB::table('sys_account')
            ->select('account')
            ->where('user_code', $emp_id)
            ->first();

        if(empty($status)){
            return "404";
        } else {
            return $status->account;
        }
    }
}
