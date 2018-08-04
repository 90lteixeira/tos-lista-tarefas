<?php
include_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
error_reporting(1);

include_once DB;
include_once HDO;
include_once ESSENCIAIS;
?> 
<!DOCTYPE html>
<html>
    <head>
        <title>TOS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="/arquivos/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- styles -->
        <link href="/arquivos/css/styles.css" rel="stylesheet">
        
        <script src="/arquivos/js/essenciais.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="header">
            <div class="container">
                <div class="row">
                    <!--<div class="col-md-10">-->
                    <div class="col-md-12">
                        <!-- Logo -->
                        <div class="logo">
                            <h1><a href="/principal">TOS</a></h1>
                        </div>
                    </div>
<!--                    <div class="col-md-2">
                        <div class="navbar navbar-inverse" role="banner">
                            <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Minha conta<b class="caret"></b></a>
                                        <ul class="dropdown-menu animated fadeInUp">
                                            <li><a href="/sair">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-md-2">
                    <div class="sidebar content-box" style="display: block;">
                        <ul class="nav">
                            <!-- Main menu -->
                            <li class="current"><a href="/principal"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
                            <li><a href="/quiz"><i class="glyphicon glyphicon-question-sign"></i> Quiz</a></li>
                            <!--                    <li class="submenu">
                                                     <a href="#">
                                                        <i class="glyphicon glyphicon-list"></i> Pages
                                                        <span class="caret pull-right"></span>
                                                     </a>
                                                      Sub menu 
                                                     <ul>
                                                        <li><a href="login.html">Login</a></li>
                                                        <li><a href="signup.html">Signup</a></li>
                                                    </ul>
                                                </li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-md-10">
