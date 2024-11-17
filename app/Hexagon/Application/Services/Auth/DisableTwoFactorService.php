<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Infrastructure\Persistence\Auth\DisableTwoFactorHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Illuminate\Support\Facades\DB;

class DisableTwoFactorService
{
    private DisableTwoFactorHandler $handler;

    public function __construct(DisableTwoFactorHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws \Exception
     */
    public function execute(): Payload
    {
        DB::beginTransaction();
        try {
            $this->handler->handle();
            DB::commit();
            return PayloadFactory::success(PayloadMessage::DISABLE_TWO_FACTOR);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
   }
}
