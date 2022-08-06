<?php

namespace App\Helper;

class Helper {

    public static function getEstado($data)
    {
        $array = self::getDataEstado();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getTipoDocumento($data)
    {
        $array = self::getDataTiposDocumentos();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getEstadoNormal($data)
    {
        $array = self::getDataEstadoNormales();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getEstadoServicio($data)
    {
        $array = self::getDataEstadoServicios();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getEstadoFacturas($data)
    {
        $array = self::getDataEstadoFacturas();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getEstadoPagos($data)
    {
        $array = self::getDataEstadoPagos();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getDataEstado()
    {
        $data = array(
            1 => "Activo",
            2 => "Suspendido",
            3 => 'Retirado',
            4 => "Egresado"
        );
        return $data;
    }

    public static function getDataTiposDocumentos()
    {
        $data = array(
            1 => "Cédula de Ciudadania",
            2 => "Cédula de Extranjeria",
            3 => 'Nit',
            4 => "Pasaporte"
        );
        return $data;
    }

    public static function getDataEstadoNormales()
    {
        $data = array(
            1 => "Activo",
            2 => "Inactivo"
        );
        return $data;
    }

    public static function getDataEstadoServicios()
    {
        $data = array(
            1 => "Activo",
            2 => "Anulado",
            3 => "Matriculado"
        );
        return $data;
    }

    public static function getDataEstadoFacturas()
    {
        $data = array(
            1 => "En mora",
            2 => "Al dia",
            3 => "Anulado"
        );
        return $data;
    }

    public static function getDataEstadoPagos()
    {
        $data = array(
            1 => "Aprobado",
            2 => "Pendiente",
            3 => "Anulado"
        );
        return $data;
    }

    public static function getColorEstado($data)
    {
        switch ($data) {
            case 1:
                $color = "success";
                break;
            case 2:
                $color = "danger";
                break;
            case 3:
                $color = "warning";
                break;
            case 4:
                $color = "dark";
                break;
        }
        return $color;
    }

    public static function getColorEstadoNormal($data)
    {
        switch ($data) {
            case 1:
                $color = "success";
                break;
            case 2:
                $color = "danger";
                break;
        }
        return $color;
    }

    public static function getColorEstadoFacturas($data)
    {
        switch ($data) {
            case 1:
                $color = "warning";
                break;
            case 2:
                $color = "success";
                break;
            case 3:
                $color = "danger";
                break;
        }
        return $color;
    }

    public static function getColorEstadoPagos($data)
    {
        switch ($data) {
            case 1:
                $color = "success";
                break;
            case 2:
                $color = "warning";
                break;
            case 3:
                $color = "danger";
                break;
        }
        return $color;
    }

}
