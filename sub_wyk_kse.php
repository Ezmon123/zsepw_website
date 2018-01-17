<!doctype html>
<html lang="pl">
  <head>
  	<title>Wielkości Podstawowe</title>
	<?php include('includes/head.php');?>
	<link rel="stylesheet" href="css/jquery-ui.min.css"/>
	<link rel="stylesheet" href="css/style_subpages.css"/>
  </head>
  <body>
	<div id="global_width">
	<?php include('includes/logonav.php');?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 bg-dark  m-0 p-0">
				<div class="container-fluid m-0 p-0">
				<div id="sidebar2 bg-dark">
				<?php include('includes/leftnavigation.php');?>
					<div class="container">
						<div class="mb-3 mt-3 text-center">
							<br/>
							<h4 class="text-center">Określ zakres dat:</h4><br/>
							Data początkowa:
						</div>
						<div><input type="text" name="from_date" id="from_date" class="form-control" value=""/></div>
						<div class="mb-3 text-center">
							<br/>
							 Data końcowa:
						</div>
						<div><input type="text" name="to_date" id="to_date" class="form-control" value=""/></div>
						<div class="mb-3 text-center">
							Kliknij w przycisk aby pokazać całą tabele z danymi dla wybranego przedziału czasowego
							<div class="mb-3 mt-3"><button id="show_all_data" value="show_all_data" type="button" class="btn btn-black">Pokaż tabele </button></div>
							Wybierz wartość z poniższej listy aby wyświetlić dane dla zadanego przedziału czasowego
						</div>
						<div class="text-center width-100">
						<select id="select_1" class="width-100">
							<option value="krajowe_zapotrzebowanie_na_moc_mw">Krajowe zapotrzebowanie na moc [MW]</option>
							<option selected = "selected" value="sumaryczna_generacja_jwcd_mwh">Sumaryczna generacja JWCD [MWh]</option>
							<option value="generacja_pi_mwh">Generacja PI [MWh]</option>
							<option value="generacja_irz_mwh">Generacja IRZ [MWh]</option>
							<option value="sumaryczna_generacja_njwcd_mwh">Sumaryczna generacja nJWCD [MWh]</option>
							<option value="krajowe_saldo_wymiany_miedzysystemowej_rownoleglej_mwh">Krajowe saldo wymiany międzysystemowej równoległej [MWh]</option>
							<option value="krajowe_saldo_wymiany_miedzysystemowej_nierownoleglej_mwh">Krajowe saldo wymiany międzysystemowej nierównoległej [MWh]</option>
						</select> 
						</div>
						<div class="mb-3 mt-3"><button id="data_for_one_value" value="data_for_one_value" type="button" class="btn btn-black">Pokaż dane</button></div>
						<div class="mb-3 text-center">
							Jezeli chcesz porównać jedną wybraną wielkość dla wybranych dwóch dni:
						</div>
						<div class="mb-3 mt-3"><button id="compare_two_days" value="filter" type="button" class="btn btn-black">Porównaj dane</button></div>
						<div class="mb-3 text-center">
							Jeżeli chcesz porównać wybraną wielkość z drugą wielkością w zadanym przedziale, wybierz ją tutaj:
						</div>
						<div class="text-center width-100">
						<select id="select_2" class="width-100">
							<option value="krajowe_zapotrzebowanie_na_moc_mw">Krajowe zapotrzebowanie na moc [MW]</option>
							<option value="sumaryczna_generacja_jwcd_mwh">Sumaryczna generacja JWCD [MWh]</option>
							<option selected = "selected" value="generacja_pi_mwh">Generacja PI [MWh]</option>
							<option value="generacja_irz_mwh">Generacja IRZ [MWh]</option>
							<option value="sumaryczna_generacja_njwcd_mwh">Sumaryczna generacja nJWCD [MWh]</option>
							<option value="krajowe_saldo_wymiany_miedzysystemowej_rownoleglej_mwh">Krajowe saldo wymiany międzysystemowej równoległej [MWh]</option>
							<option value="krajowe_saldo_wymiany_miedzysystemowej_nierownoleglej_mwh">Krajowe saldo wymiany międzysystemowej nierównoległej [MWh]</option>
						</select> 
						</div>
						<div class="mb-3 mt-3"><button id="compare_two_values" value="filter" type="button" class="btn btn-black">Porównaj dane</button></div>
						<div class="text-center smallfont mb-3">
						Legenda:<br/>
						PI - JWCD świadczące usługę praca interwencyjna<br/>
						IRZ - JWCD świadczące usługę interwencyjna rezerwa zimna<br/>
						+ - import energii z Polski<br/>
						- - export energii z Polski<br/>
						</div>
					</div>
				</div>
				</div>
			</div>
			<div class="col-lg-9 bgcontent">
			<br/>
				<div class="container">
					<div class="text-center">
						<h2>Wielkości podstawowe dotyczące pracy KSE:</h2>
					</div>
					<button id="button_table" type="button" class="btn btn-dark btn-toggle">Tabela z danymi</button>
					<div id="table_div" class="style2 "></div>
					<button id="button_chart1" type="button" class="btn btn-dark btn-toggle">Wykres przedstawiający wybrana wartość w danym przedziale czasowym</button>
					<div id="chart1_div" class="style2 m-0 p-0 text-center"></div>
					<button id="button_chart2" type="button" class="btn btn-dark  btn-toggle">Wykres porównuje wybraną wielkość dla dwóch różnych dni</button>
					<div id="chart2_div" class="style2 m-0 p-0 text-center"></div>
					<button id="button_chart3" type="button" class="btn btn-dark  btn-toggle">Wykres porównuje porównuje 2 wybrane wielkości w danym przedziale czasowym</button>
					<div id="chart3_div" class="style2 m-0 p-0 text-center"></div>
				</div>
			</div>
		</div>
	</div>
	<?php include('includes/footer.php');?>
	</div>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="js/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
	  <script>
	  var table_name = "wyk_kse"
	  var data_structure = [
	  {
	  				"table_name": "wyk_kse",
					"fields": [
				  {
					"column_name": "data",
					"title": "Data",
					"unit": " "
				  },
				  {
					"column_name": "krajowe_zapotrzebowanie_na_moc_mw",
					"title": "Krajowe zapotrzebowanie na moc",
					"unit": "MW"
				  },
				  {
				    "column_name": "sumaryczna_generacja_jwcd_mwh",
					"title": "Sumaryczna generacja JWCD",
					"unit": "MWh"
				  },
				  {
				    "column_name": "generacja_pi_mwh",
					"title": "Generacja PI",
					"unit": "MWh"
				  },
				  {
				    "column_name": "generacja_irz_mwh",
					"title": "Generacja IRZ",
					"unit": "MWh"
				  },
				  {
				  	"column_name": "sumaryczna_generacja_njwcd_mwh",
					"title": "Sumaryczna generacja nJWCD",
					"unit": "MWh"
				  },
				  {
				  	"column_name": "krajowe_saldo_wymiany_miedzysystemowej_rownoleglej_mwh",
					"title": "Krajowe saldo wymiany międzysystemowej równoległej",
					"unit": "MWh"
				  },
				  {
				  	"column_name": "krajowe_saldo_wymiany_miedzysystemowej_nierownoleglej_mwh",
					"title": "Krajowe saldo wymiany międzysystemowej nierównoległej",
					"unit": "MWh"
				  },
				  
				  
			  ]
	  }];

	  </script>
	  <script src="js/submain.js"></script>
   </body>
 </html>
