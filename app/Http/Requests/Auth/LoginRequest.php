<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_code' => ['required'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $state = $this->activated($this->input("user_code"));

        if ($state == 0) {
            throw ValidationException::withMessages([
                "user_code" => trans("auth.deactivated"),
            ]);
        } elseif ($state === "UNKNOWN" || $state == 4) {
            throw ValidationException::withMessages([
                "user_code" => trans("auth.failed"),
            ]);
        } else {
            $this->ensureIsNotRateLimited();

            if (!Auth::attempt($this->only("user_code", "password"))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    "user_code" => trans("auth.failed"),
                ]);
            }

            RateLimiter::clear($this->throttleKey());

            $password = $this->input("password");

            Auth::logoutOtherDevices($password);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $empID = $this->input("user_code");

        $datalog = [
            "status" => 0,
            "empID" => $empID,
            "author" => $empID,
        ];

        $this->employeestatelog($datalog);

        event(new Lockout($this));

        throw ValidationException::withMessages([
            "emp_id" => trans("auth.deactivated"),
        ]);

        // $seconds = RateLimiter::availableIn($this->throttleKey());

        // throw ValidationException::withMessages([
        //     'emp_id' => trans('auth.throttle', [
        //         'seconds' => $seconds,
        //         'minutes' => ceil($seconds / 60),
        //     ]),
        // ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('user_code')).'|'.$this->ip());
    }

    public function activated($empID)
    {
        $query = DB::table("employees")
            ->select("status")
            ->where("user_code", $empID)
            ->limit(1)
            ->first();

        if ($query) {
            return $query->status;
        } else {
            return "UNKNOWN";
        }
    }
}
