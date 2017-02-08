<?php

$zip = new ZipArchive();


$filename = 'ZIPTXT.rar';

if ($zip->open($filename, ZIPARCHIVE::CREATE) === true) {

    $zip->addFile('001zonas.txt');
    $zip->addFile('002zonas.txt');
    /*$zip->addFile('001zonas.txt');
    $zip->addFile('3.txt');
    $zip->addFile('b.txt');
    $zip->addFile('b.txt');
    $zip->addFile('b.txt');
    $zip->addFile('b.txt');
    $zip->addFile('b.txt');
    $zip->addFile('b.txt');
    $zip->addFile('b.txt');
    $zip->addFile('b.txt');*/
    $zip->close();
    echo 'Creado ' . $filename;
} else {
    echo 'Error creando ' . $filename;
}
