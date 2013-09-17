<html>

    <head>
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic,400italic,700italic' rel='stylesheet' type='text/css'>
        <style>
            * {
                font-family:Lato;
            }


            ::-webkit-scrollbar {
                width: 12px;
            }

            ::-webkit-scrollbar-track {
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 15px rgba(0,0,0,0.5);
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
                border-spacing:0;width:100%;font-size:12px
            }
            .experiments table tr {}
            .experiments table tr:hover {
                background:#eee;
                cursor:pointer;
            }
            .experiments table tr td {
                padding:3px 0;padding-left:1.5%;
            }
            .experiments table tr:hover td {
                border-color:#eee;
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

        </style>
    </head>

    <body>
        <header>
            <div class="inner">
                <div class="logo">GitDash</div>
            </div>
        </header>
