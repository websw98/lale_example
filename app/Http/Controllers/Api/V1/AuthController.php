<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtpJob;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return sendData($validator->errors()->all(),300, 'error');
        }

        if (Otp::whereMobile($request['mobile'])->count()>config('auth.otp_allowed_number_per_hour')){
            $data=[
                'شما بیش از حد مجاز درخواست نموده اید لطفا بعدا مجدد امتحان نمایید .'
            ];
            return sendData($data,301,'error');
        }
        if (Otp::whereMobile($request['mobile'])->where('otp_expire_at','>',Carbon::now())->first()!=null){
            $data=[
                'کد تایید قبلا به شماره موبایل شما ارسال شده است بعد از 1 دقیقه مجداد درخواست نمایید.'
            ];
            return sendData($data,303,'error');
        }


        $mobile = $request['mobile'];

        $otp=Otp::createOtp($mobile);
        SendOtpJob::dispatch($otp);


        $data=[
            'کد تایید به شماره موبایل شما ارسال گردید.'
        ];
        return sendData($data,100);
    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function checkOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric',
            'otp' => 'required|integer|between:1000,9999'
        ]);

        if ($validator->fails()) {
            return sendData($validator->errors()->all(), 'error');
        }

        $mobile = $request['mobile'];
        $otp = $request['otp'];
        $otpRecord = Otp::getOtp($mobile, $otp);
        if (is_null($otpRecord)) {
            $data = [
                'مقدار وارد شده اشتباه است !'
            ];

            return  sendData($data, 304,'error');
        }

            $user = User::findByMobile($otpRecord->mobile);

            if (is_null($user)) {
               return $this->createUser($mobile);
            }else{
                return $this->userIsExist($mobile);
            }

    }

    /**
     * @param $mobile
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function createUser($mobile)
    {
        $newUser = User::createUser(array('mobile'=>$mobile));
        $token=$newUser->createToken('lale_example')->accessToken;
         $data['token']=$token;
         return sendData($data,101);
    }

    /**
     * @param $mobile
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function userIsExist($mobile)
    {
        $user=user::where('mobile',$mobile)->first();
        $token=$user->createToken('lale_example')->accessToken;
        $data['token']=$token;
        return sendData($data,101);
    }


}
