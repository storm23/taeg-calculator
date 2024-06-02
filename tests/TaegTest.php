<?php

namespace Storm23\TaegCalculator\Tests;

use PHPUnit\Framework\TestCase;
use Storm23\TaegCalculator\Taeg;
use Storm23\TaegCalculator\Exceptions\NbrMontlyPaymentsCompleted;

class TaegTest extends TestCase
{
    private $amount_1 = 136900;
    private $taeg_1 = 15.80;
    private $nbrMonthlyPayments_1 = 30;

    public function testMonthlyTaeg()
    {
        $taeg = new Taeg($this->amount_1, $this->taeg_1, $this->nbrMonthlyPayments_1);
        $monthly = $taeg->monthlyTaeg();

        $this->assertTrue($monthly == 0.012299556585700477);
    }

    public function testMonthlyPayment()
    {
        $taeg = new Taeg($this->amount_1, $this->taeg_1, $this->nbrMonthlyPayments_1);
        $monthlyPayment = $taeg->monthlyPayment();

        $this->assertTrue($monthlyPayment == 5485);
    }

    public function testGlobalAmount()
    {
        $taeg = new Taeg($this->amount_1, $this->taeg_1, $this->nbrMonthlyPayments_1);
        $globalPayment = $taeg->globalAmount();

        $this->assertTrue($globalPayment == 164550);
    }

    public function testRemainingAmount()
    {
        $taeg = new Taeg($this->amount_1, $this->taeg_1, $this->nbrMonthlyPayments_1);
        $remainingAmount = $taeg->remainingAmount(12);

        $this->assertTrue($remainingAmount == 98730);
    }

    public function testRemainingAmountException()
    {
        $taeg = new Taeg($this->amount_1, $this->taeg_1, $this->nbrMonthlyPayments_1);
        $hasError = false;
        
        try {

            $remainingAmount = $taeg->remainingAmount(31);
        }
        catch (NbrMontlyPaymentsCompleted) {

            $hasError = true;
        }

        $this->assertTrue($hasError);
    }

    public function testInterestAmount()
    {
        $taeg = new Taeg($this->amount_1, $this->taeg_1, $this->nbrMonthlyPayments_1);
        $interestAmount = $taeg->interestAmount();

        $this->assertTrue($interestAmount == 27650);
    }

    public function testPaymentTimeline()
    {
        $taeg = new Taeg($this->amount_1, $this->taeg_1, $this->nbrMonthlyPayments_1);
        $paymentTimeline = $taeg->paymentTimeline();

        $this->assertTrue($paymentTimeline[0]['interest'] == 1684 && $paymentTimeline[0]['payed_capital'] == 3801);
        $this->assertTrue($paymentTimeline[29]['interest'] == 67 && $paymentTimeline[29]['payed_capital'] == 5418);
    }
}
