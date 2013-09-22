<html>

    <head>
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='/css/jquery.easy-pie-chart.css' rel='stylesheet' type='text/css'>
        <style>
            * {
                font-family:Lato;
            }

            ::-webkit-scrollbar {
                width: 4px;
            }

            ::-webkit-scrollbar-track {
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 15px rgba(0,0,0,0.3);
            }

            a {

            }

            header {
                height:40px;
                position:absolute;
                top:0;
                left:0;
                right:0;
                border-bottom:1px solid #e5e5e5;
            }
            header .inner {
                margin:10px;
            }
            header .inner .logo {
                font-weight: 300;
                text-transform: uppercase;
                letter-spacing: 4px;
                float:left;
            }
            header .inner .loading-status {
                width:30px;
                height:15px;
                position: relative;
                float: left;
                margin: 2px 0 0 10px;
                display:none;
            }

            #content {
                position:absolute;bottom: 50px;top: 50px;left: 10px;right: 10px;
            }

            .experiments {
                float:left;width:60%;overflow-y:scroll;font-size:14px;
                height:100%;
            }
            .experiments h3 {
                margin-bottom:10px;
                color:#888;
                font-size:16px;
                margin-top:5px;
            }
            .experiments h3 a {
                color:#333;text-decoration:none;
            }
            .experiments table {
                border-spacing:0;width:100%;font-size:12px;
                border-collapse: collapse;
            }
            .experiments table tr {}
            .experiments table tr:hover {
                background:#fafafa;
                cursor:pointer;
            }
            .experiments table tbody tr.header:hover {
                background:none;
                cursor:default;
            }
            .experiments table tr td {
                padding:3px 0;
                padding:3px 0 3px 1.5%;
            }
            .experiments table tr td:nth-of-type(2) {
                padding-left:0;
            }
            .experiments table tr td:last-child {
                 padding:3px 3px 0 0;
            }
            .experiments table tr:hover td {
                border-color:#eee;
            }

            .experiments table tbody tr.header td {
                padding:20px 0 3px;
            }

            .experiments table tbody:first-child tr.header td {
                padding:0px 0 3px 0
            }

            .experiments table.header {
                text-transform:uppercase;font-weight:300;
            }

            .experiments hr {
                margin-top:15px;
            }
            footer {
                position:absolute;height:40px;
                bottom:0;left:0;right:0;
                border-top:1px solid #e5e5e5;
            }
            footer .inner {
                margin:12px;
                color:#aaa;
                font-size:12px;
            }
            footer .inner a {
                color:#888;
                text-decoration:underline;
            }

            .badge {
                display:inline-block;
                padding:2px 4px;
                font-weight:400;
                border-radius:3px;
                font-size:8px;
                margin:0 0 0 5px;
                text-transform:uppercase;
            }

            .badge.blue {
                background:#4bf;
            }
            .badge.red {
                background:#f00;
            }

            .badge.white-text {
                color:#fff;
            }

        </style>
    </head>

    <body>
        <header>
            <div class="inner">
                <div class="logo">GitDash</div>
                <div class="loading-status">
                    <img style="width:100%" src="http://www.chimply.com/coconut/images/516706">
                </div>
            </div>
        </header>
        <div id='content'>
            <div style="width:128px;height:64px;margin:-32px 0 0 -64px;position:absolute;top:50%;left:50%;">
                <img src="http://www.chimply.com/coconut/images/516706">
            </div>
        </div>
