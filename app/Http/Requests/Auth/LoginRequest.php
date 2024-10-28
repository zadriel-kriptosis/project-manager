<?php

namespace App\Http\Requests\Auth;

use App\Exceptions\RequestException;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request as RequestFacade;
use Log;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',

        ];
    }


    public function process()
    {


        $user = User::where('username', $this->username)->first();
        if ($user == null) {
            throw new RequestException('Login failed. Please check your credentials and try again.');
        }
        // check if the password match
        if (!Hash::check($this->password, $user->password)) {
            throw new RequestException('Login failed. Please check your credentials and try again.');
        }

        if ($user->banned_until) {
            if (now()->lessThan($user->banned_until)) {
                // Calculate the difference in days and round it to the nearest whole number
                $bannedDays = round(now()->diffInDays($user->banned_until));

                // Determine the correct day text to use
                $dayText = $bannedDays === 1 ? Lang::get('messages.day') : Lang::get('messages.days');

                // Construct the message using the rounded day count
                $message = Lang::get('messages.account_suspended', ['days' => $bannedDays, 'dayText' => $dayText]);

                throw new RequestException($message);
            } else {
                // If the banned_until date has passed, set it to null and save the user
                $user->banned_until = null;
                $user->save();
            }
        }


        auth()->login($user);
        $this->logActivity($user);
        $user->save();
        session()->regenerate();
        // user does not have 2fa enabled, log him in straight away
        if ($user->login_2fa == false) {
            return redirect()->route('home');
        }

        // return route to verify 2fa
        return redirect()->route('auth.verify');
    }

    private function logActivity(User $user)
    {
        Activity::create([
            'user_id' => $user->id,
            'ip_address' => RequestFacade::ip(),
            'user_agent' => RequestFacade::header('User-Agent'),
            'last_activity' => 'Login',
            'last_login' => now(),
            'last_logout' => null
        ]);

        // Clean up old activities
        Activity::cleanupOldActivities($user->id);
    }
}
