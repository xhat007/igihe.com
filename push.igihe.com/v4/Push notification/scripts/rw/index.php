<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script src="http://demos.jquerymobile.com/1.2.1/docs/_assets/js/jqm-docs.js"></script>
        <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="http://demos.jquerymobile.com/1.2.1/js/jquery.mobile-1.2.1.js"></script>

        <link rel="stylesheet" href="http://demos.jquerymobile.com/1.2.1/css/themes/default/jquery.mobile-1.2.1.css" />
		<link rel="stylesheet" href="http://demos.jquerymobile.com/1.2.1/docs/_assets/css/jqm-docs.css" />

        <script type="text/javascript">
            $(document).ready(function(){
                
            });
			
            function sendPushNotification(){
			    
				if($('input[type=radio]:checked').length == 0){
				    alert("Choose  category please !");
					return false;
				}
				
				if($('#title').val().length == 0){
				    alert("The title is missing!");
					return false;
				}
				
				if($('#article_id').val().length == 0){
				    alert("Article ID is missing!");
					return false;
				}
				
				
                var data = $('form').serialize();
				
                $('form').unbind('submit');
                
                $.ajax({
                    url: "pushcontroller.php",
                    type: 'GET',
                    data: data,
                    beforeSend: function() {
                         
                    },
                    success: function(data, textStatus, xhr) {
					    alert(data);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        
                    }
                });
                return false;
            }
        </script>
        
    </head>
    <body>
        <div data-role="header" data-position="fixed"> 
	        <h1>IGIHE PUSH NOTIFICATION</h1> 
        </div> 
		<form id="form" method="post" onsubmit="return sendPushNotification()">
		<div class="ui-grid-a" >
	        <div class="ui-block-a" style="padding: 1%; width:50%;">
			<?php
			
			    require_once 'databaseutil.php';
			    
				echo '    <div  data-role="fieldcontain">';
				echo '       <fieldset data-role="controlgroup" data-mini="true">';
				
				$link = DatabaseUtil::openDatabase();
				$results = @mysql_query("SELECT * FROM ".CATEGORY_TABLE, $link);
				$compt=1;
				while($row=@mysql_fetch_array($results)){
					echo '           <input type="radio"  name="'.CATEGORY_ID.'" id="radio-choice-'.$compt.'" value="'.$compt.'"/>';
					echo '           <label for="radio-choice-'.$compt.'">'.$row[1].'</label>';
					$compt++;
				}
				@mysql_free_result($results);
		        @mysql_close();
			    echo '       </fieldset>';
			    echo '    </div>';
			?>
			</div>
	        <div class="ui-block-b" style="padding: 1%;  width:50%;">
			    <div data-role="fieldcontain">
                   <input type="text" name="<?php require_once 'databaseutil.php'; echo ARTICLE_ID;?>" id="article_id" placeholder="Article ID ..."  style=" width:100%; margin-bottom:20px;"/>
                   <input type="text" name="<?php require_once 'databaseutil.php'; echo ARTICLE_TITLE;?>" id="title" placeholder="Title ..."  style=" width:100%; margin-bottom:20px;"/>
                   <input type="hidden" name="<?php require_once 'databaseutil.php'; echo REQUEST_LABEL;?>" value="<?php require_once 'databaseutil.php'; echo REQUEST_NOTIFY;?>"/>
				   <input type="submit" name="request" value="<?php require_once 'databaseutil.php'; echo REQUEST_NOTIFY;?>"  data-theme="a"  style="width:100%;"/>
                </div>
			</div>
        </div>
		</form>	
		<div data-role="footer" data-position="fixed"> 
	        <h4>&copy;2014 IGIHE LTD.</h4> 
        </div> 
    </body>
</html>