<?php
namespace Modelo\BD;



use Modelo\Base\Centro;

require_once __DIR__."/GenericoBD.php";

abstract class CentroBD extends GenericoBD{

    private static $tabla = "centros";

    public static function getCentroByTrabajador($trabajador){
        $con = parent::conectar();

        $query = "SELECT * FROM ".self::$tabla." WHERE id = (Select idCentro from trabajadores where dni='".$trabajador->getDni()."')";

        $rs = mysqli_query($con, $query) or die("Error getCentrosByEmpresa");

        $centro = parent::mapear($rs, "Centro");

        parent::desconectar($con);

        return $centro;
    }

    public static function getCentrosByEmpresa($empresa){

        $con = parent::conectar();

        $query = "SELECT * FROM ".self::$tabla." WHERE idEmpresa = ".$empresa->getId()." ORDER BY nombre";

        $rs = mysqli_query($con, $query) or die("Error getCentrosByEmpresa");


        $centros = parent::mapearArray($rs, "Centro");


        parent::desconectar($con);

        return $centros;

    }
    public static function getCentrosById($centroId){

        $con = parent::conectar();

        $query = "SELECT * FROM ".self::$tabla." WHERE id = ".$centroId;

        $rs = mysqli_query($con, $query) or die("Error getCentrosByID");

        $centros = parent::mapear($rs, "Centro");

        parent::desconectar($con);

        return $centros;

    }
    //get centro by trabajador

    public static function getCentrosByVehiculo($vehiculo){

        $con = parent::conectar();

        $query = "SELECT * FROM ".self::$tabla." WHERE id = (select idCentro from vehiculos where id=".$vehiculo->getId().")";

        $rs = mysqli_query($con, $query) or die("Error getCentrosByEmpresa");

        $centros = parent::mapear($rs, "Centro");

        parent::desconectar($con);

        return $centros;

    }

    public static function add($centro){

        $con = parent::conectar();

        $query = "INSERT INTO ".self::$tabla." VALUES(null,".$centro->getEmpresa()->getId().",'".$centro->getNombre()."','".$centro->getLocalizacion()."')";

        mysqli_query($con, $query) or die("Error add Centro");

        parent::desconectar($con);

    }
    public static function getAll(){
        $con = parent::conectar();

        $query = "SELECT * FROM ".self::$tabla." ORDER BY nombre";

        $rs = mysqli_query($con, $query) or die("Error getAllCentros");

        $centros = parent::mapearArray($rs, "Centro");

        parent::desconectar($con);

        return $centros;

    }

    // IRUNE

    public static function cargarCentros() {

        $centros = [];

        $con = parent::conectar();

        $query = "SELECT * FROM ".self::$tabla;

        $rs = mysqli_query($con, $query) or die("Error getAllCentros");
        $fila = mysqli_fetch_array($rs);
        while ($fila != null) {
            $centro = new Centro($fila['id'], $fila['nombre'], $fila['localizacion']);
            array_push($centros, $centro);
            $fila = mysqli_fetch_array($rs);
        }

        parent::desconectar($con);

        return $centros;

    }


    public static function getNombreCentro(){           //Aitor

        $con = parent::conectar();

        $query = "SELECT nombre FROM ".self::$tabla;

        $rs = mysqli_query($con, $query) or die("Error getAllCentros");
        while ($fila = mysqli_fetch_array($rs)) {
            return $fila;
        }

        parent::desconectar($con);

    }

    public static function getCentrosByHorasConvenio($horasConvenio){

        $con = parent::conectar();

        $query = "SELECT * FROM ".self::$tabla." WHERE id = (select idCentro from horasconvenios where id=".$horasConvenio->getId().")";

        $rs = mysqli_query($con, $query) or die("Error getCentrosByHorasConvenio");

        $centros = parent::mapear($rs, "Centro");

        parent::desconectar($con);

        return $centros;

    }
    public static function delete($centroId){

        $con = parent::conectar();

        $query = "DELETE FROM ".self::$tabla." WHERE id =".$centroId;

        mysqli_query($con, $query) or die("Error deleteCentro");

        parent::desconectar($con);

    }

    // Alejandra

    public static function getCentrosByEmpresas($empresas){
        $con = parent::conectar();
        $query = "SELECT * FROM ".self::$tabla. " WHERE idEmpresa IN (";
        for($i=0; $i<count($empresas); $i++){
            if($i == 0){
                $query .= $empresas[$i];
            }else{
                $query .= ", " . $empresas[$i];
            }
        }
        $query .= ")";
        $rs = mysqli_query($con, $query) or die("Error getCentrosByEmpresas");
        $centros = parent::mapearArray($rs, "Centro");
        parent::desconectar($con);
        return $centros;
    }
}
