<?php
    define("HOST","localhost");
    define("USER","lex94_andropush");
    define("PASSWORD","JFdqQU4M+1{m");
    define("DATABASE","lex94_andropush");
	define("GCM_MAX_USER",1000);
	define("GCM_API_KEY","AIzaSyColRF0ZSaRee7O2qir2hZVAsrK5ZsG9xs");
	
  
    $connection=@mysql_pconnect(HOST,USER,PASSWORD);
  
    if(!$connection)
        exit("Access denied");
  
    if(!@mysql_select_db(DATABASE,$connection)){
	    @mysql_close();
        exit("Access denied");
	}
?> 