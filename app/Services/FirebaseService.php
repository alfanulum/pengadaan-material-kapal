<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;


    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(
                base_path(env('FIREBASE_CREDENTIALS'))
            );

        $this->messaging = $factory->createMessaging();
    }


    public function sendNotification(
        string $token,
        string $title,
        string $body
    ) {

        $notification = Notification::create(
            $title,
            $body
        );


        $message = CloudMessage::new()
            ->withToken($token)
            ->withNotification($notification);


        return $this->messaging->send($message);
    }
}
