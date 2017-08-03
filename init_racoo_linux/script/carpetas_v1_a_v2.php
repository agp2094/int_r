<?php

$mi_dir = "/mnt/datos/respaldo/docs/racoo/expedientes";
$mi_dir = "/media/Transcend/respaldo/docs/racoo/expedientes";
$files  = scandir($mi_dir);
$y = 0;
for( $x = 0; $x < count($files); $x++ ){
        if( strstr( $files[$x],"+") || strstr( $files[$x],"-") ){
                $file_v1 = $mi_dir."/".$files[$x];
                $file_v2 =  str_replace( "+", "/", str_replace( "-", "/", $mi_dir."/".strtoupper( $files[$x] ) ) );
                $cmd = "mkdir -p ".dirname($file_v2);
                //echo $cmd."\n";
                exec($cmd);
                $cmd = "mv \"".$file_v1."/\" \"".$file_v2."\" 2>&1 ";
                //echo $cmd."\n";
                exec( $cmd, $out );
                //print_r( $out );
                echo "\n".$y.".)".$files[$x];
                $y++;
                if( $y == 500000 || count( $out  ) > 0  ){
//                      $x =  count($files);
                        echo "\n";
                        if( count( $out  ) > 0 ){
                                echo "\n".$cmd;
                                print_r( $out );
                        }
                }
        }
}

/*
$cmd = "mkdir -p ".$mi_dir.dirname( $exp );
exec( $cmd );
$cmd = "mv \"".$mi_dir.$exp_v1."/\" \"".$mi_dir.$exp."\" 2>&1 ";
exec( $cmd, $out );
*/
?>
