<?php
/*
 * List All Opened Tickets
 */
function my_open_ticket_form(){
	echo "My ticket entered.. exiting ";exit;
if(session_id() == '' || !isset($_SESSION)) { session_start(); }
$emailId = $_SESSION['user']['email'];
$sessionKey=$_SESSION['sessionKey'];
//$employeId = get_employeeId_by_email($emailId);
$myCases = get_all_cases_by_emailId1($emailId,$sessionKey);
//$myCases=get_all_cases1();
$myCaseList = $myCases->data;
//echo '<pre>'; print_r($myCases->data);echo '</pre>';
if($emailId==''){
    
    echo "Please Login and continue..";
}else{
    $view_case_url=esc_url( get_permalink( get_page_by_title( 'Ticket Overview' ) ) );
    $edit_case_url=esc_url( get_permalink( get_page_by_title( 'Edit '.OBJECT_NAME ) ) );
?>
<?php //get_sidebar('sidebar2');?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#mycaseslist').dataTable({
            "aaSorting":[]
        });
    });
</script>
  <div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-item-wrap">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			 	<?php the_post_thumbnail( 'sparkling-featured', array( 'class' => 'single-featured' )); ?>
			</a>
		<div class="post-inner-content">
			

			<div class="entry-content ">
			<div class="contnr">
                            <table id="mycaseslist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr> <th style="width:100px">Ticket #</th>
                                        <th style="width:150px">Status</th>
                                        <th style="width:150px">Type</th>
                                        <th style="width:150px">Priority</th>
                                        <th style="width:250px">Subject</th>
                                        <th style="width:80px">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                if (is_array($myCaseList)) {
                                foreach ($myCaseList as $key => $myCase) { 
                                	if($myCase->caseStatus=='Open'){ 
                                    echo '<tr id="'.$myCase->caseId.'">
                                        <td>'.$myCase->caseNumber.'</td>
                                        <td>'.$myCase->caseStatus.'</td>
                                        <td>'.$myCase->caseType.'</td>
                                        <td>'.$myCase->casePriority.'</td>
                                        <td>'.$myCase->caseSummary.'</td>
                                        <td><a class="vieww" href="'.$view_case_url.'?id='.$myCase->caseId.'"></a></td>
                                        </tr>';
                                	}
                                    } 
                                }
                                ?>        
                                </tbody>
                            </table>
            
            </div>
			</div>
		</div>
	</div>
        </article>

    </main><!-- #main -->

  </div><!-- #primary -->


<?php
}
 	
} 
?>