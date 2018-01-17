<!doctype html>
<html lang="pl">
  <head>
  	<title>Wymiana Międzysystemowa</title>
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
							<option value="ceps_eksport_mwh">CEPS Eksport [MWh]</option>
							<option value="ceps_import_mwh">CEPS Import [MWh]</option>
							<option value="seps_eksport_mwh">SEPS Eksport [MWh]</option>
							<option value="seps_import_mwh">SEPS Import [MWh]</option>
							<option value="50hertz_eksport_mwh">50Hertz Eksport [MWh]</option>
							<option value="50hertz_import_mwh">50 Hertz Import [MWh]</option>
							<option value="svk_eksport_mwh">SvK Eksport [MWh]</option>
							<option value="svk_import_mwh">SvK Import [MWh]</option>
							<option value="nek_ukrenergo_eksport_mwh">NEK Ukrenergo Eksport [MWh]</option>
							<option value="nek_ukrenergo_import_mwh">NEK Ukrenergo Import [MWh]</option>
							<option value="litgrid_eksport_mwh">Litgrid Eksport [MWh]</option>
							<option value="litgrid_import_mwh">Litgrid Import [MWh]</option>
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
							<option value="ceps_eksport_mwh">CEPS Eksport [MWh]</option>
							<option selected = "selected" value="ceps_import_mwh">CEPS Import [MWh]</option>
							<option value="seps_eksport_mwh">SEPS Eksport [MWh]</option>
							<option value="seps_import_mwh">SEPS Import [MWh]</option>
							<option value="50hertz_eksport_mwh">50Hertz Eksport [MWh]</option>
							<option value="50hertz_import_mwh">50 Hertz Import [MWh]</option>
							<option value="svk_eksport_mwh">SvK Eksport [MWh]</option>
							<option value="svk_import_mwh">SvK Import [MWh]</option>
							<option value="nek_ukrenergo_eksport_mwh">NEK Ukrenergo Eksport [MWh]</option>
							<option value="nek_ukrenergo_import_mwh">NEK Ukrenergo Import [MWh]</option>
							<option value="litgrid_eksport_mwh">Litgrid Eksport [MWh]</option>
							<option value="litgrid_import_mwh">Litgrid Import [MWh]</option>
						</select> 
						</div>
						<div class="mb-3 mt-3"><button id="compare_two_values" value="filter" type="button" class="btn btn-black">Porównaj dane</button></div>
						<div class="text-center smallfont mb-3">
						Opis wielkości:<br/>
						CEPS - przekrój handlowy polsko-czeski<br/>
						SEPS - przekrój handlowy polsko-słowacki<br/>
						50Hertz - przekrój handlowy polsko-niemiecki<br/>
						SvK - przekrój handlowy polsko-szwedzki <br/>
						NEK Ukrenergo - przekrój handlowy polsko-ukraiński<br/>
						Litgrid - przekrój handlowy polsko-litewski<
						</div>
					</div>
				</div>
				</div>
			</div>
			<div class="col-lg-9 bgcontent">
			<br/>
				<div class="container">
					<div class="text-center">
						<h2>Przepływy mocy na poszczególnych przekrojach handlowych:</h2>
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
	  var table_name = "wyk_wym"
 	  var data_structure = [
		  {
			  "table_name": "wyk_wym",
			  "fields": [
				  {
					"column_name": "data",
					"title": "Data",
					"unit": " "
				  },
				  {
					"column_name": "ceps_eksport_mwh",
					"title": "CEPS Eksport",
					"unit": "MWh"
				  },
				  {
					"column_name": "ceps_import_mwh",
					"title": "CEPS Import",
					"unit": "MWh"
				  },
				  {
					"column_name": "seps_eksport_mwh",
					"title": "SEPS Eksport",
					"unit": "MWh"
				  },
				  {
					"column_name": "seps_import_mwh",
					"title": "SEPS Import",
					"unit": "MWh"
				  },
				  {
					"column_name": "50hertz_eksport_mwh",
					"title": "50Hertz Eksport",
					"unit": "MWh"
				  },
				  {
					"column_name": "50hertz_import_mwh",
					"title": "50Hertz Import",
					"unit": "MWh"
				  },
				  {
					"column_name": "svk_eksport_mwh",
					"title": "SvK Eksport",
					"unit": "MWh"
				  },
				  {
				  "column_name": "svk_import_mwh",
					"title": "SvK Import",
					"unit": "MWh"
				  },
				  {
				  	"column_name": "nek_ukrenergo_eksport_mwh",
					"title": "NEK Ukrenergo Eksport",
					"unit": "MWh"
				  },
				  {
				  	"column_name": "nek_ukrenergo_import_mwh",
					"title": "NEK Ukrenergo Import",
					"unit": "MWh"
				  },
				  {
				  	"column_name": "litgrid_eksport_mwh",
					"title": "Litgrid Eksport",
					"unit": "MWh"
				  },
				  {
				  	"column_name": "litgrid_import_mwh",
					"title": "Litgrid Import",
					"unit": "MWh"
				  } 
			]
		  }
	  ];
	  </script>
	  <script src="js/submain.js"></script>
   </body>
 </html>