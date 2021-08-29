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
                print("Elige el formato de documento que quieres convertir: \n 1. DOCX => ODT \n 2. XLSX => ODS \n 3. PPTX => ODP \n 4. Atrás \n");
                $tipo = readline();
                //print("::: {$tipo} \n");
            } catch (\Throwable $th) {
                print($th->getMessage());
            }
            if ($tipo < 1 || $tipo > 4) {
                return false;
            }
            if ($tipo == 4) {
                //print("Entro \n");
                $tipoSelected = $this->getTipo($tipo);
                break;
            } else {
                //print("Entro \n");
                $tipoSelected = $this->getTipo($tipo);
                break;
            }
        }
        return $tipoSelected;
    }

    public function getTipo($tipo)
    {
        switch ($tipo) {
            case 1:
                return "DOCX";
                break;
            case 2:
                return "XLSX";
                break;
            case 3:
                return "PPTX";
                break;
        }
    }

    public function  testURL()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.mercadolibre.com/users/226384143",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => ""
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
