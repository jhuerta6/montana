<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Commands Example</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h4>Testing Commands</h4>
        </div>
        <div class="col-sm-12 text-center">
            <span>Press to echo 'ls' command on server --></span>
            <button class="btn btn-warning" type="button" id="ls" onClick="ls()">Send 'ls' command</button>
        </div>
    </div>
</div>
</body>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script>
    $(document).ready(function() {
        //usually events
    });

    function ls(){
        console.log("Testing");
        let obj = {test: "Yes"};
        $.get('commands.php', obj, function(data){
            //content with data
        });
    }
</script>
</html>
