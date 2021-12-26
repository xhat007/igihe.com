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
			
			function preview(){
			    $('#preview').html($('#message').val());
			}
			
            function sendPushNotification(){
			    
				if($('input[type=radio]:checked').length == 0){
				    alert("Choose one category at most !");
					return false;
				}
				
				if($('#title').val().length == 0){
				    alert("The title is missing!");
					return false;
				}
				
				if($('#message').val().length == 0){
				    alert("HTML content is missing!");
					return false;
				}
				
				
				
				
                var data = $('form').serialize();
				
                $('form').unbind('submit');
                
                $.ajax({
                    url: "gcm.php",
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
	        <h1>IGIHE Android multicast messenger</h1> 
        </div> 
		<form id="form" method="post" onsubmit="return sendPushNotification()">
		<div class="ui-grid-b" >
	        <div class="ui-block-a" style="padding: 1%; width:30%;">
			<?php
			    require_once 'model/connect.php';
				
				echo '    <div  data-role="fieldcontain">';
				echo '       <fieldset data-role="controlgroup" data-mini="true">';
					
				$results =@mysql_query("SELECT * FROM categories",$connection);
				$compt=1;
                
				while ($row=@mysql_fetch_row($results)){
			        echo '           <input type="radio"  name="category" id="radio-choice-'.$compt.'" value="'.$compt.'"/>';
					echo '           <label for="radio-choice-'.$compt.'">'.$row[1].'</label>';
					$compt++;
		        }
				@mysql_free_result($results);
			    echo '       </fieldset>';
			    echo '    </div>';
		        @mysql_close();
			?>
			</div>
	        <div class="ui-block-b" style="padding: 1%;  width:40%;">
			    <div data-role="fieldcontain">
                  	 <input type="text" name="title" id="title" placeholder="Title ..."  style=" width:100%; margin-bottom:20px;"/>
				   <input name="body" id="message" style="width:100%;" placeholder="Id article">
					<table style=" width:100%;">
					    <tr>
						 							<th style=" width:50%;">
							    <input type="submit" name="request" value="Submit"  data-theme="a" />
							</th>
						</tr>
					</table>
                </div>
			</div>
	        <div class="ui-block-c" id="preview" style="padding: 1%;  width:30%; height:100%"></div>
        </div>
		</form>	
		<div data-role="footer" data-position="fixed"> 
	        <h4>&copy;2014 IGIHE Mob'IT.</h4> 
        </div> 
    </body>
</html>
