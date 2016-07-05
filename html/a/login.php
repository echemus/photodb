<html>
	<head>
		<title>Login page</title>
         <link rel="stylesheet" type="text/css" href="/photos/a/photos.css">
	</head>
	<body>
    <div class="topTitleBox">
        <span class="topTitle">Photographs&nbsp;&nbsp;</span>
    </div>
    <div class="copyrightBox">
        <span class="tinytext">&copy; Dom Esplen 2015</span>
    </div>
    <div style="margin-top: 10px;"><span class="topTitle">&nbsp;</span></div>
    <div class="debug" id="output-box">Debug Output</div>
    <div class="tags" id="tag-box"><div class="taginner" id="tagContent"></div></div>
    <div id="box" class="photoOuter">
        <div id="content-box" class="photoInner">
        </div>
    </div>


		<form method="POST" action="/photos/a/dologin.html">
			User: <input type="text" name="httpd_username" value="" />
			Pass: <input type="password" name="httpd_password" value="" />
			<input type="submit" name="login" value="Login" />
		</form>
	</body>
</html>
