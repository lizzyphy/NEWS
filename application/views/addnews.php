<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加新闻</title>
<link rel="stylesheet" href="/php/CIphp/skin/addnews.css" type="text/css" />
</head>

<body class = "middle whole">
	<form id="edit_form" action="/php/CIphp/index.php/home/insert_news" method="post">
		<font size=2>
		<table border="1" cellspacing="1" cellpadding="1" width="90%">
			<tr>
				<td colspan="2" bgcolor="#FFCCFF"  bordercolor="#9900FF">
					<center><font color="#FF0000" size=4 weight="bold">
						添加新闻
						</font>
					</center>
				</td>
			</tr>
			<tr>
				<td width="15%" valign="top">
					新闻主题
				</td>
				<td valign="top">
					<input type="text" name="subject" maxlength="50">
				</td>
			</tr>
			<tr>
				<td width="15%" valign="top">
					新闻内容
				</td>
				<td valign="top">
					<textarea name="news" rows="4" cols="35"></textarea>
				</td>
			</tr>
			<tr>
				<td width="15%" valign="top">
					发布者
				</td>
				<td valign="top">
					<input type="text" name="author" maxlength="50">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<center>
						<input type="submit" value="发布"> | 
						<input type="reset" value="重置">
					</center>
				</td>
			</tr>
		</table>
		</font>
	</form>
</body>
</html>