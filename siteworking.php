<!doctype html>
<html lang="pl">
  <head>
	<title>Działanie Strony</title>
	<?php include('includes/head.php');?>
	<link rel="stylesheet" href="css/style_subpages.css"/>
  </head>
  <body>
	<div id="global_width">
	<?php include('includes/logonav.php');?>
	<div class="container-fluid m-0 p-0">
	  <div class="bg-dark content">
				<div class="row">
					<div class="col-xl-9">
							<div class="container-fluid biggerfont constantwidth ">
								<h4 class="text-center">Zasada działania serwisu</h4>
								<p>Serwis działa tak jak standardowa strona internetowa, skrypty wykonywane na serwerze są napisane w języku PHP. Do połączenia z bazą danych wykorzystywana jest technologia AJAX implikowana poprzez bibliotekę JavaScript - JQuery. Zasada działania AJAX'a jest następująca:</p>
								<div class="container-fluid pagination-centered text-center" align="left">
								<figure  >
									<img src="img/ajax1.png" alt="Liczba 42" >
									<figcaption>Rysunek 1 - Podejście AJAX'owe. Źródło: http://yarpo.pl/2011/03/06</figcaption>
								</figure>
								</div>
								<p>Jak widać żądanie AJAX’owe nie powoduje pobrania całej witryny tylko jej części, dzieje się to bez przeładowania strony. Podejście takie jest o wiele szybsze od standardowego rozwiązania. Na przykładzie tej witryny - po kliknięciu na dany przycisk odpowiedzialny za wizualizację danych do funkcji AJAX utworzonej w JavaScript wysyłane są takie parametry jak data początkowa, końcowa, nazwa tabeli, nazwa kolumny, rodzaj danych(w zależności od tego który przycisk kliknął użytkownik). Parametry te są przekazywane skryptowi PHP, który wykonuje się na serwerze sieciowym. Skrypt łączy się z bazą danych MySQL, przechwytuje odpowiednie dane i zwraca je do JavaScript w formacie JSON. Dane są dalej ekstraktowane i wyświetlane.</p>
								
								<p> Na serwerze sieciowym znajdują się również skrypty odpowiedzialne za aktualizacje danych w bazie. Źródło danych to strona PSE udostępniająca swoje API między innymi w postaci możliwości pobrania odowiednich danych w formacie .csv. Skrypt na serwerze pobiera taki plik dla zadanej tabeli ze stałym okresem, wykorzystywana jest bilbioteka cURL, następnie dane są ekstraktowane i wysyłane do bazy danych</p>
								
								
						</div>
					</div>
					<div class="col-sm-3 d-none d-xl-block">
						<div class="innercolsm3">
						<br/>
							<div class="jumbotron">
							<h1 class="title2">Strony z których dowiesz sie więcej:</h1>
								<hr class="my-4">
								<a href ="https://www.pse.pl/home" target="_blank">
									<img class="complogo" src="loga/pse.png" ></a>
								<hr class="my-4">
								<a href ="http://www.wnp.pl/" target="_blank">
									<img class="complogo" src="loga/wnp.png" ></a>
								<hr class="my-4">
								<a href ="http://www.cire.pl/" target="_blank">
									<img class="complogo" src="loga/cire.png" ></a>
								<hr class="my-4">
								<a href ="https://www.kierunekenergetyka.pl/" target="_blank">
									<img class="complogo" src="loga/kierunekenergetyka.png" ></a>
								<hr class="my-4">
								<a href ="http://www.energetyka24.com/" target="_blank">
									<img class="complogo" src="loga/energetyka24.png" ></a>
								<hr class="my-4">
								<a href ="http://www.powermag.com/" target="_blank">
									<img class="complogo" src="loga/power2.png" ></a>
								<hr class="my-4">
								<a href ="http://www.power-eng.com/index.html" target="_blank">
									<img class="complogo" src="loga/powerengineering.png" ></a>
							</div>
						</div>
					</div>
				</div>
		</div>
	  </div>

	<?php include('includes/footer.php');?>
	
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
   </body>
 </html>