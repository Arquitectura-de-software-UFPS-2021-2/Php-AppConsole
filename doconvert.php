<?php

class Convertidor
{
    public function __construct()
    {
        $this->iniciar();
    }

    public function iniciar()
    {
        print("\n \n \n \n *** BIENVENIDO A LA APLICACIÓN DE CONVERSIÓN DE ARCHIVOS DOCONVERT*** \n");
        while (true) {
            try {
                print("Elige la opción que quieres elegir \n [1] Salir \n [2] Convertir un Documento \n [3] Test API \n");
                $opcion = readline();
            } catch (\Throwable $th) {
                print($th->getMessage());
            }
            if ($opcion == 1) {
                print("Gracias por utilizar la app");
                return false;
            }
            if ($opcion == 2) {
                $tipo = $this->seleccionarTipoDocumento();
                if ($tipo != null) {
                    print("**El tipo de formato seleccionado fue: {$tipo}** \n");
                    $nombre =  $this->seleccionarArchivo();
                    if ($nombre) {
                        $cargar =  $this->cargarArchivo($nombre, $tipo);
                        if ($cargar) {
                            print("Se ha convertido con éxito. \n");
                        } else {
                            print("No se ha podido convertir \n");
                            return null;
                        }
                    } else {
                        print("No se escribió un nombre. \n");
                    }
                }
            }
            if ($opcion == 3) {
                $this->testURL();
            }
        }
    }

    public function seleccionarTipoDocumento()
    {
        $tipoSelected = null;
        while (true) {
            try {
<<<<<<< HEAD:convert.php
                print("Elige el formato de documento que quieres convertir: \n 1. DOCX => ODT \n 2. ODT => DOCX \n 3. XLSX => ODS \n 4. ODS => XLSX \n 5. PPTX => ODP \n 6. ODP => PPTX \n 7. Cualquier Formato (DOCX,ODT,XLSX,ODS,PPTX,ODP) => PDF \n 8. PDF => Cualquier Formato (DOCX,ODT,XLSX,ODS,PPTX,ODP) \n");
=======
                print("Elige el formato de documento que quieres convertir: \n [0] Atrás. \n [1] DOCX => ODT \n [2] XLSX => ODS \n [3] PPTX => ODP \n [4] Cualquier formato => PDF \n \n [5] ODT => DOCX \n [6] ODS => XLSX \n [7] ODP => PPTX \n");
>>>>>>> dev:doconvert.php
                $tipo = readline();
                //print("::: {$tipo} \n");
            } catch (\Throwable $th) {
                print($th->getMessage());
            }
<<<<<<< HEAD:convert.php
            if ($tipo >= 1 && $tipo <= 8) {
=======
            if ($tipo == 0) {
                return null;
            }
            if ($tipo >= 1 && $tipo <= 7) {
>>>>>>> dev:doconvert.php
                $tipoSelected = $tipo;
                break;
            }
        }
        return $tipoSelected;
    }

    public function seleccionarArchivo()
    {
        $archivo = null;
        while (true) {
            try {
<<<<<<< HEAD:convert.php
                print("Por favor escribe el nombre del archivo (ESTE DEBE DE ESTAR EN LA RAIZ DE LA APLICACIÓN \n Si quieres volver atrás oprime 0 \n");
=======
                print("Por favor escribe el nombre del archivo: (ESTE DEBE DE ESTAR EN LA RAIZ DE LA APLICACIÓN) \n Ejemplo: prueba.docx \n Si quieres volver atrás oprime 0. \n");
>>>>>>> dev:doconvert.php
                $nombre = readline();
            } catch (\Throwable $th) {
                print($th->getMessage());
            }
            if ($nombre) {
                $archivo = $nombre;
                break;
            }
            if ($nombre == 0) {
                return null;
            }
        }
        return $archivo;
    }

    public function getTipo($tipo)
    {
        switch ($tipo) {
            case 1:
                return "docx";
                break;
            case 2:
                return "odt";
                break;
            case 3:
                return "xlsx";
                break;
            case 4:
                return "ods";
                break;
            case 5:
                return "pptx";
                break;
<<<<<<< HEAD:convert.php
            case 6:
                return "odp";
                break;
            case 7:
                return "otro";
                break;
            case 8:
                return "pdf";
=======
            case 5:
                return "odt";
                break;
            case 6:
                return "ods";
                break;
            case 7:
                return "odp";
>>>>>>> dev:doconvert.php
                break;
        }
    }

    public function toTipo($tipo)
    {
        switch ($tipo) {
            case 1:
                return "odt";
                break;
            case 2:
                return "docx";
                break;
            case 3:
                return "ods";
                break;
            case 4:
                return "xlsx";
                break;
            case 5:
                return "odp";
                break;
<<<<<<< HEAD:convert.php
            case 6:
                return "pptx";
                break;
            case 7:
                return "pdf";
                break;
            case 8:
                return "otro";//Falta Corregir Este
=======
            case 4:
                return "pdf";
                break;
            case 5:
                return "docx";
                break;
            case 6:
                return "xlsx";
                break;
            case 7:
                return "pptx";
>>>>>>> dev:doconvert.php
                break;
        }
    }

    public function cargarArchivo($nombre, $tipo)
    {
        $tipo2 = ($tipo > 4) ? $this->getTipo($tipo) : $this->getTipo($tipo);
        if (file_exists($nombre)) {
            $formato = pathinfo($nombre, PATHINFO_EXTENSION);
<<<<<<< HEAD:convert.php
            $nom = pathinfo($nombre, PATHINFO_FILENAME);
            // print("Formato archivo: {$formato} \n {$tipo}");
            if ($formato == $tipo2 || $tipo2 == "otro") {
=======

            if ($formato == $tipo2 || $tipo == 4) {
>>>>>>> dev:doconvert.php

                $contenido = file_get_contents($nombre, false);

                $base64 = base64_encode($contenido);

<<<<<<< HEAD:convert.php
                $this->convertir($base64, $this->toTipo($tipo), $formato, $nombre, $nom);
            } else {                   
=======
                return $this->convertir($base64, $this->toTipo($tipo), $formato, $nombre);
            } else {
>>>>>>> dev:doconvert.php
                print("El formato no es el mismo \n");
                return null;
            
            }
        } else {
            print("El formato no existe \n");
            return null;
        }
<<<<<<< HEAD:convert.php
        // print($base64);
=======
>>>>>>> dev:doconvert.php
    }

    public function convertir($base64, $tipo, $formato, $nombre, $nom)
    {
        $archivo = array(
            'base64' => $base64,
            'extensionDestino' => $tipo,
            'extensionFuente' => $formato,
            'nombreArchivo' => $nombre
        );

<<<<<<< HEAD:convert.php
       $encode_archivo = json_encode($archivo);
        //print($encode_archivo);
=======

>>>>>>> dev:doconvert.php
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://54.163.147.33:8080/convertir",
            //  CURLOPT_URL => "http://54.163.147.33:8080/swagger-ui.html/convertir",
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => json_encode($archivo),
            CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
            CURLOPT_RETURNTRANSFER => TRUE,
        ));
        curl_setopt($curl, CURLOPT_PROXY, '');
        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            print("URL error #:" . $error);
        } else {
            $res = json_decode($response, true);
            print("\n");
            return $this->crearArchivo($res);
        }
    }

    public function crearArchivo($res)
    {
        $archivo = fopen($res['nombreArchivo'], 'w');
        $contenido = base64_decode($res['base64']);
        fwrite($archivo, $contenido);
        return fclose($archivo);
    }


    public function  testURL()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://54.163.147.33:8080/convertir",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            echo "URL error #:" . $error; // mostramos el error
        } else {
            $res = json_decode($response);
            echo $response . "\n"; // en caso de funcionar correctamente
        }
    }
}
$convertidor = new Convertidor();
