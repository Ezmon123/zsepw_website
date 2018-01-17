$(document).ready(function(){
		$("#button_table").click(function(){
			$("#table_div").slideToggle("600","linear");
		});  
		$("#button_chart1").click(function(){
			$("#chart1_div").slideToggle("600","linear");
		});
		$("#button_chart2").click(function(){
			$("#chart2_div").slideToggle("600","linear");
		});  	
		
		function data_picker(){
			//Domyslne ustawienia dla datepicker
			$.datepicker.setDefaults({  
				dateFormat: 'yy-mm-dd',
				changeYear: true,
				yearRange: "2014:2018"
		   }); 
		   //Przypisz datepicker do odpowiednich pól
			$("#from_date").datepicker();  
			$("#to_date").datepicker();  
		
		   //Funkcja odejmuje okreslone liczbe dni od zadanej daty
		   //Jako domyslna data bedzie uzyta data z dnia wczorajszego
		   Date.prototype.subDays = function(days) {
			   var dat = new Date(this.valueOf());
			   dat.setDate(dat.getDate() - days);
			   return dat;
		   }

			var today = new Date();
			var prev_day = today.subDays(1);
			prev_day = create_string_date(prev_day);
			var day_before_prev_day = today.subDays(2);
			day_before_prev_day = create_string_date(day_before_prev_day);

			//Ustawianie wartosci domyslnych dla datepicker

			$("#from_date").val(day_before_prev_day);
			$("#to_date").val(prev_day);			
		}
		function create_string_date(date)
		{
			
			var dd = date.getDate();
			var mm = date.getMonth()+1; //Styczen to miesiac zerowy
			var yyyy = date.getFullYear();

			if(dd<10) {
				dd = '0'+dd
			} 

			if(mm<10) {
				mm = '0'+mm
			} 
			
			date = yyyy + '-' + mm +'-' +dd;
			return date;
			
			
		}
	   
	   //Automatyczne klikniecie w przycisk pokaz dane po zaladowaniu strony, wywolaj date_picker
	   setTimeout(function() { data_picker();}, 50);
	   setTimeout(function() { $('#filter_compare').click(); }, 70);
		setTimeout(function() { $('#filter').click();}, 100);
	   
	   //Po kliknieciu w przycisk aktualizuj dane
	   $('#filter').click(function(){  
			var from_date = $('#from_date').val();  
			var to_date = $('#to_date').val(); 
			getdata_AJAX(from_date,to_date,"data_between_two_dates");
	   });
	   $('#filter_compare').click(function(){  
			var from_date = $('#from_date').val();  
			var to_date = $('#to_date').val(); 
			getdata_AJAX(from_date,to_date,"data_for_two_dates");
	   });
	   
	   function getdata_AJAX(from_date, to_date, which_data)
	   {
			if((from_date > to_date) && (which_data == "data_between_two_dates"))  
			{
				alert("Data początkowa nie może być większa od daty końcowej!");
			}
			else if(from_date != '' && to_date != '')  
			{  
				 $.ajax({  
					  url:"get_dbdata_gen_wiatr.php",
					  method:"POST",  
					  data:{from_date:from_date, to_date:to_date, which_data: which_data},  
					  success:function(response)  
					  { 
					  
							//console.log(response);
							var parse_response = JSON.parse(response);
							var exploded_response = explode_JSON(parse_response);
							
							if( which_data == "data_between_two_dates")
								prepare(exploded_response,"data_between_two_dates");//Wysylaj dane do funkcji pomocniczej
							else
								var exploded_response_to_compare = explode_JSON_to_compare(parse_response, from_date, to_date);
								prepare(exploded_response, exploded_response_to_compare);

					  }  
				 });  
				 
			}  
			else  
			{  
				 alert("Please Select Date");  
			}  
		}
		
		function explode_JSON(parse_response)
		{
			var exported_date;
			var _data = [];
			
			for(var i = 0; i < parse_response.length; i++) {
			  var single = parse_response[i];
				exported_date = new Date(single.data);
				_data.push([
				exported_date,
				parseFloat(single.sumaryczna_generacja_zrodel_wiatrowych_mwh)
				]);	
			}
			return _data;
		}
		
		function explode_JSON_to_compare(parse_response, from_date, to_date)
		{
			if(parse_response.length <25)
			{
				alert("Dla jednej z wybranych dat brak danych!");
			}
			var _data_2 = []
		  for(var i = 0; i < parse_response.length; i++) {
			  var single = parse_response[i];
			  
			  single.data = single.data.split(' ')[1];
			  var _d = single.data.split(':');
			  single.data = _d[0] + ':' + _d[1];
			  
			  _data_2.push([
				single.data,
				parseFloat(single.sumaryczna_generacja_zrodel_wiatrowych_mwh)
			  ]);
		  }
		 var i =0;
		 var j = _data_2.length - 1;
		var _data_tocompare = [];
		  for(i ; i < 24; i++){
			  _data_tocompare.push([
				_data_2[i][0],
				_data_2[i][1]
				]);
			  for(j ;  j >23 ;j--){
				if( _data_2[j][0] == _data_tocompare[i][0] )
				{
					_data_tocompare[i].push(
					_data_2[j][1]
					);
				}
			}
			j = _data_2.length - 1;
		  }
			_data_tocompare.unshift(["Godzina", "Moc z "+from_date, "Moc z "+to_date]);
			return _data_tocompare;	
		}

			
		function prepare(exploded_response, exploded_response_to_compare)
		{
			google.charts.load('current', {'packages':['corechart', 'table','bar']}, {'language':['pl']});
			google.charts.setOnLoadCallback(drawChart);
			//google.charts.setOnLoadCallback(drawcompareChart);
			
			
			function drawChart() {
				var dataTable = new google.visualization.DataTable();
				
				dataTable.addColumn('date', 'Data');
				dataTable.addColumn('number', 'Moc generowana przez źródła wiatrowe[MWh]');

				dataTable.addRows(exploded_response);
				 var monthYearFormatter = new google.visualization.DateFormat({
				 pattern: "MMM-dd HH:mm"
				});
				monthYearFormatter.format(dataTable, 0);
				var table = new google.visualization.Table(document.getElementById('table_div'));

				table.draw(dataTable, {showRowNumber: true, width: '100%', height: '100%', pageSize: '24',allowHtml: true});
				
				if(exploded_response_to_compare == "data_between_two_dates")
				{
					var options = {
						title: 'Generacja Źródeł Wiatrowych',
						curveType: 'function',
						legend: { position: 'bottom' },
						 vAxis: { title: 'MWh'},
						 hAxis: { gridlines: { count: -1, units: { days: {format: ['MMM dd']}, hours: {format: ['HH:mm', 'ha']},} }, minorGridlines: { units: { hours: {format: ['HH:mm', 'ha']}}} },
						 height:350
					};
					var chart = new google.visualization.LineChart(document.getElementById('chart1_div'));
					
					chart.draw(dataTable, options);
				}
				else
				{
					var data = google.visualization.arrayToDataTable(exploded_response_to_compare);
					var options = {
					  title: 'Porównanie mocy generowanej przez źródła wiatrowe dla dwóch wybranych dni',
					  curveType: 'function',
					  legend: { position: 'bottom' },
					  vAxis: { title: 'MWh'},
					  height:500
					};
					var chart = new google.visualization.LineChart(document.getElementById('chart2_div'));
					chart.draw(data, options);
				}
			}
		}
 });