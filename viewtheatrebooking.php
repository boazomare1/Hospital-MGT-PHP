<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);
 
$thismonth=$year."-".$month."___";

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	  $locationcode=$location;
	}
?>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
#position
{
position: absolute;
    left: 830px;
    top: 420;
}
-->
</style>

<!--
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script src="js/datetimepicker_css.js"></script>
<script src="datetimepicker1_css.js"></script>
-->
<!--
<link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.print.css" media="print">
-->
<!-- fullcalendar -->
<link href='fullcalendar/core/main.css' rel='stylesheet' />
<link href='fullcalendar/daygrid/main.css' rel='stylesheet' />
<link href='fullcalendar/timegrid/main.css' rel='stylesheet' />
<link href='fullcalendar/list/main.css' rel='stylesheet' />

<style>
.hideClass
{display:none;}
</style>

<script language="javascript">

function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your Login.");
		document.form1.username.focus();
		return false;
	}
	else if (document.form1.password.value == "")
	{	
		alert ("Pleae Enter Your Password.");
		document.form1.password.focus();
		return false;
	}
}

function fundatesearch()
{
	alert();
	var fromdate = $("#ADate1").val();
	var todate = $("#ADate2").val();
	var sortfiled='';
	var sortfunc='';
	
	var dataString = 'fromdate='+fromdate+'&&todate='+todate;
	
	$.ajax({
		type: "POST",
		url: "opipcashbillsajax.php",
		data: dataString,
		cache: true,
		//delay:100,
		success: function(html){
		alert(html);
			//$("#insertplan").empty();
			//$("#insertplan").append(html);
			//$("#hiddenplansearch").val('Searched');
			
		}
	});
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

-->
</style>
</head>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>

  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top">
<table width="116%" border="0" cellspacing="0" cellpadding="0">

		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
          	<tr bgcolor="#011E6A">
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong> Theatre Bookings Calendar </strong></td>
              <td colspan="6" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
                  <?php
						
					if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
                  
                  </td>
     
              </tr>
            
          
            <!-- calendar -->
            <tr>
            	<td class="bodytext3" colspan="14" bgcolor="#ffffff">
            		<div id="calendar"></div>
            	</td>
            </tr>
           
            <tr>
             	<td colspan="12" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
	    <tr id="disease">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">
                     <!--
					 <tr>
                     <td class="bodytext3">Priliminary Diseases</td>
				   <td width="423"> <input name="dis2[]" id="dis2" type="text" size="69" autocomplete="off"></td>
                   </tr> -->
                     					
				      </table>
				  </td>
		        </tr>
				<tr>
        <td>&nbsp;</td>
        </tr>  
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
                 
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!--
<script src="dist/js/fullcalender.js"></script>
<script src="plugins/fullcalendar/fullcalendar.min.js"></script>
-->
<!-- fullcalendar -->
<script src='fullcalendar/core/main.js'></script>
<script src='fullcalendar/interaction/main.js'></script>
<script src='fullcalendar/daygrid/main.js'></script>
<script src='fullcalendar/timegrid/main.js'></script>
<script src='fullcalendar/list/main.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'dayGrid', 'timeGrid', 'list' ],
    defaultView: 'listWeek',
    header: {
      left: 'dayGridMonth,timeGridWeek,timeGridDay custom1',
      center: 'title',
      right: 'prevYear,prev,next,nextYear'
    },
    footer: {
      left: 'custom1',
      center: '',
      right: 'prev,next'
    },
    customButtons: {
      custom1: {
        text: 'Export Excel',
        click: function() {
          //alert('clicked custom button 1!');
          //var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#calendar').html()) 
          //location.href=url
          //return false
          var a = document.createElement('a');
		  //getting data from our div that contains the HTML table
		  var data_type = 'data:application/vnd.ms-excel';
		  a.href = data_type + ', ' + encodeURIComponent($('#calendar').html());
		  //setting the file name
		  a.download = 'TheatreBookingsCalendar.xls';
		  //triggering the function
		  a.click();
		  //just in case, prevent default behaviour
		  e.preventDefault();
		  return (a);
          /* end of excel function */
        }
      },
    },
    events: [
		  
		    {
              title: 'Theatre Bookings Calendar',
              /*start: new Date(y, m, 1),
              backgroundColor: "#f56954", //red
              borderColor: "#f56954" //red8*/
            }, 
			
			<?php 
			$query66 = "select * from  master_theatre_booking where recordstatus <> 'deleted'"; 
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res66 = mysqli_fetch_array($exec66))
			{
			$booking_id = $res66['auto_number'];
			$patientcode = $res66['patientcode'];
			$surgerydatetime = $res66['surgerydatetime'];
			$proceduretype = $res66['proceduretype'];
			$theatrecode = $res66['theatrecode'];

			if($proceduretype == 'emergency'){
				$bgcolor = '#f56954';
				$bordercolor = '#f56954';
			}else{
				$bgcolor = '#32CD32';
				$bordercolor = '#32CD32';
			}

			// get theatre name
			// get age and gender
		    $query677 = "select * from master_theatre where auto_number='$theatrecode'";
			$exec677 = mysqli_query($GLOBALS["___mysqli_ston"], $query677); 
			$res677 = mysqli_fetch_array($exec677);
			$theatrename = $res677['theatrename'];
			// get age and gender
		    $query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$var_appatient=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname']. '-'.$patientcode. '-'. $theatrename;
			$appatient=$var_appatient;


			$apdate = $res66['surgerydatetime'];
			
			$aptime= $res66['surgerydatetime'];
			
			$aptimeh=date('H',strtotime($aptime));
			$aptimem=date('i',strtotime($aptime));
				
			$adate = date('d',strtotime($apdate));
			$ayear = date('Y',strtotime($apdate));
			$amonth = date('m',strtotime($apdate));
			?>
			{
              title: '<?php echo $appatient; ?>',
              //url: 'edittheatrebooking.php?id=<?php echo $booking_id;?>',
              start: new Date(<?php echo $ayear; ?>, <?php echo $amonth; ?> -1, <?php echo $adate; ?>, <?php echo $aptimeh; ?>, <?php echo $aptimem; ?>),
			  allDay: false,

              backgroundColor: '<?php echo $bgcolor;?>', 
              borderColor: '<?php echo $bordercolor;?>' 
            },
			<?php
			}
			?>
		  
		  ],
  });

  calendar.render();
});
</script>
<!--
<script>
      $(function () {
        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();
        $('#calendar').fullCalendar({
          custom2: {
	        text: 'custom 2',
	        click: function() {
	          alert('clicked custom button 2!');
	        }
	      },
          header: {
            left: 'prev,next today custom2',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          footer: {
          	right: 'today'
          },
          buttonText: {
            today: 'today',
            month: 'month',
            week: 'week',
            day: 'day'
          },
          //Random default events
          events: [
		  
		    /*{
              title: 'All Day Event',
              start: new Date(y, m, 1),
              backgroundColor: "#f56954", //red
              borderColor: "#f56954" //red
            }, */
			
			<?php 
			$query66 = "select * from  master_theatre_booking where recordstatus <> 'deleted'"; 
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res66 = mysqli_fetch_array($exec66))
			{
			//$appatient = $res66['patientname'];
			$patientcode = $res66['patientcode'];
			$surgerydatetime = $res66['surgerydatetime'];
			$proceduretype = $res66['proceduretype'];

			if($proceduretype == 'emergency'){
				$bgcolor = '#f56954';
				$bordercolor = '#f56954';
			}else{
				$bgcolor = '#32CD32';
				$bordercolor = '#32CD32';
			}

			// get age and gender
		    $query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$appatient=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];


			$apdate = $res66['surgerydatetime'];
			
			$aptime= $res66['surgerydatetime'];
			
			$aptimeh=date('H',strtotime($aptime));
			$aptimem=date('i',strtotime($aptime));
				
			$adate = date('d',strtotime($apdate));
			$ayear = date('Y',strtotime($apdate));
			$amonth = date('m',strtotime($apdate));
			?>
			{
              title: '<?php echo $appatient; ?>',
              start: new Date(<?php echo $ayear; ?>, <?php echo $amonth; ?> -1, <?php echo $adate; ?>, <?php echo $aptimeh; ?>, <?php echo $aptimem; ?>),
			  allDay: false,

              backgroundColor: '<?php echo $bgcolor;?>', 
              borderColor: '<?php echo $bordercolor;?>' 
            },
			<?php
			}
			?>
		  
		  ],
          editable: false,
          droppable: false, // this allows things to be dropped onto the calendar !!!
          drop: function (date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = $(this).css("background-color");
            copiedEventObject.borderColor = $(this).css("border-color");

            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
          }
        });

        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default
        //Color chooser button
      });
    </script>
-->
</body>
</html>

