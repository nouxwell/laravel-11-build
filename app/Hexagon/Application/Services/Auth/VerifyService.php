<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Infrastructure\Persistence\Auth\VerifyHandler;
use App\Services\Enums\Payload\PayloadExceptionMessage;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Illuminate\Support\Facades\DB;

class VerifyService
{
    private VerifyHandler $handler;

    public function __construct(VerifyHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws \Exception
     */
    public function execute(int|string $id): array
    {
        DB::beginTransaction();
        try {
            $result = $this->handler->handle($id);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'status' => false,
                'message' => __(PayloadExceptionMessage::EMAIL_VERIFICATION_ERROR)
            ];
        }
   }
}
