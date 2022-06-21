<?php
/*Archivos de modele
Modelo que solo busca regirstro y devuelve valores
*/
class Mimodelobuscar extends CI_Model
{
 public function IniciarSesionUsuario($usuario, $contrasena)
  {
        $this->db->select("id"); 
        $this->db->select("username");
        $this->db->select("nombres");
        $this->db->select("apellidos");
        $this->db->select("tipousuario");           
        $this->db->where("username", $usuario);
        $this->db->where("password", md5($contrasena));     
        $this->db->limit(1);
        
        $resultado = $this->db->get("usuarios");//nombre de la tabla
        $datos = array();
        if($resultado->num_rows() == 1)
          {
            foreach($resultado->result() as $filasEncontradas)
              {
                $datos[] = $filasEncontradas;
              }                              
          } 
          
        return $datos;
  }
 public function BuscarElPermisoDelUsuario($idModulo, $idUsuario)
	{
		$consulta  = $this->db->query("SELECT COUNT(*) AS PERMISO_PERMITIDO FROM permisos WHERE tipousuario = $idUsuario AND modulo = $idModulo");
    
		$fila = $consulta->row();
		return $fila->PERMISO_PERMITIDO; //retorno el valor del AS alias PERMISO_PERMITIDO
	}
 public function ListarCuentasContables()
  {
    /*$this->db->select("codigo");
    $this->db->select("nombre");
    $this->db->where("id", 8); //id de las cuentas
    $this->db->or_where("id", 9); //id de las cuentas
    $this->db->or_where("id", 11); //id de las cuentas
    $this->db->or_where("id", 350);//id de las cuentas
    $this->db->or_where("id", 358); //id de las cuentas
    */
    /*$resultado = $this->db->query("SELECT id, codigo,  nombre, 
                      case id when 8 then 'RECAUDADORA'
                          		when 9 then 'RECAUDADORA'
                          		when 11 then 'PAGADORA'
                          		when 350 then 'FOINVER'
                          		when 358 then 'RECAUDADORA' end AS TIPO FROM contacuentascontables WHERE id = 8 or id = 9 or id = 11 or id = 350 or id = 358");
     */
    //$resultado = $this->db->get("contacuentascontables");//nombre de la tabla
    $resultado = $this->db->query("CALL pa_listasr_cuentas_contables_banco()");
    $datosEnArray = array();
    if($resultado->num_rows() > 0)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
    
    
  }
 public function BuscarNumeroCuenta($numeroCuenta)
  {
         
    //$this->db->where("numero_cuenta_bncaria", $numeroCuenta);
  
    $this->db->select("numero_cuenta_bancaria"); 
    $this->db->where("numero_cuenta_bancaria", $numeroCuenta);
    
      
    $resultado = $this->db->get("ban_cuenta_bancaria");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() > 0)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
 public function ListarTipoPartidas()
  {
    $this->db->select("id"); 
    $this->db->select("codigo");
    $this->db->select("descripcion");
      
    $resultado = $this->db->get("contatipospartida");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() > 0)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  } 
 public function ListarCuentasBancarias()
  {
    $this->db->select("id_cuenta_bancaria"); 
    $this->db->select("nombre_banco_cuenta");
    $this->db->select("numero_cuenta_bancaria");
    $this->db->select("id_cuenta_contable");
      
    $resultado = $this->db->get("ban_cuenta_bancaria");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() > 0)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
 public function BuscarOtraCuentaBancariaAtransferir($idCuentaBancaria)
  {
    $this->db->select("id_cuenta_bancaria"); 
    $this->db->select("nombre_banco_cuenta");
    $this->db->select("numero_cuenta_bancaria");
    $this->db->select("id_cuenta_contable");
	$this->db->where("id_cuenta_bancaria <>", $idCuentaBancaria);
      
    $resultado = $this->db->get("ban_cuenta_bancaria");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() > 0)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
 public function ListarTiposPartidas()
  {
    $this->db->select("id");
    $this->db->select("codigo"); 
    $this->db->select("descripcion");
    
    $resultado = $this->db->get("contatipospartida");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() > 0)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
 public function BuscarCuentaEnCheque($cuenta)//SIN USO
  {
     /*$this->db->count_all("id_cuenta_bancaria");
     $this->db->where("id_cuenta_banacaria", $cuenta);
     */
     $this->db->where('id_cuenta_bancaria', $cuenta);
     $this->db->from('ban_cheque');
     return $resultado = $this->db->count_all_results();
      /*$datosEnArray = array();
      if($resultado->num_rows() > 0)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray; */
  }
 public function BuscarCuentaBancariaEnBanCheque($idCheque)
  {
     /*$this->db->count_all("id_cuenta_bancaria");
     $this->db->where("id_cuenta_banacaria", $cuenta);
     */
     $this->db->where('id_cuenta_bancaria', $idCheque);
     $resultado = $this->db->get('ban_cheque');//nombre tabla
      
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray; 
  }
 public function BuscarUltimoNumeroCheque($cuenta)//SIN USO
  {
    $this->db->select_max("numero_cheque");
    $this->db->where("id_cuenta_bancaria", $cuenta);
    
      $resultado = $this->db->get("ban_cheque");//nombre de la tabla
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function BuscarUltimoNumeroChequeTablaCuentaBancaria($cuenta) 
  {
    $this->db->select("ultimo_numero_cheque"); 
    $this->db->where("id_cuenta_bancaria", $cuenta);
    
    $resultado = $this->db->get("ban_cuenta_bancaria");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() > 0)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
 public function BuscarCorrlativoPartida($tipoPartida, $fecha)
  {
     $mes  = substr($fecha,5,2); //extraigo la porcion del mes
	 $anio = substr($fecha,0,4); //extraigo la porcion del año
     $this->db->where('tipopartida', $tipoPartida);
     $this->db->where('mes', $mes);
     $this->db->where('anio', $anio);
     $this->db->from('contacorrelativos');
     return $resultado = $this->db->count_all_results();
  }
 public function ExtraerCorrelativoPartida($tipoPartida, $fecha)
  {
     $mes  = substr($fecha,5,2); //extraigo la porcion del mes
		 $anio = substr($fecha,0,4); //extraigo la porcion del año
     $this->db->select_max("correlativo");
     $this->db->where('tipopartida', $tipoPartida);
     $this->db->where('mes', $mes);
     $this->db->where('anio', $anio);
     
     $resultado = $this->db->get("contacorrelativos");//nombre de la tabla
     
     $datosEnArray = array();
    if($resultado->num_rows() == 1)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
 public function ExtraerCorrelativoDesdeCheque()
  {
      $this->db->select_max("correlativo_partida_creada_desde_cheque");
        
      $resultado = $this->db->get("contapartidas");//nombre de la tabla
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function ListarPartidaNoProcesadaCheque($idDelaParidaPorCheque, $idCheque)
  {
    $this->db->select("id");
    $this->db->select("correlativo");
    $this->db->select("concepto");
    //$this->db->select("abonos");
    $this->db->where("procesada_partida", $idCheque);
    $this->db->where("id", $idDelaParidaPorCheque);
    
    $resultado = $this->db->get("contapartidas");//nombre de la tabla
    $datosEnArray = array();
      if($resultado->num_rows() == 1)   //ojo con esto
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function ListarPrimerDetallePartida($idDelaParidaPorCheque)
  {
    $this->db->select("partida");//es el id de la partadi de la tabal contapartidas
    $this->db->select("cuenta"); // es el id de la cuenta de la tabla cuentascontables
    $this->db->select("codigocuenta");//es el codigo de la cuetna de la tabla cuetnascontables
    $this->db->select("nombrecuenta");//este es el nombre de la cuenta de la tabal cutnacontables
    $this->db->select("abono");//abono de la tabal contadetallepartidas
     $this->db->select("cargo");//abono de la tabal contadetallepartidas
    $this->db->select("concepto");//abono de la tabal contadetallepartidas
    ////si las tablas estubieran relacionadas esto de arriba no se haria solo se haria un join
    $this->db->where("partida", $idDelaParidaPorCheque);
    
    
    $resultado = $this->db->get("contadetallepartidas");//nombre de la tabla
    $datosEnArray = array();
      if($resultado->num_rows() == 1)   //ojo con esto
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function ListarProveedoresParaCheque($filtro)
  {
      $this->db->select("id");
      $this->db->select("codigo");
      $this->db->select("nombrefiscal");
      $this->db->select("nombrecomercial");
      if($filtro != "")
        {
              $this->db->like("codigo", $filtro);       
              $this->db->or_like("nombrefiscal", $filtro);
              $this->db->or_like("nombrecomercial", $filtro);
            
        }
	  $this->db->order_by("nombrefiscal ASC"); //eta linea la agrege para que me los odreden alfabeticamente en la vista nuevo producto/servicio
      $resultado = $this->db->get("proveedorescompras");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function TraerIdCuentaContable($cuenta)
  {
     $this->db->select("id_cuenta_contable"); 
     $this->db->where("id_cuenta_bancaria", $cuenta);
        
      $resultado = $this->db->get("ban_cuenta_bancaria");//nombre de la tabla
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 
 public function UltimoIdCheque($cuenta)
  {
     $this->db->select_max("id_cheque");
	 $this->db->where("id_cuenta_bancaria", $cuenta);
        
      $resultado = $this->db->get("ban_cheque");//nombre de la tabla
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
  public function UltimoIdChequeSinFiltro()
  {
     $this->db->select_max("id_cheque");
	         
      $resultado = $this->db->get("ban_cheque");//nombre de la tabla
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function LlistarCuentasContables($filtro)
  {
      
      $this->db->select("id");
      $this->db->select("codigo");
      $this->db->select("nombre");
      if($filtro != "")
        {
              $this->db->like("codigo", $filtro);       
              $this->db->or_like("nombre", $filtro);
            
        }
      $resultado = $this->db->get("contacuentascontables");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function BuscarCuentasContablesAgregarApartida($idCuentaContable)
  {
      
      $this->db->select("id");
      $this->db->select("codigo");
      $this->db->select("nombre");
      $this->db->where("codigo", $idCuentaContable);
      $resultado = $this->db->get("contacuentascontables");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function BuscarCuentasContablesPorId($idCuentaContable)//SIN USO
  {
  
      $this->db->where("id", $idCuentaContable);
      $resultado = $this->db->get("contacuentascontables");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function TraerIdDeLaPartidaCreadaPorChque($maxIdUltimoCheque)
  {                  
    $this->db->select("id");
    $this->db->where("procesada_partida", $maxIdUltimoCheque);
    $resultado = $this->db->get("contapartidas");//nombre tabla
    $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function BuscarIdCodigoYnombreCuenta($idCuentaContable)
  {
    $this->db->select("cc.id, cc.codigo, cc.nombre");
    $this->db->from("contacuentascontables cc");
    $this->db->join("ban_cuenta_bancaria bcb", "bcb.id_cuenta_contable = cc.id");
    $this->db->join("ban_cheque bch", "bch.id_cuenta_bancaria = bcb.id_cuenta_bancaria");
    $this->db->where("bcb.id_cuenta_contable", $idCuentaContable);
    $this->db->where("bch.id_partida IS NULL");
    $this->db->limit(1);
    
    $resultado = $this->db->get();//sin nombre de tabla porque es un join
    $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function BuscarIdCodigoYnombreCuentaTransaccion($idCuentaContable)
  {
    $this->db->select("cc.id, cc.codigo, cc.nombre");
    $this->db->from("contacuentascontables cc");
    $this->db->join("ban_cuenta_bancaria bcb", "bcb.id_cuenta_contable = cc.id");
    $this->db->join("ban_transaccion trans", "trans.id_cuenta_bancaria = bcb.id_cuenta_bancaria");
    $this->db->where("bcb.id_cuenta_contable", $idCuentaContable);
    $this->db->where("trans.id_partida IS NULL");
    $this->db->limit(1);
    
    $resultado = $this->db->get();//sin nombre de tabla porque es un join
    $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarCheques($filtro)//SIN USO
  {
      $this->db->select("ch.id_cheque, ch.numero_cheque, ch.fecha_emision, ch.monto_cheque, ch.a_nombre_de, ch.id_cuenta_bancaria, ch.id_partida, ch.impreso, banc.nombre_banco_cuenta, banc.numero_cuenta_bancaria, banc.tipo_impresion_cheque");
      $this->db->from("ban_cheque ch");
      $this->db->join("ban_cuenta_bancaria banc", "ch.id_cuenta_bancaria = banc.id_cuenta_bancaria");
      $this->db->where("ch.id_partida IS NOT NULL");
      if($filtro != "")
        {
            
          $this->db->like("ch.numero_cheque", $filtro);
          $this->db->or_like("ch.a_nombre_de", $filtro);
        }
      $resultado = $this->db->get();//sin nombre de tabla porque es un join  
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarChequesSinFiltro()//SIN USO
  {
      $this->db->select("ch.id_cheque, ch.numero_cheque, ch.fecha_emision, ch.monto_cheque, ch.a_nombre_de, ch.id_cuenta_bancaria, ch.id_partida, ch.impreso, banc.nombre_banco_cuenta, banc.numero_cuenta_bancaria, banc.tipo_impresion_cheque");
      $this->db->from("ban_cheque ch");
      $this->db->join("ban_cuenta_bancaria banc", "ch.id_cuenta_bancaria = banc.id_cuenta_bancaria");
      $this->db->where("ch.id_partida IS NOT NULL");
      $this->db->order_by("ch.id_cheque", "asc");
      
      $resultado = $this->db->get();//sin nombre de tabla porque es un join  
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarChequesNoContabilizados($filtro)//SIN USO
  {
      $this->db->select("ch.id_cheque, ch.numero_cheque, ch.fecha_emision, ch.monto_cheque, ch.a_nombre_de, ch.id_cuenta_bancaria, cp.id, banc.nombre_banco_cuenta, banc.numero_cuenta_bancaria");
      $this->db->from("ban_cheque ch");
      $this->db->join("ban_cuenta_bancaria banc", "ch.id_cuenta_bancaria = banc.id_cuenta_bancaria");
      $this->db->join("contapartidas cp", "cp.procesada_partida = ch.id_cheque");
      //$this->db->where("ch.impreso", 1);
       if($filtro != "")
        {
          $this->db->like("ch.numero_cheque", $filtro);
          $this->db->or_like("ch.a_nombre_de", $filtro);
        }
      $this->db->order_by("ch.id_cheque", "asc");
      
      $this->db->order_by("ch.id_cheque", "asc");
      $resultado = $this->db->get();//sin nombre de tabla porque es un join  
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarChequesNoContabilizadosSinFiltro() ///SIN USO
  {
      $this->db->select("ch.id_cheque, ch.numero_cheque, ch.fecha_emision, ch.monto_cheque, ch.a_nombre_de, ch.id_cuenta_bancaria, cp.id, banc.nombre_banco_cuenta, banc.numero_cuenta_bancaria");
      $this->db->from("ban_cheque ch");
      $this->db->join("ban_cuenta_bancaria banc", "ch.id_cuenta_bancaria = banc.id_cuenta_bancaria");
      $this->db->join("contapartidas cp", "cp.procesada_partida = ch.id_cheque");
      //$this->db->where("ch.impreso", 1);
      
      $resultado = $this->db->get();//sin nombre de tabla porque es un join  
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarTodosLosCheques($filtro)//INSERVIBLE FERIFICAR
  {
    $resultado = $this->db->query("CALL pa_listar_todos_los_cheques('%$filtro%')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarDatosParaImprimirChequeProcesado($idCheque)
  {
    $this->db->select("ch.id_cheque, ch.numero_cheque, ch.fecha_emision, 
                      ch.monto_cheque, ch.a_nombre_de, ch.id_cuenta_bancaria, 
                      ch.id_partida, banc.nombre_banco_cuenta, 
                      banc.numero_cuenta_bancaria, 
                      banc.nombre_digitador, 
                      banc.nombre_revisa_cheque, 
                      banc.nombre_autoriza, bdch.concepto,
                      p.id, p.correlativo, tipar.codigo, tipar.descripcion");
    $this->db->from("ban_cheque ch");
    $this->db->join("ban_cuenta_bancaria banc", "ch.id_cuenta_bancaria = banc.id_cuenta_bancaria");
    $this->db->join("ban_detalle_cheque bdch", " bdch.id_cheque = ch.id_cheque");
    $this->db->join("contapartidas p", "p.id = ch.id_partida");
    $this->db->join("contatipospartida tipar", "tipar.id = p.tipopartida");
    $this->db->where("ch.id_cheque", $idCheque);
    
    $resultado = $this->db->get();//sin nombre de tabla porque es un join
    $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function ListarDatosParaImprimirTransaccion($idTras)//busco la trasnaccion par imprimirla
  {
    $this->db->select("t.id_transaccion, t.fecha_contable, t.valor, t.id_partida, t.numero_partida,
					  banc.nombre_banco_cuenta, banc.numero_cuenta_bancaria, banc.nombre_digitador, 
					  banc.nombre_revisa_cheque, banc.nombre_autoriza, td.concepto, td.referencia,
					  tipar.codigo, tipar.descripcion");
    $this->db->from("ban_transaccion t");
    $this->db->join("ban_cuenta_bancaria banc", "t.id_cuenta_bancaria = banc.id_cuenta_bancaria");
    $this->db->join("ban_transacciones_detalle td", " td.id_transaccion = t.id_transaccion");
	 $this->db->join("contapartidas p", "p.id = t.id_partida");
    $this->db->join("contatipospartida tipar", "tipar.id = p.tipopartida");
    $this->db->where("t.id_transaccion", $idTras);
    
    $resultado = $this->db->get();//sin nombre de tabla porque es un join
    $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarPartida($idCheque)
  {
      $this->db->select("cd.* , p.concepto COCEPTO_ORIGINAL, p.cargos");
      $this->db->from("contapartidas p");
      $this->db->join("contadetallepartidas cd", "p.id = cd.partida");
      $this->db->join("ban_cheque ch", "ch.id_partida = p.id");
      $this->db->where("ch.id_cheque ", $idCheque);
	  $this->db->order_by("cargo DESC");
      $resultado = $this->db->get();//sin nombre de tabla porque es un join  
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }                                                      
public function ListarPartidaTransaccion($idTras)//listo la partida de las trasaccciones par imprimirla
  {
      $this->db->select("cd.* , p.concepto COCEPTO_ORIGINAL, p.cargos");
      $this->db->from("contapartidas p");
      $this->db->join("contadetallepartidas cd", "p.id = cd.partida");
      $this->db->join("ban_transaccion t", "t.id_partida = p.id");
      $this->db->where("t.id_transaccion ", $idTras);
      $resultado = $this->db->get();//sin nombre de tabla porque es un join  
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarCuentasBancariasPorFiltro($filtro)
  {
    $this->db->select("id_cuenta_bancaria"); 
    $this->db->select("nombre_banco_cuenta");
    $this->db->select("numero_cuenta_bancaria");
    $this->db->select("id_cuenta_contable");
    $this->db->select("ultimo_numero_cheque");
    if($filtro != "")
        {
              $this->db->like("nombre_banco_cuenta", $filtro);       
              $this->db->or_like("numero_cuenta_bancaria", $filtro);
            
        }
      
    $resultado = $this->db->get("ban_cuenta_bancaria");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() >= 1)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
 public function BusquedaInteractiva($filtro)
  {
      
      $this->db->select("id");
      $this->db->select("codigo");
      $this->db->select("nombre");
      $this->db->like("codigo", $filtro);       
      $this->db->or_like("nombre", $filtro);
      $this->db->limit(5);       
       
      $resultado = $this->db->get("contacuentascontables");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarProveedoreCXP($filtro)
  {
      $this->db->select("id");
      $this->db->select("codigo");
      $this->db->select("nombrefiscal");
      $this->db->select("nombrecomercial");
      $this->db->select("telefono");      
      $this->db->where("codigo", $filtro);
             
       
      $resultado = $this->db->get("proveedorescompras");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarCXP($idProveedor)
  {
      $this->db->select("id");
      $this->db->select("cliente");
      $this->db->select("tipomovimiento");
      $this->db->select("fecha");
      $this->db->select("cargo");
      $this->db->select("abono");
      $this->db->select("documento");
      $this->db->select("fechaquedan");      
      $this->db->where("cliente", $idProveedor);
      $this->db->where("tipomovimiento", "C");
      $this->db->where("abono < cargo");
             
       
      $resultado = $this->db->get("cuentasxpagar");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarCXPagregarAsesion($idCuentaPorPagar)
  {
      $this->db->select("id"); 
      $this->db->select("documento");     
      $this->db->where("id", $idCuentaPorPagar);
             
       
      $resultado = $this->db->get("cuentasxpagar");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarDatosCuentaProveedorServicios() //funcion para llevar los datos de la cuenta contable proveedores de servicios
  {
      
      $this->db->select("id");
      $this->db->select("codigo");
      $this->db->select("nombre");
      $this->db->where("id", 84);//84 es el ide de la cuenta contable       
       
      $resultado = $this->db->get("contacuentascontables");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarTiposTransaccion($filtro)
  {
      
      $this->db->select("tran.id_tipo, tran.nombre, tran.transaccion, tp.descripcion");
      $this->db->from("ban_tipos_transacion tran");
      $this->db->join("contatipospartida tp", "tp.id=tran.id_tipo_partida");
      if($filtro != "Elija...")
        {
          $this->db->where("tp.id", $filtro);
        }       
      $resultado = $this->db->get();//sin nombre de tabla porque es un join
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarTiposTransaccionParaNuevaTransaccion()
  {
      
      $this->db->select("tran.id_tipo, tran.nombre, tran.transaccion, tp.descripcion");
      $this->db->from("ban_tipos_transacion tran");
      $this->db->join("contatipospartida tp", "tp.id=tran.id_tipo_partida");
      
      $resultado = $this->db->get();//sin nombre de tabla porque es un join
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function UltimoIdTransaccion()
  {
     $this->db->select_max("id_transaccion");
        
      $resultado = $this->db->get("ban_transaccion");//nombre de la tabla
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
  public function UltimoIdTransaccionConFiltro($idCuentaBancaria)
  {
     $this->db->select_max("id_transaccion");

      $this->db->where("id_cuenta_bancaria", $idCuentaBancaria);  
      $resultado = $this->db->get("ban_transaccion");//nombre de la tabla
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function TraerIdDeLaPartidaCreadaPorTransaccion($maxIdUltimoIdTransaccion)
  {                  
    $this->db->select("id");
    $this->db->where("es_transaccion", $maxIdUltimoIdTransaccion);
    $resultado = $this->db->get("contapartidas");//nombre tabla
    $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarPartidaNoProcesadaTransaccion($idDelaParidaPorTransaccion, $idTransaccion)
  {
    $this->db->select("id");
    $this->db->select("correlativo");
    $this->db->select("concepto");
    //$this->db->select("abonos");
    $this->db->where("es_transaccion", $idTransaccion);
    $this->db->where("id", $idDelaParidaPorTransaccion);
    
    $resultado = $this->db->get("contapartidas");//nombre de la tabla
    $datosEnArray = array();
      if($resultado->num_rows() == 1)   //ojo con esto
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function TraerParaVerSiEsHaberOdebe($tipoTransaccion)
  {
      $this->db->select("id_tipo_partida");
      $this->db->select("transaccion");
      $this->db->where("id_tipo", $tipoTransaccion);
      
      $resultado = $this->db->get("ban_tipos_transacion");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function TraerCorrelativoPartida($idPartida)
  {
      $this->db->select("correlativo");
      $this->db->where("id", $idPartida);
      
      $resultado = $this->db->get("contapartidas");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarTransacciones($cuentaBancaria, $fechaBanco, $fechaBancoHasta)
  {
       
    $resultado = $this->db->query("CALL pa_listar_transacciones_rango_fechas('$cuentaBancaria', '$fechaBanco', '$fechaBancoHasta')");
     
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function ListarTransaccionesPorRangoFechaYcuentaBancaria($IdCuentaBancaria, $fecha, $fechaHasta)
  {
       
    $resultado = $this->db->query("CALL pa_listar_transacciones_rango_fechas('$IdCuentaBancaria', '$fecha', '$fechaHasta')");
     
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarDatosParaConciliar($idCuentaBancaria, $fecha)
  {
    $resultado = $this->db->query("CALL pa_listar_datos_a_conciliar($idCuentaBancaria, '$fecha')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function YaEstaCreadaEstaConciliacionMesAnnio($mesNumero, $annio, $cuentaBancaria)
  {
     $consulta  = $this->db->query("SELECT COUNT(*) AS CONCILIANCION_CERRADA FROM ban_conciliaciones WHERE mes = '$mesNumero' AND annio = '$annio' AND id_cuenta_bancaria = '$cuentaBancaria' AND conciliacion_cerrada = 0");
     /*$this->db->where('mes', $mesNumero);
     $this->db->where('annio', $annio);
     $this->db->where('id_cuenta_bancaria', $cuentaBancaria);
     $this->db->where('conciliacion_cerrada', 0);
     
     $this->db->from('ban_conciliaciones');
     return $resultado = $this->db->count_all_results();
    */
    $fila = $consulta->row();
    return $fila->CONCILIANCION_CERRADA; //retorno el valor del AS alias CONCILIANCION_CERRADA
      
  }
 public function ListarUltimaConciliacion()
  {
    $resultado = $this->db->query("CALL pa_listar_ultima_conciliacion()");
    $datosEnArray = array();
    if($resultado->num_rows() == 1)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
 public function RetornarTipo($idChOtrans, $numeorChequeOtransaccion) //SIN USO
  {
     
       /*inicio*/
          /*son transacciones y busco que tipo son
          almacena el tipo de datos a conciliar, 
          1 = Depositos no contabilizados, 
          2= Cargos No Contabilizados, 
          3= Depositos en Transito PARA CHEQUES Y TRANSACCIONES, 
          4= Cheques Pendientes ESTO ES SOLO PARA CHEQUES, 
          5= CARGOS PENDIENTES*/
      $tipo = "";   
      if($numeorChequeOtransaccion == 0) //son transacciones
        {   
            //veo que tipo es la tansaccion enviada DEPOSITOS NO CONTABILIZADOS
             $tipo = $this->db->query("CALL pa_ver_si_es_o_no_es_depositos_no_contabilizados('$idChOtrans')");
             $fila = $tipo->row();
             if($fila->RESULTADO == 1)
              {
                $tipo = 1;//depositos no contabilizados
              }
             
             //veo que tipo es la transaccion envidada CARGOS NO CONTABILIZADOS
              $tipo = $this->db->query("CALL pa_ver_si_es_o_no_cargos_no_contabilizados('$idChOtrans')");
              $fila = $tipo->row();
              if($fila->RESULTADO == 1)
               {
                 $tipo = 2;//cargos no contabilizados
               }
               
              //veo que tipo es la transaccion envidada DEPOSITOS EN TRANSITO
              $tipo = $this->db->query("CALL pa_ver_si_es_o_no_es_depositos_en_transito('$idChOtrans')");
              $fila = $tipo->row();
              if($fila->RESULTADO_RANSACCION == 1)
               {
                 $tipo = 3;//depositos en transitos
               } 
        
                
            //veo que tipo es la transaccion envidada CARGOS PENDIENTES
              $tipo = $this->db->query("CALL pa_ver_si_es_o_no_es_cargos_pendientes('$idChOtrans')");
              $fila = $tipo->row();
              if($fila->RESULTADO == 1)
               {
                 $tipo = 5;//cargos pendientes
               } 
             /*fin*/
      }
    else//son cheuqes
      {
        //veo que tipo es la transaccion envidada DEPOSITOS EN TRANSITO
              $tipo = $this->db->query("CALL pa_ver_si_es_o_no_es_depositos_en_transito('$idChOtrans')");
              $fila = $tipo->row();
              if($fila->RESULTADO_CHEQUES == 1)
               {
                 $tipo = 3;//depositos en transitos
               }
              else
                {
                  $tipo = 4;//cheques pendientes
                } 
      }
      
     return $tipo;
  }
 public function ListarDatosParaImprimirConciliacion($idConciliacion)
  {
    /*$resultado = $this->db->query("SELECT dc . * 
FROM ban_conciliaciones c
INNER JOIN ban_conciliacion_detalle dc ON ( dc.correlativo_id_conciliacion = c.correlativo ) 
WHERE c.correlativo = '$idConciliacion'
AND dc.tipo =5
UNION ALL 
SELECT dc . * 
FROM ban_conciliaciones c
INNER JOIN ban_conciliacion_detalle dc ON ( dc.correlativo_id_conciliacion = c.correlativo ) 
WHERE c.correlativo ='$idConciliacion' AND dc.tipo = 3");
    */
    
    $resultado = $this->db->query("CALL pa_listar_datos_reporte_conciliacion('$idConciliacion')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarTipos($idConciliacion)//SIN USO
  {
    $resultado = $this->db->query("SELECT tipo FROM ban_conciliacion_detalle WHERE correlativo_id_conciliacion ='$idConciliacion' GROUP BY tipo ASC");

    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }

public function BuscarTransaccionesDNC($cuentaBancaria, $fechaArreglada)
  {
     $resultado = $this->db->query("CALL pa_listar_depositos_no_contabilizados('$cuentaBancaria', '$fechaArreglada')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function BuscarTransaccionesCNC($cuentaBancaria, $fechaArreglada)
  {
     $resultado = $this->db->query("CALL pa_listar_cargos_no_contabilizados('$cuentaBancaria', '$fechaArreglada')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function BuscarTransaccionesDET($cuentaBancaria, $fechaArreglada)
  {
     $resultado = $this->db->query("CALL pa_listar_depositos_en_transito_trans('$cuentaBancaria', '$fechaArreglada')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function BuscarTransaccionesCP($cuentaBancaria, $fechaArreglada)
  {
     $resultado = $this->db->query("CALL pa_listar_cargos_pendientes('$cuentaBancaria', '$fechaArreglada')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function BuscarChequesNoConciliadoss($cuentaBancaria, $fechaArreglada)//SIN USO
  {
    $resultado = $this->db->query("SELECT * FROM  ban_cheque WHERE fecha_emision <='$fechaArreglada' AND pagado_banco = 0 AND id_cuenta_bancaria = '$cuentaBancaria' AND numero_cheque <> 0");

    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function BuscarChequesDET($cuentaBancaria, $fechaArreglada)
  {
     $resultado = $this->db->query("CALL pa_listar_depositos_en_transito_cheques('$cuentaBancaria', '$fechaArreglada')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function BuscarChequesPEN($cuentaBancaria, $fechaArreglada)
  {
     $resultado = $this->db->query("CALL pa_listar_cheques_pendientes('$cuentaBancaria', '$fechaArreglada')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function ListarConciliaciones($idCuetnaBancaria, $annio)
  {
   
    $this->db->distinct();
    //$this->db->select("annio"); 
    $this->db->select("conci.*, ban.nombre_banco_cuenta, ban.numero_cuenta_bancaria");
    $this->db->from("ban_conciliaciones conci");
    $this->db->join("ban_cuenta_bancaria ban", "ban.id_cuenta_bancaria = conci.id_cuenta_bancaria");
    $this->db->order_by("conci.correlativo DESC"); 
   
    
    
    if($idCuetnaBancaria != "" && $annio != "")
        {
              $this->db->where("conci.annio", $annio);       
              $this->db->where("conci.id_cuenta_bancaria", $idCuetnaBancaria);
            
        }
    
      
    $resultado = $this->db->get("ban_conciliaciones");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() >= 1)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
public function ListarAnniosConciliaon()
  {
   
    $this->db->distinct();
    $this->db->select("annio"); 
    $resultado = $this->db->get("ban_conciliaciones");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() >= 1)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
public function ListarTodosLosChequesReporte($cuentaBancaria, $fechaBanco, $fechaBancoHasta)//sin uso
  {
    $resultado = $this->db->query("CALL pa_listar_todos_los_cheques_reporte('$cuentaBancaria', '$fechaBanco', '$fechaBancoHasta')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function ListaReporteLibroBanco($cuentaBancaria, $fechaBanco, $fechaBancoHasta)
  {
    $resultado = $this->db->query("CALL pa_listar_todas_las_operaciones_bancarias_libro_banco('$cuentaBancaria', '$fechaBanco',  '$fechaBancoHasta')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function ListarSaldosAnteriores($cuentaBancaria, $fechaBanco, $fechaBancoHasta)
  {
    $resultado = $this->db->query("CALL pa_sumar_saldo_anterior_libro_banco('$cuentaBancaria', '$fechaBanco',  '$fechaBancoHasta')");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function TraerMesYannioDeConciliacion() //fucion para traer el ultimo año creado en la tabal conciliacion e irlo a mostrar en la vista VistaPreararDtaosConciliacion
  {
    $resultado = $this->db->query("SELECT mes, annio
                                    FROM ban_conciliaciones
                                    WHERE correlativo = ( 
                                    SELECT MAX( correlativo ) 
                                    FROM ban_conciliaciones )");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray; 
  }
public function BuscarSiEsCXP($idChequeOtransaccion)
  {
      $resultado = $this->db->query("SELECT monto_cheque, id_partida, 
                                      COUNT( * ) AS RESULTADO
                                      FROM ban_cheque ch
                                      INNER JOIN cuentasxpagar cxp ON ( cxp.partida = ch.id_partida ) 
                                      WHERE ch.id_cheque = '$idChequeOtransaccion'");
    $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function VerSiTransaccionEstaContabilizada($idTransaccion)
    {
        $resultado  = $this->db->query("SELECT id FROM contapartidas WHERE es_transaccion = '$idTransaccion' OR es_transaccion = '-$idTransaccion' ");
  
        $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
      
    }
public function ListarDatosChequeAmodificar($idCheque)
  {
    $resultado = $this->db->query("CALL pa_listar_datos_de_cheque_a_modificar('$idCheque')");
    $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function ListarDatosAmodificarCB($idCuentaBancaria)
	{
		$resultado = $this->db->query("CALL pa_listar_datos_cuenta_bancaria_modificar('$idCuentaBancaria')");
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function ListarCentrosDeCostos()
  {
    $this->db->select("id"); 
    $this->db->select("codigo");
    $this->db->select("descripcion");
      
    $resultado = $this->db->get("contacentroscostos");//nombre de la tabla
    $datosEnArray = array();
    if($resultado->num_rows() > 0)
      {
        foreach ($resultado->result() as $filasEncontradas)
          {
            $datosEnArray[] = $filasEncontradas;
          }
      }
    return $datosEnArray;
  }
public function ListarProveedoresTodosCampos($filtro)
  {
      /*$this->db->select("prove.*, fp.codigo AS CODIGO_FORMA_PAGO, fp.descripcion, fp.dias");
	  $this->db->from("proveedorescompras prove");
      $this->db->join("faccondicionespago fp", "prove.condicionespago = fp.id");
      //$this->db->order_by("conci.correlativo DESC");*/
	  $resultado = $this->db->query("SELECT prove.*, fp.codigo AS CODIGO_FORMA_PAGO, fp.descripcion, fp.dias 
									FROM proveedorescompras prove JOIN faccondicionespago fp 
										ON (prove.condicionespago = fp.id)");
      if($filtro != "")
        {
             
			   $resultado = $this->db->query("SELECT prove.*, fp.codigo AS CODIGO_FORMA_PAGO, fp.descripcion, fp.dias 
									FROM proveedorescompras prove JOIN faccondicionespago fp 
										ON (prove.condicionespago = fp.id)
									WHERE prove.codigo LIKE  '%$filtro%' 
										OR prove.nombrefiscal LIKE '%$filtro%'
										OR prove.nombrecomercial LIKE '%$filtro%'");
            
        }
      //$resultado = $this->db->get("proveedorescompras");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
public function TaerTransaccionAcontabilizar($idTransaccion)
	{
		$resultado = $this->db->query("CALL pa_listar_datos_transaccon_contabilizar('$idTransaccion', 1029)");//1029 es para contabilizar
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function ListarDatosAmodificarTransaccion($idTransaccion)
	{
		$resultado = $this->db->query("CALL pa_listar_datos_tipos_transaccion_para_modificar('$idTransaccion')");
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function LitarTodosLosChequesTranferencias($cuentaBancaria, $fechaBanco, $fechaBancoHasta)//el procedimiento almacenado pa_listar_todos_los_cheques y pa_listar_todos_los_cheques_reporte estan malos revisar
	{
		$resultado = $this->db->query("CALL pa_listar_todos_los_cheques_y_transferencias_bancarias('$cuentaBancaria', '$fechaBanco', '$fechaBancoHasta')");
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function TraerIdDeLaPartidaCreadaPorChequeOTransferencia($idCheque)
	{
	  $this->db->select("id");
      $this->db->where("procesada_partida", $idCheque);
	  
      $resultado = $this->db->get("contapartidas");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function TaerIdPartidaPorTransaccion($idTransaccion)
	{
	  $this->db->select("id");
      $this->db->where("es_transaccion", $idTransaccion);
	  
      $resultado = $this->db->get("contapartidas");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function IdDelOtroChque($idDeLaPartidaDelCheque)
  {
     $resultado  = $this->db->query("SELECT COUNT( * ) AS CUENTA, id_cheque AS ID_DEL_OTRO_CHEQUE
									FROM ban_cheque
									WHERE id_partida = '$idDeLaPartidaDelCheque' ");
  
        $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
      
  }
public function ListarDetallePartidaParaModificarChequeNormal($idDelaParidaPorCheque)
  {
    $this->db->select("id");
    ////si las tablas estubieran relacionadas esto de arriba no se haria solo se haria un join
    $this->db->where("partida", $idDelaParidaPorCheque);
    
    
    $resultado = $this->db->get("contadetallepartidas");//nombre de la tabla
    $datosEnArray = array();
      if($resultado->num_rows() >= 1)   //ojo con esto
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function VerSiHayDosIdDePartidas($idPartida)//EXTRAIGO LA CUETNA DE ESE REGISTRO CON ESE ID PARTIDA Y EL ID DE ESE CHEQUE PARA PONER A 0 LOS DETALLES
	{
		
		$resultado  = $this->db->query("SELECT COUNT( * ) AS RESULTADO, MAX(id_cheque) AS ID_CHQUE_OTRO
											FROM ban_cheque ch
											WHERE ch.id_partida = '$idPartida' ");
  
        $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
 public function VerSiHayDosIdDePartidasTrnasacciones($idPartida)//EXTRAIGO LA CUETNA DE ESE REGISTRO CON ESE ID PARTIDA Y EL ID DE la trasaccion PARA PONER A 0 LOS DETALLES
	{
		
		$resultado  = $this->db->query("SELECT COUNT( * ) AS RESULTADO, MAX( id_transaccion ) AS ID_OTRA_TRANSACCION
											FROM ban_transaccion t
											WHERE t.id_partida ='$idPartida' ");
  
        $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function ListarCondicionesDePago()
	{
		$resultado = $this->db->get("faccondicionespago");
		
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
		
	}
public function BusquedaInteractivaProductos($filtro)
  {
      
      $this->db->select("id");
      $this->db->select("codigo");
      $this->db->select("descripcion");
	  $this->db->select("unidad");
	  $this->db->select("costo");
      $this->db->like("codigo", $filtro);       
      $this->db->or_like("descripcion", $filtro);
	  $this->db->or_where("codigo", $filtro);
      $this->db->limit(15);       
       
      $resultado = $this->db->get("materiales");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function BuscarProductoAagregarAlCarro($codigoProducto)
  {
      
      $this->db->select("id");
      $this->db->select("codigo");
      $this->db->select("descripcion");
	  $this->db->select("unidad");
	  $this->db->select("costo");
      $this->db->where("id", $codigoProducto);     
       
      $resultado = $this->db->get("materiales");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
  }
 public function BuscarElIdDeLaCompraVerSiFueProcesada($idCompra)
	{
		$consulta  = $this->db->query("SELECT COUNT(*) AS EXISTE_ID_COMPRA_Y_NO_ESTA_PROCESADA FROM con_compra WHERE estado_compra = '0' AND id_comprobante  = '$idCompra'");
     
    $fila = $consulta->row();
    return $fila->EXISTE_ID_COMPRA_Y_NO_ESTA_PROCESADA; //retorno el valor del AS alias EXISTE_ID_COMPRA_Y_NO_ESTA_PROCESADA	
	}
public function BuscarProveedorPorId($idProveedor)
	{
	  $this->db->where("id", $idProveedor);
	  $resultado = $this->db->get("proveedorescompras");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function TaerIdProveedorDesdeCompra($idCompra)
	{
	  //$this->db->select("id_proveedor");
	  $this->db->where("id_comprobante", $idCompra);
	  $resultado = $this->db->get("con_compra");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function ListarDatosParaImprimirOrdenCompra($idCompra)
	{
		$resultado = $this->db->query("CALL pa_listar_datos_a_imprimr_orden_compra($idCompra)");
        $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function ListarOrdenesOrdenesDeCompra($fechaDesde, $fechaHasta)
	{
		if($fechaDesde > '' && $fechaHasta > '')
			{
				$this->db->where("fecha >=", $fechaDesde);
				$this->db->where("fecha <= ", $fechaHasta);
			}
		$this->db->order_by("id_comprobante DESC");	
		$resultado = $this->db->get("con_compra");//nombre de la tabla
        $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function VerSiEstaAutorizadaCompraYsiExiste($idComprobante)
  {
     $resultado  = $this->db->query("SELECT COUNT( * ) AS RESULTADO, estado_compra
									FROM con_compra
									WHERE id_comprobante = '$idComprobante' ");
  
        $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
      
  }
public function ListarCuentasContablesParaPartidaCompras($idCuentaContableCostoGasto)
	{
		$resultado = $this->db->query("CALL pa_listar_cuentas_contables_para_compra('$idCuentaContableCostoGasto')");
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function TaerMaximoIdPartida()
	{
	  $this->db->select_max("id");
		    
      $resultado = $this->db->get("contapartidas");//nombre de la tabla
      $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
	}
public function BuscarProductosAeditar($idComprobante)
	{
		$resultado = $this->db->query("SELECT cond.* , mate.id, mate.codigo
										FROM con_compra_detalle cond
										INNER JOIN materiales mate ON ( mate.id = cond.id_producto ) 
										WHERE cond.id_comprobante ='$idComprobante'");
		
		 $datosEnArray = array();
      if($resultado->num_rows() >= 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
              $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
	}
 public function BuscarElIdDeLaCompraVerSiYaTieneDetallesEsperandoQuedan($idCompra)
	{
		$consulta  = $this->db->query("SELECT COUNT(*) AS ESPERANDO_QUEDAN FROM con_compra WHERE estado_compra =  '2' AND id_comprobante  = '$idCompra'");//2 indica que ya fue procesada e impresa solo falta espara en queda y procesar cxp
     
    $fila = $consulta->row();
    return $fila->ESPERANDO_QUEDAN; //retorno el valor del AS alias EXISTE_ID_COMPRA_Y_NO_ESTA_PROCESADA	
	}
public function TaerUltimoCorreltaivoPorMes($fechaDeContabilizacion)
	{
		$consulta  = $this->db->query("SELECT IF( MAX( correlativo ) IS NULL ,  '-1029', MAX( correlativo ) ) 
											AS CORRELATIVO
										FROM con_compra
										WHERE MONTH( fecha_contable ) = '$fechaDeContabilizacion'
											  AND YEAR(fecha_contable) = '$fechaDeContabilizacion'
										AND id_tipo_comprobante !=5");//$fechaDeContabilizacion es el mes actual que le envio para que busque el ultimo correltivo y lo retorne
															//al recibo no le pongo correlativo
		//si el correlativo es null entonces significa que no existe correlativo a un para esa fecha que le ponga
		//-1029 para asignarel 1		
		$fila = $consulta->row();
		return $fila->CORRELATIVO; //retorno el valor del AS alias CORRELATIVO
	}
public function ListarRegistroGenerarLibroIVACompras($mes, $annio)
	{
		$resultado = $this->db->query("CALL pa_listar_registros_generar_libro_iva_compras('$mes', '$annio')");
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function VerSiYaEstaContabilizadaLaCompra($idComprobante)
	{
		$consulta  = $this->db->query("SELECT COUNT(*) AS RESULTADO FROM con_compra 
										WHERE id_comprobante = '$idComprobante' 
										AND estado_compra = 3");//3 que ya esta contabilizada
				
		$fila = $consulta->row();
		return $fila->RESULTADO; //retorno el valor del AS alias RESULTADO
	}
public function TaerUlitimoIdComprobante()
	{
		$this->db->select_max("id_comprobante");
		$resultado = $this->db->get("con_compra");
		
		$fila = $resultado->row();
		return $fila->id_comprobante;//retorno el ulitmo ide de lacompra como solo es un registro no lo recorre en un array

	}
public function VerSiExisteProductoServicio($coidgoProducto)
	{
		$this->db->where("codigo", $coidgoProducto);
		$this->db->from('materiales');
       return $resultado = $this->db->count_all_results();//retorno todo el resultado de la tabla
	   //el cont_all_result acepta where a diferencia del cont_all
	
	}
public function TraerIdCreadoHastaElMomento($codigoProductoServicio)
	{
		$this->db->select("id");
		$this->db->where("codigo", $codigoProductoServicio);
		$resultado = $this->db->get("materiales");
		
		$fila = $resultado->row();//le asigo la fila sleccionada
		return $fila->id;//retorno la fila seleccionada
	}
public function ListarProveedoresEnLasCompras()///SIN USO
	{
		$this->db->select("id_proveedor");
		$this->db->group_by("codigo_proveedor");
		
		$resultado = $this->db->get("con_compra");//nombre tabla
		
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function ListarComprasHistoricoXProveedor($idProveedor, $fechaBanco, $fechaBancoHasta)
	{
		 if(!empty($fechaBanco)  && !empty($fechaBancoHasta))
					{
						 $fechaBanco                = $fechaBanco;
						 $fechaBancoHasta           = $fechaBancoHasta;
					}
		ELSE
			{
				$fechaBanco                = NULL;
			    $fechaBancoHasta           = NULL;
			}
				
		$resultado = $this->db->query("CALL pa_listar_registros_historico_x_proveedor('$idProveedor', '$fechaBanco', '$fechaBancoHasta')");
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function BuscarProductos($filtro)
	{
		$this->db->select("*");
      
      if($filtro != "")
        {
              $this->db->like("codigo", $filtro);       
              $this->db->or_like("descripcion", $filtro);
            
        }
	  $this->db->order_by("id ASC"); 
      $resultado = $this->db->get("materiales");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function ListarCompraHistoricoXProducto($codigoProducto, $fechaBanco, $fechaBancoHasta)
	{
		$resultado = $this->db->query("CALL pa_listar_registros_historico_x_producto('$codigoProducto', '$fechaBanco', '$fechaBancoHasta')");
		$datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function BuscarProductosPorNombreOcategoria($filtro)
	{

		$resultado = $this->db->query("SELECT mate.*, usu.nombres
										FROM materiales mate 
											INNER JOIN usuarios usu ON(usu.id = mate.id_usuario)
										WHERE categoria = 2 AND (descripcion LIKE '%$filtro%' OR codigo LIKE '%$filtro%')
										ORDER BY mate.id DESC ");
   
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function ListarProductoServicioAmodificar($idProductoServicio)
	{
	  $this->db->select("*");
	  $this->db->where("id", $idProductoServicio);
	  $this->db->where("categoria", 2);//si es servicio que permita modificar
	  
      $resultado = $this->db->get("materiales");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	
	}
public function DosIdsChequees($idCheque)
	{
		$resultado = $this->db->query("SELECT COUNT(*) AS RESULTADO, motivo_anulacion
										FROM ban_cheque where motivo_anulacion = $idCheque ");
   
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function verSiEseNumeroChequeNoAsidoAsignadoMismaCuenta($idCuentaBancaria, $numeroChequeque)
	{
		$consulta  = $this->db->query("SELECT COUNT( * ) AS NUMERO_CHEQUE_YA_ASIGNADO
										FROM ban_cheque
										WHERE numero_cheque =  '$numeroChequeque'
										AND id_cuenta_bancaria ='$idCuentaBancaria'");
     
    $fila = $consulta->row();
    return $fila->NUMERO_CHEQUE_YA_ASIGNADO; //retorno el valor del AS alias EXISTE_ID_COMPRA_Y_NO_ESTA_PROCESADA	
	}
public function ListarEncabezadoOrdenCompraModificar($idComprobante)
	{
		$this->db->select("com.*, ccosto.*, prove.tamanocontribuyente");
		$this->db->from("con_compra com");
		$this->db->join("contacentroscostos ccosto", "ccosto.id = com.id_centro_costo");
		$this->db->join("proveedorescompras prove", "prove.id = com.id_proveedor");
		$this->db->where("com.id_comprobante", $idComprobante);
		$resultado = $this->db->get();//sin nombre de tabla porque es un inner join
        $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
		
	}
public function BuscarCentroCostoPorNombreOcategoria($filtro)
	{

		$resultado = $this->db->query("SELECT *
										FROM contacentroscostos 
										WHERE codigo = '$filtro' OR descripcion LIKE '%$filtro%' 
										ORDER BY id ");
   
      $datosEnArray = array();
        if($resultado->num_rows() >= 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	}
public function VerSiExisteCentroCosto($codigoCentroCosto)
	{
		$this->db->where("codigo", $codigoCentroCosto);
		$this->db->from('contacentroscostos');
       return $resultado = $this->db->count_all_results();//retorno todo el resultado de la tabla
	   //el cont_all_result acepta where a diferencia del cont_all
	
	}
public function ListarCentroCostoAmodificar($idCentroCosto)
	{
	  $this->db->select("*");
	  $this->db->where("id", $idCentroCosto);
	  
      $resultado = $this->db->get("contacentroscostos");//nombre de la tabla
      $datosEnArray = array();
        if($resultado->num_rows() == 1)
          {
            foreach ($resultado->result() as $filasEncontradas)
              {
                $datosEnArray[] = $filasEncontradas;
              }
          }
        return $datosEnArray;
	
	}
}      
?>
