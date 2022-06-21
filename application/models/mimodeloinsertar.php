<?php
class Mimodeloinsertar extends CI_Model
{
  public function RegistrarCuentaBanco($cuentaContable, $numeroCuenta, $banco, $ultimoCheque, $tipoPartida, $tipoImpresion, $inactiva, $nombreEmite, $cargoEmite, $nombreRevisa, $cargoRevisa, $nombreAutoriza, $cargoAutoriza)
    {
      $fecha = date("Y-m-d");
      $this->db->set("nombre_banco_cuenta", $banco);
      $this->db->set("numero_cuenta_bancaria", $numeroCuenta);
      $this->db->set("nombre_digitador", $nombreEmite);
      $this->db->set("cargo_digitador", $cargoEmite);
      $this->db->set("nombre_revisa_cheque", $nombreRevisa);
      $this->db->set("cargo_revisa_cheque", $cargoRevisa);
      $this->db->set("nombre_autoriza", $nombreAutoriza);
      $this->db->set("cargo_autoriza", $cargoAutoriza);
      $this->db->set("ultimo_numero_cheque", $ultimoCheque);
      $this->db->set("id_tipo_partida", $tipoPartida);
      $this->db->set("estado_cuenta_bancaria", $inactiva);
      $this->db->set("tipo_impresion_cheque", $tipoImpresion);
      $this->db->set("creada_por", $this->session->userdata("username"));
      $this->db->set("fecha_creacion", $fecha);
      $this->db->set("id_cuenta_contable", $cuentaContable);
      
      $insertar = $this->db->insert("ban_cuenta_bancaria");//nombre de la tabla
      if($insertar)
        {
          return true;
        }
      else
        {
          return false;
        }
    }
  public function InsertarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida)
    {
     
      $mes = substr($fecha,5,2); //extraigo la porcion del mes
		  $anio = substr($fecha,0,4); //extraigo la porcion del año
      $this->db->set("tipopartida", $tipoPartida);
      $this->db->set("mes", $mes);
      $this->db->set("anio", $anio);
      $this->db->set("correlativo", $numeroSiguienteCorrelativoPartida);
      $insertar = $this->db->insert("contacorrelativos");//nombre de la tabla
      if($insertar)
        {
          return true;
        }
      else
        {
          return false;
        }
    }
  public function InsertarNuevaPartida($fecha, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $idUsuario, $esTranferencia, $anombrede, $userName, $cuenta, $idCuentaContable, $maxIdUltimoCheque, $noIncluirNomber) //$idUltimoCheque)
    {
      
      /*$this->db->set("fecha",  );
      $this->db->set("tipopartida",  );
      $this->db->set("correlativo",  );
      $this->db->set("concepto",  );
      $this->db->set("abonos",  );
      $this->db->set("usuario",  );
      $this->db->set("fecha",  );
      $this->db->set("procesada_partida", 1);*/
      $horaYfecha = date("Y-m-d H:i:s");
      if($noIncluirNomber == 1)//no incluye nombre
        {
            $elConcepto = $anombrede.", ".$concepto. " valor $".$monto;
        }
      elseif($noIncluirNomber == 2)
        {
              $elConcepto = $concepto;
        }
      else
        {
          $elConcepto = $concepto;
        }
		
      if($esTranferencia == 0)//es trasferencia
        {
          $elConcepto = $concepto.", por transferencia";
        }
      
      //inicio transaccion
      $this->db->trans_start();
      
      $this->db->query("insert into contapartidas(fecha, tipopartida, correlativo, concepto, usuario, procesada_partida) values('$fecha', '$tipoPartida', '$numeroSiguienteCorrelativoPartida', '$elConcepto', '$idUsuario', '$maxIdUltimoCheque')");
     
	 //si el esTranferencia es 0 es porque es transferencia no debo poner en la campo motivo_anulacion el -1324
	 if($esTranferencia == 0)
		{
			//insertando en la tabla ban_cheque
				$this->db->query("insert into ban_cheque(numero_cheque, fecha_emision, monto_cheque, a_nombre_de, concepto_cheque, creado_por, fecha_hora_creacion, id_tipo_partida, id_cuenta_bancaria) values('0', '$fecha', '$monto', '$anombrede', '$concepto', '$userName', '$horaYfecha', '$tipoPartida', '$cuenta')");
		}
	else
		{
			 //insertando en la tabla ban_cheque
			$this->db->query("insert into ban_cheque(numero_cheque, fecha_emision, monto_cheque, a_nombre_de, concepto_cheque, creado_por, fecha_hora_creacion, motivo_anulacion, id_tipo_partida, id_cuenta_bancaria) values('00', '$fecha', '$monto', '$anombrede', '$concepto', '$userName', '$horaYfecha', '-1324', '$tipoPartida', '$cuenta')");//el -1324 es para indicar que este cheque aun no tiene numero de cheuqe asignado
	
		}
	 
      $this->db->trans_complete();
      //finaliza transaccion
      
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }

      
    }
 public function InsertarCargoAcuentaBancariaTransferida($fecha, $concepto, $monto, $esTranferencia, $anombrede, $userName, $idCuentaBancairiaOtraTrnasferir, $noIncluirNomber, $maxIdUltimoCheque) //$idUltimoCheque)
    {
      
     
      $horaYfecha = date("Y-m-d H:i:s");
      if($noIncluirNomber == 1)//no incluye nombre
        {
            $elConcepto = $anombrede.", ".$concepto. " valor $".$monto;
        }
      elseif($noIncluirNomber == 2)
        {
              $elConcepto = $concepto;
        }
      else
        {
          $elConcepto = $concepto;
        }

      if($esTranferencia == 0)//es trasferencia
        {
          $elConcepto = $concepto.", por transferencia";
        }
      
      //inicio transaccion
      $this->db->trans_start();
      
      //insertando el cargo en la tabla ban_cheque a la cuenta banciaria que corresponde el traspaso
      $this->db->query("insert into ban_cheque(numero_cheque, fecha_emision, monto_cheque, a_nombre_de, concepto_cheque, impreso, creado_por, fecha_hora_creacion, motivo_anulacion,  id_tipo_partida, id_cuenta_bancaria) values('0', '$fecha', '$monto', '$anombrede', '$concepto', '6', '$userName', '$horaYfecha', '$maxIdUltimoCheque', '2', '$idCuentaBancairiaOtraTrnasferir')");//el 2 es el tipo de partida generada este registro no generara partida solo es para 
	  //cuando se haga una trasferencia de fondos de cunatas a cuntas entonces, todos estos datos serán del registro del otro banco
	  //aqui cargado para que se vea el momimiento en el otro banco
      
	  //completo la transaccion
      $this->db->trans_complete();
      //finaliza transaccion
      
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }

      
    }
  public function InsertarDetalleCheque($concepto, $monto, $idUltimoCheque, $idCuentaContable, $idDelaParidaPorCheque, $idCuenta, $codigoCuenta, $nombreCuenta, $anombrede, $noIncluirNomber, $esTranferencia)
    {
      /*$this->db->set("concepto", $concepto);
      $this->db->set("haber", $monto);
      $this->db->set("id_cheque", $idUltimoCheque);
      $this->db->set("id_cuenta_contable", $idCuentaContable);
      */ 
      if($noIncluirNomber == 1)//no incluye nombre
        {
            $elConcepto = $anombrede.", ".$concepto. " valor $".$monto;
        }
      elseif($noIncluirNomber == 2)
        {
              $elConcepto = $concepto;
        }
      else
        {
          $elConcepto = $concepto;
        }

      if($esTranferencia == 0)//es trasferencia
        {
          $elConcepto = $anombrede. ", ".$concepto.", por transferencia";
        }
       
      //inicio transaccion
      $this->db->trans_start();
      
      //inserto en la tabla ban_detalle_cheque el detalle del cheque
      $this->db->query("insert into ban_detalle_cheque(concepto, haber, id_cheque, id_cuenta_contable) values('$concepto', '$monto', '$idUltimoCheque', '$idCuentaContable')");
      
      //inserto en la tabla contapartidadetalles
      $this->db->query("insert into contadetallepartidas(partida, cuenta, codigocuenta, nombrecuenta, concepto, abono) values('$idDelaParidaPorCheque', '$idCuenta', '$codigoCuenta', '$nombreCuenta', '$elConcepto', '$monto')");
      
      //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }
    }                                  
  public function InsertarDetalleChequeTrasferenciaEntreCuentas($concepto, $monto, $idUltimoCheque, $anombrede, $idCuentaContableT, $noIncluirNomber, $esTranferencia, $idDelaParidaPorCheque)
    {
     
      if($noIncluirNomber == 1)//no incluye nombre
        {
            $elConcepto = $anombrede.", ".$concepto. "  valor $".$monto;
        }
      elseif($noIncluirNomber == 2)
        {
              $elConcepto = $concepto;
        }
      else
        {
          $elConcepto = $concepto;
        }

      if($esTranferencia == 0)//es trasferencia
        {
          $elConcepto = $concepto.", por transferencia";
        }
       
      //inicio transaccion
      $this->db->trans_start();
      
      //inserto en la tabla ban_detalle_cheque el detalle del cheque los cargos para esta cuenta bancaria
      $this->db->query("insert into ban_detalle_cheque(concepto, debe, id_cheque, id_cuenta_contable) values('$concepto', '$monto', '$idUltimoCheque', '$idCuentaContableT')");
       //actualizo la tabla ban_cheque
      $this->db->query("update ban_cheque set id_partida = '$idDelaParidaPorCheque' where id_partida is NULL AND id_cheque = '$idUltimoCheque'");
      
      //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }
    }                                  
  public function GuardarYcontabilizar(array $enviarDatosAfuncion = array(), $idPartida, $totalCargos, $totalAbonos, $idChequeNoProcesado)
    {
       $datosAguardarDetalle = array(
               //tabla  contadetallepartidas
              "id"    => $enviarDatosAfuncion["id"],
              "codigo" => $enviarDatosAfuncion["codigo"],
              'nombre'        => $enviarDatosAfuncion["nombre"],//["cantidad"] es el índice del array
              "conceptoDetalle"=>$enviarDatosAfuncion["conceptoDetalle"],
              "cargo"=>$enviarDatosAfuncion["cargo"],
              "abono"=>$enviarDatosAfuncion["abono"]
              );
       //inicio transaccion
      $this->db->trans_start();
      
      //actualizo la tabla contapartidas solo los cargos y los abonos
      $this->db->query("update contapartidas set abonos = '$totalAbonos', cargos = '$totalCargos', procesada_partida = CONCAT('-', procesada_partida) where id = '$idPartida'");
      
      //actualizo la tabla ban_cheque
      $this->db->query("update ban_cheque set id_partida = '$idPartida', impreso = 1  where id_partida is NULL AND id_cheque = '$idChequeNoProcesado'");
      
      //inserto los demas detalles de esta partida en la tabla contadetallepartidas
      $this->db->query("insert into contadetallepartidas(partida, cuenta, codigocuenta, nombrecuenta, concepto, cargo, abono) values('$idPartida', '$datosAguardarDetalle[id]', '$datosAguardarDetalle[codigo]', '$datosAguardarDetalle[nombre]', '$datosAguardarDetalle[conceptoDetalle]', '$datosAguardarDetalle[cargo]', '$datosAguardarDetalle[abono]')");
    //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }  
      
      
    }
  public function GuardarYcontabilizarCXP($idPartida, $idCcontable,  $codigoContable, $nombreContable, $concepto, $cargo, $abono, $totalCargos, $totalAbonos, $idChequeNoProcesado, $idProveedor)
    {
       
       //inicio transaccion
      $this->db->trans_start();
      
      //actualizo la tabla contapartidas solo los cargos y los abonos
      $this->db->query("update contapartidas set abonos = '$totalAbonos', cargos = '$totalCargos', procesada_partida = CONCAT('-', procesada_partida)  where id = '$idPartida'");
      
      //actualizo la tabla ban_cheque
      $this->db->query("update ban_cheque set id_partida = '$idPartida' where id_partida is NULL AND id_cheque = '$idChequeNoProcesado'");
      
      //inserto los demas detalles de esta partida en la tabla contadetallepartidas
      $this->db->query("insert into contadetallepartidas(partida, cuenta, codigocuenta, nombrecuenta, concepto, cargo, abono) values('$idPartida', '$idCcontable', '$codigoContable', '$nombreContable', '$concepto', '$cargo', '$abono')");
    
    /*inserto en la tabla cuentasxpagar
      $this->db->query("insert into cuentasxpagar(cliente, tipomovimiento, fecha, abono, concepto, partida) values('$idProveedor', 'A', 'NOW()', '$abono', '$concepto', '$idPartida')");   */
      
    //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }  
      
      
    }
public function InsertarParaCuadrarPartida($idDelaParidaPorCheque, $idCuetnaProveedor,  $codigoCuentaProveedor, $nombreCuentaProveedor, $concepto, $monto, $maxIdUltimoCheque, $esTrasfeEntreCuentasCXP)
    {
       
       //inicio transaccion
      $this->db->trans_start();
      
      //actualizo la tabla contapartidas solo los cargos y los abonos
      $this->db->query("update contapartidas set abonos = '$monto', cargos = '$monto', procesada_partida = CONCAT('-', procesada_partida)  where id = '$idDelaParidaPorCheque'");
      
	  //si $esTrasfeEntreCuentasCXP = 1 es proque es trasnferencia entre cuantas bancarias de CXP
	  //actualizo el campo impreso = 8 para saber qe es un trasferencia
	  if($esTrasfeEntreCuentasCXP == 1)
		{
		  //actualizo la tabla ban_cheque
		  $this->db->query("update ban_cheque set id_partida = '$idDelaParidaPorCheque', impreso = 8 where id_partida is NULL AND id_cheque = '$maxIdUltimoCheque'");
		}
	  else
		{
			//actualizo la tabla ban_cheque
		  $this->db->query("update ban_cheque set id_partida = '$idDelaParidaPorCheque', impreso = 1 where id_partida is NULL AND id_cheque = '$maxIdUltimoCheque'");
		}
      //inserto los demas detalles de esta partida en la tabla contadetallepartidas
      $this->db->query("insert into contadetallepartidas(partida, cuenta, codigocuenta, nombrecuenta, concepto, cargo) values('$idDelaParidaPorCheque', '$idCuetnaProveedor', '$codigoCuentaProveedor', '$nombreCuentaProveedor', '$concepto', '$monto')");
    
    /*inserto en la tabla cuentasxpagar
      $this->db->query("insert into cuentasxpagar(cliente, tipomovimiento, fecha, abono, concepto, partida) values('$idProveedor', 'A', 'NOW()', '$abono', '$concepto', '$idPartida')");   */
      
    //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }  
      
      
    }
  public function InsertarAbonos(array $enviarDatosAfuncion = array(), $idProveedor, $idDelaParidaPorCheque, $fecha, $concepto)
    {
      $datosAguardarAbonos = array(
               //tabla  contadetallepartidas
              "id"=> $enviarDatosAfuncion["id"],
              "documento"=> $enviarDatosAfuncion["documento"],
              'referencia'=> $enviarDatosAfuncion["referencia"],
              //"cargo"=>$enviarDatosAfuncion["cargo"],
              "abono"=>str_replace(',', '',$enviarDatosAfuncion["abono"])
              );
       
       //inicio transaccion
      $this->db->trans_start();
      $this->db->query("insert into cuentasxpagar(
                                  cliente, tipomovimiento, 
                                  fecha, abono, partida,
                                  concepto, referencia) 
                            values('$idProveedor', 'A', 
                                  '$fecha', '$datosAguardarAbonos[abono]',
                                  '$idDelaParidaPorCheque',
                                  '$concepto', 
                                  '$datosAguardarAbonos[referencia]')");
      $this->db->query("update cuentasxpagar set abono = (abono + '$datosAguardarAbonos[abono]') where id = '$enviarDatosAfuncion[id]' and tipomovimiento = 'C'");
      
      /*inico*/
      //traigo la comparacion de los abonos y cargos para ver si ya son iguales y queden cancelados
      $resultado = $this->db->query("SELECT IF(abono = cargo, 1, 0) AS SALDADO FROM cuentasxpagar WHERE id ='$enviarDatosAfuncion[id]'");
      
      $datosEnArray = array();
      if($resultado->num_rows() > 0)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
            $datosEnArray[] = $filasEncontradas;
            }
        }
       $comparacionSaldo = $datosEnArray[0]->SALDADO;
       /*fin*/
       
       if($comparacionSaldo == 1)//el saldo y el abono son iguales
        {
          $this->db->query("update cuentasxpagar set cancelado = 1, fechacancelado = '$fecha' where id = '$enviarDatosAfuncion[id]'");
        }
    
      /*$this->db->set("cliente", $datosAguardarAbonos["id"]);
      $this->db->set("tipomovimiento", "A");
      $this->db->set("fecha", $fecha);
      $this->db->set("abono", $datosAguardarAbonos["abono"]);
      $this->db->set("partida", $idDelaParidaPorCheque);
      $this->db->set("concepto", $concepto);
      $this->db->set("referencia", $datosAguardarAbonos["referencia"]);
      
      $insertar = $this->db->insert("cuentasxpagar");//nombre de la tabla
      */
      
      //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }  
      
    }
 public function InsertarTiposTransaccion($tipoTransaccion, $tipoPartida, $transaccionSaldos)
  {
    $insertar = $this->db->query("SELECT fu_insertar_tipo_transaccion('$tipoTransaccion', $tipoPartida,$transaccionSaldos) AS RETORNO");
    $datosEnArray = array();
      if($insertar->num_rows() > 0)
        {
          foreach ($insertar->result() as $filasEncontradas)
            {
            $datosEnArray[] = $filasEncontradas;
            }
        }
      return $datosEnArray;
  }
 public function InsertarNuevaPartidaTransaccionBancaria($fecha, $fechaContable, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $contabilizar, $siConciliacion, $idUsuario, $userName, $cuenta, $idCuentaContable, $tipoTransaccion, $maxIdUltimoIdTransaccion) //$idUltimoCheque)
    {
      
     
      $horaYfecha = date("Y-m-d H:i:s");
      $elConcepto = $concepto. " Valor ".$monto;
      
      //inicio transaccion
      $this->db->trans_start();
      
      $this->db->query("insert into contapartidas(fecha, tipopartida, correlativo, concepto, usuario, es_transaccion) values('$fechaContable', '$tipoPartida', '$numeroSiguienteCorrelativoPartida', '$elConcepto', '$idUsuario', '$maxIdUltimoIdTransaccion')");
      //insertando en la tabla ban_transaccion
      $this->db->query("insert into ban_transaccion(fecha, fecha_contable, concepto, valor, incluir_conciliacion, contabilizar, creado_por,  fecha_creacion, id_cuenta_bancaria, id_tipo_partida, id_tipo) values('$fecha', '$fechaContable', '$concepto', '$monto', '$siConciliacion', '$contabilizar', '$userName', '$horaYfecha', '$cuenta' , '$tipoPartida', '$tipoTransaccion')");
     
      $this->db->trans_complete();
      //finaliza transaccion
      
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }

      
    }
public function InsertarCargoAcuentaBancariaTransaccion($fecha, $fechaContable, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $contabilizar, $siConciliacion, $userName, $idCuentaBancairiaOtraTrnasferir, $tipoTransaccion, $idDelaParidaPorTransaccion) //$idUltimoCheque)
    {
      
     
      $horaYfecha = date("Y-m-d H:i:s");
      $elConcepto = $concepto. ", transferencia a cuenta. Valor $ ".$monto;
      
      //inicio transaccion
      $this->db->trans_start();
      
      //insertando en la tabla ban_transaccion
      $this->db->query("insert into ban_transaccion(fecha, fecha_contable, concepto, valor, incluir_conciliacion, contabilizar, creado_por,  fecha_creacion, modificado_por, id_cuenta_bancaria, id_tipo_partida, id_tipo, id_partida, numero_partida) values('$fecha', '$fechaContable', '$concepto', '$monto', '$siConciliacion', '$contabilizar', '$userName', '$horaYfecha', '-1029', '$idCuentaBancairiaOtraTrnasferir' , '$tipoPartida', '$tipoTransaccion',  '$idDelaParidaPorTransaccion', '$numeroSiguienteCorrelativoPartida')");
     
      $this->db->trans_complete();
      //finaliza transaccion
      
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }

      
    }
public function InsertarNuevaPartidaTransaccionBancariaNoContablizadaAlInicio($fechaContable, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $cuenta, $idCuentaContable, $tipoTransaccion, $maxIdUltimoIdTransaccion) //$idUltimoCheque)
    {
      
     
      $horaYfecha = date("Y-m-d H:i:s");
      $elConcepto = $concepto. " Valor $ ".$monto;
      $idUsuario  = $this->session->userdata('id');
	  
      //inicio transaccion
      $this->db->trans_start();
      
      $this->db->query("insert into contapartidas(fecha, tipopartida, correlativo, concepto, usuario, es_transaccion) values('$fechaContable', '$tipoPartida', '$numeroSiguienteCorrelativoPartida', '$elConcepto', '$idUsuario', '$maxIdUltimoIdTransaccion')");
   
      $this->db->trans_complete();
      //finaliza transaccion
      
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }

      
    }
  public function InsertarDetalleTransaccion($concepto, $montoDebe, $montoHaber, $idCuentaContable, $idDelaParidaPorTransaccion, $idCuenta, $codigoCuenta, $nombreCuenta, $maxIdUltimoIdTransaccion, $monto)
    {
       $idTransaccion = time();
       $horaYfecha    = date("Y-m-d H:i:s");
       $usuario       = $this->session->userdata("username");   
      //inicio transaccion
      $this->db->trans_start();
      
      //inserto en la tabla ban_transacciones_detalle
      $this->db->query("insert into ban_transacciones_detalle(id_transaccion, id_detalle, id_cuenta_contable, referencia, concepto, debe, haber, creado_por, fecha_hora_creacion) values('$maxIdUltimoIdTransaccion', '$idTransaccion', '$idCuentaContable', '$concepto', '$concepto', '$montoDebe', '$montoHaber', '$usuario', '$horaYfecha' )");
      
      //inserto en la tabla contapartidadetalles
      $this->db->query("insert into contadetallepartidas(partida, cuenta, codigocuenta, nombrecuenta, concepto, abono, cargo) values('$idDelaParidaPorTransaccion', '$idCuenta', '$codigoCuenta', '$nombreCuenta', '$concepto valor $monto', '$montoHaber', '$montoDebe')");
      
      //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }
    }
 public function InsertarDetalleTransaccionTransferenciaEntreCuentas($concepto, $monto, $idCuentaContableT, $idUltimoTransaccionTra)
    {
       $idTransaccion = time() + 1;//para qeu no se me duplique ya es es unicio en la tabal ban_transacciones_detalle
       //$horaYfecha    = date("Y-m-d H:i:s");
       $usuario       = $this->session->userdata("username");   
      //inicio transaccion
      $this->db->trans_start();
      
      //inserto en la tabla ban_transacciones_detalle
      $this->db->query("insert into ban_transacciones_detalle(id_transaccion, id_detalle, id_cuenta_contable, referencia, concepto, debe,  creado_por) values('$idUltimoTransaccionTra', '$idTransaccion', '$idCuentaContableT', '$concepto', '$concepto', '$monto', '$usuario')");
   
      //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }
    }
 public function InsertarDetalleTransaccionNoContabilizadaAlInicio($concepto, $montoDebe, $montoHaber, $idDelaParidaPorTransaccion, $idCuenta, $codigoCuenta, $nombreCuenta, $monto)
    {
       $idTransaccion = time();
       $horaYfecha    = date("Y-m-d H:i:s");
       $usuario       = $this->session->userdata("username");   
      //inicio transaccion
      $this->db->trans_start(); 
      //inserto en la tabla contapartidadetalles
      $this->db->query("insert into contadetallepartidas(partida, cuenta, codigocuenta, nombrecuenta, concepto, abono, cargo) values('$idDelaParidaPorTransaccion', '$idCuenta', '$codigoCuenta', '$nombreCuenta', '$concepto valor $monto', '$montoHaber', '$montoDebe')");
      
      //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }
    }
    //////fucion que guarda la transaccion cuando se descchequea 
    //el chexbox no contabilizar
  public function InsertarNuevaPartidaTransaccionNoContabilizada($fechaBanco, $fechaContable, $concepto, $monto,  $siConciliacion, $contabilizar,  $userName, $cuenta, $tipoTransaccion, $tipoPartida)
    {
      
     
      $horaYfecha = date("Y-m-d H:i:s");
      $elConcepto = $concepto. " Valor ".$monto;
      
      //insertando en la tabla ban_cheque
      $resultado = $this->db->query("insert into ban_transaccion(fecha, fecha_contable, concepto, valor, incluir_conciliacion, contabilizar, creado_por,  fecha_creacion, id_cuenta_bancaria, id_tipo_partida, id_tipo) values('$fechaBanco', '$fechaContable', '$concepto', '$monto', '$siConciliacion', '$contabilizar', '$userName', '$horaYfecha', '$cuenta' , '$tipoPartida', '$tipoTransaccion')");
     
       if($resultado)
        {
          return true;
        }
       else
        {
          return false;
        }

      
    }
    //////fucion que guarda la transaccion cuando se descchequea 
    //el chexbox no contabilizar
 public function InsertarDetalleNoContabilizado($idCuentaContable, $concepto, $monto, $montoDebe, $montoHaber, $userName, $idUltimoTransaccion)
  {
      $horaYfecha = date("Y-m-d H:i:s");
      $elConcepto = $concepto. " Valor ".$monto;
      $idTransaccion = time();
      //insertando en la tabla ban_cheque
      $resultado = $this->db->query("insert into ban_transacciones_detalle(id_transaccion, id_detalle, id_cuenta_contable, referencia, concepto, debe, haber, creado_por, fecha_hora_creacion) values('$idUltimoTransaccion', '$idTransaccion', '$idCuentaContable', '$concepto', '$concepto', '$montoDebe', '$montoHaber', '$userName', '$horaYfecha' )");
      
     
       if($resultado)
        {
          return true;
        }
       else
        {
          return false;
        }
  }
 public function GuardarYcontabilizarTransaccion(array $enviarDatosAfuncion = array(), $idPartida, $totalCargos, $totalAbonos, $idTransaccionNoprocesada, $correlativoPartida)
    {
       $datosAguardarDetalle = array(
               //tabla  contadetallepartidas
              "id"    => $enviarDatosAfuncion["id"],
              "codigo" => $enviarDatosAfuncion["codigo"],
              'nombre'        => $enviarDatosAfuncion["nombre"],//["cantidad"] es el índice del array
              "conceptoDetalle"=>$enviarDatosAfuncion["conceptoDetalle"],
              "cargo"=>$enviarDatosAfuncion["cargo"],
              "abono"=>$enviarDatosAfuncion["abono"]
              );
       //inicio transaccion
      $this->db->trans_start();
      
      //actualizo la tabla contapartidas solo los cargos y los abonos
      $this->db->query("update contapartidas set abonos = '$totalAbonos', cargos = '$totalCargos', procesada_partida = '-7', es_transaccion = CONCAT('-', es_transaccion) where id = '$idPartida'");// el -7 era para identificar que era un transaccion luego agregue mejor un campo a la tabla contapartidas par lo de las trascciones asi es menos complicado actulizare el campo es_tranaccion al id de la transaccion pero en negativo para que no haya problems por si se crea un correlativo igual alguna vez
      
      //actualizo la tabla ban_transacciones
      $this->db->query("update ban_transaccion set id_partida = '$idPartida', numero_partida = '$correlativoPartida' where id_partida is NULL AND id_transaccion = '$idTransaccionNoprocesada'");
      
      //inserto los demas detalles de esta partida en la tabla contadetallepartidas
      $this->db->query("insert into contadetallepartidas(partida, cuenta, codigocuenta, nombrecuenta, concepto, cargo, abono) values('$idPartida', '$datosAguardarDetalle[id]', '$datosAguardarDetalle[codigo]', '$datosAguardarDetalle[nombre]', '$datosAguardarDetalle[conceptoDetalle]', '$datosAguardarDetalle[cargo]', '$datosAguardarDetalle[abono]')");
    //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }  
      
      
    }
 public function InsertarConciliacion($correlativo, $cuentaBancaria, $mesNumero, $annio, $saldoBanco, $fechaArreglada)
  {
    
    /*inico*/
      //traigo la suma de abosnos segun contabilidad
      $resultado = $this->db->query("CALL pa_sumar_saldo_segun_contabilidad('$cuentaBancaria','$fechaArreglada')");
      
      $datosEnArray = array();
      if($resultado->num_rows() > 0)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
            $datosEnArray[] = $filasEncontradas;
            }
        }
       $saldoSegunContabilidad = $datosEnArray[0]->SALDO_CONTABILIDAD;
        if($saldoSegunContabilidad == NULL)/*SI LA SUMA ME DEVUELVE UN VALOR NULL QUE COLOQUE 0 PARA QUE NO DE ERORA A LA HORA D INSERTAR*/
          {
             $saldoSegunContabilidad = 0;
          }
       /*fin*/
       
      /*inicio*/
      //traigo los depositos no contabilizado
       $resultadoDepositos = $this->db->query("CALL pa_sumar_depositos_no_contabilizados('$cuentaBancaria','$fechaArreglada')");
      
      $datosEnArrayDepositos = array();
      if($resultadoDepositos->num_rows() > 0)
        {
          foreach ($resultadoDepositos->result() as $filasEncontradasD)
            {
            $datosEnArrayDepositos[] = $filasEncontradasD;
            }
        }
       $depositosNoContabilizados = $datosEnArrayDepositos[0]->DEPOSITOS_NO_CONTABILIZADOS;
       if($depositosNoContabilizados == NULL)
        {
          $depositosNoContabilizados = 0;
        }
       /*fin*/
       
       /*inicio*/
      //traigo los cargos no contabilizado
       $resultadoCargos = $this->db->query("CALL pa_sumar_cargos_no_contabilizados('$cuentaBancaria','$fechaArreglada')");
      
      $datosEnArrayCargos = array();
      if($resultadoCargos->num_rows() > 0)
        {
          foreach ($resultadoCargos->result() as $filasEncontradasC)
            {
            $datosEnArrayCargos[] = $filasEncontradasC;
            }
        }
       $cargosNoContabilizados = $datosEnArrayCargos[0]->CARGOS_NO_CONTABILIZADOS;
       if($cargosNoContabilizados == NULL)
        {
          $cargosNoContabilizados = 0;
        }
       
       /*fin*/
       
       
       /*inicio*/
      //traigo los la suma de los depositos en transito--depositos pendientes de aplicar por el banco
       $resultadoDepositosTransito = $this->db->query("CALL pa_sumar_depositos_en_transito('$cuentaBancaria','$fechaArreglada')");
      
      $datosEnArrayDepositosTrnasito = array();
      if($resultadoDepositosTransito->num_rows() > 0)
        {
          foreach ($resultadoDepositosTransito->result() as $filasEncontradasDTran)
            {
            $datosEnArrayDepositosTrnasito[] = $filasEncontradasDTran;
            }
        }
       $depositosTranTrans  = $datosEnArrayDepositosTrnasito[0]->DEPOSITOS_EN_TRNASITO_TRANS;//nombre de la columan del resultado que arroja el pa
       $depositosTranChe    = $datosEnArrayDepositosTrnasito[0]->DEPOSITOS_EN_TRANSITO_CHEQUES;//nombre de la columan del resultado que arroja el pa
       $depositosTrnasito   = $depositosTranTrans +  $depositosTranChe;
       /*fin*/
       
       /*inicio*/
      //traigo los la suma de los cheques pendientes
       $resultadoChequesPendientes = $this->db->query("CALL pa_sumar_cheques_pendientes('$cuentaBancaria','$fechaArreglada')");
      
      $datosEnArrayChequesPendientes = array();
      if($resultadoChequesPendientes->num_rows() > 0)
        {
          foreach ($resultadoChequesPendientes->result() as $filasEncontradasCheP)
            {
            $datosEnArrayChequesPendientes[] = $filasEncontradasCheP;
            }
        }
       $chequesPendientes = $datosEnArrayChequesPendientes[0]->CHEQUES_PENDIENTES;//nombre de la columan del resultado que arroja el pa
       if($chequesPendientes == NULL)
        {
          $chequesPendientes= 0;
        }
       /*fin*/
       
       
       /*inicio*/
      //traigo los la suma de los cargas pendientes que son los abonos
       $resultadoCargosPen = $this->db->query("CALL pa_sumar_cargos_pendientes('$cuentaBancaria','$fechaArreglada')");
      
      $datosEnArrayCargosPen = array();
      if($resultadoCargosPen->num_rows() > 0)
        {
          foreach ($resultadoCargosPen->result() as $filasEncontradasCarPen)
            {
            $datosEnArrayCargosPen[] = $filasEncontradasCarPen;
            }
        }
       $cargosPendientes = $datosEnArrayCargosPen[0]->CARGOS_PENDIENTES;//nombre de la columan del resultado que arroja el pa
       if($cargosPendientes == NULL)
        {
          $cargosPendientes = 0;
        }
       
       /*fin*/
       
       
     /*inserto la conciliacion**/
      $this->db->set("correlativo", $correlativo);
      $this->db->set("mes", $mesNumero);
      $this->db->set("annio", $annio);
      $this->db->set("saldo_contable", $saldoSegunContabilidad);
      $this->db->set("cargos_no_contables", $cargosNoContabilizados);
      $this->db->set("depositos_no_contables", $depositosNoContabilizados);
      $this->db->set("cheques_pendientes", $chequesPendientes);
      $this->db->set("cargos_pendientes", $cargosPendientes);
      $this->db->set("depositos_pendientes", $depositosTrnasito);
      $this->db->set("saldo_banco", $saldoBanco);
      $this->db->set("id_cuenta_bancaria", $cuentaBancaria);
      
    
      
      $insertarConciliacion = $this->db->insert("ban_conciliaciones");//nombre de la tabla
      
      if($insertarConciliacion)
        {
          return true;
        }
      else
        {
          return false;
        }                                     
  }
 public function InsertarDetalleConciliacion($correlativoConciliacion, $idChOtrans, $numeorChequeOtransaccion, $concepto, $fecha, $valor, $tipo)
  {
     /*inicio*/
        //esta funcion me retornara el tipo de rugro
        /*son transacciones y busco que tipo son
          almacena el tipo de datos a conciliar, 
          3 = Depositos no contabilizados,  resmesas pendientes
          4= Cargos No Contabilizados,  cargos en cuenta aun no contabilizados
          2= Depositos en Transito PARA CHEQUES Y TRANSACCIONES, remesas
          1= Cheques Pendientes ESTO ES SOLO PARA CHEQUES,  ceques pendientos
          5= CARGOS PENDIENTES --caros contabilizados y pendientes a aplicar por el banco*/
       // $tipo   = $this->Mimodelobuscar->RetornarTipo($idChOtrans, $numeorChequeOtransaccion);
        /*fin*/
     
     /*inicio*/
     //veo si el $numeorChequeOtransaccion es diferente de 0 si es 0 es una transaccion si no es un cheque
     if($numeorChequeOtransaccion != 0)//es un cheque 
      {
        
        
        /*busco el el cheque*/
        /*$this->db->select("numero_cheque");
        $this->db->select("numero_cheque");
        $this->db->select("monto_cheque");
        $this->db->select("concepto_cheque");
        $this->db->select("fecha_emision");
        $this->db->where("id_cheque", $idChOtrans);
        $this->db->where("pagado_banco", 0);
        
        $resultado = $this->db->get("ban_cheque");//nombre de la tabla
        $datosEnArray = array();
      /*if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
            $datosEnArray[] = $filasEncontradas;
            }
        }*/
        $this->db->set("tipo", $tipo);
        $this->db->set("referencia", $numeorChequeOtransaccion);
        $this->db->set("concepto",$concepto);
        $this->db->set("fecha", $fecha);
        $this->db->set("valor", $valor);
        $this->db->set("correlativo_id_conciliacion", $correlativoConciliacion);
        
        //$insertar = $this->db->insert("ban_conciliacion_detalle");//nombre de la tabla;
      }
    else  /*son transacciones*/
      {
                
          
      
          /*busco la trnasacccion*/
        /*$this->db->select("id_transaccion");
        $this->db->select("fecha_contable");
        $this->db->select("valor");
        $this->db->select("concepto");
        //$this->db->select("fecha_emision");
        $this->db->where("id_transaccion", $idChOtrans);
        
        $resultado = $this->db->get("ban_transaccion");//nombre de la tabla
        $datosEnArray = array();
      if($resultado->num_rows() == 1)
        {
          foreach ($resultado->result() as $filasEncontradas)
            {
            $datosEnArray[] = $filasEncontradas;
            }
        } */
        $this->db->set("tipo",$tipo);
        $this->db->set("referencia", $idChOtrans);
        $this->db->set("concepto", $concepto);
        $this->db->set("fecha", $fecha);
        $this->db->set("valor", $valor);
        $this->db->set("correlativo_id_conciliacion", $correlativoConciliacion);
        

      }
    $insertar = $this->db->insert("ban_conciliacion_detalle");//nombre de la tabla;
     if($insertar)
      {
        return true;
      }
    else
      {
        return false;
      }
  } 
 public function InsertarLaNuevaConciliacion($mes, $annio)/*SIN USO*/  
  {
    $idConciliacion = time();
    $this->db->set("correlativo", $idConciliacion);
    $this->db->set("mes", $mes);
    $this->db->set("annio", $annio);
        

    $insertar = $this->db->insert("ban_conciliaciones");//nombre de la tabla;
     if($insertar)
      {
        return true;
      }
    else
      {
        return false;
      }
  }
  
  
  ///***************COMPRAS************************////////////
 public function RegistrarOrdenDeCompra($idComprobante, $idCondicionPago, $formaPago, $diasCredito, $centroCosto, $tipoComprobante, $codigoProveedor, $idProveedor, $nombreProveedor, $nit, $nrc, $condiconPago, $fecha, $solicitadaPor, $tamannoCotribuyente)//funcion que inserta el header de la tabla compras
  {
	
	  $usuario		= $this->session->userdata("username");
     //inicio transaccion
      $this->db->trans_start();
      /*NO ERA NECESARIO EN TRASACCION SOLO ES UNA SENTENCIA*/
      //inserto en la tabla con_compras
	  $this->db->query("insert into con_compra(id_comprobante, id_tipo_comprobante,
							fecha, id_proveedor, codigo_proveedor, 
							nombre, nrc, nit,
							id_forma_pago, dias_credito, 
							creada_por, solicitada_por, id_centro_costo)
						values($idComprobante, '$tipoComprobante', '$fecha', 
							  '$idProveedor', '$codigoProveedor', '$nombreProveedor', 
							  '$nrc', '$nit', '$formaPago', 
							  '$diasCredito', '$usuario', '$solicitadaPor', '$centroCosto' )");
	
       //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true;
            
          }  
  }
 
  public function RegistrarDetalleCompra(array $enviarDatosAfuncion = array(), $idCompra, $idCuentaContable)
    {
       $datosAguardarDetalle = array(
               
              //"corelativo"    => $enviarDatosAfuncion["corelativo"],
              "id" =>$enviarDatosAfuncion["id"],
              "codigo" =>$enviarDatosAfuncion["codigo"],
              "descripcion" =>addslashes($enviarDatosAfuncion["descripcion"]), //addslashes permite la ' simple o otros carracteres que perjudican una inserción o actualizacion
			  "costo" =>$enviarDatosAfuncion["costo"],
			  "idcompra"=>$enviarDatosAfuncion["idcompra"],
			  "cantidad"=>$enviarDatosAfuncion["cantidad"],
			  "subtotal"=>$enviarDatosAfuncion["subtotal"]
              );
		
		 //veo por cada producto si se ha modificado el precio original
		 $codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($datosAguardarDetalle["id"]);
		 $costoOriginal			  = $codiogoProductoAbuscar[0]->costo;		
	
		$usuario		 = $this->session->userdata("username");
		$fechaCreacion	 = date("Y-m-d H:i:s");
			  
       //inicio transaccion
      $this->db->trans_start();
		
		if($costoOriginal != $datosAguardarDetalle["costo"])//is el costo original es de distinto al traido en los detalles, es porque se ha modificado el costo, si es asi,
		//actulizo la tabla de materiales con el nuvo costo, si no el costo se mantiene
			{
				$this->db->query("update materiales set costo = '$datosAguardarDetalle[costo]'
									where id = '$datosAguardarDetalle[id]'");
			}
			
			
      //inserto los demas detalles de esta compra en la tabla con_compra_detalle
      $this->db->query("insert into con_compra_detalle(id_comprobante, id_producto,
						cantidad, descripcion,
						precio_unitario, valor_afecto,
						creado_por,	fecha_hora_creacion, 
						id_cuenta_contable) 
						values('$idCompra', '$datosAguardarDetalle[id]', '$datosAguardarDetalle[cantidad]', '$datosAguardarDetalle[descripcion]', 
						'$datosAguardarDetalle[costo]', '$datosAguardarDetalle[subtotal]',
						'$usuario', '$fechaCreacion', '$idCuentaContable')");
    //completo la transaccion
       $this->db->trans_complete();
      //comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar mesnajes
            
          }
        else
          {
            
           return true; //todo se ejecuto satisfactoriamente
            
          }  
      
      
    }
public function InsertarPartidaCompraCredito($idComprobante, $ultimoIDPartida, $tipoPartida, $numeroSiguienteCorrelativoPartida, $idCuentaContable, $codigoCuentaContable, $nombreCuentaContable, $idCuentaContableIVA, $codigoCuentaContableIVA, $nombreCuentaContableIVA, $idCuentaContableProveedores, $codigoCuentaContableProveedores, $nombreCuentaContableProveedores, $idCuentaContableIVAretenido, $codigoCuentaContableIVAretenido, $nombreCuentaContableIVAretenido, $serieDocumento, $numeroDocumento, $fechaDocumento, $fechaActual, $concepto, $totalAfecto, $iva, $ivaRetenido, $totalSinIva, $idProveedor, $nombreProveedor, $alContadoOcredito, $siguienteCorrelativoPorMes)
	{
		$usuario 			= $this->session->userdata("id");
		$abonoProveedor		= $totalAfecto;
		$elConceptoCargo 	= $serieDocumento.", ".$nombreProveedor.", ".$concepto;
	  //inicio transaccion
      $this->db->trans_start();
	  
		//actualizo la tabla con_compra
		$this->db->query("update con_compra set correlativo = '$siguienteCorrelativoPorMes',
							serie = '$serieDocumento', 
						    numero = '$numeroDocumento',
						fecha_contable = '$fechaActual', estado_compra = 3 where id_comprobante = '$idComprobante'");
						
		//inserto en la tabla contapartidas
		$this->db->query("insert into contapartidas
							(fecha, tipopartida, 
							 correlativo, concepto, 
							 abonos, cargos,
							 usuario)
						values('$fechaActual', '$tipoPartida', 
								'$numeroSiguienteCorrelativoPartida', '$concepto',
								'$totalAfecto', '$totalAfecto',
								'$usuario')");
		
		//inserto en la tabla detallepartidas la cuetna del costo gasto CARGADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContable', 
								'$codigoCuentaContable', '$nombreCuentaContable', 
								'$concepto', '$totalSinIva', 
								'0.00')");
		
		//inserto en la tabla detallepartidas la cuenta del credito fiscal CARGADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableIVA', 
								'$codigoCuentaContableIVA', '$nombreCuentaContableIVA', 
								'$concepto', '$iva', 
								'0.00')");
								
		//inserto en la tabla detallepartidas la cuenta de los proveedores  ABONADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableProveedores', 
								'$codigoCuentaContableProveedores', '$nombreCuentaContableProveedores', 
								'$concepto', '00.00', 
								'$abonoProveedor')");
								
		//inserto en la tabla detallepartidas la cuenta de iva retenido 1%  ABONADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableIVAretenido', 
								'$codigoCuentaContableIVAretenido', '$nombreCuentaContableIVAretenido', 
								'$concepto', '00.00', 
								'$ivaRetenido')");
		
		//evaluo si es al credito o al contado
		//aunque ya sea al credito o al contado simpre se ira a la cuenta por pagar
		//pero si es al credito los saldos seran iguales para cuando se muestren
		//los registros a hacer abono al proveedor ya no muestre el que fue al contado
		if($alContadoOcredito > 0)//si los dias son mayores a 0 es al credito
			{
				///inserto en la tabla cuentasxpagar
				$this->db->query("insert into cuentasxpagar
									(cliente, tipomovimiento,
									 fecha, cargo,
									 documento, concepto)
								 values('$idProveedor', 'C',
										'$fechaActual', '$totalAfecto',
										'$serieDocumento', '$elConceptoCargo')");
			}
		else
			{
				//es al contado dias = 0
				//inserto simpre en la tabla cuentasxpagar pero igualo los valores
				//el cargo = al abono
				///inserto en la tabla cuentasxpagar
				$this->db->query("insert into cuentasxpagar
									(cliente, tipomovimiento,
									 fecha, cargo, 
									 abono, cancelado,
									 documento, concepto)
								 values('$idProveedor', 'C',
										'$fechaActual', '$totalAfecto', 
										'$totalAfecto', '1',
										'$serieDocumento', '$elConceptoCargo')");
			}
		
		//completo la transaccion
		$this->db->trans_complete();
		
		//comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar menSajes al enviar el false
            
          }
        else
          {
            
           return true;
            
          }  
	}
	//funcion que insrta la compra pero si el documento es NOTA DE CREDITO NC
	//lo abonado cargado y lo cargado abonado lo contrario de un ccf
public function InsertarPartidaCompraCreditoNC($idComprobante, $ultimoIDPartida, $tipoPartida, $numeroSiguienteCorrelativoPartida, $idCuentaContable, $codigoCuentaContable, $nombreCuentaContable, $idCuentaContableIVA, $codigoCuentaContableIVA, $nombreCuentaContableIVA, $idCuentaContableProveedores, $codigoCuentaContableProveedores, $nombreCuentaContableProveedores, $idCuentaContableIVAretenido, $codigoCuentaContableIVAretenido, $nombreCuentaContableIVAretenido, $serieDocumento, $numeroDocumento, $fechaDocumento, $fechaActual, $concepto, $totalAfecto, $iva, $ivaRetenido, $totalSinIva, $idProveedor, $nombreProveedor)//SIN USO
	{
		$usuario 			= $this->session->userdata("id");
		$abonoProveedor		= $totalAfecto  - $ivaRetenido;
		$elConceptoCargo 	= $serieDocumento.", ".$nombreProveedor.", ".$concepto;
	  //inicio transaccion
      $this->db->trans_start();
	  
		//actualizo la tabla con_compra
		$this->db->query("update con_compra set serie = '$serieDocumento', numero = '$numeroDocumento',
						fecha_contable = '$fechaActual', estado_compra = 3 where id_comprobante = '$idComprobante'");
						
		//inserto en la tabla contapartidas
		$this->db->query("insert into contapartidas
							(fecha, tipopartida, 
							 correlativo, concepto, 
							 abonos, cargos,
							 usuario)
						values('$fechaActual', '$tipoPartida', 
								'$numeroSiguienteCorrelativoPartida', '$concepto',
								'$totalAfecto', '$totalAfecto',
								'$usuario')");
						
		//inserto en la tabla detallepartidas la cuenta de los proveedores  CARGADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableProveedores', 
								'$codigoCuentaContableProveedores', '$nombreCuentaContableProveedores', 
								'$concepto', '$abonoProveedor', 
								'00.00')");
								
		//inserto en la tabla detallepartidas la cuenta de iva retenido 1%  CARGADO
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableIVAretenido', 
								'$codigoCuentaContableIVAretenido', '$nombreCuentaContableIVAretenido', 
								'$concepto', '$ivaRetenido', 
								'00.00')");
		
			//inserto en la tabla detallepartidas la cuetna del costo gasto ABONADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContable', 
								'$codigoCuentaContable', '$nombreCuentaContable', 
								'$concepto', '0.00', 
								'$totalSinIva')");
		
		//inserto en la tabla detallepartidas la cuenta del credito fiscal ABONADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableIVA', 
								'$codigoCuentaContableIVA', '$nombreCuentaContableIVA', 
								'$concepto', '0.00', 
								'$iva')");
		
		///inserto en la tabla cuentasxpagar
		$this->db->query("insert into cuentasxpagar
							(cliente, tipomovimiento,
							 fecha, cargo,
							 documento, concepto)
						 values('$idProveedor', 'C',
								'$fechaActual', '$totalAfecto',
								'$serieDocumento', '$elConceptoCargo')");
		
		//completo la transaccion
		$this->db->trans_complete();
		
		//comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar menSajes al enviar el false
            
          }
        else
          {
            
           return true;
            
          }  
	}
public function InsertarPartidaDocumentoFactura($idComprobante, $ultimoIDPartida, $tipoPartida, $numeroSiguienteCorrelativoPartida, $idCuentaContable, $codigoCuentaContable, $nombreCuentaContable, $idCuentaContableProveedores, $codigoCuentaContableProveedores, $nombreCuentaContableProveedores, $idCuentaContableIVAretenido, $codigoCuentaContableIVAretenido, $nombreCuentaContableIVAretenido, $serieDocumento, $numeroDocumento, $fechaDocumento, $fechaActual, $concepto, $totalAfecto, $iva, $ivaRetenido, $totalSinIva, $idProveedor, $nombreProveedor, $alContadoOcredito, $siguienteCorrelativoPorMes)
	{
		$usuario 			= $this->session->userdata("id");
		$abonoProveedor		= $totalAfecto  - $ivaRetenido;
		$elConceptoCargo 	= $serieDocumento.", ".$nombreProveedor.", ".$concepto;
	  //inicio transaccion
      $this->db->trans_start();
	  
		//actualizo la tabla con_compra
		$this->db->query("update con_compra set correlativo = '$siguienteCorrelativoPorMes',
							serie = '$serieDocumento', numero = '$numeroDocumento',
							fecha_contable = '$fechaActual', estado_compra = 3 where id_comprobante = '$idComprobante'");
						
		//inserto en la tabla contapartidas
		$this->db->query("insert into contapartidas
							(fecha, tipopartida, 
							 correlativo, concepto, 
							 abonos, cargos,
							 usuario)
						values('$fechaActual', '$tipoPartida', 
								'$numeroSiguienteCorrelativoPartida', '$concepto',
								'$totalAfecto', '$totalAfecto',
								'$usuario')");
		
		//inserto en la tabla detallepartidas la cuetna del costo gasto CARGADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContable', 
								'$codigoCuentaContable', '$nombreCuentaContable', 
								'$concepto', '$totalAfecto', 
								'0.00')");
		
		
								
		//inserto en la tabla detallepartidas la cuenta de los proveedores  ABONADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableProveedores', 
								'$codigoCuentaContableProveedores', '$nombreCuentaContableProveedores', 
								'$concepto', '00.00', 
								'$abonoProveedor')");
								
		//inserto en la tabla detallepartidas la cuenta de iva retenido 1%  ABONADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableIVAretenido', 
								'$codigoCuentaContableIVAretenido', '$nombreCuentaContableIVAretenido', 
								'$concepto', '00.00', 
								'$ivaRetenido')");
		
		//evaluo si es al credito o al contado
		//aunque ya sea al credito o al contado simpre se ira a la cuenta por pagar
		//pero si es al credito los saldos seran iguales para cuando se muestren
		//los registros a hacer abono al proveedor ya no muestre el que fue al contado
		if($alContadoOcredito > 0)//si los dias son mayores a 0 es al credito
			{
				///inserto en la tabla cuentasxpagar
				$this->db->query("insert into cuentasxpagar
									(cliente, tipomovimiento,
									 fecha, cargo,
									 documento, concepto)
								 values('$idProveedor', 'C',
										'$fechaActual', '$totalAfecto',
										'$serieDocumento', '$elConceptoCargo')");
			}
		else
			{
				//es al contado dias = 0
				//inserto simpre en la tabla cuentasxpagar pero igualo los valores
				//el cargo = al abono
				///inserto en la tabla cuentasxpagar
				$this->db->query("insert into cuentasxpagar
									(cliente, tipomovimiento,
									 fecha, cargo, 
									 abono, cancelado,
									 documento, concepto)
								 values('$idProveedor', 'C',
										'$fechaActual', '$totalAfecto', 
										'$totalAfecto', '1',
										'$serieDocumento', '$elConceptoCargo')");
			}
		
		//completo la transaccion
		$this->db->trans_complete();
		
		//comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar menSajes al enviar el false
            
          }
        else
          {
            
           return true;
            
          }  
	}
public function InsertarPartidaDocumentoRecibo($idComprobante, $ultimoIDPartida, $tipoPartida, $numeroSiguienteCorrelativoPartida, $idCuentaContable, $codigoCuentaContable, $nombreCuentaContable, $idCuentaContableProveedores, $codigoCuentaContableProveedores, $nombreCuentaContableProveedores, $serieDocumento, $numeroDocumento, $fechaDocumento, $fechaActual, $concepto, $totalAfecto, $idProveedor, $nombreProveedor, $alContadoOcredito)
	{
		$usuario 			= $this->session->userdata("id");
		$elConceptoCargo 	= $serieDocumento.", ".$nombreProveedor.", ".$concepto;
	  //inicio transaccion
      $this->db->trans_start();
	  
		//actualizo la tabla con_compra
		$this->db->query("update con_compra set serie = '$serieDocumento', numero = '$numeroDocumento',
						fecha_contable = '$fechaActual', estado_compra = 3 where id_comprobante = '$idComprobante'");
						
		//inserto en la tabla contapartidas
		$this->db->query("insert into contapartidas
							(fecha, tipopartida, 
							 correlativo, concepto, 
							 abonos, cargos,
							 usuario)
						values('$fechaActual', '$tipoPartida', 
								'$numeroSiguienteCorrelativoPartida', '$concepto',
								'$totalAfecto', '$totalAfecto',
								'$usuario')");
		
		//inserto en la tabla detallepartidas la cuetna del costo gasto CARGADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContable', 
								'$codigoCuentaContable', '$nombreCuentaContable', 
								'$concepto', '$totalAfecto', 
								'0.00')");
		
		
								
		//inserto en la tabla detallepartidas la cuenta de los proveedores  ABONADA
		$this->db->query("insert into contadetallepartidas
							(partida, cuenta,
							 codigocuenta, nombrecuenta, 
							 concepto, cargo,
							 abono)
						values('$ultimoIDPartida', '$idCuentaContableProveedores', 
								'$codigoCuentaContableProveedores', '$nombreCuentaContableProveedores', 
								'$concepto', '00.00', 
								'$totalAfecto')");
								
		//evaluo si es al credito o al contado
		//aunque ya sea al credito o al contado simpre se ira a la cuenta por pagar
		//pero si es al credito los saldos seran iguales para cuando se muestren
		//los registros a hacer abono al proveedor ya no muestre el que fue al contado
		if($alContadoOcredito > 0)//si los dias son mayores a 0 es al credito
			{
				///inserto en la tabla cuentasxpagar
				$this->db->query("insert into cuentasxpagar
									(cliente, tipomovimiento,
									 fecha, cargo,
									 documento, concepto)
								 values('$idProveedor', 'C',
										'$fechaActual', '$totalAfecto',
										'$serieDocumento', '$elConceptoCargo')");
			
			}
		else
			{
				//es al contado dias = 0
				//inserto simpre en la tabla cuentasxpagar pero igualo los valores
				//el cargo = al abono
				///inserto en la tabla cuentasxpagar
				$this->db->query("insert into cuentasxpagar
									(cliente, tipomovimiento,
									 fecha, cargo, 
									 abono, cancelado,
									 documento, concepto)
								 values('$idProveedor', 'C',
										'$fechaActual', '$totalAfecto', 
										'$totalAfecto', '1',
										'$serieDocumento', '$elConceptoCargo')");
			}
		//completo la transaccion
		$this->db->trans_complete();
		
		//comprobamos si se han llevado a cabo correctamente todas
        //las consultas
        if ($this->db->trans_status() === FALSE)
          {
            return false;//si hubo errores mostrar menSajes al enviar el false
            
          }
        else
          {
            
           return true;
            
          }  
	}
public function InsertarProductoServicio($categoria, $codigoProductoServicio, $unidadMedida, $costo, $descripcion)
	{
		$idUsuario = $this->session->userdata("id");
		$this->db->set("codigo", $codigoProductoServicio);
		$this->db->set("descripcion", $descripcion);
		$this->db->set("unidad", $unidadMedida);
		$this->db->set("costo", $costo);
		$this->db->set("categoria", $categoria);
		$this->db->set("id_usuario", $idUsuario);
		
		$insertar = $this->db->insert("materiales");
		if($insertar)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
public function InsertarCentroCosto($codigoCentroCosto, $descripcion)
	{
		$idUsuario = $this->session->userdata("id");
		$this->db->set("codigo", $codigoCentroCosto);
		$this->db->set("descripcion", $descripcion);
		$this->db->set("id_usuario", $idUsuario);
		
		$insertar = $this->db->insert("contacentroscostos");
		if($insertar)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
                
}
?>