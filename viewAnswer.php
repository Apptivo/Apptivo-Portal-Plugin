<?php
function view_answers_form(){
	


if(session_id() == '' || !isset($_SESSION)) {
            session_start();
}	//print_r($_SESSION);
$sessionKey=$_SESSION['sessionKey'];
//echo $sessionKey;
	require_once('config.php');
	get_sidebar('sidebar3');


	$question_id=$_GET['id'];
	$response_answer=get_question_by_question_id($question_id,$sessionKey);
	$question = $response_answer->indexQuestion;
	
	$question_Text= "#".getSolutionNumber($response_answer->indexQuestion) . " - " . $response_answer->indexQuestion->questionText;
	
	//echo '<pre>';print_r($response_answer);
	
        echo '<div class="titlebg">
                <h4 id="questitle"><a class="btn btn-default fltlft pd6p12p" href="'.PORTAL_URL.'answers/"><i class="fa fa-arrow-left"></i></a>'.$question_Text.'</h4>
        </div>';
        $categories=$response_answer->indexQuestion->customAttributes;
        $parent_category=$categories[1]->customAttributeValue;
        $sub_category=$categories[2]->customAttributeValue;
        
        ?>
       
        <div class="breadcrumb-bg" id="breadcrump">
        
      <ul class="breadcrumb">
      
        <li style="margin-top: 10px"><?php echo $parent_category;?></li>
        <?php if($sub_category!=''){?>
        <li class="active" style="margin-top: 10px"><?php echo $sub_category;?></li>
        <?php } ?>
      </ul>
    </div>
    
        
    
       <div class="contnr" id="list">
       <div class="publish_date" id="publish_date"> <h5 style="margin-left:0px;">Published On: <?php echo $question->creationDate; ?></h5> </div> 
        <?php 

	//echo '<p style="font-weight:bold;color: #FF8500;">'.$response_answer->indexQuestion->questionText.'</p>';
	//echo '<small>Posted On '.$response_answer->indexQuestion->creationDate .'</small><br><hr>';
	foreach($response_answer->indexQuestion->answers as $answer){
		//po1($response_answer);
		//echo "Answered On " .$answer->creationDate . " by " .$answer->postedByName.'<br>';
		echo stripcslashes($answer->answerText);
		echo "<hr>";
                if(isset($answer->answerDocuments)){
                foreach ($answer->answerDocuments as $documents){
                    $docId=$documents->documentId;
                    $docUrl=get_download_url1($docId); 
                    echo '<div class="formsectionn1">
                                <div class="notesec1"><div class="noteseclft"><a target="_blank" href="'.$docUrl.'">'.$documents->documentName.'</a></div></div>
                          </div><br>';
                }
                }
	}


$attachments = get_all_documents_objId2 ( $question_id );
		
		$attachmentList = $attachments->aaData;
		if (is_array ( $attachmentList ) && $attachmentList [0]->documentId != '') {
			foreach ( $attachmentList as $key => $attach ) {
				$dUrl = get_download_url1 ( $attach->documentId );
				echo '<div class="formsectionn1">
                                <div class="notesec1"><div class="noteseclft"><a target="_blank" href="' . $dUrl . '">' . $attach->documentName . '</a></div></div>
                                </div>';
			}
		} else {
// 			echo 'No Attachments Added Yet.';
		}
	
	?>
	</div>
	
<!--  <div>
 comment for add answer
	<div class="entry-content">
		<form name="add_ans" action="" method="post" id="add_ans">
			<div class="formsection">
				<div class="formlft">
                                    
					<h4 class="entry-title">
						<b>Add Answers:</b>
					</h4>
				</div>
				<p id="mess" style="color: red;"></p>
				<div class="formrgt svsubmit">
					<textarea name="addansarea" id="addansarea" cols="90" rows="10"></textarea>
				</div>
			</div>
		</form>




		<br>


		<form id="upfile" name="upfile" method="post"
			enctype="multipart/form-data" action="">
			<b>Upload File:</b>
			<p id="attach">
			<?php echo $file_name; ?>
			</p>

			<input type="hidden" name="doc_id" id="doc_id">
			<input name="image" type="file" id="uploadfile"><br> 
                        <button class="btn btn-primary" type="button" value="Attach File" name="submit" id="upload"
				style="width: auto !important;"> Attach File
</button>
                        
                        
                       <span style="display:none;" id="loadimage1"><img src="https://apptivoapp.cachefly.net/site/v1.0.5/images/aloading.gif" style="padding:6px 10px 10px;"></span>
		</form>
		<br> <br> <b>youtubeURL:</b><input type="text" name="youtube"
			id="youtube" class="form-control"><br> <br>
		<div class="formrgt svsubmit">
			<button class="btn btn-primary" type="button" value="Add Answer" name="addanswer" id="addanswer"> Add Answer
</button><span style="display:none;" id="loadimage"><img src="https://apptivoapp.cachefly.net/site/v1.0.5/images/aloading.gif" style="padding:6px 10px 10px;"></span>
		</div>
		</form>
	</div>
</div>-->

<div class="featured_questindex">
<ul id="que" class="featuredqus"></ul>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript">
$ = jQuery;
$(document).ready(function () {
	$('#loadimage1').hide();
	$('#loadimage').hide();
	$("#upload").click(function(){
		var file=$('input[type=file]')[0].files[0].name;
		
		//alert(file);
		var file_size= $('input[type=file]')[0].files[0].size;
		//var file_tmp=$('input[type=file]')[0].files[0].mozFullPath;
		//alert(file_tmp);
		if(file == ''){
			
			jQuery("#attach").html("upload file");
			 
		}
		else
		{	$('#loadimage1').show();
			$.ajax(
    	            {	
    	                type: 'POST',
    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
    	                data: {'action':'upload_file',"file_name":file,"question_id":<?php echo "'$question_id'";?>,"file_size":file_size},
    	               	success:function(data){
        	               			 jQuery("#doc_id").val(data);
        	               	    	jQuery("#attach").html("<p style='color:green;'>File Uploaded Successfully</p>");
        	               	    	$('#loadimage1').hide();

        	 				}

        	            });

			}
		
		
		
	});
	

	
});
</script>

			<?php
}
?>
