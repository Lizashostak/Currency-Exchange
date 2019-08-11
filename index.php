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
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
                        <!-- <div class="col-md-3 col-sm-3"></div> -->
                        <div class="col-md-12 col-sm-12 text-center">
                            <h1>Currency Exchange
                                <span style="display:inline-block">
                                 <i class="fas fa-euro-sign"></i>
                                 <i class="fas fa-sync"></i>
                                 <i class="fas fa-dollar-sign"></i>
                                </span>
                            </h1>
                        </div>
                        <!-- <div class="col-md-3 col-sm-3"></div> -->
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 "></div>
                <div class="col-md-6 col-sm-6 message-box"></div>
                <div class="col-md-3 col-sm-3 "></div>
                <div class="col-md-12 col-sm-12 box-1">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 ">
                            <form class="form" method="POST">
                                <div>
                                    <select name="changeFrom" id="changeFrom" class="custom-select invalid col-md-3 col-sm-6">
                                        <option value="0">Change From</option>
                                        <?php foreach ($currency as $curr): ?>
                                        <option id="changeFrom" value="<?=$curr?>"><?=$curr?></option>
                                        <?php endforeach;?>
                                        <option value="EUR">EUR</option>
                                    </select>
                                    <select name="changeTo" id="changeTo" class="custom-select invalid col-md-3 col-sm-6">
                                        <option value="0">Change To</option>
                                        <?php foreach ($currency as $curr): ?>
                                        <option id="changeTo" value="<?=$curr?>"><?=$curr?></option>
                                        <?php endforeach;?>
                                        <option value="EUR">EUR</option>
                                    </select>
                                    <input class="amount col-md-2 col-sm-6" type="number" id="amount" name="amount" placeholder="Insert value"
                                        style="border: 1px solid #ced4da; padding: 6px;" class="invalid">
                                    <input name="web" type="hidden" value="web">
                                    <input class="btn btn-outline-secondary col-md-3 col-sm-6" name="submit" type="submit" value="CONVERT">
                                </div>

                            </form>
                        </div>
                        <div class="col-md-4 col-sm-6 allChangeTo">
                            <ul class="currency-list" id="list">

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 change-form box-2">
                    <table class="table" id="myTable">
                        <tr class="table-th">
                            <th scope="col">Change From</th>
                            <th scope="col">Change To</th>
                            <th scope="col">Change Rate</th>
                            <th scope="col">Value</th>
                        </tr>
                    </table>
                </div>

            </div>
        </div>

        </div>
    </main>
    <footer class="footer">
            <p>Currency Exchange &copy; </p>
        </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>