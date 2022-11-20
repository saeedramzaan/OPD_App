<!DOCTYPE html>
<html>

<head>
    <title>Appointment Details</title>
</head>

<body>

    <h1> {{ $details['title'] }} </h1>

    <p> <?php $detail = explode('/', $details['body']);
    
    ?>
    <p> {{ $detail['0'] }}</p>
    <p> {{ $detail['1'] }}</p>
    <p> {{ $detail['2'] }}</p>
    <p> {{ $detail['3'] }}</p>
    <p> {{ $detail['4'] }}</p>
    <p> {{ $detail['5'] }}</p>
    <p> {{ $detail['6'] }}</p>

    </p>

    <h3>Thank you</h3>
</body>

</html>
