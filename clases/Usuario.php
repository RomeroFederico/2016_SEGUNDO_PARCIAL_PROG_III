<?php
    class Usuario 
    {
        public $id;
        public $nombre;
        public $email;
        public $password;
        public $perfil;
        public $foto;

        //--CONSTRUCTOR
        public function __construct($id = NULL)
        {
            if ($id !== NULL)
            {
                //IMPLEMENTAR...
                $usuario = Usuario::TraerUnUsuarioPorId($id);
                $this->id = $usuario->id;
                $this->nombre = $usuario->nombre;
                $this->email = $usuario->email;
                $this->password = $usuario->password;
                $this->perfil = $usuario->perfil;
                $this->foto = $usuario->foto;
            }
        }
        
        public static function TraerUsuarioLogueado($obj)
        {
    		//IMPLEMENTAR...
            $objetoAccesoDatos = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE (email = :email AND password = :password)");

            $consulta->bindValue(':email', $obj->email, PDO::PARAM_STR);
            $consulta->bindValue(':password', $obj->password, PDO::PARAM_STR);

            $consulta->execute();

            if ($consulta->rowCount() != 1)
                return false;

            return $consulta->fetchObject('Usuario');
        }

        public static function TraerUnUsuarioPorId($id)
        {
    		//IMPLEMENTAR...
            $objetoAccesoDatos = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE (id = :id)");

            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            $consulta->execute();

            if ($consulta->rowCount() != 1)
                return false;

            return $consulta->fetchObject('Usuario');
        }

        public static function Agregar($obj)
        {
    		//IMPLEMENTAR...
            try
            {
                $objetoAccesoDatos = AccesoDatos::dameUnObjetoAcceso();

                $consulta = $objetoAccesoDatos->RetornarConsulta("INSERT INTO usuarios (id, nombre, email, password, perfil, foto) 
                                                 VALUES (:Id, :Nombre, :Email, :Password, :Perfil, :Foto)");

                $consulta->bindValue(':Id', $obj->id, PDO::PARAM_INT);
                $consulta->bindValue(':Nombre', $obj->nombre, PDO::PARAM_STR);
                $consulta->bindValue(':Email', $obj->email, PDO::PARAM_STR);
                $consulta->bindValue(':Password', $obj->password, PDO::PARAM_STR);
                $consulta->bindValue(':Perfil', $obj->perfil, PDO::PARAM_STR);
                $consulta->bindValue(':Foto', $obj->foto, PDO::PARAM_STR);

                $consulta->execute();
            }
            catch (Exception $e) 
            {
                return FALSE;
            }

            return TRUE;
        }

        public function ActualizarFoto($origen, $destino)
        {
    		//IMPLEMENTAR...

            if (substr_count($origen, "tmp/") > 0)
            {
                if (Archivo::Mover($origen, $destino))
                {
                    if ($this->foto != "pordefecto.jpg")
                        return Archivo::Borrar("fotos/" . $this->foto);
                    return TRUE;
                }
                return FALSE;
            }
            return TRUE;
        }

        public static function Modificar($obj)
        {
    		//IMPLEMENTAR...
            try
            {
                $objetoAccesoDatos = AccesoDatos::dameUnObjetoAcceso();

                $consulta = $objetoAccesoDatos->RetornarConsulta("UPDATE usuarios SET nombre = :Nombre, email = :Email, perfil = :Perfil, foto = :Foto  
                                                 WHERE (id = :Id)");

                $consulta->bindValue(':Id', $obj->id, PDO::PARAM_INT);
                $consulta->bindValue(':Nombre', $obj->nombre, PDO::PARAM_STR);
                $consulta->bindValue(':Email', $obj->email, PDO::PARAM_STR);
                $consulta->bindValue(':Perfil', $obj->perfil, PDO::PARAM_STR);
                $consulta->bindValue(':Foto', $obj->foto, PDO::PARAM_STR);

                $consulta->execute();
            }
            catch (Exception $e) 
            {
                return FALSE;
            }

            return TRUE;
        }

        public static function TraerTodosLosUsuarios()
        {
    		//IMPLEMENTAR...
            $usuarios = array();

            $objetoAccesoDatos = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM usuarios ORDER BY id");

            $consulta->execute();

            $consulta->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Usuario');

            foreach ($consulta as $usuario)
                array_push($usuarios, $usuario);

            return $usuarios;
        }

        public static function TraerTodosLosPerfiles()
        {
    		//IMPLEMENTAR...
            $perfiles = array();

            $objetoAccesoDatos = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT DISTINCT perfil FROM usuarios");

            $consulta->execute();

            foreach ($consulta as $perfil)
                array_push($perfiles, $perfil[0]);

            return $perfiles;
        }

        public static function Borrar($id)
        {
    		//IMPLEMENTAR...
            try
            {
                $objetoAccesoDatos = AccesoDatos::dameUnObjetoAcceso();

                $consulta = $objetoAccesoDatos->RetornarConsulta("DELETE FROM usuarios WHERE (id = :Id)");

                $consulta->bindValue(':Id', $id, PDO::PARAM_INT);

                $consulta->execute();
            }
            catch (Exception $e) 
            {
                return FALSE;
            }

            return TRUE;
        }

        public static function VerificarEmail($email, $id = 0)
        {
            //IMPLEMENTAR...
            try
            {
                $objetoAccesoDatos = AccesoDatos::dameUnObjetoAcceso();

                $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE (email = :email AND id <> :id)");

                $consulta->bindValue(':email', $email, PDO::PARAM_STR);
                $consulta->bindValue(':id', $id, PDO::PARAM_INT);

                $consulta->execute();

                if ($consulta->rowCount() == 0)
                    return TRUE;

                return FALSE;
            }
            catch (Exception $e) 
            {
                return FALSE;
            }
        }
    }

?>