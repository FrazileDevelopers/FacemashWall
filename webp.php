<?php
/*
Run this command first
==>  open -a ImageOptim DIRECTORY_NAME/*.jpg
*/

// directory in which there are original pics
$dir = 'images/Food';
// directory in which compressed webp pics will be saved.
$webpdir = $dir . 'webp';

if ($handle = opendir($dir)) {
    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            $images[] = $file;
        }
    }
    closedir($handle);
}

if (!file_exists($webpdir) && !is_dir($webpdir)) {mkdir($webpdir);}

for ($i = 0; $i < count($images); $i++) {
    print "\033[36m ". "Image => " . $images[$i] . "\n\033[37m"." \033[33m";
    // print "Image Name => " . substr($images[$i], 0, strrpos($images[$i], '.')) . "\n\n";
    exec("cwebp -q 80 " . $dir . "/" . $images[$i] . " -o " . $webpdir . "/" . substr($images[$i], 0, strrpos($images[$i], '.')) . ".webp");
    print "\n";
    print "\033[0m";
    if ($i == (count($images)-1)) { print "\n\n \033[34m ALL IMAGES CONVERTED & INSTALLED SUCCESSFULLY! \033[0m \n\n"; }
}

/*
    colors for cli

Black 0;30
Blue 0;34
Green 0;32
Cyan 0;36
Red 0;31
Purple 0;35
Brown 0;33
Light Gray 0;37 
Dark Gray 1;30
Light Blue 1;34
Light Green 1;32
Light Cyan 1;36
Light Red 1;31
Light Purple 1;35
Yellow 1;33
White 1;37

*/
