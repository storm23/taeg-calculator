
# TAEG Calculator

Calculate Taeg ("taux annuel effectif global" in french)

Amounts are in cents.

A TAEG of 10.30 % is 10.30.

## Example

Calculate monthly payment for a loan of 1360,00 euros, during 30 months, TAEG of 15,80 %

```
$taeg = new Taeg(136900, 15.80, 30);
$monthlyPayment = $taeg->monthlyPayment();
echo $monthlyPayment

// 5485 => 54.85 euros
```
