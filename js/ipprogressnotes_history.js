

$(function() {

    $( "#items_dialog" ).dialog({  

                autoOpen: false, 

                maxWidth:10000,

                maxHeight: 500,

                width: 1000,

                height: 300,

                modal: true   

         });





    $( ".viewhistory" ).click(function() {
     var itemcode = $(this).attr('id');
       // alert(id)
        $.ajax({
          url: 'ajax/get_ipprogressnotes_history.php',
          type: 'POST',
          //async: false,
          dataType: 'json',
          //processData: false,    
          data: { 
              itemcode: itemcode
          },
          success: function (data) { 
            var docno = "";
            for (var i = 0; i < data.length; i++) {
                docno = data[i]['docno'];
            }

            if(docno == "")
            var docno = $('#'+docno).attr("docno");
            var html ="";
           // html += '<div class="bodytext31 itemtitle"><b>'+docno+'</b></div>';
            html += '<table width="100%" border="1" cellspacing="0.5" cellpadding="2">';
            html += '<tbody ><tr><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Past Med/Surg/OBS</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Present Med/Surg/OBS </strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Family Social History</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Notes</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Diagnosis</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Procedure</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>D.O.P</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Weight of Baby</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Notification</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Condition</strong></td></tr>';

			for (var i = 0; i < data.length; i++) {
                console.log(data[i]['docno']);
                var pastmed = data[i]['pastmed'];
                var presentmed = data[i]['presentmed'];
                var familyhistory = data[i]['familyhistory'];
                var notes = data[i]['notes'];
                var diagnosis = data[i]['diagnosis'];
                var procedure1 = data[i]['procedure1'];
                var dop = data[i]['dop'];
                var weightofbaby = data[i]['weightofbaby'];
                var notification = data[i]['notification'];
                var condition1 = data[i]['condition1'];

                html += '<tr><td class="bodytext31" align="center">'+pastmed+'</td><td align="right" class="bodytext31">'+presentmed+'</td><td align="right" class="bodytext31">'+familyhistory+'</td><td align="center" class="bodytext31">'+notes+'</td><td align="center" class="bodytext31">'+diagnosis+'</td><td align="center" class="bodytext31">'+procedure1+'</td><td align="center" class="bodytext31">'+dop+'</td><td align="center" class="bodytext31">'+weightofbaby+'</td><td align="center" class="bodytext31">'+notification+'</td><td align="center" class="bodytext31">'+condition1+'</td></tr>';

            }

           
            if(data.length == 0)

            {

                html += '<tr><td colspan="4" class="bodytext31" align="center">No Data found</td></tr>';

            }

            html += '</tbody></table>';

            

            $('#items_dialog').html(html);



            $( "#items_dialog" ).dialog( "open" );

            

          }

        });

    });



});