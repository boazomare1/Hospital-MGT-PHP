$(function() {
    $( "#items_dialog" ).dialog({  
                autoOpen: false, 
                maxWidth:600,
                maxHeight: 500,
                width: 700,
                height: 300,
                modal: true   
         });
    $( ".viewitemhistory" ).click(function() {
        var visitcode = $(this).attr('id');
        var viewname = $(this).attr('viewname');
        //alert(viewname);
        $.ajax({
          url: 'ajax/getpkgmedicineitemhistory.php',
          type: 'POST',
          //async: false,
          dataType: 'json',
          //processData: false,    
          data: { 
              viewname: viewname,
              visitcode: visitcode
              
          },
          success: function (data) { 
            
            var patientname = "";
            for (var i = 0; i < data.length; i++) {
                patientname = data[i]['patientname'];
                
            }
            if(patientname == "")
            var patientname = $('#'+visitcode).attr("patientname");
            var html ="";
            html += '<div class="bodytext31 itemtitle"><b>'+patientname+'</b></div>';
            html += '<table width="100%" border="1" cellspacing="0.5" cellpadding="2">';
            html += '<tbody ><tr><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Date</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Item Code </strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Item Name</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong> Quantity </strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Rate</strong><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Amount</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Status</strong></td></tr>';
            for (var i = 0; i < data.length; i++) {
                //console.log(data[i]['amount']);
                var entrydate = data[i]['entrydate'];
                var itemname = data[i]['itemname'];
                var itemcode = data[i]['itemcode'];
                var entrydate = data[i]['entrydate'];
                var rate = data[i]['rate'];
                var quantity = data[i]['quantity'];
                quantity = quantity;
                var amount = data[i]['amount'];
                var recordstatus = data[i]['recordstatus'];
               
                html += '<tr><td class="bodytext31" align="center">'+entrydate+'</td><td class="bodytext31" align="center">'+itemcode+'</td><td class="bodytext31" align="center">'+itemname+'</td><td align="right" class="bodytext31">'+quantity+'</td><td align="right" class="bodytext31">'+rate+'</td><td align="center" class="bodytext31">'+amount+'</td><td align="center" class="bodytext31">'+recordstatus+'</td></tr>';
            }
            if(data.length == 0)
            {
                html += '<tr><td colspan="7" class="bodytext31" align="center">No Data found</td></tr>';
            }
            html += '</tbody></table>';
            
            $('#items_dialog').html(html);
            $( "#items_dialog" ).dialog( "open" );
            
          }
        });
    });
	
	
	
	
});