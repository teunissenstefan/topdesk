<!doctype html>
<html lang="nl">
	<head>
        <title>TOPdesk</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/jquery-ui.min.css" />
        <link rel="stylesheet" href="css/main.css" />
	</head>
	<body>	
            <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" style="min-height:55px;">
                <div class="container">
                    <a class="navbar-brand" href="?controller=pages&action=home">TOPdesk</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=pages&action=home">Home</a>
                        </li>
                        <?php
                            if(!isset($_SESSION['id'])){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=pages&action=register">Registreren</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=pages&action=login">Inloggen</a>
                        </li>
                        <?php
                            }else{
                                if($isAdmin){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=incidents&action=index">Incidenten</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=gebruikers&action=index">Gebruikers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sla/index.php" target="_blank">SLA</a>
                        </li>
                        <?php
                                }else{
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=incidents&action=melden">Melding maken</a>
                        </li>
                        <?php
                                }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=pages&action=logout">Uitloggen</a>
                        </li>
                        <?php
                            }
                        ?>
                        </ul>
                        <?php
                            if($isAdmin){
                        ?>
                        <form class="form-inline my-2 my-lg-0" id="searchform">
                            <input class="form-control mr-sm-2" type="search" placeholder="Incidentnummer" name="id" id="zoekbalk" aria-label="Zoeken">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Openen</button>
                        </form>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </nav>
	
        <div class="container" style="margin-top:70px;">

			<?php require_once('routes.php'); ?>

		</div>

        <div id="niet-gevonden-popper" style="background-color:white;padding:10px 10px 10px 10px;display:none;border:1px solid black;z-index:100;">
            Incident niet gevonden
        </div>

        <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery.query-object.js"></script>
        <script src="js/topdesk.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<body>
<html>