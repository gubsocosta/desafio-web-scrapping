<?php

namespace App\Adapters\Log;

use Core\Infra\Log\Logger;
use Illuminate\Support\Facades\Log;

class MonologLogger implements Logger
{

    public function error(string $message): void
    {
        Log::error($message);
    }

    public function info(string $message): void
    {
        Log::info($message);
    }
}
