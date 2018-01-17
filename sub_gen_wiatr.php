<!doctype html>


<html lang="pl">
  <head>
	<title>Generacja Źródeł Witrowych</title>
	<?php include('includes/head.php');?>
	<link rel="stylesheet" href="css/jquery-ui.min.css"/>
  </head>
  <body>
	<div id="global_width">
	<?php include('includes/logonav.php');?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 bg-dark  m-0 p-0">
				<div class="container-fluid m-0 p-0">
				<div id="sidebar2 bg-dark">
				<?php include('includes/leftnavigation.php');?>
					<div class="container">
						<div class="mb-3 mt-3 text-center">
							</br>
							<h4 class="text-center">Określ zakres dat:</h4></br>
							Data początkowa:
						</div>
						<div><input type="text" name="from_date" id="from_date" class="form-control" value=""/></div>
						<div class="mb-3 text-center">
							<br/>
							 Data końcowa:
						</div>
						<div><input type="text" name="to_date" id="to_date" class="form-control" value=""/></div>
						<div class="mb-3 mt-3"><button id="filter" value="filter" type="button" class="btn btn-black">Pokaż dane</button></div>
						<div class="mb-3 text-center">
							Jezeli chcesz porównać dane dla wybranych dwóch dni:
						</div>
						<div class="mb-3 mt-3"><button id="filter_compare" value="filter" type="button" class="btn btn-black">Porównaj dane</button></div>
					</div>
				</div>
				</div>
			</div>
			<div class="col-sm-9 bgcontent">
			</br>
				<div class="container contentwithoutcarousel">
					<h2>Zobacz dane na temat generacji wiatrowej:<h2>
					<button id="button_table" type="button" class="btn btn-dark btn-toggle">Tabela z danymi</button>
					<div id="table_div" class="style2"></div>
				</br>
					<button id="button_chart1" type="button" class="btn btn-dark btn-toggle">Wykres przedstawiający moc generowaną przez źródła wiatrowe</button>
					<div id="chart1_div" class="style2 m-0 p-0 text-center"></div>
				</br>
					<button id="button_chart2" type="button" class="btn btn-dark  btn-toggle">Wykres przedstawia porównanie mocy generowanej dla dwóch różnych dni</button>
					<div id="chart2_div" class="style2 m-0 p-0 text-center"></div>
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
	<script src="js/submain_gen_wiatr.js"></script>
   </body>
 </html>
 