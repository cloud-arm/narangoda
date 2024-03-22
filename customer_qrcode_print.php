<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CLOUD ARM | Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <style>
        @media print {
            body img {
                width: 350px;
            }

            body .div {
                padding: 10px;
                border-radius: 10px;
                border: 1px solid;
                width: max-content;
            }

            body .content {
                width: 100%;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: space-around;
                flex-direction: column;
            }

            body h1 {
                font-size: 25px;
                text-align: center;
                margin-bottom: 0;
            }
        }
    </style>


</head>

<body onload="window.print() ">
    <?php
    $sec = "1";
    ?>
    <meta http-equiv="refresh" content="<?php echo $sec; ?>;URL='customer.php'">
    <div class="wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="div">
                <h1>NARANGODA GROUP</h1>
                <img src="<?php echo $_GET['file']; ?>">
            </div>
            <div class="div">
                <h1>Narangoda Group</h1>
                <img src="<?php echo $_GET['file']; ?>">
            </div>
        </section>
    </div>
</body>

</html>