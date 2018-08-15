<?php

	if(!isset($_COOKIE["time"])) {
		setcookie("time", date('H:i:s'), time() + 14400, "/");
		$all_second = 14400;
	} else {
		$old_date = $_COOKIE["time"];
		$new_date = date('H:i:s');
		$time1 = new DateTime($old_date);
		$time2 = new DateTime($new_date);
		$interval = $time1->diff($time2);
		$date =  ($interval->format('%H') * 3600) + ($interval->format('%I') * 60) + $interval->format('%S');
		$all_second = 14400 - $date;
	}

	$Month_r = array(
	"01" => "Января",
	"02" => "Февраля",
	"03" => "Марта",
	"04" => "Апреля",
	"05" => "Мая",
	"06" => "Июня",
	"07" => "Июля",
	"08" => "Августа",
	"09" => "Сентября",
	"10" => "Октября",
	"11" => "Ноября",
	"12" => "Декабря");

	$now_month = date('m', time()); // месяц на eng
	$rus_month = $Month_r[$now_month];


	if (filter_input(INPUT_GET,"utm_source",FILTER_SANITIZE_STRING) == NULL or filter_input(INPUT_GET,"utm_source",FILTER_SANITIZE_STRING) == ''){
		if(isset($_SERVER['HTTP_REFERER'])) {
			$utm_source = $_SERVER['HTTP_REFERER'];
		}else{
			$utm_source = "Прямой переход";
		}
		$utm_source = "Прямой переход";
		$utm_campaign = "";
		$utm_keyword = "";
		$utm_sourcersy = "";
		$utm_medium = "";
	}else{
		$utm_source = filter_input(INPUT_GET,"utm_source",FILTER_SANITIZE_STRING);
		$utm_campaign = filter_input(INPUT_GET,"utm_campaign",FILTER_SANITIZE_STRING);
		$utm_keyword = filter_input(INPUT_GET,"utm_term",FILTER_SANITIZE_STRING);
		$utm_sourcersy = filter_input(INPUT_GET,"utm_content",FILTER_SANITIZE_STRING);
		$utm_medium = filter_input(INPUT_GET,"utm_medium",FILTER_SANITIZE_STRING);
	}

	if($utm_source == NULL or $utm_source == ''){
		$utm_source = "Прямой переход";
	}

	if(isset($_GET['utm_city'])) {
		if($_GET['utm_city'] == 'alm') {
			$city = 'Almaty';
		}
		elseif($_GET['utm_city'] == 'ast'){
			$city = 'Astana';
		}
	}else {
		$city = "Almaty";
	}

	if (isset($_REQUEST["text"])) {
		$text = preg_replace("![^0-9]!", "", $_REQUEST["text"]);
	}
	if (isset($_REQUEST["add"])) {
		$add = preg_replace("![^0-9]!", "", $_REQUEST["add"]);
	}
	if (isset($_REQUEST["block"])) {
		$block = preg_replace("![^0-9]!", "", $_REQUEST["block"]);
	}
	if (isset($_REQUEST["stock"])) {
		$stock = preg_replace("![^0-9]!", "", $_REQUEST["stock"]);
	}

	if (!isset($text)) {
		$text = 1;
	}
	if (!isset($add)) {
		$add = 1;
	}
	if (!isset($block)) {
		$block = 1;
	}
	if (!isset($stock)) {
		$stock = 1;
	}


	//Ссылка на наш опубликованный файл CSV
	$fileUrl = 'https://docs.google.com/spreadsheets/d/1uoynMIKJUAH9zmRJE5YRRHcV7dgW3P0ytA3jn6qy-uA/pub?gid=400294816&single=true&output=csv';
	//Получаем наш файл из гугл док в виде массива
	$table = fsCsvToArray($fileUrl);
	// Для каждой переменной выбираем значение из таблицы

	for ($i=0; $i<count($table); $i++) {
		if ($table[$i][0] == $text) {
			$curr_text = $table[$i][1];
			break;
		}
	}

	for ($i=0; $i<count($table); $i++) {
		if ($table[$i][2] == $add) {
			$curr_add = $table[$i][3];
			break;
		}
	}

	for ($i=0; $i<count($table); $i++) {
		if ($table[$i][4] == $block) {
			$curr_block = $table[$i][5];
			break;
		}
	}

	for ($i=0; $i<count($table); $i++) {
		if ($table[$i][6] == $stock) {
			$curr_stock = $table[$i][7];
			break;
		}
	}

	function fsCsvToArray($pFile, $pDelimiter = ','){

			if (($handle = fopen($pFile, 'r')) !== FALSE) {
				$i = 0;
				while (($lineArray = fgetcsv($handle, 4000, $pDelimiter, '"')) !== FALSE) {
					for ($j = 0; $j < count($lineArray); $j++) {
						$arr[$i][$j] = $lineArray[$j];
					}
					$i++;
				}
				fclose($handle);
			}
			return $arr;
	}

	function formatPrint($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}

	$city_array = array('в Павлодаре', 'в Семее', 'в Уральске', 'в Костанае');
	if (isset($_GET['city'])) {
		$var_city = $city_array[$_GET['city']];
	}else{
		$var_city = "по всему Казахстану";
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="yandex-verification" content="5e280580c2d09929" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>MD Express | Оперативные бухгалтерские услуги <?php echo $var_city ?>.</title>
		<meta name="Keywords" content="Сдача налоговой отчетности, сдача отчетности, налоговая отчетность,сдача налоговой отчетности алматы, услуги по сдаче налоговой отчетности алматы, заказать сдачу отчетности" />
		<meta name="Description" content="Разовая сдача налоговой отчетности за 24 часа (сутки) всех видов. Сдача нулевой отчетности, для ип и тоо без стресса в жатые сроки. Конфиденцально. Гарантий. Заходите!" />
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="img/favicon.png" type="image/x-icon">

		<!-- Bootstrap -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- Style -->
		<link rel="stylesheet/less" type="text/css" href="style/style.less">
		<script src="js/less.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="js/like/social-likes_classic.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

		<!-- JS -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
		<script src="//vk.com/js/api/openapi.js?133" type="text/javascript"></script>

	    <script src="js/sweetalert/dist/sweetalert.min.js"></script>
	    <link rel="stylesheet" type="text/css" href="js/sweetalert/dist/sweetalert.css">

	</head>
	<body>
	<div id="wrapper">

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="right">
						<p class="btn_end" class="text-right"><span><i class="fa fa-times fa-lg" class="close" data-dismiss="modal"></i></span></p>
						<div class="jumbotronus">
							<div class="text-center head">
								<h2>ОСТАВЬТЕ ЗАЯВКУ</h2>
								<p id="modalText"></p>
							</div>
							<form>
								<input type="text" id="name" name="name" placeholder="ИМЯ"><br>
								<input type="email" id="email" name="email" placeholder="ЭЛЕКТРОННАЯ ПОЧТА"><br>
								<input type="text" id="phone" name="phone" class="phoneInput" placeholder="ТЕЛЕФОН"><br>
								<p class="button text-center" onclick="sendData()">ОСТАВИТЬ ЗАЯВКУ</p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Modal -->

		<div style="position: relative;">
			<!-- SECTION HEADER -->
			<div class="container-fluid" id="headerSection">
				<div class="container_my">

				<div class="content">

					<div class="row">
						<div class="col-sm-6 logo" style="position: relative;z-index: 1000">
							<p class="logoName">MD</p>
							<p class="logoType">EXPRESS</p>
							<p class="logoSlogan">ОПЕРАТИВНЫЕ БУХГАЛТЕРСКИЕ<br>УСЛУГИ <?php echo $var_city ?>.</p>
						</div>
						<div class="two-blocks" style="z-index: 1000">
							<div class="first-block radius-block" id="f-block" onclick="changeBtn1()">ПРЕДПРИНИМАТЕЛЬ</div>
							<div class="second-block" id="s-block" onclick="changeBtn2()">КОМПАНИЯ</div>
							<!-- <p><a class="phoneLookHref" href="javascript: void(0)"><span class="phoneLook"></span></a></p>
							<img src="img/phone.gif">
							<div class="clear"></div> -->
						</div>
					</div>

				</div>

				</div>
			</div>
			<!-- /SECTION HEADER -->

			<!-- SECTION UTP -->
			<div class="container-fluid" id="utpSection">
				<div class="container_my">

				<div class="content">

					<div class="row" style="position: relative;z-index: 1000">
						<div class="col-sm-12">
							<p><?php echo $curr_text;?></p>
							<h1><?php echo $curr_add;?></h1>
							<div class="coupon"><span>
								<b><?php echo $curr_block;?></b><br>
								<b><?php echo $curr_stock;?></b>
							</span></div>
							<div class="buttons menu"><a href="#there" onclick="showContainer()"><span>ОСТАВИТЬ ЗАЯВКУ</span></a>
							<a href="#here" onclick="showPainContainer()"><span>УЗНАТЬ БОЛЬШЕ</span></a></div>
						</div>
					</div>

				</div>

				</div>
			</div>
			<!-- /SECTION UTP -->
			<video autoplay muted loop id="myVideo">
			  <source src="./files/bg.mp4" type="video/mp4">
			</video>
		</div>

		<!-- SECTION MENU -->
		<!-- <div class="container-fluid" id="menuSection">
			<div class="container_my">

				<div class="row">
					<div class="col-sm-12" id="nav">
						<ul class="menu" >
							<li><a href="#painSection">ПОЧЕМУ С НАМИ?</a></li>
							<li><a href="#studentTypeSection">ДЛЯ КОГО?</a></li>
							<li><a href="#factsSection">ЧТО МЫ СДЕЛАЛИ?</a></li>
							<li><a href="#packetsSection">СКОЛЬКО СТОИТ?</a></li>
							<li><a href="#reasonsSection">ПОЧЕМУ У НАС?</a></li>
							<li><a href="#offerSection">ПОЧЕМУ СЕЙЧАС?</a></li>
						</ul>
					</div>
					<div class="col-sm-12 display_none" id="navMobile">
						<ul class="menu">
							<li>
								<div id="divBar">
									<svg viewBox="0 0 800 600">
										<path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
										<path d="M300,320 L540,320" id="middle"></path>
										<path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
									</svg>
								</div>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div> -->

		
		<!-- /SECTION MENU -->
		<div class="container-hide" id="painSection1">
		<div class="container-fluid" id="painSection"> 
			
			<div class="container_my">

			<div class="content" >

				<div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel">
					<div class="carousel-inner" role="listbox">

						<div class="item active">
							<div class="carousel-caption">
								<div class="top">
									<p id="here">Устали переплачивать</p>
									<p>БУХГАЛТЕРУ, КОТОРЫЙ ДЕЛАЕТ ОШИБКИ</p>
									<p>и постоянно ноет</p>
								</div>
								<div class="image">
									<center><img src="img/slider/Slide_icon1.svg"></center>
								</div>
								<div class="foot">
									<div>
										<p>Платите только за сделанную работу</p>
										<p>по факту ваших оборотов</p>
									</div>
                  					<p class="text-center"><span href="#myCarousel" onclick="painButton()" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
								</div>
							</div>
						</div>

						<div class="item">
							<div class="carousel-caption">
								<div class="top">
									<p>Устали мотивировать</p>
									<p>БУХГАЛТЕРА КОТОРЫЙ ПРОСИТ ПОВЫШЕНИЕ</p>
									<p>зарплаты не обоснованно</p>
								</div>
								<div class="image">
									<center><img src="img/slider/Slide_icon2.svg"></center>
								</div>
								<div class="foot">
									<div>
										<p>Доверьтесь команде профессионалов</p>
										<p>по цене одного бухгалтера</p>
									</div>
                  					<p class="text-center"><span href="#myCarousel" onclick="painButton()" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
								</div>
							</div>
						</div>

						<div class="item">
							<div class="carousel-caption">
								<div class="top">
									<p>Устали искать</p>
									<p>БУХГАЛТЕРА КОТОРЫЙ РАБОТАЕТ СТАБИЛЬНО</p>
									<p>и не выносит мозг</p>
								</div>
								<div class="image">
									<center><img src="img/slider/Slide_icon3.svg"></center>
								</div>
								<div class="foot">
									<div>
										<p>Бухгалтерия работает на вас</p>
										<p>А не вы на бухгалтера</p>
									</div>
                  					<p class="text-center"><span href="#myCarousel" onclick="painButton()" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
								</div>
							</div>
						</div>

						<div class="item">
							<div class="carousel-caption">
								<div class="top">
									<p>Устали восстанавливать</p>
									<p>БУХГАЛТЕРИЮ ПО ВИНЕ БУХГАЛТЕРА</p>
									<p>которому не хватает компетенции</p>
								</div>
								<div class="image">
									<center><img src="img/slider/Slide_icon4.svg"></center>
								</div>
								<div class="foot">
									<div>
										<p>Получайте аналитику и прозрачность</p>
										<p>в конце каждого месяца</p>
									</div>
                  					<p class="text-center"><span href="#myCarousel" onclick="painButton()" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
								</div>
							</div>
						</div>

					</div>

					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span><img class="swap1" src="img/slider/left_o.png" /></span><span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span><img class="swap2" src="img/slider/right_o.png" /></span><span class="sr-only">Next</span>
					</a>

				</div>

			</div>

			</div>
		</div> 
</div>
			<!--Тут я меняю-->
			<div class="container-hide" id="container-hide"> 
			<!-- <div id="sidebar" class="transition">
			<ul class="menu">
				<a href="#painSection"><li>ПОЧЕМУ С НАМИ?</li></a>
				<a href="#studentTypeSection"><li>ДЛЯ КОГО?</li></a>
				<a href="#factsSection"><li>ЧТО МЫ СДЕЛАЛИ?</li></a>
				<a href="#packetsSection"><li>СКОЛЬКО СТОИТ?</li></a>
				<a href="#reasonsSection"><li>ПОЧЕМУ У НАС?</li></a>
				<a href="#offerSection"><li>ПОЧЕМУ СЕЙЧАС?</li></a>
			</ul>
		</div> -->

		

			<!-- SECTION PAIN -->
		<!-- <div class="container-fluid" id="painSection"> 

			<div class="container_my">

			<div class="content" >

				<div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel">
					<div class="carousel-inner" role="listbox">

						<div class="item active">
							<div class="carousel-caption">
								<div class="top">
									<p id="here">Устали переплачивать</p>
									<p>БУХГАЛТЕРУ, КОТОРЫЙ ДЕЛАЕТ ОШИБКИ</p>
									<p>и постоянно ноет</p>
								</div>
								<div class="image">
									<center><img src="img/slider/Slide_icon1.svg"></center>
								</div>
								<div class="foot">
									<div>
										<p>Платите только за сделанную работу</p>
										<p>по факту ваших оборотов</p>
									</div>
                  					<p class="text-center"><span href="#myCarousel" onclick="painButton()" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
								</div>
							</div>
						</div>

						<div class="item">
							<div class="carousel-caption">
								<div class="top">
									<p>Устали мотивировать</p>
									<p>БУХГАЛТЕРА КОТОРЫЙ ПРОСИТ ПОВЫШЕНИЕ</p>
									<p>зарплаты не обоснованно</p>
								</div>
								<div class="image">
									<center><img src="img/slider/Slide_icon2.svg"></center>
								</div>
								<div class="foot">
									<div>
										<p>Доверьтесь команде профессионалов</p>
										<p>по цене одного бухгалтера</p>
									</div>
                  					<p class="text-center"><span href="#myCarousel" onclick="painButton()" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
								</div>
							</div>
						</div>

						<div class="item">
							<div class="carousel-caption">
								<div class="top">
									<p>Устали искать</p>
									<p>БУХГАЛТЕРА КОТОРЫЙ РАБОТАЕТ СТАБИЛЬНО</p>
									<p>и не выносит мозг</p>
								</div>
								<div class="image">
									<center><img src="img/slider/Slide_icon3.svg"></center>
								</div>
								<div class="foot">
									<div>
										<p>Бухгалтерия работает на вас</p>
										<p>А не вы на бухгалтера</p>
									</div>
                  					<p class="text-center"><span href="#myCarousel" onclick="painButton()" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
								</div>
							</div>
						</div>

						<div class="item">
							<div class="carousel-caption">
								<div class="top">
									<p>Устали восстанавливать</p>
									<p>БУХГАЛТЕРИЮ ПО ВИНЕ БУХГАЛТЕРА</p>
									<p>которому не хватает компетенции</p>
								</div>
								<div class="image">
									<center><img src="img/slider/Slide_icon4.svg"></center>
								</div>
								<div class="foot">
									<div>
										<p>Получайте аналитику и прозрачность</p>
										<p>в конце каждого месяца</p>
									</div>
                  					<p class="text-center"><span href="#myCarousel" onclick="painButton()" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
								</div>
							</div>
						</div>

					</div>

					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span><img class="swap1" src="img/slider/left_o.png" /></span><span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span><img class="swap2" src="img/slider/right_o.png" /></span><span class="sr-only">Next</span>
					</a>

				</div>

			</div>

			</div>
		</div>  -->
		<!-- /SECTION PAIN -->

		<!-- SECTION STUDENT TYPE -->
		<div class="container-fluid" id="studentTypeSection">
			<div class="container_my">

			<div class="content">

				<div class="row head1">
					<div class="col-sm-12 text-center">
						<p>Ведение бухгалтерского учета</p>
						<p>ДЛЯ МАЛОГО И СРЕДНЕГО БИЗНЕСА</p>
						<p>любой сложности по всему Казахстану</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 type">
						<img src="img/student_type/1.svg">
						<div class="text">
							<p>Вы начинающий предприниматель</p>
							<p>Собираетесь открыть бизнес и не знаете с чего начать. Хотите грамотно вести учет и посвятить свое время бизнесу.</p>
						</div>
						<div class="clear"></div>
					</div>
					<div class="col-md-6 type">
						<img src="img/student_type/2.svg">
						<div class="text">
							<p>Вы индивидуальный предприниматель</p>
							<p>Хотите получить бухгалтера за адекватную цену, вовремя выставлять счета и не переживать за отчеты.</p>
						</div>
						<div class="clear"></div>
					</div>
					<div class="col-md-6 type">
						<img src="img/student_type/3.svg">
						<div class="text">
							<p>Вы малый бизнес</p>
							<p>Устали постоянно менять бухгалтера и хотите делегировать бухгалтерию в надежные руки.</p>
						</div>
						<div class="clear"></div>
					</div>
					<div class="col-md-6 type">
						<img src="img/student_type/4.svg">
						<div class="text">
							<p>Вы средний бизнес</p>
							<p>Хотите организовать бухгалтерский учет, который вовремя дает вам нужные цифры и не затягивать с отчетами.</p>
						</div>
						<div class="clear"></div>
					</div>
				</div>

			</div>

			</div>
		</div>
		<!-- /SECTION STUDENT TYPE -->



		<!-- SECTION FACTS -->
		<div class="container-fluid" id="factsSection">
			<div class="container_my">

			<div class="content">


				<div class="row head1">
					<div class="col-sm-12 text-center">
						<p>НЕОСПОРИМЫЕ И</p>
						<p>ПОДТВЕРЖДЕННЫЕ ПРИЧИНЫ РАБОТАТЬ</p>
						<p>с прогрессивной компанией MIRUSDESK</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3 col-xs-6 fact">
						<center>
							<img src="img/facts/1.svg">
							<p>Ежемесячно обслуживаем клиентов по всему РК<span class="hide768"> бесперебойно и без штрафов.</span></p>
						</center>
					</div>
					<div class="col-sm-3 col-xs-6 fact">
						<center>
							<img src="img/facts/2.svg">
							<p>Каждый документ клиента сканируется и никогда не теряется.</p>
						</center>
					</div>
					<div class="col-sm-3 col-xs-6 fact">
						<center>
							<img src="img/facts/3.svg">
							<p>Несем отвественность по договору и представляем интересы в органах НК</p>
						</center>
					</div>
					<div class="col-sm-3 col-xs-6 fact">
						<center>
							<img src="img/facts/4.svg">
							<p>Круглосуточный автоматизированный сервис, прозрачные цифры.</p>
						</center>
					</div>
					<div class="col-sm-12 bigFact">
						<center>
							<div>
								<img src="img/wow4.gif">
							</div>
							<div class="clear"></div>
							<div class="text">
								<p>Вы ежедневно развиваете свой бизнес</p>
								<p>а мы занимаемся прочей рутиной</p>
							</div>
						</center>
					</div>
				</div>

			</div>

			</div>
		</div>
		<!-- /SECTION FACTS -->

		 <!-- SECTION PACKETS -->
		<div class="container-fluid" id="packetsSection">
			<div class="container_my">

			<div class="content">

				<div class="row head1">
					<div class="col-sm-12 text-center">
						<p id="there">Выберите</p>
						<p>Вид услуги</p>
						<p>по обслуживанию бухгалтерского учета</p>
					</div>
				</div>

				<div class="row text-center">
					<div class="col-sm-4 first">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Без абонентской платы</strong></div>
							<div class="panel-body">
								<center><img src="img/packets/1.svg"></center>
								<ul class="price1check">
									<li><label><input type="checkbox" disabled="disabled" checked="checked"> Проверка кабинета налогоплательщика</label></li>
									<li><label><input type="checkbox" disabled="disabled" checked="checked"> Бесплатная налоговая консультация</label></li>
									<li><label><input type="checkbox" disabled="disabled" checked="checked"> Отсутствие абонентской платы </label></li>
									<li><label><input type="checkbox" disabled="disabled" checked="checked"> Отсутствие оплаты за базу 1С</label></li>
									<li><label><input id="1" type="checkbox"> Оплата за каждый документ по факту</label></li>
								</ul>
							</div>
						</div>
						<div class="footer">
							<p>(вместо <span><span class="span1">29 000 тенге</span></span>)</p>
							<p><span class="span1_1">Бесплатно</span> </p>
							<p>до <?php echo (new DateTime('+1 day'))->format('d') . " " . $rus_month; ?></p>
							<p class="button chooseButton1" onclick="choose(1)"><span>СКАЧАТЬ ПРАЙС-ЛИСТ</span></p>
						</div>
					</div>

					<div class="col-sm-4 second">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Недавно открылись</strong></div>
							<div class="panel-body">
								<center><img src="img/packets/2.svg"></center>
								<ul class="price2check">
									<li><label><input id="1" type="checkbox" disabled="disabled" checked="checked"> Проверка кабинета налогоплательщика</label></li>
									<li><label><input id="2" type="checkbox" disabled="disabled" checked="checked"> Бесплатная налоговая консультация</label></li>
									<li><label><input id="3" type="checkbox" disabled="disabled" checked="checked"> Введение бухгалтерского учета для ТОО/ИП</label></li>
									<li><label><input id="4" type="checkbox" disabled="disabled" checked="checked"> Автоматическое сканирование документов</label></li>
									<li><label><input id="5" type="checkbox" disabled="disabled" checked="checked"> Расчет и начисление заработной платы</label></li>
									<li><label><input id="6" type="checkbox" disabled="disabled" checked="checked"> Ежемесячный отчет для руководителя</label></li>
									<li><label><input id="7" type="checkbox" disabled="disabled" checked="checked"> Введение онлайн банкинга</label></li>
									<li><label><input id="8" type="checkbox" disabled="disabled" checked="checked"> Cдача налоговой отчетности</label></li>
									<li><label><input id="9" type="checkbox" disabled="disabled" checked="checked"> Сдача стат. отчетности</label></li>
									<li><label><input id="10" type="checkbox" disabled="disabled" checked="checked"> Сбор актов-сверок</label></li>
								</ul>
							</div>
						</div>
						<div class="footer">
							<p>(вместо <span class="span2">59 000</span>)</p>
							<p><span class="span2_1">от 29 900 тг</span> <!-- <img src="img/tg_green.png"> --></p>
							<p>до <?php echo (new DateTime('+1 day'))->format('d') . " " . $rus_month; ?></p>
							<p class="button chooseButton2" onclick="choose(2)"><span>ОСТАВИТЬ ЗАЯВКУ</span></p>
						</div>
					</div>

					<div class="col-sm-4 third">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Существующий бизнес</strong></div>
							<div class="panel-body">
								<center><img src="img/packets/3.svg"></center>
								<ul class="price3check">
									<li><label><input id="1" type="checkbox" disabled="disabled" checked="checked"> Проверка кабинета налогоплательщика</label></li>
									<li><label><input id="4" type="checkbox" disabled="disabled" checked="checked"> Бесплатная налоговая консультация</label></li>
									<li id="btnGrp1">
										<div class="btn-group">
											<span id="optradio1" class="btn btn-success optradio11" checked="" value="ip"> ИП</span>
											<span id="optradio1" class="btn btn-default optradio12" value="too"> ТОО</span>
										</div>
									</li>
									<li id="btnGrp2">
										Выберите:
										<div class="btn-group">
											<span id="optradio2" class="btn btn-default optradio21" value="obw"> Общеустановленный </span>
											<span id="optradio2" class="btn btn-default optradio22" value="upr"> Упрощенный</span>
										</div>
									</li>
									<li id="btnGrp3" class="display_none">
										<div class="btn-group">
											<span id="optradio3" class="btn btn-default optradio31" value="usl"> Услуга</span>
											<span id="optradio3" class="btn btn-default optradio32" value="tov"> Товар</span>
											<span id="optradio3" class="btn btn-default optradio33" value="pro"> Производство</span>
										</div>
									</li>
									<li id="btnGrp4" class="display_none">
										Документы в квартал:
										<div class="btn-group">
											<span id="optradio4" class="btn btn-default optradio41" value="do100doc"> < 100</span>
											<span id="optradio4" class="btn btn-default optradio42" value="pos100doc"> > 100</span>
										</div>
									</li>
									<li id="btnGrp5" class="display_none">
										<div class="btn-group">
											<span id="optradio5" class="btn btn-default optradio51" value="alm"> в Алматы</span>
											<span id="optradio5" class="btn btn-default optradio52" value="notalm"> в другом городе</span>
										</div>
									</li>
									<li id="btnGrp6" class="display_none">
										<div class="btn-group">
											<span id="optradio6" class="btn btn-default optradio61" value="nonds"> без НДС</span>
											<span id="optradio6" class="btn btn-default optradio62" value="nds"> с НДС</span>
										</div>
									</li>
									<li id="btnGrp7" class="display_none">
										<div class="btn-group">
											<span id="optradio7" class="btn btn-default optradio71" value="do10sot"> < 10 сотрудников</span>
											<span id="optradio7" class="btn btn-default optradio72" value="pos10sot"> > 10 сотрудников</span>
										</div>
									</li>
									<li id="btnGrp8" class="display_none">
										Оборот в квартал:
										<div class="btn-group">
											<span id="optradio8" class="btn btn-default optradio81" value="do10mln"> < 10 млн.</span>
											<span id="optradio8" class="btn btn-default optradio82" value="pos10mln"> > 10 млн.</span>
										</div>
									</li>
									<li id="btnGrp9" class="display_none">
										Бухгалтер:
										<div class="btn-group">
											<span id="optradio9" class="btn btn-default optradio91" value="aut"> Аутсорсинг</span>
											<span id="optradio9" class="btn btn-default optradio92" value="pri"> Приходящий</span>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="footer">
							<p>(вместо <span class="span3">39 000</span>)</p>
							<p><span class="span3_1">14 900 тг</span> <!-- <img src="img/tg_purple.png"> --></p>
							<p>до <?php echo (new DateTime('+1 day'))->format('d') . " " . $rus_month; ?></p>
							<p class="button chooseButton3" onclick="choose(3)"><span>ОСТАВИТЬ ЗАЯВКУ</span></p>
						</div>
					</div>
				</div>

			</div>


			</div>
		</div>
		<!-- /SECTION PACKETS -->

		<!-- SECTION REASONS -->
		<div class="container-fluid" id="reasonsSection">
			<div class="container_my">

			<div class="content">


				<div class="row head1">
					<div class="col-sm-12 text-center">
						<p>Самые важные</p>
						<p>7 фактов о компании</p>
						<p>MIRUSDESK</p>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-3 col-xs-6 reason">
						<center>
							<img src="img/reasons/1.svg">
							<p>На рынке Казахстана<br>с 2008 года</p>
						</center>
					</div>
					<div class="col-sm-3 col-xs-6 reason">
						<center>
							<img src="img/reasons/2.svg">
							<p>Представлены услуги в<br>12 городах РК</p>
						</center>
					</div>
					<div class="col-sm-3 col-xs-6 reason">
						<center>
							<img src="img/reasons/3.svg">
							<p>38,5 гб база<br>собственных знаний и опыта</p>
						</center>
					</div>
					<div class="col-sm-3 col-xs-6 reason">
						<center>
							<img src="img/reasons/4.svg">
							<p>18 прогрессивных<br>инструментов</p>
						</center>
					</div>
				</div><br>

				<div class="row">
					<div class="col-sm-1" style="width: 12.499999995%"></div>
					<div class="col-sm-3 col-xs-6 reason">
						<center>
							<img src="img/reasons/5.svg">
							<p>9 экспертов в области<br>бух. учета</p>
						</center>
					</div>
					<div class="col-sm-3 col-xs-6 reason">
						<center>
							<img src="img/reasons/6.svg">
							<p>Офис компании в<br>центре города</p>
						</center>
					</div>
					<div class="col-sm-3 col-xs-12 reason">
						<center>
							<img src="img/reasons/7.svg">
							<p>Участие в разработке<br>Налогового кодекса РК</p>
						</center>
					</div>
				</div>

			</div>

			</div>
		</div>
		<!-- /SECTION REASONS -->

		<!-- SECTION OFFER -->
		<div class="container-fluid" id="offerSection">
			<div class="container_my">

			<div class="content">

				<div class="row">
					<div class="col-sm-12">
						<p>ПРИХОДЯЩИЙ</p>
						<p>главный бухгалтер по цене <br>рядового бухгалтера</p>
						<div class="coupon"><span>индивидуальное расписание.<br><u>платите только за обЪем работы.</u></span></div>
						<div class="timer">
							<b>Предложение действует:</b>
							<div>
								<span class="count hour">00</span>
								<span class="dots">:</span>
								<span class="count minutes">00</span>
								<span class="dots">:</span>
								<span class="count seconds">00</span>
								<span class="button" onclick="choose(5)">ПОЛУЧИТЬ АКЦИЮ</span>
							</div>
						</div>
					</div>
				</div>

			</div>

			</div>
		</div>
		<!-- /SECTION OFFER -->

		<!-- SECTION COMPANIES -->
		<div class="container-fluid" id="companiesSection">
			<div class="container_my">

			<div class="content">


				<div class="row head1">
					<div class="col-sm-12 text-center">
						<p>В ЭТОМ КВАРТАЛЕ</p>
						<p>К НАМ ОБРАТИЛИСЬ КОМПАНИИ</p>
						<p>и остались довольны нашими услугами</p>
					</div>
				</div>

				<div class="row">

					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/gt.jpg" style="width: 100%;"></center>
					</div>
					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/opt.jpg" style="width: 100%;"></center>
					</div>
					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/vse.jpg" style="width: 100%;"></center>
					</div>
					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/gala.jpg" style="width: 100%;"></center>
					</div>

				</div>
				<br><br>
				<div class="row">

					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/mle.jpg" style="width: 100%;"></center>
					</div>
					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/stroi.jpg" style="width: 100%;"></center>
					</div>
					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/alasha.jpg" style="width: 100%;"></center>
					</div>
					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/trub.jpg" style="width: 100%;"></center>
					</div>

				</div>
				<br><br>
				<div class="row">

					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/kabel.jpg" style="width: 100%;"></center>
					</div>
					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/alel.jpg" style="width: 100%;"></center>
					</div>
					<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/md.jpg" style="width: 100%;"></center>
					</div>
					<!--<div class="col-sm-3 col-xs-6">
						<center><img src="img/logos/amanat.jpg" style="width: 100%;"></center>
					</div> -->
				</div>

				<br><br><br><br><br><br>

			</div>

			</div>
		</div>
		<!-- /SECTION COMPANIES -->


		<div class="container-fluid" id="feedbackSection">
			<div class="container_my">

			<div class="content">

				<div class="row head1">
					<div class="col-sm-12 text-center">
						<p>отзывы реальных клиентов, которым</p>
						<p>понравилась услуга с первого раза</p>
						<p>с разных регионов казахстана</p>
					</div>
				</div>

				<div class="row">

					<div class="col-sm-6 feedback">
						<div class="panel panel-default">
							<div class="panel-body">
								<img src="img/ava4.jpg">
								<div class="text">
									<p>Сапар Ильясов</p>
									<p>------------</p>
									<p>Ляззат Амангельдиевна оперативно помогла с составлением отчетов. Все было сделано в тот же день. Работала она удаленно, отчеты прислала на почту. Я все сдал, каких-то вопросов не было, составлены грамотно, без ошибок. При необходимости будем обращаться еще!</p>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-6 feedback">
						<div class="panel panel-default">
							<div class="panel-body">
								<img src="img/ava2.jpg">
								<div class="text">
									<p>Алишер Ахметов</p>
									<p>------------</p>
									<p>Открыл свое ИП в этом году, но в документации я ноль, в налоговой сказали нужно сдать нулевую отчетность. Пошел гуглить и наткнулся на MIRUSDESK. На сайте было сказано, что та отчетность, которая нужна бесплатна. Ну мы-то не глупые, бесплатный сыр только в мышеловке - так думал я, но все же решил попробовать. Оказалось не соврали, даже сами сходили за меня в налоговую. Я сам сходил и проверил, в налоговой сказали, что все в порядке. Выражаю благодарность бухгалтерам MIRUSDESK, обязательно продолжу работать с вами!</p>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="row">

					<div class="col-sm-6 feedback">
						<div class="panel panel-default">
							<div class="panel-body">
								<img src="img/ava1.jpg">
								<div class="text">
									<p>Зарина Рзашева</p>
									<p>------------</p>
									<p>В прошлом месяце у меня возникли сложности со сдачей налоговой в компании, занимающейся клининг услугами. После университета у меня было недостаточно знаний в этой области. Я обратилась в эту компании, поначалу не вызывало доверия, так как за  такую работу с меня потребовали приличную сумму. Но блин, у меня поджимали сроки и на поиск других компаний просто не оставалось времени. В итоге осталась довольна, за 1 день собрали все что нужно и сами сдали 😊.</p>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-6 feedback">
						<div class="panel panel-default">
							<div class="panel-body">
								<img src="img/ava3.jpg">
								<div class="text">
									<p>Кабдумалик Айгерим</p>
									<p>------------</p>
									<p>Веду свой бизнес уже более 3ех лет, занимаюсь продажей брендовой итальянской одежды. Недавно столкнулась с такой проблемой, наняла себе бухгалтера вроде сообразительная девушка, ну и как-то не обращала внимание на то, как она работает, главное еженедельно сдавала мне отчёты, да и всё. Недавно выяснилось, что мой бухгалтер вела совсем неправильную отчётность, и вовсе запутала мне всю бухгалтерию! В общем бухгалтера я уволила, но отчётность приводить в порядок было нужно срочно, так как неожиданно и налоговая проверка могла нагрянуть!  В общем нашла в интернете компанию MD, цена мне конечно не совсем понравилась, но работу сделали качественно, более того посоветовали мне толкового бухгалтера, который проходил у них стажировку, сейчас веду работу с ним! Спасибо MD</p>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 share" style="margin-top: 10px;">
						<div class="text-center">
							<p style="font-size: 20px;">РАССКАЖИТЕ ДРУЗЬЯМ И ПОЛУЧИТЕ ДОСТУП К СООБЩЕСТВУ</p>
							<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
							<script src="js/like/social-likes.min.js"></script>

							<div class="social-likes" data-url="http://tax.mirusdesk.kz">
								<div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
								<div class="mailru" title="Поделиться ссылкой в Моём мире">Мой мир</div>
								<div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
								<div class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div>
								<div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
							</div>
						</div>
					</div>


				</div>

			</div>

			</div>
		</div>
		<!-- SECTION REASONS -->

		<!-- SECTION COMMENT -->
		<div class="container-fluid" id="commentSection">
			<div class="container_my">

			<div class="content">

				<div class="row head1">
					<div class="col-sm-12 text-center">
						<p>Здесь наши клиенты оставляют</p>
						<p>слова благодарности и делятся инсайтами</p>
						<p>после удачной сдачи отчетности</p>
					</div>
				</div>

				<div class="row">

					<div class="col-sm-6">
						<script type="text/javascript">
							VK.init({apiId: 5674295, onlyWidgets: true});
						</script>
						<div id="vk_comments"></div>
						<script type="text/javascript">
						VK.Widgets.Comments("vk_comments", {limit: 10, width: "665", attach: "*"});
						</script>
					</div>

					<div class="col-sm-6">
						<div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
						<div class="fb-comments" data-href="http://express.mirusdesk.kz" data-numposts="5"></div>
					</div>

				</div>

			</div>

			</div>
		</div>
		<!-- /SECTION COMMENT -->
		</div>
		<!--тут заканчиваю-->

		<!-- SECTION FOOTER -->
		<div class="container-fluid" id="footerSection">
			<div class="container_my">

			<div class="content">

				<div class="row">

					<div class="col-md-4 col-sm-6">
						<div class="logo">
							<p class="logoName">MD</p>
							<p class="logoType">EXPRESS</p>
							<p class="logoSlogan">ОПЕРАТИВНЫЕ БУХГАЛТЕРСКИЕ<br>УСЛУГИ ПО ВСЕМУ КАЗАХСТАНУ</p>
							<div class="clear"></div>
						</div>

						<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=XwY5PU4D4YB32GhPO-BMWUd8Rj3S8XEr&amp;width=100%&amp;height=120&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
						<p class="adress"><span>Наш офис: </span>г. <strong>Алматы</strong>, мкр. Самал-2, 58/19</p>

						<p class="copy">© 2008 — <?php echo date ( 'Y' ) ; ?> MADE WITH<img src="img/love1.gif">BY MIRUSDESK<br><a href="#">ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</a></p>
					</div>

					<div class="col-md-4 hidden-sm hidden-xs">
						<p>
							<span>Оформление:</span> приходного кассового ордера | прихода в кассу от оплаты покупателя | взноса наличных денежных средств в банк из кассы | реализации товаров | реализации услуг | покупки товаров у поставщика | доверенности на покупку товара | командировочного удостоверения | расходно-кассового ордера на оплату поставщику
							<br><br>
							<span>Формирование:</span> платежного поручения на перечисление пенсионных взносов | платежного поручения на перечисление социальных отчислений  | платежного поручения на перечисление социального налога  | платежного поручения на перечисление индивидуального подоходного налога | платежного поручения на выплату заработной платы сотруднику с расчетного счета
							<!-- <span>Создание:</span> платежного поручения в банк для оплаты поставщику | Создание платежного поручения оплаты от поставщика | Создание счета на оплату покупателю на приобретение товара | Создание счета на оплату покупателю на оказание услуг | авансового отчета сотрудника -->
						</p>
					</div>

					<div class="col-md-4 col-sm-6">
						<p>ЭЛЕКТРОННАЯ РАССЫЛКА</p>
						<p>Опыт | идеи | кейсы | новости | скидки | обратная связь</p>
						<p>Оставьте свою электронную почту,<br class="sm-hidden"> и будь в курсе событии</p>
						<input type="text" class="text" id="emailFooter" placeholder="Ваша почта:">
            <p class='button' onclick="sendEmail();">ПОДПИСАТЬСЯ!</p>
						<p class="copy">© 2008 — <?php echo date ( 'Y' ) ; ?> MADE WITH<img src="img/love1.gif">BY MIRUSDESK<br><a href="#">ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</a></p>
					</div>

				</div>

			</div>

			</div>
		</div>
		<!-- /SECTION FOOTER -->
		<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

		<script type="text/javascript">
			jQuery(function($){
				$(".phoneInput").mask("+7 (999) 999-9999");
			});
		</script>

		<script type="text/javascript" src="https://one.callback.pw/widget/cc009791-fe07-436d-bfe4-1c28677ac0c5"></script>

		<script type="text/javascript">

		function painButton(){
			yaCounter40321965.reachGoal('pain');
		}

		function sendEmail() {
	        var email = $("#emailFooter").val();
	        if (!isEmail(email)) {
	          swal("Упс!", "Напишите действительную почту", "error");
	        }else{
	          var postForm = { //Fetch form data
	            'email'     : email
	          };
	          $.ajax({ //Process the form using $.ajax()
	              type      : 'POST', //Method type
	              url       : 'newsletter.php', //Your form processing file URL
	              data      : postForm, //Forms name
	              dataType  : 'text',
	              success: function(msg) {
	                swal("Успешно отправлено!", "Теперь вы будете в курсе всех событии", "success");
	              }
	          });
	        }
	    }
      function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
      }
		// Call sidebar
		$("#divBar").click(function() {
			sidebar("slide");
		});

		// Check which nav must see user
		checkScreenSize();
		window.onresize = function(event) {
			checkScreenSize();
		}

		// when scroll check screen, fix nav and close sidebar
		$(window).scroll(function(){
			checkScreenSize();
			fixedNav();
			sidebar("close");
		});

		// sidebar open and close
		function sidebar(command){
			if (command == "close"){
				if($("#divBar").hasClass("cross") == true) {
					$("#sidebar").css("right","-100%");
					$("#divBar").removeClass("cross");
				}
			}else{
				if($("#divBar").hasClass("cross") == false){
					$("#sidebar").css("right","0px");
				}else{
					$("#sidebar").css("right","-100%");
				}
				return $("#divBar").toggleClass("cross");
			}
		}

		// Check which nav must see user
		function checkScreenSize(){
			var windowWidth = window.screen.width < window.outerWidth ? window.screen.width : window.outerWidth;
			var mobile = windowWidth < 993;
			var hideContact = windowWidth < 500;

			if (mobile) {
				$("#nav").addClass('display_none');
				$("#navMobile").removeClass('display_none');
			}else{
				$("#navMobile").addClass('display_none');
				$("#nav").removeClass('display_none');
			}
		}

		// Fix navigation to top
		function fixedNav(){
			var aTop = $('#headerSection').height() + $('#utpSection').height();
			var width = window.screen.width < window.outerWidth ? window.screen.width : window.outerWidth;

			if($(this).scrollTop()>=aTop){
				$('#menuSection').css("position", "fixed");
				$('#menuSection').css("top", "0px");
				$('#menuSection').css("margin-top", "0px");

				$('#sidebar').css("position", "fixed");
				$('#sidebar').css("top", "49px");
			}else{

				if (width > 991) {
					// Table etc
					$('#menuSection').css("position", "absolute");
					$('#menuSection').css("top", "600px");
					$('#menuSection').css("margin-top", "2px");

					$('#sidebar').css("position", "absolute");
					$('#sidebar').css("top", "652px");

				}else{
					// Mobile
					$('#menuSection').css("position", "absolute");
					$('#menuSection').css("top", "480px");
					$('#menuSection').css("margin-top", "2px");

					$('#sidebar').css("position", "absolute");
					$('#sidebar').css("top", "532px");
				}
			}
		}

		</script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">

			var formNumber = 0;

			// Teachers blog with big video animate slide left
			function animateLeft($src, $tgt){
				var $parent = $src.parent();
				var width = $parent.width();
				var srcWidth = $src.width();
				$src.css({position: 'relative'});
				$src.fadeOut( 500, function() {
					$tgt.hide().appendTo($parent).css({left: width, position: 'relative'});
					$tgt.show().animate({left: 0}, 500, function(){
						$tgt.css({left: null, position: null});
					});
				});
			}

			$(function(){
				var $first = $("#videoSection .bigReason:nth-child(1)");
				var $second = $("#videoSection .bigReason:nth-child(2)");
				$second.hide();
				$("#btnAnimate1").click(function(){
					animateLeft($first, $second);
					var tmp = $first;
					$first = $second;
					$second = tmp;
				});
				$("#btnAnimate2").click(function(){
					animateLeft($first, $second);
					var tmp = $first;
					$first = $second;
					$second = tmp;
				});
			})

			// Header contact button
			// $(".phoneLook").html("<p class='text-center phoneButton phoneButtonactive'>Бесплатная консультация <i class='fa fa-eye' aria-hidden='true'></i></p>")
			// $(".phoneLook").click(function (){
			// 	yaCounter40321965.reachGoal('number');
			// 	$(".phoneLook").html("<p class='text-center phoneButton'>+7 (707) 754-0083 <i class='fa fa-eye' aria-hidden='true'></i></p>");
			// })

			// Pain slide swap button highlight to orange color
			$('img.swap1').hover(function (){ this.src = 'img/slider/left.png';
			}, function (){ this.src = 'img/slider/left_o.png'; });
			$('img.swap2').hover(function (){ this.src = 'img/slider/right.png';
			}, function (){ this.src = 'img/slider/right_o.png'; });

			// Parallax effect slide
			$(".menu").on("click","a", function (event) {
				event.preventDefault();
				var id  = $(this).attr('href');
					if (id == "#painSection") {
						var top = $(id).offset().top;
					}else{
						var top = $(id).offset().top - 49;
					}
				$('body,html').animate({scrollTop: top}, 500);
			});

			// Timer for offer section
			var all_second = <?php echo $all_second; ?>;
			var second = 0;
			var minute = 0;
			var hour = 0;

			window.setInterval(function(){
				hour = (all_second - (all_second % 3600)) / 3600;
				second = ((all_second - (hour * 3600)) % 60);
				minute =  (all_second - (hour * 3600) - second) / 60;

				if (hour < 10) {hour = "0"+hour;}
				if (minute < 10) {minute = "0"+minute;}
				if (second < 10) {second = "0"+second;}

				$(".hour").html(hour);
				$(".minutes").html(minute);
				$(".seconds").html(second);
				all_second -= 1;
			}, 1000);

			var zayavka = "zayavka";
			var send = false;

			function sendData() {
				if (send == false) {
					send = true;
					setTimeout(function () {
				        send = false;
				    }, 5000);
					var name = $("#name").val();
					var email = $("#email").val();
					var phone = $("#phone").val();

					if (zayavka == "pricefree"){
						message = "Бесплатная заявка (без абонентской платы)";
					}else if (zayavka == "price1"){
						message = "Заявка от 29 900 тг";
					}else if (zayavka == "price2"){
						message = packet(2);
					}else if (zayavka == "utpButton"){
						message = "Хочет узнать во сколько обойдется приходящий бухгалтер в месяц";
					}else if (zayavka == "offerButton"){
						message = "Хочет узнать во сколько обойдется приходящий бухгалтер в месяц";
					}else{
						message = "";
					}

					if (name.length < 2) {
						swal("Упс!", "Напишите Ваше имя", "error");
					}else if (!isEmail(email)) {
						swal("Упс!", "Напишите действительную почту", "error");
					}else if (phone.length < 2){
						swal("Упс!", "Напишите Ваш номер телефона", "error");
					}else {
						var postForm = { //Fetch form data
							'name'      : name,
							'email'     : email,
							'phone'     : phone,
							'message'   : message,
							"utm_source" : "<?php echo $utm_source;?>"  ,
							"utm_keyword" : "<?php echo $utm_keyword;?>"  ,
							"utm_campaign" : "<?php echo $utm_campaign;?>"  ,
							"utm_sourcersy" : "<?php echo $utm_sourcersy;?>"  ,
							"utm_medium" : "<?php echo $utm_medium;?>"  ,
							"city" : "<?echo $city;?>",
							"form_src" : ""
						};
						$.ajax({ //Process the form using $.ajax()
							type      : 'POST', //Method type
							url       : 'order.php', //Your form processing file URL
							data      : postForm, //Forms name
							dataType  : 'text',
							success: function(msg) {
								yaCounter40321965.reachGoal(zayavka);
								ga('send', 'event', zayavka, 'click');
								swal("Успешно отправлено!", "Наш менеджер Вам перезвонит и ответит на все Ваши вопросы", "success");
							}
						});
					}
				}
			}

			function isEmail(email) {
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return regex.test(email);
			}

			function packet(want){

				var comment = "";
				var price = 14900;

				if(price3attr[0] == 'ip'){
					comment = comment + "ИП %0A"
				} else if(price3attr[0] == 'too'){
					price = price + 15000;
					comment = comment + "ТОО %0A"
				}

				if(price3attr[1] == 'obw'){
					price = price + 10000;
					comment = comment + "Общеустановленный %0A"
				} else if(price3attr[1] == 'upr'){
					comment = comment + "Упрощенный %0A"
				}

				if(price3attr[2] == 'usl'){
					comment = comment + "Услуга %0A"
				} else if(price3attr[2] == 'tov'){
					price = price + 10000;
					comment = comment + "Товар %0A"
				} else if(price3attr[2] == 'pro'){
					price = price + 25000;
					comment = comment + "Производство %0A"
				}

				if(price3attr[3] == 'do100doc'){
					comment = comment + "до 100 документов %0A"
				} else if(price3attr[3] == 'pos100doc'){
					price = price + 10000;
					comment = comment + "после 100 документов %0A"
				}

				if(price3attr[4] == 'alm'){
					comment = comment + "в Алматы %0A"
				} else if(price3attr[4] == 'notalm'){
					price = price + 10000;
					comment = comment + "в другом городе %0A"
				}

				if(price3attr[5] == 'nonds'){
					comment = comment + "без НДС %0A"
				} else if(price3attr[5] == 'nds'){
					price = price + 15000;
					comment = comment + "с НДС %0A"
				}

				if(price3attr[6] == 'do10sot'){
					comment = comment + "до 10 сотрудников %0A"
				} else if(price3attr[6] == 'pos10sot'){
					price = price + 15000;
					comment = comment + "после 10 сотрудников %0A"
				}

				if(price3attr[7] == 'do10mln'){
					comment = comment + "до 10 млн. %0A"
				} else if(price3attr[7] == 'pos10mln'){
					price = price + 15000;
					comment = comment + "после 10 млн. %0A"
				}

				if(price3attr[8] == 'aut'){
					comment = comment + "Аутсорсинг %0A"
				} else if(price3attr[8] == 'pri'){
					price = price + 80000;
					comment = comment + "Приходящий %0A"
				}

				comment = comment + "Цена: " + price;

				if (want == 1) {
					return price;
				}else if (want == 2) {
					return comment;
				}
			}

			// Choose pack of education
			function choose(num){
				if (num == 1) {
					$("#modalText").html("И НАЧНИТЕ ОБСУЖИВАТЬСЯ БЕСПЛАТНО <br>УЖЕ С ЭТОЙ НЕДЕЛИ");
					zayavka = "pricefree";
				}else if (num == 2) {
					$("#modalText").html("ЧТОБЫ ОЗНАКОМИТЬСЯ И СКАЧАТЬ<br> ДОГОВОР ОФЕРТЫ");
					zayavka = "price1";
				}else if (num == 3){
					$("#modalText").html("ЧТОБЫ ОЗНАКОМИТЬСЯ И СКАЧАТЬ<br> ДОГОВОР ОФЕРТЫ");
					zayavka = "price2";
				}else if (num == 4) {
					$("#modalText").html("И УЗНАЙТЕ ВО СКОЛЬКО ВАМ ОБОЙДЕТСЯ <br>ПРИХОДЯЩИЙ БУХГАЛТЕР В МЕСЯЦ");
					zayavka = "utpButton";
				}else if (num == 5) {
					$("#modalText").html("И УЗНАЙТЕ ВО СКОЛЬКО ВАМ ОБОЙДЕТСЯ <br>ПРИХОДЯЩИЙ БУХГАЛТЕР В МЕСЯЦ");
					zayavka = "offerButton";
				}

				$("#myModal").modal();
			}

			// 1

			var price1attr = "false";
			var price1checkNum = 1;
			var price1status = 'price';

			$('.price1check :checkbox').click(function() {
				var $this = $(this);
				if ($this.is(':checked')) {
					if($this.attr('id') == 1){
						price1attr = "true";
						$('.first .span1').html( "29 000 тенге" );
						$('.first .span1_1').html( "Договорная" );
					}
				} else {
					if($this.attr('id') == 1){
						price1attr = "false";
						$('.first .span1').html( "29 000 тенге" );
						$('.first .span1_1').html( "Бесплатно" );
					}
				}

			});

			// 3

			var price3attr = ["ip", "", "", "" , "", "", "", "" , ""];
			var price = 0;
			$('.price3check span').click(function() {
				var $this = $(this);

					if($this.attr('id') == 'optradio1'){
						if ($this.attr('value') == 'ip') {
							price3attr[0] = 'ip';
							$(".optradio11").removeClass("btn-default").addClass("btn-success")
							$(".optradio12").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'too') {
							price3attr[0] = 'too';
							$(".optradio11").removeClass("btn-success").addClass("btn-default")
							$(".optradio12").removeClass("btn-default").addClass("btn-success")
						}
					}else if($this.attr('id') == 'optradio2'){
						if ($this.attr('value') == 'obw') {
							price3attr[1] = 'obw';
							$(".optradio21").removeClass("btn-default").addClass("btn-success")
							$(".optradio22").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'upr') {
							price3attr[1] = 'upr';
							$(".optradio21").removeClass("btn-success").addClass("btn-default")
							$(".optradio22").removeClass("btn-default").addClass("btn-success")
						}
						$("#btnGrp3").removeClass('display_none');
					}else if($this.attr('id') == 'optradio3'){
						if ($this.attr('value') == 'usl') {
							price3attr[2] = 'usl';
							$(".optradio31").removeClass("btn-default").addClass("btn-success")
							$(".optradio32").removeClass("btn-success").addClass("btn-default")
							$(".optradio33").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'tov') {
							price3attr[2] = 'tov';
							$(".optradio31").removeClass("btn-success").addClass("btn-default")
							$(".optradio32").removeClass("btn-default").addClass("btn-success")
							$(".optradio33").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'pro') {
							price3attr[2] = 'pro';
							$(".optradio31").removeClass("btn-success").addClass("btn-default")
							$(".optradio32").removeClass("btn-success").addClass("btn-default")
							$(".optradio33").removeClass("btn-default").addClass("btn-success")
						}
						$("#btnGrp4").removeClass('display_none');
					}else if($this.attr('id') == 'optradio4'){
						if ($this.attr('value') == 'do100doc') {
							price3attr[3] = 'do100doc';
							$(".optradio41").removeClass("btn-default").addClass("btn-success")
							$(".optradio42").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'pos100doc') {
							price3attr[3] = 'pos100doc';
							$(".optradio41").removeClass("btn-success").addClass("btn-default")
							$(".optradio42").removeClass("btn-default").addClass("btn-success")
						}
						$("#btnGrp5").removeClass('display_none');
					}else if($this.attr('id') == 'optradio5'){
						if ($this.attr('value') == 'alm') {
							price3attr[4] = 'alm';
							$(".optradio51").removeClass("btn-default").addClass("btn-success")
							$(".optradio52").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'notalm') {
							price3attr[4] = 'notalm';
							$(".optradio51").removeClass("btn-success").addClass("btn-default")
							$(".optradio52").removeClass("btn-success").addClass("btn-success")
						}
						$("#btnGrp6").removeClass('display_none');
					}else if($this.attr('id') == 'optradio6'){
						if ($this.attr('value') == 'nonds') {
							price3attr[5] = 'nonds';
							$(".optradio61").removeClass("btn-default").addClass("btn-success")
							$(".optradio62").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'nds') {
							price3attr[5] = 'nds';
							$(".optradio61").removeClass("btn-success").addClass("btn-default")
							$(".optradio62").removeClass("btn-default").addClass("btn-success")
						}
						$("#btnGrp7").removeClass('display_none');
					}else if($this.attr('id') == 'optradio7'){
						if ($this.attr('value') == 'do10sot') {
							price3attr[6] = 'do10sot';
							$(".optradio71").removeClass("btn-default").addClass("btn-success")
							$(".optradio72").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'pos10sot') {
							price3attr[6] = 'pos10sot';
							$(".optradio71").removeClass("btn-success").addClass("btn-default")
							$(".optradio72").removeClass("btn-default").addClass("btn-success")
						}
						$("#btnGrp8").removeClass('display_none');
					}else if($this.attr('id') == 'optradio8'){
						if ($this.attr('value') == 'do10mln') {
							price3attr[7] = 'do10mln';
							$(".optradio81").removeClass("btn-default").addClass("btn-success")
							$(".optradio82").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'pos10mln') {
							price3attr[7] = 'pos10mln';
							$(".optradio81").removeClass("btn-success").addClass("btn-default")
							$(".optradio82").removeClass("btn-default").addClass("btn-success")
						}
						$("#btnGrp9").removeClass('display_none');
					}else if($this.attr('id') == 'optradio9'){
						if ($this.attr('value') == 'aut') {
							price3attr[8] = 'aut';
							$(".optradio91").removeClass("btn-default").addClass("btn-success")
							$(".optradio92").removeClass("btn-success").addClass("btn-default")
						}else if ($this.attr('value') == 'pri') {
							price3attr[8] = 'pri';
							$(".optradio91").removeClass("btn-success").addClass("btn-default")
							$(".optradio92").removeClass("btn-default").addClass("btn-success")
						}
					}

					$('.third .span3').html( packet(1)*2 + " тг" );
					$('.third .span3_1').html( packet(1) + " тг" );


			});

		</script>

		<!-- Facebook Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');

		fbq('init', '1839276229684359', {
		em: 'insert_email_variable,'
		});
		fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=1839276229684359&ev=PageView&noscript=1"
		/></noscript>
		<!-- DO NOT MODIFY -->
		<!-- End Facebook Pixel Code -->
		
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
		    (function (d, w, c) {
		        (w[c] = w[c] || []).push(function() {
		            try {
		                w.yaCounter40321965 = new Ya.Metrika({
		                    id:40321965,
		                    clickmap:true,
		                    trackLinks:true,
		                    accurateTrackBounce:true,
		                    webvisor:true,
		                    trackHash:true
		                });
		            } catch(e) { }
		        });

		        var n = d.getElementsByTagName("script")[0],
		            s = d.createElement("script"),
		            f = function () { n.parentNode.insertBefore(s, n); };
		        s.type = "text/javascript";
		        s.async = true;
		        s.src = "https://mc.yandex.ru/metrika/watch.js";

		        if (w.opera == "[object Opera]") {
		            d.addEventListener("DOMContentLoaded", f, false);
		        } else { f(); }
		    })(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/40321965" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->

<!-- Google Code for Express MD &#1090;&#1077;&#1075; Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 848451486;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "OMdnCOiXznMQnq_JlAM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<script type="text/javascript" src="./js/containerHide.js">
</script>	
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/848451486/?label=OMdnCOiXznMQnq_JlAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-103174485-1', 'auto');
  ga('require', 'displayfeatures');﻿
  ga('send', 'pageview');

</script>

	</div>
	</body>
</html>
