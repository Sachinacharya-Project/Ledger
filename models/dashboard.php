<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("location: /");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/612f542d54.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Allan&family=Anton&family=Bebas+Neue&family=Courgette&family=Imbue&family=Kaushan+Script&family=Lobster&family=Nova+Square&family=Oswald:wght@300;400&family=PT+Sans+Narrow&family=Pathway+Gothic+One&family=Poppins&family=Potta+One&family=Righteous&family=Roboto:wght@300;400&family=Squada+One&family=Teko:wght@300;400&family=Trade+Winds&family=Yanone+Kaffeesatz:wght@400;500&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/nav.css">
    <link rel="stylesheet" href="/css/dashoboard.css">
    <title>Dashboard | Ledger</title>
</head>
<body>
    <div class="signedInUser">
        <p></p>
    </div>
    <div class="selectOptions">
        <label for="optionsTransactions">Choose Interface</label>
        <select id="optionsTransactions" name="optionsTransactions">
            <option value="text">Show as Text</option>
            <option value="graph">Show as Graphical Interface</option>
        </select>
    </div>
    <div class="div-trans">
        <fieldset>
            <legend>Transaction Interface</legend>
            <p>Displayed Amount is in NRS (Nepali Currency)</p>
            <div class="transactionhistory">
                <div class="boxes box-total">
                    <strong>Total Transaction (कुल लेनदेन)</strong>
                    <span>120000</span>
                </div>
                <div class="boxes box-received">
                    <strong>Total Received Amount (कुल प्राप्त रकम)</strong>
                    <span>120000</span>
                </div>
                <div class="boxes box-paid">
                    <strong>
                        Total Paid Amount (कुल भुक्तानी राशि)
                    </strong>
                    <span>
                        100000
                    </span>
                </div>
                <div class="boxes box-left-to-pay">
                    <strong>Amount Left to Pay (भुक्तान गर्न बाँया रकम)</strong>
                    <span>10000</span>
                </div>
                <div class="boxes box-left-to-be-paid">
                    <strong>Amount Left to Receive (प्राप्त गर्न बाँया रकम)</strong>
                    <span>20000</span>
                </div>
            </div>
        </fieldset>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="/js/nav.js"></script>
    <script src="/js/dashboard.js"></script>
    <script>
        setnav('home')
        NumberParse()
    </script>
</body>
</html>