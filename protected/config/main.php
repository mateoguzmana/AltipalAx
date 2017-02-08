<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Altipal',
    'language' => 'es',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.service.*',
        'application.models.seguimientos.*',
        'application.models.reportes.*',
        'application.models.tablero.*',
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        'seguimientos',
        'reportes',
        'service',
        'tablero',
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '12345',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array($_SERVER['REMOTE_ADDR']),
        ),
    ),
    // application components
    'components' => array(
        'ePdf' => array(
            'class' => 'application.extensions.yii-pdf.EYiiPdf',
            'params' => array(
                'mpdf' => array(
                    'librarySourcePath' => 'application.vendors.mpdf.*',
                    'constants' => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                    'defaultParams' => array(// More info: http://mpdf1.com/manual/index.php?tid=184
                        'mode' => '', //  This parameter specifies the mode of the new document.
                        'format' => 'A4', // format A4, A5, ...
                        'default_font_size' => 0, // Sets the default document font size in points (pt)
                        'default_font' => '', // Sets the default font-family for the new document.
                        'mgl' => 3, // margin_left. Sets the page margins for the new document.
                        'mgr' => 3, // margin_right
                        'mgt' => 3, // margin_top
                        'mgb' => 3, // margin_bottom
                        'mgh' => 4, // margin_header
                        'mgf' => 4, // margin_footer
                        'orientation' => 'P', // landscape or portrait orientation
                    )
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendors.html2pdf.*',
                    'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
                /* 'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                  'orientation' => 'P', // landscape or portrait orientation
                  'format'      => 'A4', // format A4, A5, ...
                  'language'    => 'en', // language: fr, en, it ...
                  'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                  'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                  'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                  ) */
                )
            ),
        ),
        'user' => array(
            // enable cookie-based authentication
            'loginUrl' => array('/'),
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        /*
          'urlManager'=>array(
          'urlFormat'=>'path',
          'rules'=>array(
          '<controller:\w+>/<id:\d+>'=>'<controller>/view',
          '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
          '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
          ),
          ),
         */
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax',
            'emulatePrepare' => true,
            'username' => 'altipalbd14ax',
            'password' => 'xSon4WkbFpkhx',
            'charset' => 'utf8',
        ),
        'Apartado' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax1',
            'emulatePrepare' => true,
            'username' => 'altipalbd1',
            'password' => 'fdYOdGwT9IY',
            'charset' => 'utf8',
        ),
        'Bogota' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax2',
            'emulatePrepare' => true,
            'username' => 'altipalbd2',
            'password' => '7jwKYRP9CrhsD6',
            'charset' => 'utf8',
        ),
        'Cali' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax3',
            'emulatePrepare' => true,
            'username' => 'altipalbd3',
            'password' => 'wtUxesImcXjAE',
            'charset' => 'utf8',
        ),
        'Duitama' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax4',
            'emulatePrepare' => true,
            'username' => 'altipalbd4',
            'password' => 'wDRfTqoDrTq1mE8',
            'charset' => 'utf8',
        ),
        'Ibague' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax5',
            'emulatePrepare' => true,
            'username' => 'altipalbd5',
            'password' => 'NIwoagfsLT',
            'charset' => 'utf8',
        ),
        'Medellin' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax6',
            'emulatePrepare' => true,
            'username' => 'altipalbd6',
            'password' => 'Uz0QhMjQlEPhvSN',
            'charset' => 'utf8',
        ),
        'Monteria' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax7',
            'emulatePrepare' => true,
            'username' => 'altipalbd7',
            'password' => 'ICxhy8EjcZcKgX',
            'charset' => 'utf8',
        ),
        'Pasto' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax8',
            'emulatePrepare' => true,
            'username' => 'altipalbd8',
            'password' => 'd5CfeML6GDF',
            'charset' => 'utf8',
        ),
        'Pereira' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax9',
            'emulatePrepare' => true,
            'username' => 'altipalbd9',
            'password' => 'mP7QmdcZhLE0y',
            'charset' => 'utf8',
        ),
        'Popayan' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax10',
            'emulatePrepare' => true,
            'username' => 'altipalbd10',
            'password' => '6h8jDTbFjC',
            'charset' => 'utf8',
        ),
        'Villavicencio' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=Altipal_bdax11',
            'emulatePrepare' => true,
            'username' => 'altipalbd11',
            'password' => 'W0TFU5vPVJl',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);
