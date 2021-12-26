<html>
    <head>
        <title>IGIHE DB SPECIAL QUERY SCRIPT</title>
    </head>
    <body>
        <?php
        while($get_q=mysql_fetch_assoc($q)){
            echo '<h2>'.$get_q['titre'].'<h2>';
        }
        ?>
    </body>
</html>