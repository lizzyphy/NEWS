<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" href="/php/CIphp/skin/addnews.css" type="text/css" />
</head>

<body class = "middle whole">
	<div class = "middle mainnews">
		<div id = "subject" class = "center"><p><?php echo $subject ?></p></div>
		<div id = "datetime">
			<span class="pad">发布者&nbsp;&nbsp;<?php echo $author ?></span>
			<span class = "float_right">发布时间&nbsp;&nbsp;<?php echo $datetime ?></span>
			
		</div>
		<div id = "news"><p><?php echo $news ?></p></div>
		<div class = "clear"></div>
	</div>
</body>
</html>