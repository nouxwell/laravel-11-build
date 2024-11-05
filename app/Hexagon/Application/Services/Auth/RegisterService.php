<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;
use App\Hexagon\Infrastructure\Persistence\Auth\RegisterHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\PayloadFactory;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    private RegisterHandler $handler;

    public function __construct(RegisterHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws \Exception
     */
    public function execute(RegisterRequestDto $dto) {
        DB::beginTransaction();
        try {
            $this->handler->handle($dto);
            DB::commit();
            return PayloadFactory::success(PayloadMessage::REGISTRATION_SUCCESS);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
   }
}
