<?php

/**
 * @author David Fleming
 * @copyright 2010
 */

function evr_admin_categories(){
?>
<div class="wrap">
<h2><a href="http://www.wordpresseventregister.com"><img src="<?php echo EVR_PLUGINFULLURL ?>images/evr_icon.png" alt="Event Registration for Wordpress" /></a></h2>
<h2><?php _e('Category Management','evr_language');?></h2>

  <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"];?>">
    <input type="hidden" name="action" value="add_new_category">
    <input class="button-secondary" type="submit" name="Submit" value="ADD NEW CATEGORY"/>
  </form>

<div id="dashboard-widgets-wrap">
<div id="dashboard-widgets" class="metabox-holder">
	<div class='postbox-container' style='width:90%;'>
        <div id='normal-sortables' class='meta-box-sortables'>
            <div id="dashboard_right_now" class="postbox " >
                 
                <h3 class='hndle'><span><?php _e('Manage Categories','evr_language');?></span></h3>
                  <div class="inside">
                    <div class="padding">
                    <?php
                    $category_action = $_REQUEST['action'];
                    switch ($category_action) {
        
                            case "add_new_category" : 
                                    ?>
                                     
                                    <h3 class='hndle'><span><?php _e('Add A Category','evr_language');?></span></h3>
                                      <div class="inside">
                                        <div class="padding">
                                    
                                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
                                    <input type="hidden" name="action" value="add">
                                    <ul>
                                    <li><label><?php _e('Category Name','evr_language');?></label> <input name="category_name" size="25"></li>
                                    <li><label><?php _e('Unique ID For Category','evr_language');?></label> <input name="category_identifier"></li>
                                    <li><?php _e('Do you want to display the category description on the events page?','evr_language');?>
                                    <input type='radio' name='display_desc' value='Y'><?php _e('Yes','evr_language');?>
                                    <input type='radio' name='display_desc' checked value='N'><?php _e('No','evr_language');?></li>
                                    <li><?php _e('Category Description','evr_language');?><br />
                                    <textarea rows="5" cols="95" name="category_desc" id="new_cat_desc"  class="my_ed"></textarea><br />
                                    <script>myEdToolbar('new_cat_desc'); </script></p><br /></li>
                                    <script type="text/javascript">
                                        <!--
                                        var colorhex="#FF0000"
                                        function mouseOverColor(hex)
                                        {
                                        document.getElementById("divpreview").style.backgroundColor=hex;
                                        document.getElementById("divpreviewtxt").innerHTML=hex;
                                        document.body.style.cursor="pointer";
                                        }
                                        
                                        function mouseOutMap()
                                        {
                                        document.getElementById("divpreview").style.backgroundColor=colorhex;
                                        document.getElementById("divpreviewtxt").innerHTML=colorhex;
                                        document.body.style.cursor="";
                                        }
                                        
                                        function clickColor(hex,seltop,selleft)
                                        {
                                        var xhttp,c
                                        if (hex==0)
                                        	{
                                        	c=document.getElementById("colorhex").value;
                                        	}
                                        else
                                        	{
                                        	c=hex;
                                        	}
                                        if (c.substr(0,1)=="#")
                                        	{
                                        	c=c.substr(1);
                                        	}
                                        colorhex="#" + c;
                                        document.getElementById("colorhex").value=colorhex;
                                        if (window.XMLHttpRequest)
                                          {
                                          xhttp=new XMLHttpRequest();
                                          }
                                        else
                                          {
                                          xhttp=new ActiveXObject("Microsoft.XMLHTTP");
                                          }
                                        xhttp.open("GET","http_colorshades.asp?colorhex=" + c + "&r=" + Math.random(),false);
                                        xhttp.send("");
                                        document.getElementById("colorshades").innerHTML=xhttp.responseText;
                                        if (seltop>-1 && selleft>-1)
                                        	{
                                        	document.getElementById("selectedColor").style.top=seltop + "px";
                                        	document.getElementById("selectedColor").style.left=selleft + "px";
                                        	document.getElementById("selectedColor").style.visibility="visible";
                                        	}
                                        else
                                        	{
                                        	document.getElementById("divpreview").style.backgroundColor=colorhex;
                                        	document.getElementById("divpreviewtxt").innerHTML=colorhex;
                                        	document.getElementById("selectedColor").style.visibility="hidden";
                                        	}
                                        //refreshleader()
                                        }
                                        //-->
                                        </script>
                                        
                                        Select color for Calendar Display:
                                        <div id='selectedColor' style='visibility:hidden;position:relative;width:21px;height:21px;background-image:url("<?php echo EVR_PLUGINFULLURL.'images/';?>selectedcolor.gif")'></div><img border='0' style='margin-right:2px;' src='<?php echo EVR_PLUGINFULLURL."images/";?>colormap.gif' usemap='#colormap' alt='colormap' /><map id='colormap' name='colormap' onmouseout='mouseOutMap()'><area style='cursor:pointer' shape='poly' coords='63,0,72,4,72,15,63,19,54,15,54,4' onclick='clickColor("#003366",20,54)' onmouseover='mouseOverColor("#003366")' alt='#003366' /><area style='cursor:pointer' shape='poly' coords='81,0,90,4,90,15,81,19,72,15,72,4' onclick='clickColor("#336699",20,72)' onmouseover='mouseOverColor("#336699")' alt='#336699' /><area style='cursor:pointer' shape='poly' coords='99,0,108,4,108,15,99,19,90,15,90,4' onclick='clickColor("#3366CC",20,90)' onmouseover='mouseOverColor("#3366CC")' alt='#3366CC' /><area style='cursor:pointer' shape='poly' coords='117,0,126,4,126,15,117,19,108,15,108,4' onclick='clickColor("#003399",20,108)' onmouseover='mouseOverColor("#003399")' alt='#003399' /><area style='cursor:pointer' shape='poly' coords='135,0,144,4,144,15,135,19,126,15,126,4' onclick='clickColor("#000099",20,126)' onmouseover='mouseOverColor("#000099")' alt='#000099' /><area style='cursor:pointer' shape='poly' coords='153,0,162,4,162,15,153,19,144,15,144,4' onclick='clickColor("#0000CC",20,144)' onmouseover='mouseOverColor("#0000CC")' alt='#0000CC' /><area style='cursor:pointer' shape='poly' coords='171,0,180,4,180,15,171,19,162,15,162,4' onclick='clickColor("#000066",20,162)' onmouseover='mouseOverColor("#000066")' alt='#000066' /><area style='cursor:pointer' shape='poly' coords='54,15,63,19,63,30,54,34,45,30,45,19' onclick='clickColor("#006666",35,45)' onmouseover='mouseOverColor("#006666")' alt='#006666' /><area style='cursor:pointer' shape='poly' coords='72,15,81,19,81,30,72,34,63,30,63,19' onclick='clickColor("#006699",35,63)' onmouseover='mouseOverColor("#006699")' alt='#006699' /><area style='cursor:pointer' shape='poly' coords='90,15,99,19,99,30,90,34,81,30,81,19' onclick='clickColor("#0099CC",35,81)' onmouseover='mouseOverColor("#0099CC")' alt='#0099CC' /><area style='cursor:pointer' shape='poly' coords='108,15,117,19,117,30,108,34,99,30,99,19' onclick='clickColor("#0066CC",35,99)' onmouseover='mouseOverColor("#0066CC")' alt='#0066CC' /><area style='cursor:pointer' shape='poly' coords='126,15,135,19,135,30,126,34,117,30,117,19' onclick='clickColor("#0033CC",35,117)' onmouseover='mouseOverColor("#0033CC")' alt='#0033CC' /><area style='cursor:pointer' shape='poly' coords='144,15,153,19,153,30,144,34,135,30,135,19' onclick='clickColor("#0000FF",35,135)' onmouseover='mouseOverColor("#0000FF")' alt='#0000FF' /><area style='cursor:pointer' shape='poly' coords='162,15,171,19,171,30,162,34,153,30,153,19' onclick='clickColor("#3333FF",35,153)' onmouseover='mouseOverColor("#3333FF")' alt='#3333FF' /><area style='cursor:pointer' shape='poly' coords='180,15,189,19,189,30,180,34,171,30,171,19' onclick='clickColor("#333399",35,171)' onmouseover='mouseOverColor("#333399")' alt='#333399' /><area style='cursor:pointer' shape='poly' coords='45,30,54,34,54,45,45,49,36,45,36,34' onclick='clickColor("#669999",50,36)' onmouseover='mouseOverColor("#669999")' alt='#669999' /><area style='cursor:pointer' shape='poly' coords='63,30,72,34,72,45,63,49,54,45,54,34' onclick='clickColor("#009999",50,54)' onmouseover='mouseOverColor("#009999")' alt='#009999' /><area style='cursor:pointer' shape='poly' coords='81,30,90,34,90,45,81,49,72,45,72,34' onclick='clickColor("#33CCCC",50,72)' onmouseover='mouseOverColor("#33CCCC")' alt='#33CCCC' /><area style='cursor:pointer' shape='poly' coords='99,30,108,34,108,45,99,49,90,45,90,34' onclick='clickColor("#00CCFF",50,90)' onmouseover='mouseOverColor("#00CCFF")' alt='#00CCFF' /><area style='cursor:pointer' shape='poly' coords='117,30,126,34,126,45,117,49,108,45,108,34' onclick='clickColor("#0099FF",50,108)' onmouseover='mouseOverColor("#0099FF")' alt='#0099FF' /><area style='cursor:pointer' shape='poly' coords='135,30,144,34,144,45,135,49,126,45,126,34' onclick='clickColor("#0066FF",50,126)' onmouseover='mouseOverColor("#0066FF")' alt='#0066FF' /><area style='cursor:pointer' shape='poly' coords='153,30,162,34,162,45,153,49,144,45,144,34' onclick='clickColor("#3366FF",50,144)' onmouseover='mouseOverColor("#3366FF")' alt='#3366FF' /><area style='cursor:pointer' shape='poly' coords='171,30,180,34,180,45,171,49,162,45,162,34' onclick='clickColor("#3333CC",50,162)' onmouseover='mouseOverColor("#3333CC")' alt='#3333CC' /><area style='cursor:pointer' shape='poly' coords='189,30,198,34,198,45,189,49,180,45,180,34' onclick='clickColor("#666699",50,180)' onmouseover='mouseOverColor("#666699")' alt='#666699' /><area style='cursor:pointer' shape='poly' coords='36,45,45,49,45,60,36,64,27,60,27,49' onclick='clickColor("#339966",65,27)' onmouseover='mouseOverColor("#339966")' alt='#339966' /><area style='cursor:pointer' shape='poly' coords='54,45,63,49,63,60,54,64,45,60,45,49' onclick='clickColor("#00CC99",65,45)' onmouseover='mouseOverColor("#00CC99")' alt='#00CC99' /><area style='cursor:pointer' shape='poly' coords='72,45,81,49,81,60,72,64,63,60,63,49' onclick='clickColor("#00FFCC",65,63)' onmouseover='mouseOverColor("#00FFCC")' alt='#00FFCC' /><area style='cursor:pointer' shape='poly' coords='90,45,99,49,99,60,90,64,81,60,81,49' onclick='clickColor("#00FFFF",65,81)' onmouseover='mouseOverColor("#00FFFF")' alt='#00FFFF' /><area style='cursor:pointer' shape='poly' coords='108,45,117,49,117,60,108,64,99,60,99,49' onclick='clickColor("#33CCFF",65,99)' onmouseover='mouseOverColor("#33CCFF")' alt='#33CCFF' /><area style='cursor:pointer' shape='poly' coords='126,45,135,49,135,60,126,64,117,60,117,49' onclick='clickColor("#3399FF",65,117)' onmouseover='mouseOverColor("#3399FF")' alt='#3399FF' /><area style='cursor:pointer' shape='poly' coords='144,45,153,49,153,60,144,64,135,60,135,49' onclick='clickColor("#6699FF",65,135)' onmouseover='mouseOverColor("#6699FF")' alt='#6699FF' /><area style='cursor:pointer' shape='poly' coords='162,45,171,49,171,60,162,64,153,60,153,49' onclick='clickColor("#6666FF",65,153)' onmouseover='mouseOverColor("#6666FF")' alt='#6666FF' /><area style='cursor:pointer' shape='poly' coords='180,45,189,49,189,60,180,64,171,60,171,49' onclick='clickColor("#6600FF",65,171)' onmouseover='mouseOverColor("#6600FF")' alt='#6600FF' /><area style='cursor:pointer' shape='poly' coords='198,45,207,49,207,60,198,64,189,60,189,49' onclick='clickColor("#6600CC",65,189)' onmouseover='mouseOverColor("#6600CC")' alt='#6600CC' /><area style='cursor:pointer' shape='poly' coords='27,60,36,64,36,75,27,79,18,75,18,64' onclick='clickColor("#339933",80,18)' onmouseover='mouseOverColor("#339933")' alt='#339933' /><area style='cursor:pointer' shape='poly' coords='45,60,54,64,54,75,45,79,36,75,36,64' onclick='clickColor("#00CC66",80,36)' onmouseover='mouseOverColor("#00CC66")' alt='#00CC66' /><area style='cursor:pointer' shape='poly' coords='63,60,72,64,72,75,63,79,54,75,54,64' onclick='clickColor("#00FF99",80,54)' onmouseover='mouseOverColor("#00FF99")' alt='#00FF99' /><area style='cursor:pointer' shape='poly' coords='81,60,90,64,90,75,81,79,72,75,72,64' onclick='clickColor("#66FFCC",80,72)' onmouseover='mouseOverColor("#66FFCC")' alt='#66FFCC' /><area style='cursor:pointer' shape='poly' coords='99,60,108,64,108,75,99,79,90,75,90,64' onclick='clickColor("#66FFFF",80,90)' onmouseover='mouseOverColor("#66FFFF")' alt='#66FFFF' /><area style='cursor:pointer' shape='poly' coords='117,60,126,64,126,75,117,79,108,75,108,64' onclick='clickColor("#66CCFF",80,108)' onmouseover='mouseOverColor("#66CCFF")' alt='#66CCFF' /><area style='cursor:pointer' shape='poly' coords='135,60,144,64,144,75,135,79,126,75,126,64' onclick='clickColor("#99CCFF",80,126)' onmouseover='mouseOverColor("#99CCFF")' alt='#99CCFF' /><area style='cursor:pointer' shape='poly' coords='153,60,162,64,162,75,153,79,144,75,144,64' onclick='clickColor("#9999FF",80,144)' onmouseover='mouseOverColor("#9999FF")' alt='#9999FF' /><area style='cursor:pointer' shape='poly' coords='171,60,180,64,180,75,171,79,162,75,162,64' onclick='clickColor("#9966FF",80,162)' onmouseover='mouseOverColor("#9966FF")' alt='#9966FF' /><area style='cursor:pointer' shape='poly' coords='189,60,198,64,198,75,189,79,180,75,180,64' onclick='clickColor("#9933FF",80,180)' onmouseover='mouseOverColor("#9933FF")' alt='#9933FF' /><area style='cursor:pointer' shape='poly' coords='207,60,216,64,216,75,207,79,198,75,198,64' onclick='clickColor("#9900FF",80,198)' onmouseover='mouseOverColor("#9900FF")' alt='#9900FF' /><area style='cursor:pointer' shape='poly' coords='18,75,27,79,27,90,18,94,9,90,9,79' onclick='clickColor("#006600",95,9)' onmouseover='mouseOverColor("#006600")' alt='#006600' /><area style='cursor:pointer' shape='poly' coords='36,75,45,79,45,90,36,94,27,90,27,79' onclick='clickColor("#00CC00",95,27)' onmouseover='mouseOverColor("#00CC00")' alt='#00CC00' /><area style='cursor:pointer' shape='poly' coords='54,75,63,79,63,90,54,94,45,90,45,79' onclick='clickColor("#00FF00",95,45)' onmouseover='mouseOverColor("#00FF00")' alt='#00FF00' /><area style='cursor:pointer' shape='poly' coords='72,75,81,79,81,90,72,94,63,90,63,79' onclick='clickColor("#66FF99",95,63)' onmouseover='mouseOverColor("#66FF99")' alt='#66FF99' /><area style='cursor:pointer' shape='poly' coords='90,75,99,79,99,90,90,94,81,90,81,79' onclick='clickColor("#99FFCC",95,81)' onmouseover='mouseOverColor("#99FFCC")' alt='#99FFCC' /><area style='cursor:pointer' shape='poly' coords='108,75,117,79,117,90,108,94,99,90,99,79' onclick='clickColor("#CCFFFF",95,99)' onmouseover='mouseOverColor("#CCFFFF")' alt='#CCFFFF' /><area style='cursor:pointer' shape='poly' coords='126,75,135,79,135,90,126,94,117,90,117,79' onclick='clickColor("#CCCCFF",95,117)' onmouseover='mouseOverColor("#CCCCFF")' alt='#CCCCFF' /><area style='cursor:pointer' shape='poly' coords='144,75,153,79,153,90,144,94,135,90,135,79' onclick='clickColor("#CC99FF",95,135)' onmouseover='mouseOverColor("#CC99FF")' alt='#CC99FF' /><area style='cursor:pointer' shape='poly' coords='162,75,171,79,171,90,162,94,153,90,153,79' onclick='clickColor("#CC66FF",95,153)' onmouseover='mouseOverColor("#CC66FF")' alt='#CC66FF' /><area style='cursor:pointer' shape='poly' coords='180,75,189,79,189,90,180,94,171,90,171,79' onclick='clickColor("#CC33FF",95,171)' onmouseover='mouseOverColor("#CC33FF")' alt='#CC33FF' /><area style='cursor:pointer' shape='poly' coords='198,75,207,79,207,90,198,94,189,90,189,79' onclick='clickColor("#CC00FF",95,189)' onmouseover='mouseOverColor("#CC00FF")' alt='#CC00FF' /><area style='cursor:pointer' shape='poly' coords='216,75,225,79,225,90,216,94,207,90,207,79' onclick='clickColor("#9900CC",95,207)' onmouseover='mouseOverColor("#9900CC")' alt='#9900CC' /><area style='cursor:pointer' shape='poly' coords='9,90,18,94,18,105,9,109,0,105,0,94' onclick='clickColor("#003300",110,0)' onmouseover='mouseOverColor("#003300")' alt='#003300' /><area style='cursor:pointer' shape='poly' coords='27,90,36,94,36,105,27,109,18,105,18,94' onclick='clickColor("#009933",110,18)' onmouseover='mouseOverColor("#009933")' alt='#009933' /><area style='cursor:pointer' shape='poly' coords='45,90,54,94,54,105,45,109,36,105,36,94' onclick='clickColor("#33CC33",110,36)' onmouseover='mouseOverColor("#33CC33")' alt='#33CC33' /><area style='cursor:pointer' shape='poly' coords='63,90,72,94,72,105,63,109,54,105,54,94' onclick='clickColor("#66FF66",110,54)' onmouseover='mouseOverColor("#66FF66")' alt='#66FF66' /><area style='cursor:pointer' shape='poly' coords='81,90,90,94,90,105,81,109,72,105,72,94' onclick='clickColor("#99FF99",110,72)' onmouseover='mouseOverColor("#99FF99")' alt='#99FF99' /><area style='cursor:pointer' shape='poly' coords='99,90,108,94,108,105,99,109,90,105,90,94' onclick='clickColor("#CCFFCC",110,90)' onmouseover='mouseOverColor("#CCFFCC")' alt='#CCFFCC' /><area style='cursor:pointer' shape='poly' coords='117,90,126,94,126,105,117,109,108,105,108,94' onclick='clickColor("#FFFFFF",110,108)' onmouseover='mouseOverColor("#FFFFFF")' alt='#FFFFFF' /><area style='cursor:pointer' shape='poly' coords='135,90,144,94,144,105,135,109,126,105,126,94' onclick='clickColor("#FFCCFF",110,126)' onmouseover='mouseOverColor("#FFCCFF")' alt='#FFCCFF' /><area style='cursor:pointer' shape='poly' coords='153,90,162,94,162,105,153,109,144,105,144,94' onclick='clickColor("#FF99FF",110,144)' onmouseover='mouseOverColor("#FF99FF")' alt='#FF99FF' /><area style='cursor:pointer' shape='poly' coords='171,90,180,94,180,105,171,109,162,105,162,94' onclick='clickColor("#FF66FF",110,162)' onmouseover='mouseOverColor("#FF66FF")' alt='#FF66FF' /><area style='cursor:pointer' shape='poly' coords='189,90,198,94,198,105,189,109,180,105,180,94' onclick='clickColor("#FF00FF",110,180)' onmouseover='mouseOverColor("#FF00FF")' alt='#FF00FF' /><area style='cursor:pointer' shape='poly' coords='207,90,216,94,216,105,207,109,198,105,198,94' onclick='clickColor("#CC00CC",110,198)' onmouseover='mouseOverColor("#CC00CC")' alt='#CC00CC' /><area style='cursor:pointer' shape='poly' coords='225,90,234,94,234,105,225,109,216,105,216,94' onclick='clickColor("#660066",110,216)' onmouseover='mouseOverColor("#660066")' alt='#660066' /><area style='cursor:pointer' shape='poly' coords='18,105,27,109,27,120,18,124,9,120,9,109' onclick='clickColor("#336600",125,9)' onmouseover='mouseOverColor("#336600")' alt='#336600' /><area style='cursor:pointer' shape='poly' coords='36,105,45,109,45,120,36,124,27,120,27,109' onclick='clickColor("#009900",125,27)' onmouseover='mouseOverColor("#009900")' alt='#009900' /><area style='cursor:pointer' shape='poly' coords='54,105,63,109,63,120,54,124,45,120,45,109' onclick='clickColor("#66FF33",125,45)' onmouseover='mouseOverColor("#66FF33")' alt='#66FF33' /><area style='cursor:pointer' shape='poly' coords='72,105,81,109,81,120,72,124,63,120,63,109' onclick='clickColor("#99FF66",125,63)' onmouseover='mouseOverColor("#99FF66")' alt='#99FF66' /><area style='cursor:pointer' shape='poly' coords='90,105,99,109,99,120,90,124,81,120,81,109' onclick='clickColor("#CCFF99",125,81)' onmouseover='mouseOverColor("#CCFF99")' alt='#CCFF99' /><area style='cursor:pointer' shape='poly' coords='108,105,117,109,117,120,108,124,99,120,99,109' onclick='clickColor("#FFFFCC",125,99)' onmouseover='mouseOverColor("#FFFFCC")' alt='#FFFFCC' /><area style='cursor:pointer' shape='poly' coords='126,105,135,109,135,120,126,124,117,120,117,109' onclick='clickColor("#FFCCCC",125,117)' onmouseover='mouseOverColor("#FFCCCC")' alt='#FFCCCC' /><area style='cursor:pointer' shape='poly' coords='144,105,153,109,153,120,144,124,135,120,135,109' onclick='clickColor("#FF99CC",125,135)' onmouseover='mouseOverColor("#FF99CC")' alt='#FF99CC' /><area style='cursor:pointer' shape='poly' coords='162,105,171,109,171,120,162,124,153,120,153,109' onclick='clickColor("#FF66CC",125,153)' onmouseover='mouseOverColor("#FF66CC")' alt='#FF66CC' /><area style='cursor:pointer' shape='poly' coords='180,105,189,109,189,120,180,124,171,120,171,109' onclick='clickColor("#FF33CC",125,171)' onmouseover='mouseOverColor("#FF33CC")' alt='#FF33CC' /><area style='cursor:pointer' shape='poly' coords='198,105,207,109,207,120,198,124,189,120,189,109' onclick='clickColor("#CC0099",125,189)' onmouseover='mouseOverColor("#CC0099")' alt='#CC0099' /><area style='cursor:pointer' shape='poly' coords='216,105,225,109,225,120,216,124,207,120,207,109' onclick='clickColor("#993399",125,207)' onmouseover='mouseOverColor("#993399")' alt='#993399' /><area style='cursor:pointer' shape='poly' coords='27,120,36,124,36,135,27,139,18,135,18,124' onclick='clickColor("#333300",140,18)' onmouseover='mouseOverColor("#333300")' alt='#333300' /><area style='cursor:pointer' shape='poly' coords='45,120,54,124,54,135,45,139,36,135,36,124' onclick='clickColor("#669900",140,36)' onmouseover='mouseOverColor("#669900")' alt='#669900' /><area style='cursor:pointer' shape='poly' coords='63,120,72,124,72,135,63,139,54,135,54,124' onclick='clickColor("#99FF33",140,54)' onmouseover='mouseOverColor("#99FF33")' alt='#99FF33' /><area style='cursor:pointer' shape='poly' coords='81,120,90,124,90,135,81,139,72,135,72,124' onclick='clickColor("#CCFF66",140,72)' onmouseover='mouseOverColor("#CCFF66")' alt='#CCFF66' /><area style='cursor:pointer' shape='poly' coords='99,120,108,124,108,135,99,139,90,135,90,124' onclick='clickColor("#FFFF99",140,90)' onmouseover='mouseOverColor("#FFFF99")' alt='#FFFF99' /><area style='cursor:pointer' shape='poly' coords='117,120,126,124,126,135,117,139,108,135,108,124' onclick='clickColor("#FFCC99",140,108)' onmouseover='mouseOverColor("#FFCC99")' alt='#FFCC99' /><area style='cursor:pointer' shape='poly' coords='135,120,144,124,144,135,135,139,126,135,126,124' onclick='clickColor("#FF9999",140,126)' onmouseover='mouseOverColor("#FF9999")' alt='#FF9999' /><area style='cursor:pointer' shape='poly' coords='153,120,162,124,162,135,153,139,144,135,144,124' onclick='clickColor("#FF6699",140,144)' onmouseover='mouseOverColor("#FF6699")' alt='#FF6699' /><area style='cursor:pointer' shape='poly' coords='171,120,180,124,180,135,171,139,162,135,162,124' onclick='clickColor("#FF3399",140,162)' onmouseover='mouseOverColor("#FF3399")' alt='#FF3399' /><area style='cursor:pointer' shape='poly' coords='189,120,198,124,198,135,189,139,180,135,180,124' onclick='clickColor("#CC3399",140,180)' onmouseover='mouseOverColor("#CC3399")' alt='#CC3399' /><area style='cursor:pointer' shape='poly' coords='207,120,216,124,216,135,207,139,198,135,198,124' onclick='clickColor("#990099",140,198)' onmouseover='mouseOverColor("#990099")' alt='#990099' /><area style='cursor:pointer' shape='poly' coords='36,135,45,139,45,150,36,154,27,150,27,139' onclick='clickColor("#666633",155,27)' onmouseover='mouseOverColor("#666633")' alt='#666633' /><area style='cursor:pointer' shape='poly' coords='54,135,63,139,63,150,54,154,45,150,45,139' onclick='clickColor("#99CC00",155,45)' onmouseover='mouseOverColor("#99CC00")' alt='#99CC00' /><area style='cursor:pointer' shape='poly' coords='72,135,81,139,81,150,72,154,63,150,63,139' onclick='clickColor("#CCFF33",155,63)' onmouseover='mouseOverColor("#CCFF33")' alt='#CCFF33' /><area style='cursor:pointer' shape='poly' coords='90,135,99,139,99,150,90,154,81,150,81,139' onclick='clickColor("#FFFF66",155,81)' onmouseover='mouseOverColor("#FFFF66")' alt='#FFFF66' /><area style='cursor:pointer' shape='poly' coords='108,135,117,139,117,150,108,154,99,150,99,139' onclick='clickColor("#FFCC66",155,99)' onmouseover='mouseOverColor("#FFCC66")' alt='#FFCC66' /><area style='cursor:pointer' shape='poly' coords='126,135,135,139,135,150,126,154,117,150,117,139' onclick='clickColor("#FF9966",155,117)' onmouseover='mouseOverColor("#FF9966")' alt='#FF9966' /><area style='cursor:pointer' shape='poly' coords='144,135,153,139,153,150,144,154,135,150,135,139' onclick='clickColor("#FF6666",155,135)' onmouseover='mouseOverColor("#FF6666")' alt='#FF6666' /><area style='cursor:pointer' shape='poly' coords='162,135,171,139,171,150,162,154,153,150,153,139' onclick='clickColor("#FF0066",155,153)' onmouseover='mouseOverColor("#FF0066")' alt='#FF0066' /><area style='cursor:pointer' shape='poly' coords='180,135,189,139,189,150,180,154,171,150,171,139' onclick='clickColor("#CC6699",155,171)' onmouseover='mouseOverColor("#CC6699")' alt='#CC6699' /><area style='cursor:pointer' shape='poly' coords='198,135,207,139,207,150,198,154,189,150,189,139' onclick='clickColor("#993366",155,189)' onmouseover='mouseOverColor("#993366")' alt='#993366' /><area style='cursor:pointer' shape='poly' coords='45,150,54,154,54,165,45,169,36,165,36,154' onclick='clickColor("#999966",170,36)' onmouseover='mouseOverColor("#999966")' alt='#999966' /><area style='cursor:pointer' shape='poly' coords='63,150,72,154,72,165,63,169,54,165,54,154' onclick='clickColor("#CCCC00",170,54)' onmouseover='mouseOverColor("#CCCC00")' alt='#CCCC00' /><area style='cursor:pointer' shape='poly' coords='81,150,90,154,90,165,81,169,72,165,72,154' onclick='clickColor("#FFFF00",170,72)' onmouseover='mouseOverColor("#FFFF00")' alt='#FFFF00' /><area style='cursor:pointer' shape='poly' coords='99,150,108,154,108,165,99,169,90,165,90,154' onclick='clickColor("#FFCC00",170,90)' onmouseover='mouseOverColor("#FFCC00")' alt='#FFCC00' /><area style='cursor:pointer' shape='poly' coords='117,150,126,154,126,165,117,169,108,165,108,154' onclick='clickColor("#FF9933",170,108)' onmouseover='mouseOverColor("#FF9933")' alt='#FF9933' /><area style='cursor:pointer' shape='poly' coords='135,150,144,154,144,165,135,169,126,165,126,154' onclick='clickColor("#FF6600",170,126)' onmouseover='mouseOverColor("#FF6600")' alt='#FF6600' /><area style='cursor:pointer' shape='poly' coords='153,150,162,154,162,165,153,169,144,165,144,154' onclick='clickColor("#FF5050",170,144)' onmouseover='mouseOverColor("#FF5050")' alt='#FF5050' /><area style='cursor:pointer' shape='poly' coords='171,150,180,154,180,165,171,169,162,165,162,154' onclick='clickColor("#CC0066",170,162)' onmouseover='mouseOverColor("#CC0066")' alt='#CC0066' /><area style='cursor:pointer' shape='poly' coords='189,150,198,154,198,165,189,169,180,165,180,154' onclick='clickColor("#660033",170,180)' onmouseover='mouseOverColor("#660033")' alt='#660033' /><area style='cursor:pointer' shape='poly' coords='54,165,63,169,63,180,54,184,45,180,45,169' onclick='clickColor("#996633",185,45)' onmouseover='mouseOverColor("#996633")' alt='#996633' /><area style='cursor:pointer' shape='poly' coords='72,165,81,169,81,180,72,184,63,180,63,169' onclick='clickColor("#CC9900",185,63)' onmouseover='mouseOverColor("#CC9900")' alt='#CC9900' /><area style='cursor:pointer' shape='poly' coords='90,165,99,169,99,180,90,184,81,180,81,169' onclick='clickColor("#FF9900",185,81)' onmouseover='mouseOverColor("#FF9900")' alt='#FF9900' /><area style='cursor:pointer' shape='poly' coords='108,165,117,169,117,180,108,184,99,180,99,169' onclick='clickColor("#CC6600",185,99)' onmouseover='mouseOverColor("#CC6600")' alt='#CC6600' /><area style='cursor:pointer' shape='poly' coords='126,165,135,169,135,180,126,184,117,180,117,169' onclick='clickColor("#FF3300",185,117)' onmouseover='mouseOverColor("#FF3300")' alt='#FF3300' /><area style='cursor:pointer' shape='poly' coords='144,165,153,169,153,180,144,184,135,180,135,169' onclick='clickColor("#FF0000",185,135)' onmouseover='mouseOverColor("#FF0000")' alt='#FF0000' /><area style='cursor:pointer' shape='poly' coords='162,165,171,169,171,180,162,184,153,180,153,169' onclick='clickColor("#CC0000",185,153)' onmouseover='mouseOverColor("#CC0000")' alt='#CC0000' /><area style='cursor:pointer' shape='poly' coords='180,165,189,169,189,180,180,184,171,180,171,169' onclick='clickColor("#990033",185,171)' onmouseover='mouseOverColor("#990033")' alt='#990033' /><area style='cursor:pointer' shape='poly' coords='63,180,72,184,72,195,63,199,54,195,54,184' onclick='clickColor("#663300",200,54)' onmouseover='mouseOverColor("#663300")' alt='#663300' /><area style='cursor:pointer' shape='poly' coords='81,180,90,184,90,195,81,199,72,195,72,184' onclick='clickColor("#996600",200,72)' onmouseover='mouseOverColor("#996600")' alt='#996600' /><area style='cursor:pointer' shape='poly' coords='99,180,108,184,108,195,99,199,90,195,90,184' onclick='clickColor("#CC3300",200,90)' onmouseover='mouseOverColor("#CC3300")' alt='#CC3300' /><area style='cursor:pointer' shape='poly' coords='117,180,126,184,126,195,117,199,108,195,108,184' onclick='clickColor("#993300",200,108)' onmouseover='mouseOverColor("#993300")' alt='#993300' /><area style='cursor:pointer' shape='poly' coords='135,180,144,184,144,195,135,199,126,195,126,184' onclick='clickColor("#990000",200,126)' onmouseover='mouseOverColor("#990000")' alt='#990000' /><area style='cursor:pointer' shape='poly' coords='153,180,162,184,162,195,153,199,144,195,144,184' onclick='clickColor("#800000",200,144)' onmouseover='mouseOverColor("#800000")' alt='#800000' /><area style='cursor:pointer' shape='poly' coords='171,180,180,184,180,195,171,199,162,195,162,184' onclick='clickColor("#993333",200,162)' onmouseover='mouseOverColor("#993333")' alt='#993333' /></map>
                                        	<script type="text/javascript">
                                        	document.getElementById("selectedColor").style.top="185px";
                                        	document.getElementById("selectedColor").style.left="135px";
                                        	document.getElementById("selectedColor").style.visibility="visible";
                                        	</script>
                                        	<br /><br /><table cellpadding='0' border='0' cellspacing='0' width='100%'><tr><td width='67'></td><td width='110'><div id='divpreview' style='height:30px;width:100px;border:1px solid #d4d4d4;background-color:#FF0000;'>&nbsp;</div></td><td><div id='divpreviewtxt'>#FF0000</div></td></table>
                                        <br />
                                        <br />
                                        <li><p>Category Background Color: <input style="width:70px;" name='cat_back' id='colorhex' value='#FFFF99' /></p></li>
                                        <li><p>Category Text Color: <select style="width:70px;" name='cat_text' >
                                        <option value="#000000">Black</option>
                                        <option value="#FFFFFF">White</option></select></p></li>
                                                                            
                                    <li><p><input class="button-primary" type="submit" name="Submit" value="<?php _e('Add Category','evr_language');?>" id="add_new_category" /></p></li>
                                    </ul>
                                    
                                    
                                    
                                    
                                    </form>
                                    <br/><br/></div></div>
                                    <?php
                            break;
                            
                            case "edit":
                                    global $wpdb;
                                    $id=$_REQUEST['id'];
                                    $sql = "SELECT * FROM ". get_option('evr_category') ." WHERE id =".$id;
                                    $result = mysql_query ($sql);
                                    
                                    while ($row = mysql_fetch_assoc ($result)){
                                    	$category_id= $row['id'];
                                    	$category_name=$row['category_name'];
                                    	$category_identifier=$row['category_identifier'];
                                    	$category_desc=$row['category_desc'];
                                    	$display_category_desc=$row['display_desc'];
                                        $category_color = $row['category_color'];
                                        $font_color = $row['font_color'];
                                        
                                    }
                                    ?>
                                    <!--Add event display-->
                                     
                                    <h3 class='hndle'><span><?php _e('Edit Category','evr_language');?>:<?php echo $category_name ?></span></h3>
                                      <div class="inside">
                                        <div class="padding">
                                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
                                    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                                    <input type="hidden" name="action" value="update">
                                    <ul>
                                    <li><label><strong><?php _e('Category Name','evr_language');?>:</strong></label> <input name="category_name" size="25" value="<?php echo $category_name;?>"></li>
                                    <li><label><strong><?php _e('Unique Category Identifier','evr_language')?>:</strong></label> 
                                    <input name="category_identifier" value="<?php echo $category_identifier;?>"> </a></li>
                                    <li><?php _e('Do you want to display the event description on the events page?','evr_language');?>
                                    <input type="radio" name="display_desc" value="Y" <?php if($display_category_desc=="Y"){echo "checked";};?>/><?php _e('Yes','evr_language');?>
                                    <input type="radio" name="display_desc" value="N" <?php if($display_category_desc=="N"){echo "checked";};?>/><?php _e('No','evr_language');?>
                                    </li>
                                    <li><strong><?php _e('Category Description','evr_language');?>:</strong><br />
                                    <textarea rows="5" cols="95" name="category_desc" id="new_cat_desc"  class="my_ed"><?php echo $category_desc; ?></textarea><br />
                                    <script>myEdToolbar('new_cat_desc'); </script>
                                    </li>
                                    <script type="text/javascript">
                                        <!--
                                        var colorhex="#FF0000"
                                        function mouseOverColor(hex)
                                        {
                                        document.getElementById("divpreview").style.backgroundColor=hex;
                                        document.getElementById("divpreviewtxt").innerHTML=hex;
                                        document.body.style.cursor="pointer";
                                        }
                                        
                                        function mouseOutMap()
                                        {
                                        document.getElementById("divpreview").style.backgroundColor=colorhex;
                                        document.getElementById("divpreviewtxt").innerHTML=colorhex;
                                        document.body.style.cursor="";
                                        }
                                        
                                        function clickColor(hex,seltop,selleft)
                                        {
                                        var xhttp,c
                                        if (hex==0)
                                        	{
                                        	c=document.getElementById("colorhex").value;
                                        	}
                                        else
                                        	{
                                        	c=hex;
                                        	}
                                        if (c.substr(0,1)=="#")
                                        	{
                                        	c=c.substr(1);
                                        	}
                                        colorhex="#" + c;
                                        document.getElementById("colorhex").value=colorhex;
                                        if (window.XMLHttpRequest)
                                          {
                                          xhttp=new XMLHttpRequest();
                                          }
                                        else
                                          {
                                          xhttp=new ActiveXObject("Microsoft.XMLHTTP");
                                          }
                                        xhttp.open("GET","http_colorshades.asp?colorhex=" + c + "&r=" + Math.random(),false);
                                        xhttp.send("");
                                        document.getElementById("colorshades").innerHTML=xhttp.responseText;
                                        if (seltop>-1 && selleft>-1)
                                        	{
                                        	document.getElementById("selectedColor").style.top=seltop + "px";
                                        	document.getElementById("selectedColor").style.left=selleft + "px";
                                        	document.getElementById("selectedColor").style.visibility="visible";
                                        	}
                                        else
                                        	{
                                        	document.getElementById("divpreview").style.backgroundColor=colorhex;
                                        	document.getElementById("divpreviewtxt").innerHTML=colorhex;
                                        	document.getElementById("selectedColor").style.visibility="hidden";
                                        	}
                                        //refreshleader()
                                        }
                                        //-->
                                        </script>
                                        
                                        Select color for Calendar Display:
                                        <div id='selectedColor' style='visibility:hidden;position:relative;width:21px;height:21px;background-image:url("<?php echo EVR_PLUGINFULLURL.'images/';?>selectedcolor.gif")'></div><img border='0' style='margin-right:2px;' src='<?php echo EVR_PLUGINFULLURL."images/";?>colormap.gif' usemap='#colormap' alt='colormap' /><map id='colormap' name='colormap' onmouseout='mouseOutMap()'><area style='cursor:pointer' shape='poly' coords='63,0,72,4,72,15,63,19,54,15,54,4' onclick='clickColor("#003366",20,54)' onmouseover='mouseOverColor("#003366")' alt='#003366' /><area style='cursor:pointer' shape='poly' coords='81,0,90,4,90,15,81,19,72,15,72,4' onclick='clickColor("#336699",20,72)' onmouseover='mouseOverColor("#336699")' alt='#336699' /><area style='cursor:pointer' shape='poly' coords='99,0,108,4,108,15,99,19,90,15,90,4' onclick='clickColor("#3366CC",20,90)' onmouseover='mouseOverColor("#3366CC")' alt='#3366CC' /><area style='cursor:pointer' shape='poly' coords='117,0,126,4,126,15,117,19,108,15,108,4' onclick='clickColor("#003399",20,108)' onmouseover='mouseOverColor("#003399")' alt='#003399' /><area style='cursor:pointer' shape='poly' coords='135,0,144,4,144,15,135,19,126,15,126,4' onclick='clickColor("#000099",20,126)' onmouseover='mouseOverColor("#000099")' alt='#000099' /><area style='cursor:pointer' shape='poly' coords='153,0,162,4,162,15,153,19,144,15,144,4' onclick='clickColor("#0000CC",20,144)' onmouseover='mouseOverColor("#0000CC")' alt='#0000CC' /><area style='cursor:pointer' shape='poly' coords='171,0,180,4,180,15,171,19,162,15,162,4' onclick='clickColor("#000066",20,162)' onmouseover='mouseOverColor("#000066")' alt='#000066' /><area style='cursor:pointer' shape='poly' coords='54,15,63,19,63,30,54,34,45,30,45,19' onclick='clickColor("#006666",35,45)' onmouseover='mouseOverColor("#006666")' alt='#006666' /><area style='cursor:pointer' shape='poly' coords='72,15,81,19,81,30,72,34,63,30,63,19' onclick='clickColor("#006699",35,63)' onmouseover='mouseOverColor("#006699")' alt='#006699' /><area style='cursor:pointer' shape='poly' coords='90,15,99,19,99,30,90,34,81,30,81,19' onclick='clickColor("#0099CC",35,81)' onmouseover='mouseOverColor("#0099CC")' alt='#0099CC' /><area style='cursor:pointer' shape='poly' coords='108,15,117,19,117,30,108,34,99,30,99,19' onclick='clickColor("#0066CC",35,99)' onmouseover='mouseOverColor("#0066CC")' alt='#0066CC' /><area style='cursor:pointer' shape='poly' coords='126,15,135,19,135,30,126,34,117,30,117,19' onclick='clickColor("#0033CC",35,117)' onmouseover='mouseOverColor("#0033CC")' alt='#0033CC' /><area style='cursor:pointer' shape='poly' coords='144,15,153,19,153,30,144,34,135,30,135,19' onclick='clickColor("#0000FF",35,135)' onmouseover='mouseOverColor("#0000FF")' alt='#0000FF' /><area style='cursor:pointer' shape='poly' coords='162,15,171,19,171,30,162,34,153,30,153,19' onclick='clickColor("#3333FF",35,153)' onmouseover='mouseOverColor("#3333FF")' alt='#3333FF' /><area style='cursor:pointer' shape='poly' coords='180,15,189,19,189,30,180,34,171,30,171,19' onclick='clickColor("#333399",35,171)' onmouseover='mouseOverColor("#333399")' alt='#333399' /><area style='cursor:pointer' shape='poly' coords='45,30,54,34,54,45,45,49,36,45,36,34' onclick='clickColor("#669999",50,36)' onmouseover='mouseOverColor("#669999")' alt='#669999' /><area style='cursor:pointer' shape='poly' coords='63,30,72,34,72,45,63,49,54,45,54,34' onclick='clickColor("#009999",50,54)' onmouseover='mouseOverColor("#009999")' alt='#009999' /><area style='cursor:pointer' shape='poly' coords='81,30,90,34,90,45,81,49,72,45,72,34' onclick='clickColor("#33CCCC",50,72)' onmouseover='mouseOverColor("#33CCCC")' alt='#33CCCC' /><area style='cursor:pointer' shape='poly' coords='99,30,108,34,108,45,99,49,90,45,90,34' onclick='clickColor("#00CCFF",50,90)' onmouseover='mouseOverColor("#00CCFF")' alt='#00CCFF' /><area style='cursor:pointer' shape='poly' coords='117,30,126,34,126,45,117,49,108,45,108,34' onclick='clickColor("#0099FF",50,108)' onmouseover='mouseOverColor("#0099FF")' alt='#0099FF' /><area style='cursor:pointer' shape='poly' coords='135,30,144,34,144,45,135,49,126,45,126,34' onclick='clickColor("#0066FF",50,126)' onmouseover='mouseOverColor("#0066FF")' alt='#0066FF' /><area style='cursor:pointer' shape='poly' coords='153,30,162,34,162,45,153,49,144,45,144,34' onclick='clickColor("#3366FF",50,144)' onmouseover='mouseOverColor("#3366FF")' alt='#3366FF' /><area style='cursor:pointer' shape='poly' coords='171,30,180,34,180,45,171,49,162,45,162,34' onclick='clickColor("#3333CC",50,162)' onmouseover='mouseOverColor("#3333CC")' alt='#3333CC' /><area style='cursor:pointer' shape='poly' coords='189,30,198,34,198,45,189,49,180,45,180,34' onclick='clickColor("#666699",50,180)' onmouseover='mouseOverColor("#666699")' alt='#666699' /><area style='cursor:pointer' shape='poly' coords='36,45,45,49,45,60,36,64,27,60,27,49' onclick='clickColor("#339966",65,27)' onmouseover='mouseOverColor("#339966")' alt='#339966' /><area style='cursor:pointer' shape='poly' coords='54,45,63,49,63,60,54,64,45,60,45,49' onclick='clickColor("#00CC99",65,45)' onmouseover='mouseOverColor("#00CC99")' alt='#00CC99' /><area style='cursor:pointer' shape='poly' coords='72,45,81,49,81,60,72,64,63,60,63,49' onclick='clickColor("#00FFCC",65,63)' onmouseover='mouseOverColor("#00FFCC")' alt='#00FFCC' /><area style='cursor:pointer' shape='poly' coords='90,45,99,49,99,60,90,64,81,60,81,49' onclick='clickColor("#00FFFF",65,81)' onmouseover='mouseOverColor("#00FFFF")' alt='#00FFFF' /><area style='cursor:pointer' shape='poly' coords='108,45,117,49,117,60,108,64,99,60,99,49' onclick='clickColor("#33CCFF",65,99)' onmouseover='mouseOverColor("#33CCFF")' alt='#33CCFF' /><area style='cursor:pointer' shape='poly' coords='126,45,135,49,135,60,126,64,117,60,117,49' onclick='clickColor("#3399FF",65,117)' onmouseover='mouseOverColor("#3399FF")' alt='#3399FF' /><area style='cursor:pointer' shape='poly' coords='144,45,153,49,153,60,144,64,135,60,135,49' onclick='clickColor("#6699FF",65,135)' onmouseover='mouseOverColor("#6699FF")' alt='#6699FF' /><area style='cursor:pointer' shape='poly' coords='162,45,171,49,171,60,162,64,153,60,153,49' onclick='clickColor("#6666FF",65,153)' onmouseover='mouseOverColor("#6666FF")' alt='#6666FF' /><area style='cursor:pointer' shape='poly' coords='180,45,189,49,189,60,180,64,171,60,171,49' onclick='clickColor("#6600FF",65,171)' onmouseover='mouseOverColor("#6600FF")' alt='#6600FF' /><area style='cursor:pointer' shape='poly' coords='198,45,207,49,207,60,198,64,189,60,189,49' onclick='clickColor("#6600CC",65,189)' onmouseover='mouseOverColor("#6600CC")' alt='#6600CC' /><area style='cursor:pointer' shape='poly' coords='27,60,36,64,36,75,27,79,18,75,18,64' onclick='clickColor("#339933",80,18)' onmouseover='mouseOverColor("#339933")' alt='#339933' /><area style='cursor:pointer' shape='poly' coords='45,60,54,64,54,75,45,79,36,75,36,64' onclick='clickColor("#00CC66",80,36)' onmouseover='mouseOverColor("#00CC66")' alt='#00CC66' /><area style='cursor:pointer' shape='poly' coords='63,60,72,64,72,75,63,79,54,75,54,64' onclick='clickColor("#00FF99",80,54)' onmouseover='mouseOverColor("#00FF99")' alt='#00FF99' /><area style='cursor:pointer' shape='poly' coords='81,60,90,64,90,75,81,79,72,75,72,64' onclick='clickColor("#66FFCC",80,72)' onmouseover='mouseOverColor("#66FFCC")' alt='#66FFCC' /><area style='cursor:pointer' shape='poly' coords='99,60,108,64,108,75,99,79,90,75,90,64' onclick='clickColor("#66FFFF",80,90)' onmouseover='mouseOverColor("#66FFFF")' alt='#66FFFF' /><area style='cursor:pointer' shape='poly' coords='117,60,126,64,126,75,117,79,108,75,108,64' onclick='clickColor("#66CCFF",80,108)' onmouseover='mouseOverColor("#66CCFF")' alt='#66CCFF' /><area style='cursor:pointer' shape='poly' coords='135,60,144,64,144,75,135,79,126,75,126,64' onclick='clickColor("#99CCFF",80,126)' onmouseover='mouseOverColor("#99CCFF")' alt='#99CCFF' /><area style='cursor:pointer' shape='poly' coords='153,60,162,64,162,75,153,79,144,75,144,64' onclick='clickColor("#9999FF",80,144)' onmouseover='mouseOverColor("#9999FF")' alt='#9999FF' /><area style='cursor:pointer' shape='poly' coords='171,60,180,64,180,75,171,79,162,75,162,64' onclick='clickColor("#9966FF",80,162)' onmouseover='mouseOverColor("#9966FF")' alt='#9966FF' /><area style='cursor:pointer' shape='poly' coords='189,60,198,64,198,75,189,79,180,75,180,64' onclick='clickColor("#9933FF",80,180)' onmouseover='mouseOverColor("#9933FF")' alt='#9933FF' /><area style='cursor:pointer' shape='poly' coords='207,60,216,64,216,75,207,79,198,75,198,64' onclick='clickColor("#9900FF",80,198)' onmouseover='mouseOverColor("#9900FF")' alt='#9900FF' /><area style='cursor:pointer' shape='poly' coords='18,75,27,79,27,90,18,94,9,90,9,79' onclick='clickColor("#006600",95,9)' onmouseover='mouseOverColor("#006600")' alt='#006600' /><area style='cursor:pointer' shape='poly' coords='36,75,45,79,45,90,36,94,27,90,27,79' onclick='clickColor("#00CC00",95,27)' onmouseover='mouseOverColor("#00CC00")' alt='#00CC00' /><area style='cursor:pointer' shape='poly' coords='54,75,63,79,63,90,54,94,45,90,45,79' onclick='clickColor("#00FF00",95,45)' onmouseover='mouseOverColor("#00FF00")' alt='#00FF00' /><area style='cursor:pointer' shape='poly' coords='72,75,81,79,81,90,72,94,63,90,63,79' onclick='clickColor("#66FF99",95,63)' onmouseover='mouseOverColor("#66FF99")' alt='#66FF99' /><area style='cursor:pointer' shape='poly' coords='90,75,99,79,99,90,90,94,81,90,81,79' onclick='clickColor("#99FFCC",95,81)' onmouseover='mouseOverColor("#99FFCC")' alt='#99FFCC' /><area style='cursor:pointer' shape='poly' coords='108,75,117,79,117,90,108,94,99,90,99,79' onclick='clickColor("#CCFFFF",95,99)' onmouseover='mouseOverColor("#CCFFFF")' alt='#CCFFFF' /><area style='cursor:pointer' shape='poly' coords='126,75,135,79,135,90,126,94,117,90,117,79' onclick='clickColor("#CCCCFF",95,117)' onmouseover='mouseOverColor("#CCCCFF")' alt='#CCCCFF' /><area style='cursor:pointer' shape='poly' coords='144,75,153,79,153,90,144,94,135,90,135,79' onclick='clickColor("#CC99FF",95,135)' onmouseover='mouseOverColor("#CC99FF")' alt='#CC99FF' /><area style='cursor:pointer' shape='poly' coords='162,75,171,79,171,90,162,94,153,90,153,79' onclick='clickColor("#CC66FF",95,153)' onmouseover='mouseOverColor("#CC66FF")' alt='#CC66FF' /><area style='cursor:pointer' shape='poly' coords='180,75,189,79,189,90,180,94,171,90,171,79' onclick='clickColor("#CC33FF",95,171)' onmouseover='mouseOverColor("#CC33FF")' alt='#CC33FF' /><area style='cursor:pointer' shape='poly' coords='198,75,207,79,207,90,198,94,189,90,189,79' onclick='clickColor("#CC00FF",95,189)' onmouseover='mouseOverColor("#CC00FF")' alt='#CC00FF' /><area style='cursor:pointer' shape='poly' coords='216,75,225,79,225,90,216,94,207,90,207,79' onclick='clickColor("#9900CC",95,207)' onmouseover='mouseOverColor("#9900CC")' alt='#9900CC' /><area style='cursor:pointer' shape='poly' coords='9,90,18,94,18,105,9,109,0,105,0,94' onclick='clickColor("#003300",110,0)' onmouseover='mouseOverColor("#003300")' alt='#003300' /><area style='cursor:pointer' shape='poly' coords='27,90,36,94,36,105,27,109,18,105,18,94' onclick='clickColor("#009933",110,18)' onmouseover='mouseOverColor("#009933")' alt='#009933' /><area style='cursor:pointer' shape='poly' coords='45,90,54,94,54,105,45,109,36,105,36,94' onclick='clickColor("#33CC33",110,36)' onmouseover='mouseOverColor("#33CC33")' alt='#33CC33' /><area style='cursor:pointer' shape='poly' coords='63,90,72,94,72,105,63,109,54,105,54,94' onclick='clickColor("#66FF66",110,54)' onmouseover='mouseOverColor("#66FF66")' alt='#66FF66' /><area style='cursor:pointer' shape='poly' coords='81,90,90,94,90,105,81,109,72,105,72,94' onclick='clickColor("#99FF99",110,72)' onmouseover='mouseOverColor("#99FF99")' alt='#99FF99' /><area style='cursor:pointer' shape='poly' coords='99,90,108,94,108,105,99,109,90,105,90,94' onclick='clickColor("#CCFFCC",110,90)' onmouseover='mouseOverColor("#CCFFCC")' alt='#CCFFCC' /><area style='cursor:pointer' shape='poly' coords='117,90,126,94,126,105,117,109,108,105,108,94' onclick='clickColor("#FFFFFF",110,108)' onmouseover='mouseOverColor("#FFFFFF")' alt='#FFFFFF' /><area style='cursor:pointer' shape='poly' coords='135,90,144,94,144,105,135,109,126,105,126,94' onclick='clickColor("#FFCCFF",110,126)' onmouseover='mouseOverColor("#FFCCFF")' alt='#FFCCFF' /><area style='cursor:pointer' shape='poly' coords='153,90,162,94,162,105,153,109,144,105,144,94' onclick='clickColor("#FF99FF",110,144)' onmouseover='mouseOverColor("#FF99FF")' alt='#FF99FF' /><area style='cursor:pointer' shape='poly' coords='171,90,180,94,180,105,171,109,162,105,162,94' onclick='clickColor("#FF66FF",110,162)' onmouseover='mouseOverColor("#FF66FF")' alt='#FF66FF' /><area style='cursor:pointer' shape='poly' coords='189,90,198,94,198,105,189,109,180,105,180,94' onclick='clickColor("#FF00FF",110,180)' onmouseover='mouseOverColor("#FF00FF")' alt='#FF00FF' /><area style='cursor:pointer' shape='poly' coords='207,90,216,94,216,105,207,109,198,105,198,94' onclick='clickColor("#CC00CC",110,198)' onmouseover='mouseOverColor("#CC00CC")' alt='#CC00CC' /><area style='cursor:pointer' shape='poly' coords='225,90,234,94,234,105,225,109,216,105,216,94' onclick='clickColor("#660066",110,216)' onmouseover='mouseOverColor("#660066")' alt='#660066' /><area style='cursor:pointer' shape='poly' coords='18,105,27,109,27,120,18,124,9,120,9,109' onclick='clickColor("#336600",125,9)' onmouseover='mouseOverColor("#336600")' alt='#336600' /><area style='cursor:pointer' shape='poly' coords='36,105,45,109,45,120,36,124,27,120,27,109' onclick='clickColor("#009900",125,27)' onmouseover='mouseOverColor("#009900")' alt='#009900' /><area style='cursor:pointer' shape='poly' coords='54,105,63,109,63,120,54,124,45,120,45,109' onclick='clickColor("#66FF33",125,45)' onmouseover='mouseOverColor("#66FF33")' alt='#66FF33' /><area style='cursor:pointer' shape='poly' coords='72,105,81,109,81,120,72,124,63,120,63,109' onclick='clickColor("#99FF66",125,63)' onmouseover='mouseOverColor("#99FF66")' alt='#99FF66' /><area style='cursor:pointer' shape='poly' coords='90,105,99,109,99,120,90,124,81,120,81,109' onclick='clickColor("#CCFF99",125,81)' onmouseover='mouseOverColor("#CCFF99")' alt='#CCFF99' /><area style='cursor:pointer' shape='poly' coords='108,105,117,109,117,120,108,124,99,120,99,109' onclick='clickColor("#FFFFCC",125,99)' onmouseover='mouseOverColor("#FFFFCC")' alt='#FFFFCC' /><area style='cursor:pointer' shape='poly' coords='126,105,135,109,135,120,126,124,117,120,117,109' onclick='clickColor("#FFCCCC",125,117)' onmouseover='mouseOverColor("#FFCCCC")' alt='#FFCCCC' /><area style='cursor:pointer' shape='poly' coords='144,105,153,109,153,120,144,124,135,120,135,109' onclick='clickColor("#FF99CC",125,135)' onmouseover='mouseOverColor("#FF99CC")' alt='#FF99CC' /><area style='cursor:pointer' shape='poly' coords='162,105,171,109,171,120,162,124,153,120,153,109' onclick='clickColor("#FF66CC",125,153)' onmouseover='mouseOverColor("#FF66CC")' alt='#FF66CC' /><area style='cursor:pointer' shape='poly' coords='180,105,189,109,189,120,180,124,171,120,171,109' onclick='clickColor("#FF33CC",125,171)' onmouseover='mouseOverColor("#FF33CC")' alt='#FF33CC' /><area style='cursor:pointer' shape='poly' coords='198,105,207,109,207,120,198,124,189,120,189,109' onclick='clickColor("#CC0099",125,189)' onmouseover='mouseOverColor("#CC0099")' alt='#CC0099' /><area style='cursor:pointer' shape='poly' coords='216,105,225,109,225,120,216,124,207,120,207,109' onclick='clickColor("#993399",125,207)' onmouseover='mouseOverColor("#993399")' alt='#993399' /><area style='cursor:pointer' shape='poly' coords='27,120,36,124,36,135,27,139,18,135,18,124' onclick='clickColor("#333300",140,18)' onmouseover='mouseOverColor("#333300")' alt='#333300' /><area style='cursor:pointer' shape='poly' coords='45,120,54,124,54,135,45,139,36,135,36,124' onclick='clickColor("#669900",140,36)' onmouseover='mouseOverColor("#669900")' alt='#669900' /><area style='cursor:pointer' shape='poly' coords='63,120,72,124,72,135,63,139,54,135,54,124' onclick='clickColor("#99FF33",140,54)' onmouseover='mouseOverColor("#99FF33")' alt='#99FF33' /><area style='cursor:pointer' shape='poly' coords='81,120,90,124,90,135,81,139,72,135,72,124' onclick='clickColor("#CCFF66",140,72)' onmouseover='mouseOverColor("#CCFF66")' alt='#CCFF66' /><area style='cursor:pointer' shape='poly' coords='99,120,108,124,108,135,99,139,90,135,90,124' onclick='clickColor("#FFFF99",140,90)' onmouseover='mouseOverColor("#FFFF99")' alt='#FFFF99' /><area style='cursor:pointer' shape='poly' coords='117,120,126,124,126,135,117,139,108,135,108,124' onclick='clickColor("#FFCC99",140,108)' onmouseover='mouseOverColor("#FFCC99")' alt='#FFCC99' /><area style='cursor:pointer' shape='poly' coords='135,120,144,124,144,135,135,139,126,135,126,124' onclick='clickColor("#FF9999",140,126)' onmouseover='mouseOverColor("#FF9999")' alt='#FF9999' /><area style='cursor:pointer' shape='poly' coords='153,120,162,124,162,135,153,139,144,135,144,124' onclick='clickColor("#FF6699",140,144)' onmouseover='mouseOverColor("#FF6699")' alt='#FF6699' /><area style='cursor:pointer' shape='poly' coords='171,120,180,124,180,135,171,139,162,135,162,124' onclick='clickColor("#FF3399",140,162)' onmouseover='mouseOverColor("#FF3399")' alt='#FF3399' /><area style='cursor:pointer' shape='poly' coords='189,120,198,124,198,135,189,139,180,135,180,124' onclick='clickColor("#CC3399",140,180)' onmouseover='mouseOverColor("#CC3399")' alt='#CC3399' /><area style='cursor:pointer' shape='poly' coords='207,120,216,124,216,135,207,139,198,135,198,124' onclick='clickColor("#990099",140,198)' onmouseover='mouseOverColor("#990099")' alt='#990099' /><area style='cursor:pointer' shape='poly' coords='36,135,45,139,45,150,36,154,27,150,27,139' onclick='clickColor("#666633",155,27)' onmouseover='mouseOverColor("#666633")' alt='#666633' /><area style='cursor:pointer' shape='poly' coords='54,135,63,139,63,150,54,154,45,150,45,139' onclick='clickColor("#99CC00",155,45)' onmouseover='mouseOverColor("#99CC00")' alt='#99CC00' /><area style='cursor:pointer' shape='poly' coords='72,135,81,139,81,150,72,154,63,150,63,139' onclick='clickColor("#CCFF33",155,63)' onmouseover='mouseOverColor("#CCFF33")' alt='#CCFF33' /><area style='cursor:pointer' shape='poly' coords='90,135,99,139,99,150,90,154,81,150,81,139' onclick='clickColor("#FFFF66",155,81)' onmouseover='mouseOverColor("#FFFF66")' alt='#FFFF66' /><area style='cursor:pointer' shape='poly' coords='108,135,117,139,117,150,108,154,99,150,99,139' onclick='clickColor("#FFCC66",155,99)' onmouseover='mouseOverColor("#FFCC66")' alt='#FFCC66' /><area style='cursor:pointer' shape='poly' coords='126,135,135,139,135,150,126,154,117,150,117,139' onclick='clickColor("#FF9966",155,117)' onmouseover='mouseOverColor("#FF9966")' alt='#FF9966' /><area style='cursor:pointer' shape='poly' coords='144,135,153,139,153,150,144,154,135,150,135,139' onclick='clickColor("#FF6666",155,135)' onmouseover='mouseOverColor("#FF6666")' alt='#FF6666' /><area style='cursor:pointer' shape='poly' coords='162,135,171,139,171,150,162,154,153,150,153,139' onclick='clickColor("#FF0066",155,153)' onmouseover='mouseOverColor("#FF0066")' alt='#FF0066' /><area style='cursor:pointer' shape='poly' coords='180,135,189,139,189,150,180,154,171,150,171,139' onclick='clickColor("#CC6699",155,171)' onmouseover='mouseOverColor("#CC6699")' alt='#CC6699' /><area style='cursor:pointer' shape='poly' coords='198,135,207,139,207,150,198,154,189,150,189,139' onclick='clickColor("#993366",155,189)' onmouseover='mouseOverColor("#993366")' alt='#993366' /><area style='cursor:pointer' shape='poly' coords='45,150,54,154,54,165,45,169,36,165,36,154' onclick='clickColor("#999966",170,36)' onmouseover='mouseOverColor("#999966")' alt='#999966' /><area style='cursor:pointer' shape='poly' coords='63,150,72,154,72,165,63,169,54,165,54,154' onclick='clickColor("#CCCC00",170,54)' onmouseover='mouseOverColor("#CCCC00")' alt='#CCCC00' /><area style='cursor:pointer' shape='poly' coords='81,150,90,154,90,165,81,169,72,165,72,154' onclick='clickColor("#FFFF00",170,72)' onmouseover='mouseOverColor("#FFFF00")' alt='#FFFF00' /><area style='cursor:pointer' shape='poly' coords='99,150,108,154,108,165,99,169,90,165,90,154' onclick='clickColor("#FFCC00",170,90)' onmouseover='mouseOverColor("#FFCC00")' alt='#FFCC00' /><area style='cursor:pointer' shape='poly' coords='117,150,126,154,126,165,117,169,108,165,108,154' onclick='clickColor("#FF9933",170,108)' onmouseover='mouseOverColor("#FF9933")' alt='#FF9933' /><area style='cursor:pointer' shape='poly' coords='135,150,144,154,144,165,135,169,126,165,126,154' onclick='clickColor("#FF6600",170,126)' onmouseover='mouseOverColor("#FF6600")' alt='#FF6600' /><area style='cursor:pointer' shape='poly' coords='153,150,162,154,162,165,153,169,144,165,144,154' onclick='clickColor("#FF5050",170,144)' onmouseover='mouseOverColor("#FF5050")' alt='#FF5050' /><area style='cursor:pointer' shape='poly' coords='171,150,180,154,180,165,171,169,162,165,162,154' onclick='clickColor("#CC0066",170,162)' onmouseover='mouseOverColor("#CC0066")' alt='#CC0066' /><area style='cursor:pointer' shape='poly' coords='189,150,198,154,198,165,189,169,180,165,180,154' onclick='clickColor("#660033",170,180)' onmouseover='mouseOverColor("#660033")' alt='#660033' /><area style='cursor:pointer' shape='poly' coords='54,165,63,169,63,180,54,184,45,180,45,169' onclick='clickColor("#996633",185,45)' onmouseover='mouseOverColor("#996633")' alt='#996633' /><area style='cursor:pointer' shape='poly' coords='72,165,81,169,81,180,72,184,63,180,63,169' onclick='clickColor("#CC9900",185,63)' onmouseover='mouseOverColor("#CC9900")' alt='#CC9900' /><area style='cursor:pointer' shape='poly' coords='90,165,99,169,99,180,90,184,81,180,81,169' onclick='clickColor("#FF9900",185,81)' onmouseover='mouseOverColor("#FF9900")' alt='#FF9900' /><area style='cursor:pointer' shape='poly' coords='108,165,117,169,117,180,108,184,99,180,99,169' onclick='clickColor("#CC6600",185,99)' onmouseover='mouseOverColor("#CC6600")' alt='#CC6600' /><area style='cursor:pointer' shape='poly' coords='126,165,135,169,135,180,126,184,117,180,117,169' onclick='clickColor("#FF3300",185,117)' onmouseover='mouseOverColor("#FF3300")' alt='#FF3300' /><area style='cursor:pointer' shape='poly' coords='144,165,153,169,153,180,144,184,135,180,135,169' onclick='clickColor("#FF0000",185,135)' onmouseover='mouseOverColor("#FF0000")' alt='#FF0000' /><area style='cursor:pointer' shape='poly' coords='162,165,171,169,171,180,162,184,153,180,153,169' onclick='clickColor("#CC0000",185,153)' onmouseover='mouseOverColor("#CC0000")' alt='#CC0000' /><area style='cursor:pointer' shape='poly' coords='180,165,189,169,189,180,180,184,171,180,171,169' onclick='clickColor("#990033",185,171)' onmouseover='mouseOverColor("#990033")' alt='#990033' /><area style='cursor:pointer' shape='poly' coords='63,180,72,184,72,195,63,199,54,195,54,184' onclick='clickColor("#663300",200,54)' onmouseover='mouseOverColor("#663300")' alt='#663300' /><area style='cursor:pointer' shape='poly' coords='81,180,90,184,90,195,81,199,72,195,72,184' onclick='clickColor("#996600",200,72)' onmouseover='mouseOverColor("#996600")' alt='#996600' /><area style='cursor:pointer' shape='poly' coords='99,180,108,184,108,195,99,199,90,195,90,184' onclick='clickColor("#CC3300",200,90)' onmouseover='mouseOverColor("#CC3300")' alt='#CC3300' /><area style='cursor:pointer' shape='poly' coords='117,180,126,184,126,195,117,199,108,195,108,184' onclick='clickColor("#993300",200,108)' onmouseover='mouseOverColor("#993300")' alt='#993300' /><area style='cursor:pointer' shape='poly' coords='135,180,144,184,144,195,135,199,126,195,126,184' onclick='clickColor("#990000",200,126)' onmouseover='mouseOverColor("#990000")' alt='#990000' /><area style='cursor:pointer' shape='poly' coords='153,180,162,184,162,195,153,199,144,195,144,184' onclick='clickColor("#800000",200,144)' onmouseover='mouseOverColor("#800000")' alt='#800000' /><area style='cursor:pointer' shape='poly' coords='171,180,180,184,180,195,171,199,162,195,162,184' onclick='clickColor("#993333",200,162)' onmouseover='mouseOverColor("#993333")' alt='#993333' /></map>
                                        	<script type="text/javascript">
                                        	document.getElementById("selectedColor").style.top="185px";
                                        	document.getElementById("selectedColor").style.left="135px";
                                        	document.getElementById("selectedColor").style.visibility="visible";
                                        	</script>
                                        	<br /><br /><table cellpadding='0' border='0' cellspacing='0' width='100%'><tr><td width='67'></td><td width='110'><div id='divpreview' style='height:30px;width:100px;border:1px solid #d4d4d4;background-color:<?php echo $category_color;?>;'>&nbsp;</div></td><td><div id='divpreviewtxt'><?php echo $font_color;?></div></td></table>
                                        <br />
                                        <br />
                                        <li><p>Category Background Color: <input style="width:70px;" name='cat_back' id='colorhex' value='<?php echo $category_color;?>' /></p></li>
                                        <li><p>Category Text Color: <select style="width:70px;" name='cat_text' >
                                        <?php
                                        if ($font_color =="#000000") { ?> <option value="#000000">Black</option><?php }
                                        if ($font_color =="#FFFFFF") { ?> <option value="#FFFFFF">White</option><?php } ?>
                                        <option value="#000000">Black</option>
                                        <option value="#FFFFFF">White</option></select></p></li>
                                    <li>
                                    <p>
                                    <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Category','evr_language'); ?>" id="update_category" />
                                    </p>
                                    </li>
                                    </ul>
                                    </form>
                                    </div>
                                    </div>
                                    <?php  
                            break;
                            
                            case "add":
                                    global $wpdb;
                                    $category_name= htmlentities2($_REQUEST['category_name']);
                                    $category_identifier = htmlentities2($_REQUEST['category_identifier']);
                                    $category_desc= htmlentities2($_REQUEST['category_desc']); 
                                    $display_category_desc=$_REQUEST['display_desc'];
                                    $category_background = $_REQUEST['cat_back'];
                                    $category_font = $_REQUEST['cat_text'];
                                    $sql=array('category_name'=>$category_name, 'category_identifier'=>$category_identifier, 'category_desc'=>$category_desc, 
                                    'display_desc'=>$display_category_desc, 'font_color'=>$category_font, 'category_color'=>$category_background); 
                                    $sql_data = array('%s','%s','%s','%s','%s','%s');
                                    
                                    if ($wpdb->insert( get_option('evr_category'), $sql, $sql_data )){?>
                                    	<div id="message" class="updated fade"><p><strong><?php _e('The category has been added.','evr_language');?></strong></p></div>
                                    <?php }else { ?>
                                    	<div id="message" class="error"><p><strong><?php _e('The category was not saved.','evr_language');?> <?php print mysql_error() ?>.</strong></p></div>
                                    <?php
                                    }
                                    echo "<META HTTP-EQUIV='refresh' content='2;URL=admin.php?page=categories'>";
                            break;
                                    	 
                            case "update":
                                    $category_id= $_REQUEST['category_id'];
                                    $category_name= htmlentities2($_REQUEST['category_name']);
                                    $category_identifier = htmlentities2($_REQUEST['category_identifier']);
                                    $category_desc= htmlentities2($_REQUEST['category_desc']); 
                                    $display_category_desc=$_REQUEST['display_desc'];
                                    $category_background = $_REQUEST['cat_back'];
                                    $category_font = $_REQUEST['cat_text'];
                                    global $wpdb;
                                    $sql=array('category_name'=>$category_name, 'category_identifier'=>$category_identifier, 'category_desc'=>$category_desc, 
                                    'display_desc'=>$display_category_desc,'font_color'=>$category_font, 'category_color'=>$category_background); 
                                    
                                    $update_id = array('id'=> $category_id);
                                    
                                    $sql_data = array('%s','%s','%s','%s','%s','%s');
                                    
                                    if ($wpdb->update( get_option('evr_category'), $sql, $update_id, $sql_data, array( '%d' ) )){?>
                                    <div id="message" class="updated fade"><p><strong><?php _e('The category has been updated.','evr_language');?></strong></p></div>
                                    <?php }else { ?>
                                    <div id="message" class="error"><p><strong><?php _e('The category was not updated.','evr_language');?> <?php print mysql_error() ?>.</strong></p></div>
                                    <?php
                    }
                                    echo "<META HTTP-EQUIV='refresh' content='2;URL=admin.php?page=categories'>";
                            break;    
                                  
                            case "delete":    
                                    $id=$_REQUEST['id'];
                                    global $wpdb;
                                    $id = $row['id'];
                                    $sql = "DELETE FROM ".get_option('evr_category')." WHERE id='$id'";
                                    $wpdb->query ( $sql );
                                    echo "<div id='message' class='updated fade'><p><strong>";
                                    _e('The category has been successfully deleted.','evr_language');
                                    echo "</strong></p></div>";
                                    echo "<META HTTP-EQUIV='refresh' content='2;URL=admin.php?page=event_categories'>";
                            break;
                            
                            default:
                                    ?>
                                    <h3><?php _e('Current Categories','evr_language');?></h3>
                                    <form id="form1" name="form1" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                                    <table class="widefat">
                                    <thead>
                                    <tr>
                                        <th><?php _e('ID','evr_language');?></th>
                                        <th><?php _e('Name ','evr_language');?></th>
                                        <th><?php _e('Identifier','evr_language');?></th>
                                        <th><?php _e('Description','evr_language');?></th>
                                        <th><?php _e('Display Description','evr_language');?></th>
                                        <th><?php _e('Shortcode','evr_language');?></th>
                                        <th><?php _e('Action','evr_language');?></th></tr>
                                    </thead>
                                        <tfoot>
                                    <tr>
                                        <th><?php _e('ID','evr_language');?></th>
                                        <th><?php _e('Name ','evr_language');?></th>
                                        <th><?php _e('Identifier','evr_language');?></th>
                                        <th><?php _e('Description','evr_language');?></th>
                                        <th><?php _e('Display Description','evr_language');?></th>
                                        <th><?php _e('Shortcode','evr_language');?></th>
                                        <th><?php _e('Action','evr_language');?></th></tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                    global $wpdb;
                                    $sql = "SELECT * FROM ". get_option('evr_category') ." ORDER BY id ASC";
                                    $result = mysql_query ($sql);
                                    if (mysql_num_rows($result) > 0 ) {
                                    while ($row = mysql_fetch_assoc ($result)){
                                    					$category_id= $row['id'];
                                    					$category_name=$row['category_name'];
                                    					$category_identifier=$row['category_identifier'];
                                    					$category_desc=$row['category_desc'];
                                    					$display_category_desc=$row['display_desc'];
                                                        $category_color = $row['category_color'];
                                                        $font_color = $row['font_color'];
                                                        $style = "background-color:".$category_color." ; color:".$font_color." ;";
                                    ?>
                                    <tr><td><?php echo $category_id?></td>
                                        <td><span style="<?php echo $style;?>"><?php echo $category_name?></span></td>
                                        <td><?php echo $category_identifier?></td>
                                        <td><?php echo $category_desc?></td>
                                        <td><?php echo $display_category_desc?></td>
                                        <td>[EVR_CATEGORY event_category_id="<?php echo $category_identifier?>"]</td>
                                        <td><a href="admin.php?page=categories&action=edit&id=<?php echo $category_id;?>"><?php _e('EDIT','evr_language');?></a>  |
                                        <a href="admin.php?page=categories&action=delete&id=<?php echo $category_id;?>" ONCLICK="return confirm('<?php _e('Are you sure you want to delete category?','evr_language');?>')"><?php _e('DELETE','evr_language');?></a></td></tr>
                                    <?php } 
                                    		}else { 
                                    ?>
                                      <tr><td><?php _e('No Record Found!','evr_language');?></td></tr>
                                    <?php }?>
                                    </tbody></table>
                                    <?php
                            break;
                         }
                         ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php
}
?>