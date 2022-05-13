<?php

/**
 * @param null $data
 * @param string $message
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
 */
function sendData($data = null,$code, $message = 'successful')
{
    return response([
        'data' => $data,
        'code'=>$code,
        'message' => $message,
    ]);
}


//generate otp
function otpGenerate()
{
    return rand(1000, 9999);
}

