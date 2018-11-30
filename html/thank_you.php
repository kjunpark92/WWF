<div>
    <?php
    $first_name = $_POST['donor_firstname'];
    $amount = (int)$_POST['donate_dollars'];
    $gift = $_POST['gift_options'];
    echo "Thank you for donation " . $first_name . "<br>You gave a monthly donatation of " . $amount . "<br>You will recieve " . $gift;
    ?>
</div>
<div>
    <table>
        <tr>
            <td>History</td>
        </tr>
        <?php
        $totalamount = 0;
        $month_full = date('n');
        for ($i=1; $i <=12; $i++){
            if($month_full>12){
                $month_full =1;
            }
            echo "<tr><td>" . date("F", mktime(null, null, null, $month_full, 1)) . "</td><td>" . $amount . "</td></tr>";
            $totalamount += $amount;
            $month_full++;
        }
        ?>
    </table>
    <?php
    echo "Total amount given : " . $totalamount;
    ?>
    <form action="../panda/index.php" method="post">
        <input type="submit" value="Give Again" name="give_again">
    </form>
</div>

<div>
    <table>
        <tr>
            <td> Recent Donations </td>
    </tr>
    <?php 
        try
        {
            $db = new PDO("mysql:host=localhost;dbname=Panda;charset=utf8",'root','root');
        }
        catch (Exception $e)
        {
            die('Error: '. $e->getMessage());
        }
        $req = $db -> query("SELECT donor.first_name, donor.last_name, donor.monthly_amount, donor.city, payment.date FROM donor_info donor, payment_info payment WHERE donor.ID = payment.ID ORDER BY payment.date DESC LIMIT 0,5");
        while ($data = $req->fetch()){
            echo $data['first_name'].' '.$data['last_name'].'from '. $data['city'].' made a monthly contribution of '.$data['monthly_amount'].'<br/>';
        }
    ?>
</div>