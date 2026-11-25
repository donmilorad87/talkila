<?php

namespace App\Console\Commands;

use App\Entity\RoomStates;
use App\Entity\StateTypes;
use App\Entity\TalkTypes;
use App\Http\Controllers\Admin\BookingsController;
use App\Mail\BookingCancellationClient;
use App\Models\Booking;
use App\Models\SocketRoom;
use App\Models\WalletHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RefundIfSupplierDidNotShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:refund';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refunds all customers in case the Supplier did not show.';

    /**
     * A Booking model.
     */
    public SocketRoom $socket_rooms;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->socket_rooms = new SocketRoom();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    public function handle()
    {
        $wallet_history = new WalletHistory();

        foreach ($this->socket_rooms->all() as $socket_room) {
            DB::beginTransaction();

            if ($socket_room->teacher_joined == StateTypes::NO && $socket_room->state != RoomStates::REFUNDED) {
                $booking   = $socket_room->booking;
                $talk      = $booking->talk;
                $talk_type = $talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk';
                $client    = $socket_room->booking->participant_user;
                $supplier  = $socket_room->booking->teacher_user;

                BookingsController::createBookingProtocolEvent($booking->id, Booking::STATE['canceled']);

                $socket_room->booking()->update([
                    'cancellation_reason_id' => 21,
                    'cancel_type'            => Booking::CANCEL_TYPE['client'],
                    'state'                  => Booking::STATE['canceled'],
                ]);

                $wallet_history->addFundsInWallet($client, $booking->price, WalletHistory::TYPE['CREDIT'], $booking->id, null, null, WalletHistory::STATUS['COMPLETED'], WalletHistory::SOURCE['REFUND']);
                Mail::to($client->email)->queue(
                    new BookingCancellationClient(
                        $supplier->last_language,
                        $supplier->email,
                        $supplier->username,
                        $talk->id,
                        $talk->headline,
                        // Carbon::parse($booking->start_date)->addMinutes($client->timezone ?: null)->format('d.m.Y'),
                        convertToUserTimezone($booking->start_date, 'd.m.Y'),
                        // Carbon::parse($booking->start_time)->addMinutes($client->timezone ?: null)->format('H:i'),
                        convertToUserTimezone($booking->start_time, 'H:i'),
                        // Carbon::parse($booking->end_time)->addMinutes($client->timezone ?: null)->format('H:i'),
                        convertToUserTimezone($booking->end_time, 'H:i'),
                        $talk->duration,
                        $talk->price,
                        $talk_type,
                        $booking->id
                    )
                );

                $socket_room->update([
                    'state' => RoomStates::REFUNDED,
                ]);
            }

            DB::commit();
        }
    }
}
