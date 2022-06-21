<?php
class Mimodeloactualizar extends CI_Model
{
  public function ActualizarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida)
    {
      $mes  = substr($fecha,5,2); //extraigo la porcion del mes
		  $anio = substr($fecha,0,4); //extraigo la porcion del año
      $this->db->set("correlativo", $numeroSiguienteCorrelativoPartida);
      $this->db->where('tipopartida', $tipoPartida);
      $this->db->where('mes', $mes);
      $this->db->where('anio', $anio);
      
      $actualizar = $this->db->update("contacorrelativos");   
    }
  public function ActualizarChequeImpreso($idCheque)
    {
      $this->db->set("impreso", 0);//ya esta impreso
      $this->db->where("id_cheque", $idCheque);
      $actualizar = $this->db->update("ban_cheque");
    }
  public function ActualizarEstadoConciliacion($idConciliacion, $mes, $annio)
    {
      /*$this->db->set("conciliacion_cerrada", 0);
      $this->db->where("correlativo", $idConciliacion);
      
      $actualizar = $this->db->update("ban_conciliaciones");//nombre de la tabla
      if($actualizar)
        {
          return true;
        }
      else
        {
          return false;
        } */
        
        $nuecoIdConciliacion = time();
       //inicio transaccion
      $this->db->trans_start();
      
      //actualizo la tabla conciliaciones
      $this->db->query("update ban_conciliaciones set conciliacion_cerrada = 0 where correlativo = '$idConciliacion'");
      
    
      //inserto la nueva conciliacion
      $this->db->query("insert into ban_conciliaciones(correlativo, mes, annio) values('$nuecoIdConciliacion', '$mes', '$annio')");
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
  public function ActualizarRegistrosAconciliadosTransaccion($idTrasOcheque)
    {
      $this->db->set("procesada_banco", 1);//que ya esta conciliado
      $this->db->where("id_transaccion", $idTrasOcheque);
      
      $actualizar = $this->db->update("ban_transaccion");//nombre de la tabla
      if($actualizar)
        {
          return true;
        }
      else
        {
          return false;
        }
    }
  public function ActualizarRegistrosAconciliadosCheques($idTrasOcheque)
    {
      $this->db->set("pagado_banco", 1); // que ya esta conciliado
      $this->db->where("id_cheque", $idTrasOcheque);
      
      $actualizar = $this->db->update("ban_cheque");//nombre de la tabla
      if($actualizar)
        {
          return true;
        }
      else
        {
          return false;
        }
    }
  public function AnularChequeTransferencia($idChequeOtransaferencia, $motivoAnulacion)
    {
      $buscarSiChequeOtransferenciaEsCXP = $this->Mimodelobuscar->BuscarSiEsCXP($idChequeOtransaferencia);
      $resultadoCount                    = $buscarSiChequeOtransferenciaEsCXP[0]->RESULTADO;
      $idPartida                         = $buscarSiChequeOtransferenciaEsCXP[0]->id_partida;
	  
	  //veo si la partida tiene dos registros para anular la otra trasferencia del banco que no se ve en las vistas
	  $verSiHayDosRegistro				= $this->Mimodelobuscar->VerSiHayDosIdDePartidas($idPartida);
	  $resultado						= $verSiHayDosRegistro[0]->RESULTADO;
	  $idOtroChque						= $verSiHayDosRegistro[0]->ID_CHQUE_OTRO;
      
      ///inicio la transaccion
      $this->db->trans_start();
      
      //actualizo la tabla ban_cheque
      $this->db->query("update ban_cheque set monto_cheque = 0, impreso = 0, anulado_cheque = 1, facha_anulacion_cheque = NOW(), motivo_anulacion = '$motivoAnulacion' where id_cheque = '$idChequeOtransaferencia'");
      
      //actualizo la tabla detalle cheque
      $this->db->query("update ban_detalle_cheque set debe = 0, haber = 0 where id_cheque = '$idChequeOtransaferencia'");
      
      //actualizo la tabla partidas
      $this->db->query("update contapartidas set abonos = 0, cargos = 0 where id = '$idPartida'");
      
      //actualizo la tabla detallepartidas
      $this->db->query("update contadetallepartidas set cargo = 0, abono = 0 where partida = '$idPartida'");
      
      /*veo si esta partida esta en cxp*/
      if($resultadoCount > 0)
        {
          //si esta en la tabla  de cxp hago un cargo a este proveedor el abono se combierte en cargo
          $this->db->query("insert into 
                            cuentasxpagar(cliente, tipomovimiento, fecha, cargo,  
                                          cancelado, documento, concepto) 
                                          (select cliente, 'C', now(), 
                                            SUM(abono), 0, concat 
                                              ('Por la anulacion de ', concepto), 
                                              concat ('Por la anulacion de ', concepto) 
                            from cuentasxpagar where partida ='$idPartida')");
          //elimino el abono por la anulacion
         $this->db->query("delete from cuentasxpagar where partida = '$idPartida'");
           
        }
	
	//si el resultado es mayor o igual a 2 entonces, hay un cheque con numero cheque negativo y hay que anular tambien
      if($resultado >= 2)//se acualiza el otro cheuqe
		{
			//actualizo la tabla ban_cheque
			  $this->db->query("update ban_cheque set monto_cheque = 0, impreso = 0, anulado_cheque = 1, facha_anulacion_cheque = NOW(), motivo_anulacion = '$motivoAnulacion' where id_cheque = '$idOtroChque'");
			  
			  //actualizo la tabla detalle cheque
			  $this->db->query("update ban_detalle_cheque set debe = 0, haber = 0 where id_cheque = '$idOtroChque'");
		}
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
public function AnularTransaccion($idTransaccion, $idPartida)
    {
      //veo si la partida tiene dos registros para anular la otra trasferencia del banco que no se ve en las vistas
	  $verSiHayDosRegistro				= $this->Mimodelobuscar->VerSiHayDosIdDePartidasTrnasacciones($idPartida);
	  $resultado						= $verSiHayDosRegistro[0]->RESULTADO;
	  $idOtraTransaccion     			= $verSiHayDosRegistro[0]->ID_OTRA_TRANSACCION;
      ///inicio la transaccion
      $this->db->trans_start();
      
      //actualizo la tabla ban_transaccion
      $this->db->query("update ban_transaccion set valor = 0 where id_transaccion = '$idTransaccion'");
      
	  //acutalizo la tabal ban_transacciones_detalle
	  $this->db->query("update ban_transacciones_detalle set debe = 0, haber = 0, referencia = 'Transaccion anulada' where id_transaccion = '$idTransaccion'");

      //actualizo la tabla partidas
      $this->db->query("update contapartidas set abonos = 0, cargos = 0 where id = '$idPartida'");
          
      //actualizo la tabla detallepartidas
      $this->db->query("update contadetallepartidas set cargo = 0, abono = 0 where partida = '$idPartida'");
   
		//hay otra trasaccion oculta que no se muestra en las vista ya que solo es para efectos de afectar el auxiliar
		if($resultado >= 1)
			{
				//actualizo la tabla ban_transaccion
				$this->db->query("update ban_transaccion set valor = 0 where id_transaccion = '$idOtraTransaccion'");
      
				//acutalizo la tabal ban_transacciones_detalle
				$this->db->query("update ban_transacciones_detalle set debe = 0, haber = 0, referencia = 'Transaccion anulada' where id_transaccion = '$idOtraTransaccion'");

			}
   
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
 public function ActualizarCuentaBanco($cuentaContable, $numeroCuenta, $banco, $ultimoCheque, $tipoPartida, $tipoImpresion, $inactiva, $nombreEmite, $cargoEmite, $nombreRevisa, $cargoRevisa, $nombreAutoriza, $cargoAutoriza, $idCuentaBCari)
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
      //$this->db->set("creada_por", $this->session->userdata("username"));
      //$this->db->set("fecha_creacion", $fecha);
      $this->db->where("id_cuenta_bancaria", $idCuentaBCari);
      
      $actualizar = $this->db->update("ban_cuenta_bancaria");//nombre de la tabla
      if($actualizar)
        {
          return true;
        }
      else
        {
          return false;
        }
    }
public function ActualizarTipoTransaccion($idTipoTrnasaccion, $tipoTransaccion, $tipoPartida, $transaccionSaldos)
	{
		$this->db->set("nombre", $tipoTransaccion);
		$this->db->set("id_tipo_partida", $tipoPartida);
		$this->db->set("transaccion", $transaccionSaldos);
		$this->db->where("id_tipo", $idTipoTrnasaccion);
		
		$actualizar = $this->db->update("ban_tipos_transacion");//nombre de la tabla
      if($actualizar)
        {
          return true;
        }
      else
        {
          return false;
        }
		
	}
public function ActualizarChequeDos($fecha, $concepto, $monto, $anombrede, $userName, $idCuentaContableT, $idCuentaBancairiaOtraTrnasferir, $idOtroCheque)
	{
	 $fechaHoraMofidicacion	= date("Y-m-d H:i:s");
		
	 $elConcepto	= $anombrede. ", ".$concepto." por Transferencia valor $ ".$monto;
		///inicio la transaccion
      $this->db->trans_start();
      if($idCuentaBancairiaOtraTrnasferir != 0)//se ha chequedo el ceckbox y se ha cambiado la cuenta bancaria
		{
			  //actualizo la tabla ban_cheque
			  $this->db->query("update ban_cheque set fecha_emision ='$fecha' ,  monto_cheque ='$monto' , 
									a_nombre_de = '$anombrede', concepto_cheque ='$elConcepto' ,
									modificado_por ='$userName' , fecha_hora_modificacion ='$fechaHoraMofidicacion' ,
									id_cuenta_bancaria = '$idCuentaBancairiaOtraTrnasferir'
									where id_cheque = '$idOtroCheque'");
			  
			  //acutalizo la tabal ban_detalle_cheque
			  $this->db->query("update ban_detalle_cheque set concepto ='$elConcepto' , debe ='$monto' , 
									id_cuenta_contable ='$idCuentaContableT'  where id_cheque = '$idOtroCheque'");
		}
	 else//no se sechqueo el chexbox y la idCuentaBancairiaOtraTrnasferir es 0
		{
			//actualizo la tabla ban_cheque
			  $this->db->query("update ban_cheque set fecha_emision ='$fecha' ,  monto_cheque ='$monto' , 
									a_nombre_de = '$anombrede', concepto_cheque ='$elConcepto' ,
									modificado_por ='$userName' , fecha_hora_modificacion ='$fechaHoraMofidicacion'
									where id_cheque = '$idOtroCheque'");
			  
			  //acutalizo la tabal ban_detalle_cheque
			  $this->db->query("update ban_detalle_cheque set concepto ='$elConcepto' , debe ='$monto'  
									 where id_cheque = '$idOtroCheque'");
		}
     
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
public function ActualizarChequeElejido($fecha, $concepto, $monto, $anombrede, $userName, $idCuentaContableChE,  $cuenta, $idCheque, $numeroChequeOri, $idDeLaPartidaDelCheque, $idCuenta, $codigoCuenta, $nombreCuenta, $transferirEntreCuentas)
	{
		/*esta funcion ActualizarChequeElejido es la actualizacion del cheque original elejido de la vista cheques*/
		$fechaHoraMofidicacion	= date("Y-m-d H:i:s");
		if($transferirEntreCuentas == 1) //es tranferencia
			{
				$elConcepto	= $anombrede.", ".$concepto." valor $".$monto.", por trasferencia.";
			}
		else
			{
				$elConcepto	= $anombrede.", ".$concepto." valor ".$monto;
			}
		

		///inicio la transaccion
      $this->db->trans_start();
      
      //actualizo la tabla ban_cheque
      $this->db->query("update ban_cheque set fecha_emision ='$fecha' ,  monto_cheque ='$monto' , 
							a_nombre_de = '$anombrede', concepto_cheque ='$elConcepto' ,
							modificado_por ='$userName' , fecha_hora_modificacion ='$fechaHoraMofidicacion' ,
							id_cuenta_bancaria = '$cuenta'
							where id_cheque = '$idCheque'");
	
      
	  //acutalizo la tabal ban_detalle_cheque
	  $this->db->query("update ban_detalle_cheque set concepto ='$elConcepto' , haber ='$monto' , 
							id_cuenta_contable ='$idCuentaContableChE'  where id_cheque = '$idCheque'");
							
	  //actualizo la partida del chque original
	  $this->db->query("update contapartidas set fecha = '$fecha', concepto = '$elConcepto'
						where id = $idDeLaPartidaDelCheque");
		
	  //actualizo los detalles de la partida
	  $this->db->query("update contadetallepartidas set cuenta = $idCuenta, 
							codigocuenta ='$codigoCuenta', nombrecuenta = '$nombreCuenta', 
							concepto ='$elConcepto', abono = $monto  where partida = $idDeLaPartidaDelCheque");
		    
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
public function ActulizarCompra($idCompra, $iva, $unoPorCiento, $totalDelDocumento, $totalSinIva, $observaciones)
	{
		$this->db->set("total_afecto", $totalDelDocumento);
		$this->db->set("total_iva", $iva);
		$this->db->set("total_impuesto2", $unoPorCiento);
		$this->db->set("total_comprobante", $totalDelDocumento);
		$this->db->set("estado_compra", 1);
		$this->db->set("observaciones", $observaciones);
		$this->db->where("id_comprobante", $idCompra);
		
		$actualizar = $this->db->update("con_compra");//nombre de la tabla
		if($actualizar)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
public function ActulizarCompraNuevosDetalles($idCompra, $iva, $unoPorCiento, $totalDelDocumento, $totalSinIva, $observaciones)
	{
		$fechaHoraMofidicacion	= date("Y-m-d H:i:s");
		$idUsuario = $this->session->userdata("id");
		$this->db->set("total_afecto", $totalDelDocumento);
		$this->db->set("total_iva", $iva);
		$this->db->set("total_impuesto2", $unoPorCiento);
		$this->db->set("total_comprobante", $totalDelDocumento);
		$this->db->set("fecha_hora_modificacion", $fechaHoraMofidicacion);
		$this->db->set("modificado_por", $idUsuario);
		$this->db->set("observaciones", $observaciones);
		$this->db->where("id_comprobante", $idCompra);
		
		$actualizar = $this->db->update("con_compra");//nombre de la tabla
		if($actualizar)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
public function ActualizarEstadoCompra($idCompra)
	{
		$this->db->set("estado_compra", 2);//2 indiqa que solo esta esperando el comprobante de credito fiscal en físico
		
		$this->db->where("id_comprobante", $idCompra);
		
		$actualizar = $this->db->update("con_compra");//nombre de la tabla
		if($actualizar)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
public function AnularOrdenCompraSinCotabilizar($idComprobante)
	{
		//actualizo la tabla con_compra
		$this->db->set("total_exento", 0.00);
		$this->db->set("total_afecto", 0.00);
		$this->db->set("total_iva", 0.00);
		$this->db->set("total_impuesto1", 0.00);
		$this->db->set("total_impuesto2", 0.00);
		$this->db->set("total_comprobante", 0.00);
		$this->db->set("estado_compra", 10);//10 siginifica que fue anulada
		$this->db->where("id_comprobante", $idComprobante);
		
		
		$actualizar = $this->db->update("con_compra");//nombre de la tabla
		

		
		if($actualizar)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
public function ActualizarIVAOrdenCompra($idComprobante, $iva)
	{
		//actualizo la tabla con_compra
		
		$this->db->set("total_iva", $iva);
		$this->db->where("id_comprobante", $idComprobante);
		
		
		$actualizar = $this->db->update("con_compra");//nombre de la tabla
		

		
		if($actualizar)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
public function ActualizarProductoServicio($codigoProductoServicio, $unidadMedida, $costo, $descripcion,$codigo)
	{
		$this->db->set("codigo", $codigo);
		$this->db->set("unidad", $unidadMedida);
		$this->db->set("costo", $costo);
		$this->db->set("descripcion", $descripcion);
		$this->db->where("id", $codigoProductoServicio);
		
		$actualizar = $this->db->update("materiales");//nombre de la tabla
		

		
		if($actualizar)
			{
				return true;
			}
		else
			{
				return false;
			}
	}
public function ActualizarNumeroCheque($idCuentaBancaria, $numeroChequeque, $idCheque, $idPartida)	
	{
	
		//veo si hay dos cheques con el mismo id es porque ha sido transferencia entre cuaentas
		$verSiHayDosIdsDeCheques = $this->Mimodelobuscar->DosIdsChequees($idCheque);
		$resultado				 = $verSiHayDosIdsDeCheques[0]->RESULTADO;
		$idDelChequeOriginal     = $verSiHayDosIdsDeCheques[0]->motivo_anulacion;
		 //inicio transaccion
      $this->db->trans_start();
      
	  //es tranferncia de cuantas y tengo que actualziar el concepto
	 if($resultado > 0)
		{
			$this->db->query("update ban_cheque 
							set concepto_cheque = concat(concepto_cheque, ' Cheque #. $numeroChequeque' ),
							numero_cheque = -$numeroChequeque
							where motivo_anulacion  = '$idDelChequeOriginal'");
			//vuelvo a actualizar la tabla con el campo motivo_anulacion = null
			$this->db->query("update ban_cheque 
							set concepto_cheque = concat(concepto_cheque, ' Cheque #. $numeroChequeque' ),
							numero_cheque = -$numeroChequeque
							where motivo_anulacion  = NULL");
		}
      
	  $this->db->query("update ban_cheque 
							set concepto_cheque = concat(concepto_cheque, ' Cheque #. $numeroChequeque' ),
							numero_cheque = $numeroChequeque, 
							motivo_anulacion = NULL
							where id_cheque = '$idCheque'");
      //
      $this->db->query("update contapartidas set concepto = concat(concepto, ' Cheque #. $numeroChequeque')
							where id = $idPartida");
	
	  $this->db->query("update contadetallepartidas set concepto = concat(concepto, ' Cheque #. $numeroChequeque')
							where partida = $idPartida");
	
      $this->db->query("update ban_cuenta_bancaria set ultimo_numero_cheque = $numeroChequeque + 1
							where id_cuenta_bancaria = $idCuentaBancaria");
		
	 

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
public function ActualizarEncabezadoOrdenCompra($idComprobante, $idCondicionPago, $formaPago, $diasCredito, $centroCosto, $tipoComprobante, $codigoProveedor,  $idProveedor, $nombreProveedor, $nit, $nrc, $condiconPago, $fecha, $solicitadaPor, $tamannoCotribuyente)//la variable $tamannoCotribuyente y $idCondicionPago no se utilizan
	{
		$fechaHoraMofidicacion	= date("Y-m-d H:i:s");

		$usuario = $this->session->userdata("username");
		$this->db->set("id_tipo_comprobante", $tipoComprobante);
		$this->db->set("fecha", $fecha);
		$this->db->set("id_proveedor", $idProveedor);
		$this->db->set("codigo_proveedor", $codigoProveedor);
		$this->db->set("nombre", $nombreProveedor);
		$this->db->set("nrc", $nrc);
		$this->db->set("nit", $nit);
		$this->db->set("id_forma_pago", $formaPago);
		$this->db->set("dias_credito", $diasCredito);
		$this->db->set("modificado_por", $usuario);
		$this->db->set("fecha_hora_modificacion", $fechaHoraMofidicacion);
		$this->db->set("solicitada_por", $solicitadaPor);
		$this->db->set("id_centro_costo", $centroCosto);
		$this->db->where("id_comprobante", $idComprobante);
		
		$actualizar = $this->db->update("con_compra");
		if($actualizar)
			{
				return true;
			}
		else
			{
				return false;
			}
		
	}
public function ActualizarCentroCosto($idCentroCosto, $descripcion)
	{
	
		$this->db->set("descripcion", $descripcion);
		$this->db->where("id", $idCentroCosto);
		
		$actualizar = $this->db->update("contacentroscostos");//nombre de la tabla
		

		
		if($actualizar)
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