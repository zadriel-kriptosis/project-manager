<?php

namespace App\Http\Requests\Auth;

use App\Exceptions\RequestException;
use App\Models\User;
use App\Utilities\Encryption\Keypair;
use App\Utilities\Mnemonic\Mnemonic;
use Defuse\Crypto\Crypto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
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
            'username' => 'required|unique:users|alpha_num|min:4|max:14',
            'password' => 'required|confirmed|min:8',
            'pin' => 'required|digits:6',
            'terms_accepted' => 'accepted|required',
                        // -> CAPTCHA CHECK (positions)
            'position_x' => 'required_with:position_y|integer',
            'position_y' => 'required_with:position_x|integer',
        ];
    }

    public function process()
    {
        $captchaValidator = new \App\Utilities\Captcha\ValidateCaptcha($this);

        if (!$captchaValidator->validate()) {
            throw new RequestException('CAPTCHA validation failed');
        }

        //check if there is referral id
        if ($this->refid !== null) {
            $referred_by = User::where('referral_code', $this->refid)->first();
        } else
            $referred_by = null;


        // create users public and private RSA Keys
        $keyPair = new Keypair();
        $privateKey = $keyPair->getPrivateKey();
        $publicKey = $keyPair->getPublicKey();
        // encrypt private key with user's password
        $encryptedPrivateKey = Crypto::encryptWithPassword($privateKey, $this->password);

        $mnemonic = (new Mnemonic())->generate(config('marketplace.mnemonic_length'));

        $user = new User();
        $user->username = $this->username;
        $user->password = bcrypt($this->password);
        $user->mnemonic = bcrypt(hash('sha256', $mnemonic));
        $user->referral_code = strtoupper(Str::random(10));
        $user->identifier = strtoupper(Str::random(24));
        $user->msg_public_key = encrypt($publicKey);
        $user->msg_private_key = $encryptedPrivateKey;
        $user->referred_by = optional($referred_by)->id;
        $user->pin = $this->pin;
        $user->save();

        // generate vendor addresses
//        $user->generateDepositAddresses();

        //UserRegistered::dispatch($user);

        session()->flash('mnemonic_key', $mnemonic);
    }

}
