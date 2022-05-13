<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable=array('otp','mobile','otp_expire_at');

    public static function getOtp($mobile,$otp){
        return self::where('mobile',$mobile)->where('otp',$otp)->where('otp_expire_at','>',Carbon::now())->first();
    }


    public static function createOtp($mobile)
    {
        $otpCode = otpGenerate();
        return self::create([
            'mobile' => $mobile,
            'otp' => $otpCode,
            'otp_expire_at' => Carbon::now()->addSeconds(config('auth.otp_expire_at'))
        ]);
    }
}
