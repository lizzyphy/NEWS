<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>News Release System</title>
	<link rel="stylesheet" href="/php/CIphp/skin/index.css" type="text/css" />
</head>

<body>
    <div id = "head" class = "whole middle">
        <p class = "center title">新闻发布系统</p>
    </div>
    
    <div id = "login" class = "whole middle">
    	<p><?php echo "Welcome $uname !"; ?><a href= "/php/CIphp/index.php/home/loginout">注销</a></p>
    </div>
    
    <div id = "addnews" class = "whole middle">
        <span class = "float_left">
            <form action="/php/CIphp/index.php/home/add" method="post">
                <input type="submit" value="Add News" />
            </form>
        </span>
        <span class = "float_right">
        	<form action="/php/CIphp/index.php/home/index" method="get" >
            <?php
				if(isset($newsname))
				{
					echo <<<ENDIT
					<input class="float_left search" type="text" name="newsname" value="{$newsname}" style="color:#000" />
ENDIT;
				}
				else
				{
					echo <<<ENDIT
					<input class="float_left search" type="text" name="newsname" value="&nbsp;请输入关键字"  
                            onmouseover=this.focus();this.select();  
                            onclick="if(value==defaultValue){value='';this.style.color='#000'}"   
                            onBlur="if(!value){value=defaultValue;this.style.color='#999'}"style="color:#999" />
                    
ENDIT;
				}
			?> 
            	<input class="float_left search_bg" type="submit" name="submit" id="submit" value=" " />   
            </form>
         </span>
         <div class="clear"></div>
    </div>
    
    <div class = "whole middle">
    
		<div class = "middle mainnews" >
			<ul >
				<li>新闻主题</li>
				<li>新闻内容</li>
				<li>发布者</li>
				<li>发布时间</li>
				<div class="clear"></div>
			</ul>
		</div>
		
		
		<?php
		foreach($arr as $x)
		{
			$x->news = substr($x->news,0,52) . "...";
			$id = $x->id;
		?>
			<div class = "middle mainnews" >
				<ul>
					<li><a href='/php/CIphp/index.php/home/present_news?id=<?php echo $id?>'><?php echo $x->subject;?></a></li>
					<li><?php echo $x->news;?></li>
					<li><?php echo $x->author;?></li>
					<li><?php echo $x->datetime;?></li>
					<li><input class="but edit_bg" type="button" value=" " onClick="javascript:window.location.href='/php/CIphp/index.php/home/edit_news?id=<?php echo $id?>'"/>
						<input class="but dele_bg" type="button" value=" " onClick="javascript:window.location.href='/php/CIphp/index.php/home/dele_news?id=<?php echo $id?>'"/></li>
					<div class="clear"></div>
				</ul>
			</div>
		<?php 		
		}
		echo "<div align = 'center' class = 'middle'>共".$pages."页(".$page."/".$pages.")";
		echo "$key";
		?>
		</div>
	
</body>
</html>