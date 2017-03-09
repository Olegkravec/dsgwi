<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Distributed System Geting Weather Information</title>
		<meta name="description" content="Distributed System Geting Weather Information" />
		<meta name="keywords" content="Meteo, weather, information, data" />
		<meta name="author" content="TailorGroup" />
		<link rel="shortcut icon" href="favicon.ico">
		<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/data.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/core.js"></script>
        <script language="javascript" type="text/javascript" src="js/modal.js"></script>
        <script language="javascript" type="text/javascript" src="js/menu.js"></script>
        <script language="javascript" type="text/javascript" src="js/ai_func.js"></script>
		<!--[if IE]>
  		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]--><script>document.documentElement.className = 'js';</script>
        <script>
            jQuery( document ).ready(function() {
                recreload();
                console.log( "ready!" );
            });
        </script>
	</head>
	<body class="demo-4">
    <input type="text" hidden id="city" value="<?php if($_GET["search"] !== null){echo $_GET["search"];}else{echo "NOSEARCH";}?>" />
		<svg class="hidden">
			<defs>
				<symbol id="icon-arrow" viewBox="0 0 24 24">
					<title>arrow</title>
					<polygon points="6.3,12.8 20.9,12.8 20.9,11.2 6.3,11.2 10.2,7.2 9,6 3.1,12 9,18 10.2,16.8 "/>
				</symbol>
				<symbol id="icon-drop" viewBox="0 0 24 24">
					<title>drop</title>
					<path d="M12,21c-3.6,0-6.6-3-6.6-6.6C5.4,11,10.8,4,11.4,3.2C11.6,3.1,11.8,3,12,3s0.4,0.1,0.6,0.3c0.6,0.8,6.1,7.8,6.1,11.2C18.6,18.1,15.6,21,12,21zM12,4.8c-1.8,2.4-5.2,7.4-5.2,9.6c0,2.9,2.3,5.2,5.2,5.2s5.2-2.3,5.2-5.2C17.2,12.2,13.8,7.3,12,4.8z"/><path d="M12,18.2c-0.4,0-0.7-0.3-0.7-0.7s0.3-0.7,0.7-0.7c1.3,0,2.4-1.1,2.4-2.4c0-0.4,0.3-0.7,0.7-0.7c0.4,0,0.7,0.3,0.7,0.7C15.8,16.5,14.1,18.2,12,18.2z"/>
				</symbol>
				<symbol id="icon-search" viewBox="0 0 24 24">
					<title>search</title>
					<path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
				</symbol>
				<symbol id="icon-cross" viewBox="0 0 24 24">
					<title>cross</title>
					<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
				</symbol>
			</defs>
		</svg>
		<div class="search">
			<button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form"><svg class="icon icon--cross"><use xlink:href="#icon-cross"></use></svg></button>
			<form class="search__form" action="">
				<input class="search__input" name="search" type="search" placeholder="Find..." autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
				<span class="search__info">Hit enter to search or ESC to close</span>
			</form>
		</div><!-- /search -->
		<div class="page">
			<div class="page__folder page__folder--dummy"></div>
			<div class="page__folder page__folder--dummy"></div>
			<div class="page__folder page__folder--dummy"></div>
			<main class="main-wrap page__folder">
				<header class="codrops-header">
					<h1 class="codrops-header__title">Distributed System Geting Weather Information</h1>
					<div class="search-wrap">
						<button id="btn-search" class="btn btn--search"><svg class="icon icon--search"><use xlink:href="#icon-search"></use></svg></button>
					</div>
				</header>
                <div class="info"></div>
                <div class="modal_window" id="notification">
                    <span class="modal_close">X</span>
                    <div class="content_notification">Enter your city in search field.</div>
                </div>
                <div class="modal_window" id="error">
                    <span class="modal_close">X</span>
                    <div class="content_error">This is modal error window!</div>
                </div>
                <div class="modal_window" id="full_screen">
                    <span class="modal_close_full_screen">X</span>
                    <div align="center" class="content_full_screen">
                        <h2>Help page</h2>
                        <table>
                            <thead>
                            <tr>
                                <td><h1>Popular</h1></td>
                                <td><h1>Recomended</h1></td>
                                <td><h1>API</h1></td>
                            </tr>
                            </thead>
                            <tr>
                                <td id="border_t">
                                    <a href="index.php?search=Lutsk" id="cloud_link" alt="Get weather information for Lutsk[city]">#Lutsk</a>
                                    <a href="index.php?search=Rivne" id="cloud_link" alt="Get weather information for Rivne[city]">#Rivne</a>
                                    <a href="index.php?search=Kiev" id="cloud_link" alt="Get weather information for Kiev[city]">#Kiev</a>
                                    <a href="index.php?search=Moskow" id="cloud_link" alt="Get weather information for Lutsk[city]">#Moskow</a>
                                </td>
                                <td id="border_t">
                                    Nothing recommended for You!
                                </td>
                                <td id="border_t">
                                    Use <a href="echo_data.php"><b>echo_data.php</b></a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h2 id="help">DSGWI</h2>
                <div class="in_page">
                    <div  align="center">

                        <div id="infa"><h2>Need help you? <a href="#full_screen" class="open_modal">YES</a>/<a href="#" onclick="no_help()" id="no_help">NO</a></h2></div>
                        <h3>Status: <span id="status">please wait...</span></h3>
                    </div>
                <div id="data">
                    <p>
                        <div align="center"> <a href="#notification" class="open_modal"><b>City: </b></a><b><span class="data" id="scity"></span></b></div>
                        DB ID: <b><span class="data" id="id"></span></b>
                        Station[ID]: <b></b><span class="data" id="station"></span></b>
                    </p>
					<p>
                        Temperature[C]: <b><span class="data" id="data0"></span></b>
                        Humidity[%]: <b><span class="data" id="data1"></span></b>
                        HIC[C]: <b><span class="data" id="data2"></span></b>
                    </p>
                    <p>
                    Rain[0-1024]: <b><span class="data" id="data3"></span></b><div id="rain-icon"></div>
                    Light[0-1024]: <b><span class="data" id="data4"></span></b><div id="light-icon"></div>
                    Gigrometer[1 or 0]: <b><span class="data" id="data5"></span></b>
                    Vibration[1 or 0]: <b><span class="data" id="data6"></span></b>
                    </p>
                    <p>
                        Date[yyyy-mm-dd]: <b><span class="data" id="date"></span></b>
                        Time[hh:mm:ss]: <b><span class="data" id="time"></span></b>
                    </p>
				</div>
                </div>
			</main>
		</div>
		<script src="js/search.js"></script>
	</body>
</html>