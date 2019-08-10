<?php
//All currencies from API
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.exchangeratesapi.io/latest ",
    CURLOPT_RETURNTRANSFER => true,
));
$response = curl_exec($curl);
$response = json_decode($response);
$response = $response->rates;

$currency = [];
$currency_value = [];
foreach ($response as $rate => $value) {
    $currency[] = $rate;
}
// foreach ($response as $rate => $value) {
//     $currency_value[] = $value;
// }

// //Submit Form
// if (isset($_POST['submit'])) {
//     $name = trim($_POST['name']);
//     $phone = trim($_POST['phone']);
//     $email = trim($_POST['email']);
//     $country = trim($_POST['country']);
//     $_SESSION['customer'] = $name;

//     if (empty($name)) {
//         $err = 'Insert your name';
//     } elseif (empty($phone)) {
//         $err = 'Insert your phone number';
//     } elseif (empty($email)) {
//         $err = 'Insert your email';
//     } elseif (empty($country)) {
//         $err = 'Choose your country';
//     } else {
//         $name = strtolower(trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
//         $phone = strtolower(trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT)));
//         $email = strtolower(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
//         $country = strtolower(trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING)));
//         if ($link = db_connect()) {

//             $sql = "SELECT * FROM customers WHERE email = '$email' ";
//             $result = mysqli_query($link, $sql);
//             if ($result && mysqli_num_rows($result) > 0) {
//                 $err = "Your email already have been sent";
//             } else {
//                 $name = mysqli_real_escape_string($link, $name);
//                 $phone = mysqli_real_escape_string($link, $phone);
//                 $email = mysqli_real_escape_string($link, $email);
//                 $country = mysqli_real_escape_string($link, $country);
//                 $sql = "INSERT INTO customers (id, name, country, phone, email, created_at, updated_at) VALUES ('', '$name', '$country', '$phone','$email', CURRENT_TIME(), CURRENT_TIME());";
//                 $result = mysqli_query($link, $sql);
//                 if ($result && mysqli_affected_rows($link) > 0) {
//                     header('Location: thanks.php');
//                 } else {
//                     $err = "There was a problem to send your detailes, please try again later";
//                 }
//             }
//         }
//     }
// }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Easy Coin Converter</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/carousel/">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">


</head>

<body>

    <main role="main" class="home-container">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 header">
                    <div class="row">
                        <div class="col-md-3 col-sm-3"></div>
                        <div class="col-md-5 col-sm-5">
                            <h1>Currency Exchange</h1>
                        </div>
                        <div class="col-md-1 col-sm-1">
                            <img src="imgs/logo.png" style="height: 60%">
                        </div>
                        <div class="col-md-3 col-sm-3"></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 "></div>
                <div class="col-md-6 col-sm-6 message-box"></div>
                <div class="col-md-3 col-sm-3 "></div>
                <div class="col-md-12 col-sm-12 box-1">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 ">
                            <form class="form" method="POST">
                                <div>
                                    <select name="changeFrom" id="changeFrom" class="invalid">
                                        <option value="0">Change From</option>
                                        <?php foreach ($currency as $curr): ?>
                                        <option id="changeFrom" value="<?=$curr?>"><?=$curr?></option>
                                        <?php endforeach;?>
                                        <option value="EUR">EUR</option>
                                    </select>
                                    <select name="changeTo" id="changeTo" class="invalid">
                                        <option value="0">Change To</option>
                                        <?php foreach ($currency as $curr): ?>
                                        <option id="changeTo" value="<?=$curr?>"><?=$curr?></option>
                                        <?php endforeach;?>
                                        <option value="EUR">EUR</option>
                                    </select>
                                    <input type="text" id="amount" name="amount" placeholder="Insert value"
                                        style="width: 93px;" class="invalid">
                                    <input name="web" type="hidden" value="web">
                                    <input name="submit" type="submit" value="CONVERT">
                                </div>

                            </form>
                        </div>
                        <div class="col-md-6 col-sm-6 allChangeTo">
                            <ul id="list">

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 change-form box-2">
                    <table class="table" id="myTable">
                        <tr class="thead-dark">
                            <th scope="col">Change From</th>
                            <th scope="col">Change To</th>
                            <th scope="col">Change Rate</th>
                            <th scope="col">Value</th>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
        <footer class="footer">
            <p>Easy Coin Converter &copy; </p>
        </footer>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>