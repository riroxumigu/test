<?php

namespace App\Handler;

abstract class Handler implements InterfaceHandler
{
    /**
     * @var Handler|null
     */
    private $successor = null;

    /**
     * Handler constructor.
     * @param Handler|null $handler
     */
    public function __construct(Handler $handler = null)
    {
        $this->successor = $handler;
    }

    /**
     * Sets a successor handler,
     * in case the class is not able to satisfy the request.
     *
     * @param InterfaceHandler $handler
     * @return InterfaceHandler
     */
    final public function setSuccessor(InterfaceHandler $handler): InterfaceHandler
    {
        if($this->successor === null) {
            $this->successor = $handler;
        }
        else {
            $this->successor->setSuccessor($handler);
        }

        return $this;
    }

    /**
     * This approach by using a template method pattern ensures you that
     * each subclass will not forget to call the successor
     *
     * @param mixed $request
     *
     * @return mixed
     */
    final public function handle($request = null)
    {
        $processed = $this->processing($request);
        if($processed === null) {
            // the request has not been processed by this handler => see the next
            if($this->successor !== null) {
                $processed = $this->successor->handle($request);
            }
        }
        return $processed;
    }

    /**
     * @param mixed $request
     * @return mixed
     */
    abstract protected function processing($request);
}
