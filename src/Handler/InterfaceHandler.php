<?php

declare(strict_types=1);

namespace App\Handler;

interface InterfaceHandler
{
    /**
     * @param InterfaceHandler $handler
     * @return InterfaceHandler
     */
    public function setSuccessor(InterfaceHandler $handler): InterfaceHandler;

    /**
     * @param mixed $request
     * @return mixed
     */
    public function handle($request = null);
}
