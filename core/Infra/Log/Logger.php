<?php

namespace Core\Infra\Log;

interface Logger
{
    public function error(string $message);
    public function info(string $message);
}
