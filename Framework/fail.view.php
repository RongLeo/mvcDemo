<!DOCTYPE html>
<html>
   <head>
     <meta charset="utf-8" />
     <title>操作失败</title>
   </head>
   <body>
     <h1>操作提示</h1>
     <h4><?php echo $data['message']; ?></h4>
     <div id="count">2</div>
     <script type="text/javascript">
     var count = document.getElementById('count').innerHTML;
     var intervalId = setInterval(function() {
         if (count > 0) {
        	    count--;
        	    document.getElementById('count').innerHTML = count;
         } else {
             clearInterval(intervalId);
             <?php
             if (isset($data['url']) && trim($data['url'] != '')) {
             	echo 'window.location.href = \'' . $data['url'] . '\';';
             } else {
             	echo 'window.history.go(-1);';
             }
             ?>
         }
     }, 1000);
     </script>
   </body>
</html>
