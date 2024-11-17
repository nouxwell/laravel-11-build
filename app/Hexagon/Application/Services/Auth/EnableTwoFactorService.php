<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Infrastructure\Persistence\Auth\EnableTwoFactorHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Illuminate\Support\Facades\DB;

class EnableTwoFactorService
{
    private EnableTwoFactorHandler $handler;

    public function __construct(EnableTwoFactorHandler $handler)
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
            return PayloadFactory::success(PayloadMessage::ENABLE_TWO_FACTOR);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
   }
}