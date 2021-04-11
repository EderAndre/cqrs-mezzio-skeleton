<?php
declare(strict_types = 1);
namespace Com\Incoders\SampleMS\Domain\Auth;

class Client
{

    public $authenticated;

    public $requestUserToken;

    public $status;

    public $message;


    public function __construct(bool $authenticated, bool $requestUserToken, string $status, string $message)
    {
        $this->authenticated = $authenticated;
        $this->requestUserToken = $requestUserToken;
        $this->status = $status;
        $this->message = $message;
    }
}
