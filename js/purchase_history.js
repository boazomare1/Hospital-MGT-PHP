
$(function() {
    $( "#items_dialog" ).dialog({  
                autoOpen: false, 
                maxWidth:600,
                maxHeight: 500,
                width: 600,
                height: 300,
                modal: true   
         });


    $( ".viewhistory" ).click(function() {

        var itemcode = $(this).attr('id');
        //alert(id)

        $.ajax({
          url: 'ajax/getitempurchasehistory.php',
          type: 'POST',
          //async: false,
          dataType: 'json',
          //processData: false,    
          data: { 
              itemcode: itemcode
          },
          success: function (data) { 
            
            var itemname = "";
            for (var i = 0; i < data.length; i++) {
                itemname = data[i]['itemname'];
                
            }
            if(itemname == "")
            var itemname = $('#'+itemcode).attr("itemname");

            var html ="";
            html += '<div class="bodytext31 itemtitle"><b>'+itemname+'</b></div>';
            html += '<table width="100%" border="1" cellspacing="0.5" cellpadding="2">';
            html += '<tbody ><tr><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Purchase Date</strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Cost Price </strong></td><td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Quantity<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Supplier</strong></td></tr>';

            for (var i = 0; i < data.length; i++) {
                console.log(data[i]['suppliername']);
                var entrydate = data[i]['entrydate'];
                var rate = data[i]['rate'];
                var quantity = data[i]['quantity'];
                quantity = quantity;
                var suppliername = data[i]['suppliername'];
               
                html += '<tr><td class="bodytext31" align="center">'+entrydate+'</td><td align="right" class="bodytext31">'+rate+'</td><td align="right" class="bodytext31">'+quantity+'</td><td align="center" class="bodytext31">'+suppliername+'</td></tr>';
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