var titles = [];
var column_names = [];
var units = [];
 data_structure[0]["fields"].forEach(function(element){
	column_names.push(
	element["column_name"]
	);
	
	titles.push(
	element["title"]
	);
	
	units.push(
	element["unit"]
	);
});
	
  
  //console.log(data_structure[0]["fields"][0]["unit"]);
  
  //Pokazuj divy z wykresami
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
		$("#button_chart3").click(function(){
			$("#chart3_div").slideToggle("600","linear");
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
		setTimeout(function() { data_picker();}, 20);
		setTimeout(function() { $('#show_all_data').click();}, 25);
		//setTimeout(function() { $('#compare_two_days').click();}, 40);
		//setTimeout(function() { $('#compare_two_values').click();}, 75);
		//setTimeout(function() { $('#data_for_one_value').click();}, 100);
	   
	   //Po kliknieciu w przycisk aktualizuj dane
	   $('#show_all_data').click(function(){  
			var from_date = $('#from_date').val();  
			var to_date = $('#to_date').val();
			var column_name = ["all"];
			getdata_AJAX(from_date, to_date,"all_data_table", column_name);
	   });
	   
	   $('#data_for_one_value').click(function(){  
			var from_date = $('#from_date').val();  
			var to_date = $('#to_date').val(); 
			var column_name =[$("#select_1").val()];
			getdata_AJAX(from_date, to_date,"data_between_two_dates", column_name);
	   });
	 $('#compare_two_days').click(function(){  
			var from_date = $('#from_date').val();  
			var to_date = $('#to_date').val(); 
			var column_name = [$("#select_1").val()];
			getdata_AJAX(from_date,to_date,"data_two_days", column_name);
	   });
	   $('#compare_two_values').click(function(){  
			var from_date = $('#from_date').val();  
			var to_date = $('#to_date').val(); 
			var column_name =[$("#select_1").val(), $("#select_2").val()];
			if(column_name[0]==column_name[1])
				alert("Proszę podać dwie różne wielkości do porównania");
			else
				getdata_AJAX(from_date,to_date,"data_two_values", column_name);
	   });
	   
	   function getdata_AJAX(from_date, to_date, which_data, column_name)
	   {
			if((from_date > to_date) && (which_data == "data_between_two_dates"))  
			{
				alert("Data początkowa nie może być większa od daty końcowej!");
			}
			else if(from_date != '' && to_date != '')  
			{  
				 $.ajax({  
					  url:"get_dbdata.php",
					  method:"POST",  
					  data:{from_date:from_date, to_date:to_date, which_data:which_data, table_name:table_name, column_name:column_name},  
					  success:function(response)  
					  { 
					  
							//console.log(response);
							var parse_response = JSON.parse(response);
							if(parse_response.length > 15000)
							{
								alert("Dla tej opcji został przekroczony zakres pobieranych danych!");
							}
							else
							{
							var exploded_response = explode_JSON(parse_response);
							if( which_data == "all_data_table")
								prepare(exploded_response, "all_data_table", column_name);
							else if( which_data == "data_between_two_dates")
								prepare(exploded_response, "data_between_two_dates", column_name);//Wysylaj dane do funkcji pomocniczej
							else if (which_data == "data_two_days")
							{
								var exploded_response_to_compare = explode_JSON_to_compare(parse_response, column_name, from_date, to_date );
								prepare(exploded_response, exploded_response_to_compare, column_name);
							}
							else if(which_data == "data_two_values")
							{
								prepare(exploded_response,"data_two_values", column_name);									
							}
							}

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
			/*for(var i = 1; i< Object.keys(parse_response[0]).length;i++)
			{
				_data.push([
				Object.getOwnPropertyNames(parse_response[0])[i]
				]);
			}*/
			
			for(var i = 0; i < parse_response.length; i++) {
			  var single = parse_response[i];
			 //console.log(single);
			  //console.log(Object.getOwnPropertyNames(single)[0]);
				exported_date = new Date(single.data);
				_data.push([
				exported_date,
				]);
				for(var j =0; j<Object.keys(single).length;j++){
					for(var k = 1; k< column_names.length; k++){
						if(column_names[k] == Object.getOwnPropertyNames(single)[j])
						{
						_data[i].push(
						parseFloat(single[column_names[k]])
						);
						}
					}
				}
			}
			return _data;
		}
		
		function explode_JSON_to_compare(parse_response, column_name, from_date, to_date)
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
				parseFloat(single[column_name])
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
		  var index_column_name = column_names.indexOf(column_name[0])
			_data_tocompare.unshift(["Godzina", from_date, to_date]);
			return _data_tocompare;	
			
		}

			
		function prepare(exploded_response, exploded_response_to_compare, column_name)
		{
			google.charts.load('current', {'packages':['corechart', 'table','bar']}, {'language':['pl']});
			google.charts.setOnLoadCallback(drawChart);
			
			function drawChart() {
				
				var dataTable = new google.visualization.DataTable();
				dataTable.addColumn('date', 'Data');
				if(exploded_response_to_compare == "all_data_table")
				{

					for(var i = 1; i<titles.length;i++)
					{
					dataTable.addColumn('number', titles[i]);
					}
				}
				else
				{
					for(var i =1; i<column_names.length; i++){
						for(var j =0; j<column_name.length;j++){
							if(column_names[i] == column_name[j])
							{
								dataTable.addColumn('number', titles[i]);
							}
							
						}
					}
				}
				
				//console.log(exploded_response);
				dataTable.addRows(exploded_response);
				
				 var monthYearFormatter = new google.visualization.DateFormat({
				 pattern: "MMM-dd HH:mm"
				});
			
				monthYearFormatter.format(dataTable, 0)

				var table = new google.visualization.Table(document.getElementById('table_div'));

				table.draw(dataTable, {showRowNumber: true, width: '100%', height: '100%',allowHtml: true, cssClassNames: {headerCell: 'googleHeaderCell'}, page: 'event', pageSize: '24'});
				
				//Koniec rysowania tabeli

				var index_column_name = column_names.indexOf(column_name[0]);
				var index_2_column_name;
				var unit_show = units[index_column_name];
				var unit_show_2;
				var column_title = $("#select_1 option:selected").text();
				var column_title_2 = $("#select_2 option:selected").text();
				if(exploded_response_to_compare == "data_between_two_dates")
				{
					//var index_column_name = column_names.indexOf(column_name[0]);
					exploded_response.unshift(
					["Data", titles[index_column_name]]
					);
							
					
					var data = google.visualization.arrayToDataTable(exploded_response);

					var options = {
						title: 'Wykres przedstawia wartość '+column_title+' dla zadanego przedziału czasowego',
						curveType: 'function',
						legend: { position: 'bottom', maxLines: 5 },
						 vAxis: { title: unit_show},
						 hAxis: { gridlines: { count: -1, units: { days: {format: ['MMM dd']}, hours: {format: ['HH:mm', 'ha']},} }, minorGridlines: { units: { hours: {format: ['HH:mm', 'ha']}}} },
						 height:350,
					};
					var chart = new google.visualization.LineChart(document.getElementById('chart1_div'));
					
					chart.draw(data, options);
				}
				else if(exploded_response_to_compare == "data_two_values")
				{
					//var index_column_name = column_names.indexOf(column_name[0]);
					index_2_column_name = column_names.indexOf(column_name[1]);
					unit_show_2 = units[index_2_column_name]
					if(unit_show != unit_show_2)
					{
						alert("Do porównania 2 wielkości proszę wybrać te o jednakowych jednostkach!");
					}
					else
					{
						exploded_response.unshift(
						["Data", titles[index_column_name], titles[index_2_column_name]]
						);

						var data = google.visualization.arrayToDataTable(exploded_response);
						var options = {
						  title: 'Wykres porównuje wartości '+column_title+' oraz '+column_title_2+' dla zadanego przedziału czasowego',
						  curveType: 'function',
						  legend: { position: 'bottom', maxLines: 5 },
						  vAxis: { title: unit_show},
						  hAxis: { gridlines: { count: -1, units: { days: {format: ['MMM dd']}, hours: {format: ['HH:mm', 'ha']},} }, minorGridlines: { units: { hours: {format: ['HH:mm', 'ha']}}} }, 
						  height:500
						};
						var chart = new google.visualization.LineChart(document.getElementById('chart3_div'));
						chart.draw(data, options);
					}
				}
				else if(exploded_response_to_compare !="all_data_table")
				{
					
					var data = google.visualization.arrayToDataTable(exploded_response_to_compare);
					var options = {
					  title: 'Wykres porównuje wartości '+column_title+' dla dwóch wybranych dni',
					  curveType: 'function',
					  legend: { position: 'bottom' , maxLines: 2},
					 vAxis: { title: unit_show},
					 height:500
					};
					var chart = new google.visualization.LineChart(document.getElementById('chart2_div'));
					chart.draw(data, options);

				}
			}
		}
 });