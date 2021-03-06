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
    $gift = $_POST['gift_options'];
    $first_name= $_POST['donor_firstname'];
    $last_name= $_POST['donor_lastname'];
    $address1 = $_POST['donor_address1'];
    $city = $_POST['donor_city'];
    $country= $_POST['donor_country'];
    $address2= $_POST['donor_address2'];
    $state = $_POST['donor_state'];
    $zipcode= $_POST['donor_zip'];
    $email = $_POST['donor_email'];
    $receiveNews= $_POST['donor_receive_news'];
    $receiveNews= $_POST['donor_receive_news'];
    $paymentOptions= $_POST['payment_options'];
    $cc_number= $_POST['credit_card_number'];
    $cc_month= $_POST['cc_month'];
    $cc_year= $_POST['cc_year'];
    $cc_cvv= $_POST['cw_cc_number'];

    if (isset($_POST['donate_dollars']) OR isset($_POST['donate_dollars_other'])) { 
        $monthly_amount = ($_POST['donate_dollars_other'])? $_POST['donate_dollars_other'] : $_POST['donate_dollars'] ; 
   
            if (!empty($cc_number) AND !empty($cc_cvv) AND !empty($paymentOptions) AND !empty($gift) AND !empty($first_name) AND !empty($last_name) AND !empty($address1) AND !empty($city) AND !empty($country) AND !empty($zipcode) AND !empty($email)){

        echo "test";
        
        $req = $db -> prepare("INSERT INTO payment_info(payment_type, cc_number, exp_month, exp_year, cvv) VALUES (:payment_type, :cc_number, :exp_month, :exp_year, :cvv)");
         $req -> execute(array(
            'payment_type' => $paymentOptions,
            'cc_number' => $cc_number,
            'exp_month' => $cc_month,
            'exp_year' => $cc_year,
            'cvv' => $cc_cvv
        ));

        $req = $db -> prepare("INSERT INTO donor_info(monthly_amount, gift_options, first_name, last_name, address_1, address_2, city, country, state_us, zipcode, email) VALUES (:monthly_amount, :gift_options,:first_name, :last_name, :address_1, :address_2, :city, :country,  :state_us, :zipcode, :email);");
        $array_to_insert = array(
            'monthly_amount' => $monthly_amount,
            'gift_options' => $gift,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address_1' => $address1,
            'address_2' => $address2,
            'city' => $city,
            'country' => $country,
            'state_us' => $state,
            'zipcode' => $zipcode,
            'email' => $email
        );
        $req->execute($array_to_insert);
    }
    else{
        echo 'Please check your inputs';
    }
}
?> 