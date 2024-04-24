<?php

    function tree($racine, $count){
        
        $fil = scandir($racine);

        $arr = explode("/", $_SERVER['REQUEST_URI']);

        foreach ($fil as $f) {
            if ($f === "." || $f === ".." || str_contains($f,'.sock')) {
                    continue;
            }
            else if (is_dir($racine.'/'.$f)){
                if(in_array($f, $arr)){
                    echo "<details open>";
                    echo "<summary>". str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count).'ᐁ <i class="fa-regular fa-folder"></i> '.$f."</summary>";
                    tree($racine.'/'.$f, $count+1);
                    echo "</details>";
                }
                else{
                    echo "<details>";
                    echo "<summary>". str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count).'<i class="fa-regular fa-folder"></i> '.$f."</summary>";
                    tree($racine.'/'.$f, $count+1);
                    echo "</details>";
                }
            }
            else{
                $p = pathinfo($racine.'/'.$f, PATHINFO_EXTENSION);
                if($p === 'html'){
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-brands fa-html5\"></i> " . $f."<br>";
                }
                else if($p === "sock"){
                    continue;
                }
                else if($p === 'css'){
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-brands fa-css3-alt\"></i> " . $f."<br>";
                }
                else if($p === 'js'){
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-brands fa-js\"></i> " . $f."<br>";
                }
                else if($p === 'php'){
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-brands fa-php\"></i> " . $f."<br>";
                } 
                else if($p === 'sql'){
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-solid fa-database\"></i> " . $f."<br>";
                } 
                else if($p === 'txt'){
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-regular fa-file-lines\"></i> " . $f."<br>";
                } 
                else if($p === 'pdf'){
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-regular fa-file-pdf\"></i> " . $f."<br>";
                }
                else if($p === 'jpeg' || $p === 'png' || $p === 'jpg'){
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-regular fa-image\"></i> " . $f."<br>";
                }
                else{
                    echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $count) . "<i class=\"fa-regular fa-file\"></i> " . $f."<br>";
                }
            }
        }
        return 0;
    }

    function last($str){
        $l = 0;
        for($i=0;$i<strlen($str); $i++){
            if($str[$i] == '/' && $i > $l){
                $l = $i;
            }
        }
        return str_replace(substr($str,$l),'',$str);
    }

    function taille($file){
        $size = 0;
        $all = scandir($file);

        foreach ($all as $f) {
            if ($f === "." || $f === ".." || str_contains($f,'.sock')) {
                    continue;
            }
            else if (is_dir($file.'/'.$f)){
                $size += taille($file.'/'.$f);
            }
            else{
                $size += filesize($file.'/'.$f);
            }
        }
        return $size;
    }

    function scan($ch){
        $fileList = scandir($ch);
        $ch = str_replace('//', '/' , $ch);
        $folders = [];
        $files = [];
        foreach ($fileList as $fil) {
            $file = $ch . '/' . $fil;
            if ($fil === "." || $fil === "..")
                continue;
            else if (is_dir($file)){
                if(!str_contains(strrchr($_SERVER['REQUEST_URI'], '/') , '/h5ai.php')){
                    $ur = '/h5ai.php'.str_replace('/h5ai.php', '' ,$_SERVER['REQUEST_URI']);
                }
                else{
                    $ur = $_SERVER['REQUEST_URI'];
                }
                array_push($folders, 'ᐅ <i class="fa-regular fa-folder"></i> <a href="'. $ur .'/' . $fil . '">' . $fil . '</a>' . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . taille($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : "  . date("d/m/Y H:i", filemtime($file)) .'<br>');
            }
            else if (is_file($file)){
                $p = pathinfo($file, PATHINFO_EXTENSION);
                if($p === 'html'){
                    array_push($files,"- <i class=\"fa-brands fa-html5\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                }
                else if($p === "sock"){
                    continue;
                }
                else if($p === 'css'){
                    array_push($files,"- <i class=\"fa-brands fa-css3-alt\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                }
                else if($p === 'js'){
                    array_push($files,"- <i class=\"fa-brands fa-js\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                }
                else if($p === 'php'){
                    array_push($files,"- <i class=\"fa-brands fa-php\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                } 
                else if($p === 'sql'){
                    array_push($files,"- <i class=\"fa-solid fa-database\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                } 
                else if($p === 'txt'){
                    array_push($files,"- <i class=\"fa-regular fa-file-lines\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                } 
                else if($p === 'pdf'){
                    array_push($files,"- <i class=\"fa-regular fa-file-pdf\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                }
                else if($p === 'jpeg' || $p === 'png' || $p === 'jpg'){
                    array_push($files,"- <i class=\"fa-regular fa-image\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                }
                else{
                    array_push($folders,"- <i class=\"fa-regular fa-file\"></i> " . $fil . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; taille : " . filesize($file)." octets &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dernière modification : " . date("d/m/Y H:i", filemtime($file)) . "<br>");
                }

            }
            //else
               //echo "ERROR : File " . $file . " at " . $fil . " doesn't exists !" . "<br>";
        }

        echo "<div>";

        echo($ch . "<br>");
        echo "<br>";

        for($i = 0; $i < count($folders);$i++){
            echo $folders[$i];
        }
        for($i = 0; $i < count($files);$i++){
            echo $files[$i];
        }

        echo "</div>";
    }

   
    echo '<script src="https://kit.fontawesome.com/5f6fc26193.js" crossorigin="anonymous"></script>';

    echo '<style> a { color: black; text-decoration: none; } body { display:flex; justify-content: space-around; } summary { list-style:none; cursor: pointer; } </style>';


    echo "<div>";

    if($_SERVER['REQUEST_URI'] != "/h5ai.php" && $_SERVER['REQUEST_URI'] != '/h5ai.php/' ){
        echo "<a href=\"" . last($_SERVER['REQUEST_URI']) . "\" ><i class=\"fa-solid fa-backward\"></i> </a> <br>";
        echo "<br>";
    }

    $ch = "/Users/marco/documents/Tweet/";


    $url = strrchr($_SERVER['REQUEST_URI'], '/h5ai.php/');

    $racine = $ch;
    tree($racine, 0);
    echo "</div>";


    if($url != "/" && $url != "/h5ai.php"){
        $ch = substr($ch, 0, -1);
        $url = str_replace('/h5ai.php', '' ,$_SERVER['REQUEST_URI']);
        scan($ch . $url);
    }
    else{
        scan($ch);
    }

?>