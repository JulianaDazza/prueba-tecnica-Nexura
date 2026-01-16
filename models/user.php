<?php

class User{
    private $conn;
    private $table_name="empleados";

    public function __construct($db){
        $this->conn = $db;
    }

    /* LISTAR EMPLEADOS */
    public function getAll(){
        $query = "
                    SELECT
                    e.id,
                    e.nombre,
                    e.email,
                    e.sexo,
                    e.boletin,
                    e.descripcion,
                    a.nombre AS area
                FROM empleados e
                INNER JOIN areas a ON e.area_id = a.id
                ORDER BY e.id DESC
            ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
        
    }

    /* CREAR EMPLEADOS */
    public function create($data){
        try{
            $this->conn->beginTransaction();

            $query = "
                    INSERT INTO empleados
                (nombre, email, sexo, area_id, boletin, descripcion)
                VALUES
                (:nombre, :email, :sexo, :area_id, :boletin, :descripcion)
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $data['nombre']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":sexo", $data['sexo']);
            $stmt->bindParam(":area_id", $data['area_id']);
            $stmt->bindParam(":boletin", $data['boletin']);
            $stmt->bindParam(":descripcion", $data['descripcion']);

            $stmt->execute();

            $empleado_id = $this->conn->lastInsertId();

            //Insertar roles
            $queryRol = "
                INSERT INTO empleado_rol (empleado_id, rol_id)
                VALUES (:empleado_id, :rol_id)
            ";

            $stmRol = $this->conn->prepare($queryRol);

            foreach ($data['roles'] as $rol_id){
                $stmRol->bindParam('empleado_id', $empleado_id);
                $stmRol->bindParam('rol_id', $rol_id);
                $stmRol->execute();
            }

            $this->conn->commit();
            return true;
        } catch(Exception $e){
            $this->conn->rollBack();
            return false;
        }

    }

    /* BUSCAR EMPLEADO POR ID */
    public function getById($id){
        $query = "
                SELECT * FROM empleados WHERE id = :id LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    /* BUSCAR ROLES DEL EMPLEADO */
    public function getRoles($empleadoId){
        $query = "SELECT rol_id FROM empleado_rol WHERE empleado_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$empleadoId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    /* ACTUALIZAR EMPLEADO */
    public function update($id, $data){
        try{
            $this->conn->beginTransaction();

            $query = "
                    UPDATE empleados SET
                        nombre = :nombre,
                        email = :email,
                        sexo = :sexo,
                        area_id = :area_id,
                        boletin = :boletin,
                        descripcion = :descripcion
                    WHERE id = :id
            ";

           $stmt = $this->conn->prepare($query);
           $stmt->bindParam(":nombre", $data['nombre']);
           $stmt->bindParam(":email", $data['email']);
           $stmt->bindParam(":sexo", $data['sexo']);
           $stmt->bindParam(":area_id", $data['area_id']);
           $stmt->bindParam(":boletin", $data['boletin']);
           $stmt->bindParam(":descripcion", $data['descripcion']);
           $stmt->bindParam(":id", $id);

            $stmt->execute();

            //Eliminar roles actuales
            $queryDelete = "
                        DELETE FROM empleado_rol WHERE empleado_id =:empleado_id
            ";

            $stmtDelete = $this->conn->prepare($queryDelete);
            $stmtDelete->bindParam(":empleado_id", $id);
            $stmtDelete->execute();

            //Insertar nuevos roles
            $queryInsert = "
                        INSERT INTO empleado_rol (empleado_id, rol_id)
                        VALUES (:empleado_id, :rol_id)
            ";

            $stmtInsert = $this->conn->prepare($queryInsert);

            foreach ($data['roles'] as $rol_id){
                $stmtInsert->bindParam(':empleado_id', $id);
                $stmtInsert->bindParam(':rol_id', $rol_id);
                $stmtInsert->execute();
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }

    }

    /* ACTUALIZAR EMPLEADO */
    public function delete($id){
        $query = "DELETE FROM empleados WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
            
    }


}