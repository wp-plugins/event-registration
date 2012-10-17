<?php

/**
 * @author David Fleming
 * @copyright 2012
 */



?>
<style>
section 
{
	display: block;
} 

.evr_accordion
{
	background-color: #eee;
 	border: 1px solid #ccc;
	width: 600px;
	padding: 10px;	
	margin: 50px auto;
	
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	
	-moz-box-shadow: 0 1px 0 #999;
	-webkit-box-shadow: 0 1px 0 #999;
	box-shadow: 0 1px 0 #999;
}
 
.evr_accordion section 
{
 	border-bottom: 1px solid #ccc;
	margin: 5px;
	
	background-color: #fff;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#eee));
    background-image: -webkit-linear-gradient(top, #fff, #eee);
    background-image:    -moz-linear-gradient(top, #fff, #eee);
    background-image:     -ms-linear-gradient(top, #fff, #eee);
    background-image:      -o-linear-gradient(top, #fff, #eee);
    background-image:         linear-gradient(top, #fff, #eee);
  
  	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}

.evr_accordion h2,
 .evr_accordion p
{
	margin: 0;
	
}

.evr_accordion p
{
	padding: 10px;
}
 
.evr_accordion h2 a 
{
	display: block;
	position: relative;
	font: 14px/1 'Trebuchet MS', 'Lucida Sans';
	padding: 10px;
	color: #333;
	text-decoration: none;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}

.evr_accordion h2 a:hover 
{
	background: #fff;
}
 
.evr_accordion h2 + div 
{
	height: 0;
	overflow: hidden;
	-moz-transition: height 0.3s ease-in-out;
	-webkit-transition: height 0.3s ease-in-out;
	-o-transition: height 0.3s ease-in-out;
	transition: height 0.3s ease-in-out;	
}

.evr_accordion :target h2 a:after 
{  
    content: '';
	position: absolute;
	right: 10px;
	top: 50%;
	margin-top: -3px;
	border-top: 5px solid #333;
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;	
}

.evr_accordion :target h2 + div 
{
/*	height: 100px; */
height: auto;
}
</style>