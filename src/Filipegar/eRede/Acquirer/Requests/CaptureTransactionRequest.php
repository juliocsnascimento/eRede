<?php

namespace Filipegar\eRede\Acquirer\Requests;

use Filipegar\eRede\Acquirer\Environment;
use Filipegar\eRede\Acquirer\Transaction;
use Filipegar\eRede\Merchant;

class CaptureTransactionRequest extends AbstractRequest
{
    private $environment;

    public function __construct(Merchant $merchant, Environment $environment)
    {
        parent::__construct($merchant);

        $this->environment = $environment;
    }

    /**
     * @param Requestable $transaction
     * @return mixed|null
     *
     * @throws eRedeErrorException
     */
    public function execute(Requestable $transaction)
    {
        /** @var Transaction $transaction */
        return $this->sendRequest(
            $this->environment,
            'PUT',
            "transactions/{$transaction->getTid()}",
            $transaction->toRequest()
        );
    }

    protected function unserialize($response)
    {
        return Transaction::fromJson((string) $response);
    }
}
