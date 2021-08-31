<?php

class Convertidor
{
    public function __construct()
    {
        $this->iniciar();
    }

    public function iniciar()
    {
        while (true) {
            try {
                print("Elige la opción que quieres elegir \n 1. Salir \n 2. Convertir un Documento \n 3. Test API \n");
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
                    print("El tipo de formato seleccionado fue: {$tipo} \n");
                    $nombre =  $this->seleccionarArchivo();
                    if ($nombre) {
                        $cargar =  $this->cargarArchivo($nombre, $tipo);
                    } else {
                        print("No se escribió un nombre. \n");
                    }
                } else {
                    print("No se ha seleccionado ninguna opción. \n");
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
                print("Elige el formato de documento que quieres convertir: \n 1. DOCX => ODT \n 2. ODT => DOCX \n 3. XLSX => ODS \n 4. ODS => XLSX \n 5. PPTX => ODP \n 6. ODP => PPTX \n 7. Cualquier Formato (DOCX,ODT,XLSX,ODS,PPTX,ODP) => PDF \n 8. PDF => Cualquier Formato (DOCX,ODT,XLSX,ODS,PPTX,ODP) \n");
                $tipo = readline();
                //print("::: {$tipo} \n");
            } catch (\Throwable $th) {
                print($th->getMessage());
            }
            if ($tipo >= 1 && $tipo <= 8) {
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
                print("Por favor escribe el nombre del archivo (ESTE DEBE DE ESTAR EN LA RAIZ DE LA APLICACIÓN \n Si quieres volver atrás oprime 0 \n");
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
            case 6:
                return "odp";
                break;
            case 7:
                return "otro";
                break;
            case 8:
                return "pdf";
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
            case 6:
                return "pptx";
                break;
            case 7:
                return "pdf";
                break;
            case 8:
                return "otro";//Falta Corregir Este
                break;
        }
    }

    public function cargarArchivo($nombre, $tipo)
    {
        $tipo2 = $this->getTipo($tipo);
        // echo "Nombre escrito: {$nombre} \n";

        $existe = file_exists($nombre) ? "Si existe" : "No existe";
        if (file_exists($nombre)) {
            // print("Existe el archivo: {$existe} \n");
            $formato = pathinfo($nombre, PATHINFO_EXTENSION);
            $nom = pathinfo($nombre, PATHINFO_FILENAME);
            // print("Formato archivo: {$formato} \n {$tipo}");
            if ($formato == $tipo2 || $tipo2 == "otro") {

                $contenido = file_get_contents($nombre, false);

                $base64 = base64_encode($contenido);

                $this->convertir($base64, $this->toTipo($tipo), $formato, $nombre, $nom);
            } else {                   
                print("El formato no es el mismo \n");
                return null;
            
            }
        } else {
            print("El formato no existe \n");
            return null;
        }
        // print($base64);
    }

    public function convertir($base64, $tipo, $formato, $nombre, $nom)
    {
        //  print("ENTRO ACÁ CONVERTIR \n {$base64} \n destino: {$tipo} \n origen: {$formato} \n nombrearchivo: {$nombre} \n");
        $archivo = array(
            'base64' => $base64,
            'extensionDestino' => $tipo,
            'extensionFuente' => $formato,
            'nombreArchivo' => $nombre
        );

       $encode_archivo = json_encode($archivo);
        //print($encode_archivo);
        $decode_archivo = base64_decode($base64);
        $documento = fopen($nom.'.'.$tipo, 'w');
        fwrite($documento, $decode_archivo);
        fclose($documento);  //Descarga el Archivo pero genera error al abrirlo , TOCA CORREGIRLO
        $curl = curl_init();
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $encode_archivo);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://54.163.147.33:8080/convertir",
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => json_encode($archivo),
            CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
            // CURLOPT_POSTFIELDS => "base64={$base64}&extensionDestino={$tipo}&extensionFuente={$formato}&nombreArchivo={$nombre}",
            CURLOPT_RETURNTRANSFER => TRUE,
        ));
        curl_setopt($curl, CURLOPT_PROXY, '');
        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            print("URL error #:" . $error); // mostramos el error
        } else {
            print("NO DIÓ ERROR \n");
            $res = json_decode($response);
            print("\n");
            print($response); // en caso de funcionar correctamente
        }
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
