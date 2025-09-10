function insertrow()
{         var i=1;
          var tbl = document.getElementById('presid');
          var lastRow = tbl.rows.length;
          var iteration = lastRow - 1;
          var row = tbl.insertRow(lastRow);
	
		  var firstCell = row.insertCell(0);
          var el = document.createElement('input');
          el.type = 'text';
          el.name = 'Name' + i;
          el.id = 'Name' + i;
          el.size = 25;
         firstCell.appendChild(el);
		  
		  var secondCell = row.insertCell(1);
          var e2 = document.createElement('input');
          e2.type = 'text';
          e2.name = 'dose' + i;
          e2.id = 'dose' + i;
          e2.size = 8;
          e2.maxlength = 8;
          secondCell.appendChild(e2);
		  
		  var fifthCell = row.insertCell(2);
          var el5 = document.createElement('input');
          el5.type = 'text';
          el5.name = 'frequency' + i;
          el5.id = 'frequency' + i;
          el5.size = 8;
          el5.maxlength = 8;
          fifthCell.appendChild(el5);
         
		  var sixthCell = row.insertCell(3);
          var el6 = document.createElement('input');
          el6.type = 'select';
          el6.name = 'days' + i;
          el6.id = 'days' + i;
          el6.size = 8;
          el6.maxlength = 8;
          sixthCell.appendChild(el6);
		 
		  var sevenththCell = row.insertCell(4);
          var el7 = document.createElement('input');
          el7.type = 'text';
          el7.name = 'qty' + i;
          el7.id = 'qty' + i;
          el7.size = 8;
          el7.maxlength = 8;
          sevenththCell.appendChild(el7);
		  
		  
		  var eighthCell = row.insertCell(5);
          var el8 = document.createElement('input');
          el8.type = 'text';
          el8.name = 'instructions' + i;
          el8.id = 'instructions' + i;
          el8.size = 20;
          el8.maxlength = 20;
          eighthCell.appendChild(el8);
		  
		  var ninethCell = row.insertCell(6);
          var el9 = document.createElement('input');
          el9.type = 'text';
          el9.name = 'rate' + i;
          el9.id = 'rate' + i;
          el9.size = 8;
          el9.maxlength = 8;
          ninethCell.appendChild(el9);
		  
		  var tenththCell = row.insertCell(7);
          var el0 = document.createElement('input');
          el0.type = 'text';
          el0.name = 'rate' + i;
          el0.id = 'rate' + i;
          el0.size = 8;
          el0.maxlength = 8;
          tenththCell.appendChild(el0);	
		  //alert(i);
          i++;
          form1.h.value=i;
          //alert(i);	 
}

