<!DOCTYPE html>
<html lang="en">
<head>
  <title>New Payment has been Received for you Event {{ $event_name}} </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<h3>New Payment has been Received for you Event {{ $event_name}} </h3>

<h4>Donater Name: {{ $clientname }} {{ $lastname }}</h4>
<h4>Client Email: {{ $useremail }} </h4>
<h4>Donation Amount: {{ $amount }}</h4>
<h4>Event name: {{ $event_name}}</h4>

</body>
</html>