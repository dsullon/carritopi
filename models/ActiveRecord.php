<?php

namespace Models;

class ActiveRecord {

    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    public static function setDB($baseDatos) {
        self::$db = $baseDatos;
    }

    public static function listar() {
        $query = "SELECT * FROM " . static::$tabla;
        $listado = self::consultar($query);
        return $listado;
    }

    public static function obtenerPorId($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $listado = self::consultar($query);
        return array_shift($listado);
    }

    public function crear() {
        $atributos = $this->atributos();

        $query = "INSERT INTO " . static::$tabla ." (";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES('";
        $query .= join("' ,'", array_values($atributos));
        $query .= "')";

        $result = self::$db->query($query);
        return [
            'resultado' => $result,
            'id' => self::$db->insert_id
        ];
    }

    public function actualizar() {
        $atributos = $this->atributos();

        $valores = [];
        foreach($atributos as $clave => $valor){
            $valores[] = "{$clave} = '{$valor}'";
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(", ", $valores);
        $query .= " WHERE id = {$this->id} LIMIT 1";

        $result = self::$db->query($query);
        return $result;
    }

    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = {$this->id} LIMIT 1";
        
        $result = self::$db->query($query);
        return $result;
    }

    public static function where($args = []){
        $query = "SELECT * FROM " . static::$tabla . " WHERE";
        foreach ($args as $clave => $valor) {
            if($clave == array_key_last($args)){
                $query .= " {$clave} = '{$valor}'";
            } else {
                $query .= " {$clave} = '{$valor}' AND ";
            }
        }
        $resultado = self::consultar($query);
        return array_shift($resultado);    
    }

    public static function whereAll(array $filter = [], array $order = []) {
        $query = "SELECT * FROM " . static::$tabla;
         //WHERE
         if(count($filter) > 0){
            $query .= " WHERE ";
            foreach($filter as $key => $value) {
                if($key == array_key_last($filter)) {
                    $query .= "{$key} = '{$value}'";
                } else {
                    $query .= "{$key} = '{$value}' AND ";
                }
            }
        }
        //ORDER BY
        if(count($order) > 0){
            $query .= " ORDER BY";
            foreach($order as $key => $value) {
                if($key == array_key_last($order)) {
                    $query .= " {$key} {$value}";
                } else {
                    $query .= " {$key} {$value},";
                }
            }
        }
        $resultado = self::consultar($query);
        return $resultado;
    }

    protected static function consultar($query) {
        $result = self::$db->query($query);
        $datos = [];
        while($row = $result->fetch_assoc()){
            $datos[] = static::crearObjeto($row);
        }
        $result->free();
        return $datos;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $clave => $valor){
            if(property_exists($objeto, $clave)){
                $objeto->$clave = $valor;
            }
        }
        return $objeto;
    }

    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if($columna === "id") continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sincronizar($args=[]){
        foreach($args as $clave => $valor){
            if(property_exists($this, $clave) && !is_null($valor)){
                $this->$clave = $valor;
            }
        }
    }
}