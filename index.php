<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Healing Photos</title>
    <link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300,400' rel='stylesheet' type='text/css'>
    <link href="css/style.css" type="text/css" rel="stylesheet" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script language="javascript" type="text/javascript">  
    $(function(){  
      $(".file").change(function(){  
        $('#targetInput').val($(".file").val());
        $('.btn').fadeIn('slow');
      }); 
    });  
    </script> 

</head>
<body id='top'>
	<img alt="full screen background image" src="images/background.jpg" id="full-screen-background-image" /> 
  <div id="wrapper">
    <h1 class='title'>Healing Photos</h1>
    <p>I'll reccomended healing photos for you.</p>

    <form action='postFace.php' method="post" enctype="multipart/form-data">
    <div class="fileinputs">
      <input type="file" name="img" class="file"> 
      <div class="fakefile">
        <input id="targetInput" name='inputFile' type="hidden">
        <img src="images/file_btn.png">
      </div>
    </div>

    <input type='submit' class='btn' value='go'>
    </form>
  </div>
</body>
</html>
