<?php

namespace App\Entity;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use App\Events\KickedParticipant;
use App\Models\SocketRoomError;
use DateTime;

/**
 * Class for handling TWILIO SDK methods.
 */
class Twilio
{
    /**
     * Twilio sid
     * @var string
     */
    protected $sid;

    /**
     * Twilio token
     * @var string
     */
    protected $token;

    /**
     * Twilio apiSID
     * @var string
     */
    protected $apiSid;

    /**
     * Twilio API Secret
     * @var string
     */
    protected $apiSecret;

    /**
     * @var Client
     */
    protected $twilio;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->sid = config('services.twilio.account_sid');
        $this->token = config('services.twilio.auth_token');
        $this->apiSid = config('services.twilio.api_sid');
        $this->apiSecret = config('services.twilio.api_secret');
    }

    /**
     * @throws ConfigurationException
     *
     * @return Client
     */
    public function getTwilio(): Client
    {
        if ($this->twilio) {
            return $this->twilio;
        }

        return $this->twilio = new Client($this->sid, $this->token);
    }

    public function createRoom($roomData)
    {
        return $this->getTwilio()->video->v1->rooms->create($roomData)->sid;
    }

    public function createAccessToken($identity, $roomName)
    {

        $token = new AccessToken($this->sid, $this->apiSid, $this->apiSecret, 3600, $identity);

        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        $token->addGrant($videoGrant);

        return $token->toJWT();
    }

    public function kickParticipant($roomName, $participantIdentity)
    {

        $client = $this->getTwilio();

        $room = $client->video->v1->rooms($roomName)->fetch();
        if ($room->status == "in-progress") {

            $participant = $client->video->rooms($roomName)
                ->participants($participantIdentity)
                ->fetch();
            if ($participant) {
                if ($participant->status == "connected") {
                    $participant = $client->video->rooms($roomName)
                        ->participants($participantIdentity)
                        ->update(array("status" => "disconnected"));
                    return $participant->status;
                }
            }
        }
    }

    public function closeRoom($roomId)
    {
        $client = $this->getTwilio();
        try {
            $room = $client->video->v1->rooms($roomId)->fetch();
            if ($room->status == "in-progress") {
                $client->video->v1->rooms($roomId)->update("completed");
            }
        } catch (TwilioException $e) {
            $socket_room_error = new SocketRoomError();
            $socket_room_error->socket_room_id = $roomId;
            $socket_room_error->error = $e->getMessage();
            $socket_room_error->created_at = new DateTime();
            $socket_room_error->save();
        }
    }

    public function sendSMS($to_number)
    {
        $client = $this->getTwilio();
        $client->messages->create(
            $to_number,
            array(
                'from' => "+12513192769",
                'body' => 'Your talk has started at Talkila.com'
            )
        );
    }
}
