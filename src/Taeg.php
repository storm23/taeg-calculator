<?php

namespace Storm23\TaegCalculator;

use Storm23\TaegCalculator\Exceptions\NbrMontlyPaymentsCompleted;

class Taeg 
{
    protected $taeg;
    protected $amount;
    protected $nbrMontlyPayments;

    public function __construct(int $amount, float $taeg, int $nbrMontlyPayments)
    {
        $this->taeg = $taeg;
        $this->amount = $amount;
        $this->nbrMontlyPayments = $nbrMontlyPayments;
    }

    public function monthlyTaeg() : float
    {
        return pow(1 + ($this->taeg / 100), 1/12) - 1;
    }

    public function monthlyPayment() : int
    {
        $r = $this->monthlyTaeg();
        $j = pow(1 + $this->monthlyTaeg(), $this->nbrMontlyPayments);
        
        return ceil(($this->amount * $r * $j) / ($j - 1));
    }

    public function globalAmount() : int
    {
        return ceil($this->monthlyPayment() * $this->nbrMontlyPayments);
    }

    public function remainingAmount(int $nbrMontlyPaymentsCompleted) : int
    {
        if ($nbrMontlyPaymentsCompleted > $this->nbrMontlyPayments) {

            throw new NbrMontlyPaymentsCompleted;
        }

        return $this->globalAmount() - ($this->monthlyPayment() * $nbrMontlyPaymentsCompleted);
    }

   public function interestAmount()
   {
        return $this->globalAmount() - $this->amount;
   }

   public function paymentTimeline()
   {
        $payments = [];
        $amount = $this->amount;
        $monthlyPayment = $this->monthlyPayment();
        $nbrMontlyPayments = $this->nbrMontlyPayments;

        while ($nbrMontlyPayments > 0) {

            $interest = ceil($amount * $this->monthlyTaeg());

            $payments[] = [
                'outstanding_capital' => $amount,
                'interest' => $interest,
                'payed_capital' => $monthlyPayment - $interest,
                'monthly_payment' => $monthlyPayment
            ];

            $nbrMontlyPayments--;
            $amount = $amount - ($monthlyPayment - $interest);
        }

        return $payments;
   }
}
