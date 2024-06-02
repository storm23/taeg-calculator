<?php

namespace Storm23\TaegCalculator\Exceptions;

class NbrMontlyPaymentsCompleted extends \Exception
{
    public function __construct()
    {
        parent::__construct('nbrMontlyPaymentsCompleted cannot be greather than nbrMontlyPayments');
    }
}
