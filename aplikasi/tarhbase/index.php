<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="shortcut icon" href="../favicon.ico"> 
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link href="css/hexaflip.css" rel="stylesheet" type="text/css">
<link href="css/demo.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.style9 {color: #6D9E3A}
-->
</style>
</head>

<body>

<div id="page">

    <div id="hexaflip-demo1" class="demo"></div>
    
    <form id="searchForm" method="get" action="result.php">
		<fieldset>
        
           	<input id="s" type="text" name="key" />
            <input type="hidden" name="page" value="1"/>
            <input type="hidden" name="s" value="1"/>
            <input type="submit" value="Submit" id="submitButton" />          
        </fieldset>
    </form>
    
</div>


<script src="js/hexaflip.js"></script>
    <script>
        var hexaDemo1,
            text1 = 'SEARCH'.split(''),
            settings = {
                size: 60,
                margin: 10,
                fontSize: 30,
                perspective: 450
            },
            makeObject = function(a){
                var o = {};
                for(var i = 0, l = a.length; i < l; i++){
                    o['letter' + i] = a;
                }
                return o;
            },
            getSequence = function(a, reverse, random){
                var o = {}, p;
                for(var i = 0, l = a.length; i < l; i++){
                    if(reverse){
                        p = l - i - 1;
                    }else if(random){
                        p = Math.floor(Math.random() * l);
                    }else{
                        p = i;
                    }
                    o['letter' + i] = a[p];
                }
                return o;
            };
    
        document.addEventListener('DOMContentLoaded', function(){
            hexaDemo1 = new HexaFlip(document.getElementById('hexaflip-demo1'), makeObject(text1), settings);
    
            setTimeout(function(){
                hexaDemo1.setValue(getSequence(text1, true));
            }, 0);
    
            setTimeout(function(){
                hexaDemo1.setValue(getSequence(text1));
            }, 1000);
    
            setTimeout(function(){
                setInterval(function(){
                    hexaDemo1.setValue(getSequence(text1, false, true));
                }, 3000);
            }, 5000);
        }, false);
    
    </script>
</body>
</html>