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
        string $body,
        ?string $imageUrl = null,
        array $data = []
    ) {
        $notification = Notification::create(
            $title,
            $body,
            $imageUrl
        );


        $message = CloudMessage::new()
            ->withToken($token)
            ->withNotification($notification);

        if (!empty($data)) {
            $message = $message->withData($data);
        }

        return $this->messaging->send($message);
    }
}
