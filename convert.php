<?php

//prevent users to acsess this page
if (isset($_POST['web'])) {
    //get user data from AJAX and send response
    if (isset($_POST["submit"])) {
        $changeTo = [];
        $changeFrom = $_POST['changeFromSelection'];
        $changeTo = json_decode($_POST['changeTo']);
        $amount = $_POST['amount'];
        if ($results = dataFromDB($changeFrom, $changeTo, $amount)) {
            print_r(json_encode($results));
        } else {
            // get Currency from API
            $currency = getCurrency($changeFrom);
            //calculation
            foreach ($changeTo as $data) {
                $results[] = $amount * $currency[$data];
            }

            foreach ($changeTo as $k) {
                $db_arr[$k] = $currency[$k];
            }

            //set data to db
            setDataToDB($changeFrom, $db_arr);

            //return results to UI
            print_r(json_encode($results));

        }
    }
} else {
    header("location: index.php");
}
//currency from API
function getCurrency($changeFrom, $rate = '')
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.exchangeratesapi.io/latest?base=$changeFrom&symbols=$rate",
        CURLOPT_RETURNTRANSFER => true,
    ));
    $response = curl_exec($curl);
    $response = json_decode($response);
    $response = $response->rates;
    $currency = [];
    foreach ($response as $rate => $value) {
        $currency[$rate] = $value;
    }
    return $currency;
}
//DB Connection
function db_connect()
{
    if ($link = mysqli_connect('localhost', 'root', '', 'currency_convertor')) {
        return $link;
    } else {
        $err_db = 'Data Base connection is unavaliable right now, please try later';
    }
}
//check if data exist in DB
function dataFromDB($changeFrom, $changeTo, $amount)
{
    if ($link = db_connect()) {
        $date = date("Y-m-d");
        $sql = "SELECT * FROM daily_currency WHERE created_at='$date' AND base='$changeFrom'";
        $result = mysqli_query($link, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            $calc_array = [];
            foreach ($data as $d) {
                $calc_array[$d['currency']] = $d['rate'];
            }
            //check diff between db data and user request
            $diff = array_diff($changeTo, array_flip($calc_array));
            $rate = implode(",", $diff);
            //if diff get data from api for diff and insert to calc array
            if ($diff) {
                $response = getCurrency($changeFrom, $rate);
                foreach ($response as $k => $v) {
                    $calc_array[$k] = $v;
                    $difference[$k] = $v;
                }
                updateDB($changeFrom, $difference);
            }
            foreach ($changeTo as $change) {
                $results[] = $amount * $calc_array[$change];
            }
            return $results;
        }
    }
}
//insert currency if diff
function updateDB($changeFrom, $difference)
{
    if ($link = db_connect()) {
        $date = date("Y-m-d");
        $sql = "";
        foreach ($difference as $k => $v) {
            $sql .= "INSERT INTO daily_currency(id,base,currency,rate,created_at,updated_at) VALUES('','$changeFrom','$k','$v','$date','$date');";
        }
        $result = mysqli_multi_query($link, $sql);
    }
}
//set data to db
function setDataToDB($base, $db_arr)
{
    if ($link = db_connect()) {
        $date = date("Y-m-d");
        $sql = "DELETE FROM daily_currency WHERE base='$base'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $sql = "";
            foreach ($db_arr as $k => $v) {
                $sql .= "INSERT INTO daily_currency(id,base,currency,rate,created_at,updated_at) VALUES('','$base','$k','$v','$date','$date');";
            }
            $result = mysqli_multi_query($link, $sql);
        }
    }
}