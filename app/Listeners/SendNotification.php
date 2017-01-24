<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use App\Repositories\FCMTokenRepository;
use FCM;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification
{
    protected $fcmTokenRepo;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(FCMTokenRepository $fcmTokenRepo)
    {
        $this->fcmTokenRepo = $fcmTokenRepo;
    }

    /**
     * Handle the event.
     *
     * @param  AppointmentCreated  $event
     * @return void
     */
    public function handle(AppointmentCreated $event)
    {
        $user = $event->appointment->donor->user;
        $hospital = $event->appointment->hospital;

        $title = 'Blood Required: ' . $hospital->name;
        $body = 'There is an urgent requirement of your blood type in this hospital. Someone\'s life is depending on you.';

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle($title);
        $notificationBuilder->setBody($body);

        $notification = $notificationBuilder->build();
        $tokens = $this->fcmTokenRepo->getByUser($user)->pluck('token')->all();

        if (empty($tokens)) return;

        $response = FCM::sendTo($tokens, null, $notification);

        $expiredTokens = $response->tokensToDelete();
        foreach ($expiredTokens as $expiredToken) {
            $fcmTokenRepo->deleteToken($expiredToken);
        }
    }
}
