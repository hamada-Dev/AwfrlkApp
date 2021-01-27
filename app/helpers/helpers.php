<?php

function is_active($routeName){ 
    return null !== request()->segment('3') && request()->segment('3') == $routeName ? 'active' : '';
}

function getYoutubeId($url){
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return isset($match[1]) ? $match[1] : null ;
}

function slug($name){
    return strtolower(trim(str_replace(' ', '_', $name)));
}

function sendMessage($message, $recipients)
{

    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new \Twilio\Rest\Client($account_sid, $auth_token);
    $client->messages->create($recipients,
        ['from' => $twilio_number, 'body' => $message] );
}

function getPrice($datefrom, $dateto, $hotel_id, $type, $view, $accommodation, $check){

    $totalPrice=0;
    $avilableNights=0;
    while ($datefrom != $dateto)
    {
        $price=\App\Models\Room::where('hotel_id', $hotel_id)
            ->where('date_from', '<=',$datefrom)
            ->where('date_to', '>',$datefrom)
            ->where('type', $type)
            ->where('view', $view)
            ->where('accommodation', $accommodation)
            ->pluck('price')
            ->last();
        if ($price == null)
        {
            break;
        }

        $totalPrice+=$price;
        $avilableNights+=1;
        $datetime = new \DateTime($datefrom);
        $datetime->modify('+1 day');
        $datefrom=$datetime->format('Y-m-d');
    }

    if ($check == 'true')
    {
        return $totalPrice ;
    }else{
        return $avilableNights;
    }


} // end of get price function

function cartCount($id){
    return \App\Models\Roomcart::where('user_id',$id)->count() + \App\Models\ProgramCart::where('user_id',$id)->count();
}