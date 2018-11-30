<h6> Payment Information </h6>
<div id="payment_type">
    <label for ="credit_cards" id="credit_card_payment">
    Choose a Payment Type:
    </label> <br>
    <input type="radio" name="payment_options" id="credit_cards" value="Credit Card" checked>
    <img src="https://support.worldwildlife.org/images/visa_small.gif" alt="Visa">
    <img src="https://support.worldwildlife.org/images/discovercard_sm.gif" alt="Discover Card">
    <img src="https://support.worldwildlife.org/images/mastercd_small.gif" alt="Master Card">
    <img src="https://support.worldwildlife.org/images/amex_small.gif" alt="Amex">
    
    <input type="radio" name="payment_options" id="bank_account_withdrawal" value="Bank account withdrawl">
    <label for ="bank_account_withdrawal" id="payment_options">
        Bank Account Withdrawal 
    </label> 
    <input type="radio" name="payment_options" id="paypal" value="Paypal"> 
    <img src="https://support.worldwildlife.org/images/payment/paypal-logo.png" alt="PayPal">
    <br>
    <label for ="credit_card_number" id="cc_number_payment">
        <span class="red_star">*</span>Credit Card Number
    </label> 
    <input type="text" name="credit_card_number" id="credit_card_number" maxlength="16"><br>
    <label for ="exipiration_date" id="cc_expiration_payment">
        <span class="red_star">*</span>Expiration Date
    </label> 
    <select name="cc_month" id="cc_month">
        <?php
            $month = date('n');
            for($i=1; $i<=12; $i++) {
                if ( $i == $month) {
                    echo "<option value='".$i."' selected>".$i."</option>";
                }
                else{
                    echo "<option value='".$i."'>".$i."</option>";
                }
            }
        ?>
    </select>
    <select name="cc_year" id="cc_year">
        <?php
            $year = date('Y');
            for($i=2018; $i<=2028; $i++) {
                if ( $i == $year) {
                    echo "<option value='".$i."' selected>".$i."</option>";
                }
                else{
                    echo "<option value='".$i."'>".$i."</option>";
                }
            }
        ?>
    </select><br>
    <label for="cw_cc_number" id="cw_cc_payment">
        <span class="red_star">*</span>CVV Number
    </label><br>
    <a href = "" target="_blank"> What is CW number? </a>
    <input type="text" name="cw_cc_number" id="cw_cc_number" maxlength="3">
    <br>
    <input type="submit" name="submit_button" id="submit_button" value="Submit"/>
</div>

<?php 
 try
{
    $db = new PDO("mysql:host=localhost;dbname=Panda;charset=utf8",'root','root');
}
catch (Exception $e)
{
    die('Error: '. $e->getMessage());
}
  ?>
 <?php
    $paymentOptions= $_POST['payment_options'];
    $cc_number= $_POST['credit_card_number'];
    $cc_month= $_POST['cc_month'];
    $cc_year= $_POST['cc_year'];
    $cc_cvv= $_POST['cw_cc_number'];
 if (isset($paymentOptions)) { 
   
    if (!empty($cc_number) AND !empty($cc_cvv)  AND !empty($paymentOptions)){
        echo "test";
        $req = $db -> prepare("INSERT INTO payment_info(payment_type, cc_number, exp_month, exp_year, cvv) VALUES (:payment_type, :cc_number, :exp_month, :exp_year, :cvv)");
         $req -> execute(array(
            'payment_type' => $paymentOptions,
            'cc_number' => $cc_number,
            'exp_month' => $cc_month,
            'exp_year' => $cc_year,
            'cvv' => $cc_cvv
        ));
    }
    else{
        echo 'Enter correct credit card information';
    }
}
 // if (isset($gift) AND isset($monthly_amount) AND isset($first_name) AND isset($last_name) AND isset($address1) AND isset($city) AND isset($country) AND isset($state) AND isset($zipcode) AND isset($email) AND isset($paymentOptions) AND isset($cc_number) AND isset($cc_expiry) AND isset($cc_cvv)){
 //         header('Location:thank_you.php');
// }
// else{
//     header('Location:index.php');
// }
 ?> 