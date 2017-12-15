<?php
    $file = $_GET['file'];

    if( file_exists($file) )
    {
        $fileHandler = fopen($file, "r");

        if( $fileHandler )
        {
            $line;

            while( $line = fgets( $fileHandler ) )
            {
                $exLine = explode( ";", $line );

                foreach( $exLine as $key => $value)
                    echo $value." - ";

                echo "<br>";
            }

            fclose( $fileHandler );
        }
        else echo "Não foi possível abrir o arquivo";
    }
    else echo "Arquivo não existe ou não foi encontrado";
?>