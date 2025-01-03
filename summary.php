<?php
session_start();
ob_start();
require_once('DBconnect.php');
ob_end_clean();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num = $_POST['people'];
    $sauce = $_POST['source'];
    $res_name = $_POST['restaurant'];
    $act = $_POST['activity'];
    $trans = $_POST['transport'];
    $trans_cost = NULL;
    $total_cost = NULL;
    $cost_per_person = NULL;
    $output = [];

    $res_sql = "SELECT AVG(m.price) as A_R_Price FROM menu m, restaurants r WHERE m.R_ID = r.R_ID AND r.R_NAME='$res_name'";
    $act_sql = "SELECT A_PRICE FROM activity WHERE A_NAME = '$act'"; 
    $res_cost = mysqli_query($conn,$res_sql);
    $act_cost = mysqli_query($conn,$act_sql);

    #for transport cost#  
    $tran1 = "SELECT T.T_COST*ABS(S1.D1-S2.D2) AS T1 FROM (SELECT Distance AS D1 FROM Location WHERE L_NAME = '$sauce') S1,(SELECT l.Distance AS D2 FROM Location l, Restaurants r WHERE r.L_NAME = l.L_NAME AND r.R_NAME = '$res_name') S2, Transport T WHERE T.T_NAME = '$trans'";
    $tran2 = "SELECT T.T_COST*ABS(S1.D1-S2.D2) AS T2 FROM (SELECT l.Distance AS D1 FROM Location l, Restaurants r WHERE r.L_NAME = l.L_NAME AND r.R_NAME = '$res_name') S1, (SELECT l1.Distance AS D2 FROM Location l1, Activity A WHERE l1.L_NAME = A.L_NAME AND A.A_NAME = '$act') S2, Transport T WHERE T.T_NAME = '$trans'";
    $tran3 = "SELECT T.T_COST*ABS(S1.D1-S2.D2) AS T3 FROM (SELECT l1.Distance AS D1 FROM Location l1, Activity A WHERE l1.L_NAME = A.L_NAME AND A.A_NAME = '$act') S1, (SELECT Distance AS D2 FROM Location WHERE L_NAME = '$sauce') S2, Transport T WHERE T.T_NAME = '$trans'";

    $trans_1 = mysqli_query($conn,$tran1);
    $trans_2 = mysqli_query($conn,$tran2);
    $trans_3 = mysqli_query($conn,$tran3);


    if ($res_cost->num_rows > 0 and $act_cost->num_rows>0 and $trans_1->num_rows>0 and $trans_2->num_rows> 0 and $trans_3->num_rows> 0) {
        $r1 = $res_cost -> fetch_assoc();
        $r2 = $act_cost -> fetch_assoc();
        $t1 = $trans_1 -> fetch_assoc();
        $t2 = $trans_2 -> fetch_assoc();
        $t3 = $trans_3 -> fetch_assoc();
        $trans_cost = $t1["T1"] + $t2["T2"] + $t3["T3"];
        $trans_cost_per_person = $trans_cost/$num;
        $total_cost = (($r1["A_R_Price"] + $r2["A_PRICE"])*$num) + $trans_cost;
        $cost_per_person = $total_cost/$num;

        $output = [
            "Restaurant Cost"=> $r1["A_R_Price"],
            "Activity Cost"=> $r2["A_PRICE"],
            "Transport Cost"=> $trans_cost_per_person,
            "Total"=> $total_cost,
            "Cost per person"=> $cost_per_person
        ];

        $sql1 = "INSERT INTO hangout_plans (Creator, Source_L, P_NO, Total) VALUES ('" . $_SESSION['user'] . "', '$sauce', $num, $total_cost)";
        $res1 = mysqli_query($conn,$sql1);
        $sql2 = "INSERT INTO CAN_HAVE(H_ID, R_ID) SELECT H.H_ID, R.R_ID FROM hangout_plans H, Restaurants R WHERE H.Creator = '" . $_SESSION['user'] . "' AND R.R_NAME = '$res_name'ORDER BY H.H_ID DESC LIMIT 1";
        $res2 = mysqli_query($conn,$sql2);
        $sql3 = "INSERT INTO CONSISTS_OF(H_ID, A_ID) SELECT H.H_ID, A.A_ID FROM hangout_plans H, Activity A WHERE H.Creator = '" . $_SESSION['user'] . "' AND A.A_NAME = '$act'ORDER BY H.H_ID DESC LIMIT 1";
        $res3 = mysqli_query($conn,$sql3);
        $sql4 = "INSERT INTO MAY_HAVE(H_ID, T_NAME) SELECT H.H_ID, T.T_NAME FROM hangout_plans H, Transport T WHERE H.Creator = '" . $_SESSION['user'] . "' AND T.T_NAME = '$trans'ORDER BY H.H_ID DESC LIMIT 1";
        $res4 = mysqli_query($conn,$sql4);
        $sql5 = "INSERT INTO MODERATES(H_ID, AEmail) SELECT H.H_ID, A.AEmail FROM hangout_plans H, ADMIN A WHERE H.Creator = '" . $_SESSION['user'] . "' ORDER BY H.H_ID DESC LIMIT 1";
        $res5 = mysqli_query($conn,$sql5);
    
        if (!($res1 && $res2 && $res3 && $res4 && $res5)) {
            echo "Hangout Plan Data insertion failed";
        } 

        $_SESSION["summary"] = $output;
        $_SESSION["num"] = $num;
        $_SESSION["res_name"] = $res_name;
        $_SESSION["act"] = $act;
        $_SESSION["trans"] = $trans;

    } else {
         echo "One of the queries did not return any results. Your plan wasn't saved.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Hangout Planner</title>
</head>
<body>
    <header>
        <nav>
            <div class="nav_logo">
                <h1><a href="index.php">Hangout Planner</a></h1>
            </div>
        </nav>
    </header>
    <main>
        <div class="summary_box">
            <h2>Hangout Plan Summary</h2><br><hr class="ext_text"><br>
            <table class="restaurant_table">
                <tr>
                    <th>No. of People</th>
                    <td><?php echo htmlspecialchars($_POST['people']); ?></td>
                </tr>
                <tr>
                    <th>Starting Location</th>
                    <td><?php echo htmlspecialchars($_POST['source']); ?></td>
                </tr>
                <tr>
                    <th>Restaurant Per Person</th>
                    <td><?php echo htmlspecialchars($output['Restaurant Cost']); ?> tk</td>
                </tr>
                <tr>
                    <th>Activity Per Person</th>
                    <td><?php echo htmlspecialchars($output['Activity Cost']); ?> tk</td>
                </tr>
                <tr>
                    <th>Transport Per Person</th>
                    <td><?php echo (int)$output['Transport Cost']; ?> tk</td>
                </tr>
                <tr>
                    <th>Estmated Total Cost Per Person</th>
                    <td><?php echo (int)$output['Cost per person']; ?> tk</td>
                </tr>
                <tr>
                    <th>Estimated Total Cost</th>
                    <td><?php echo (int)$output['Total']; ?> tk</td>
                </tr>
            </table>
            <br>
            <button type="button" class="see_menu_btn" onclick="window.location.href='hangout_list.php'">See all plans</button>
        </div>
    </main>
</body>
</html>