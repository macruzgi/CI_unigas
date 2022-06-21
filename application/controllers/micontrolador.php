<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Micontrolador extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct(){
    parent::__construct();
    
    //cargo el helper de url
    //$this->load->helper('url');
    $this->load->library('session');
     $this->load->library('form_validation'); 
     $this->load->model("Mimodelobuscar");//cargo el modelo no es necesario esto aquie ni hacer el consturctor
     //$this->load->model("Mimodelobuscar");//cargo el modelo no es necesario esto aquie ni hacer el consturctor
    	session_start();//inicio la sesión del para agregar las cuentas contables
			if(!isset($_SESSION["cuentasAlaPartida"]) || !is_array($_SESSION["cuentasAlaPartida"])) 
        {
				$_SESSION["cuentasAlaPartida"] = array();
			   }
         
      //sesion para los abonos a pagar a los proveedores
      if(!isset($_SESSION["agregarAbonos"]) || !is_array($_SESSION["agregarAbonos"])) 
        {
				$_SESSION["agregarAbonos"] = array();
			   }
      
      //sesion para las cuetas a las partidas de transacciones
      if(!isset($_SESSION["cuentasAlaPartidaTransaccion"]) || !is_array($_SESSION["cuentasAlaPartidaTransaccion"])) 
        {
				$_SESSION["cuentasAlaPartidaTransaccion"] = array();
		}
	//sesion para agregar productos al carro Compras
      if(!isset($_SESSION["carro"]) || !is_array($_SESSION["carro"])) 
        {
				$_SESSION["carro"] = array();
		}
	//sesion para mostrar los productos en el carro a modificar
      if(!isset($_SESSION["carro2"]) || !is_array($_SESSION["carro2"])) 
        {
				$_SESSION["carro2"] = array();
		}
  } 
  public function index()
	 {
	   $mostrar["contenido"] = "vista_index";   
      $this->load->view("plantilla", $mostrar);
	 }
 public function EstaLogueado($idModulo)     
  {
    $tienePermisosElUsuario	= $this->VerifcarPermisoModulo($idModulo);
    if(isset($this->session->userdata['username']) && $tienePermisosElUsuario > 0)
      {
          return TRUE;
      }
    else                                 
      {
          return FALSE;
      }                           

  }
 public function VerifcarPermisoModulo($idModulo)     
  {
	$idUsuario = $this->session->userdata("tipousuario");
	if($idUsuario != "")
		{
			$buscoElpermisoConElUsuario = $this->Mimodelobuscar->BuscarElPermisoDelUsuario($idModulo, $idUsuario);
		}
	else
		{
			$buscoElpermisoConElUsuario = 0;
		}
	
    if($buscoElpermisoConElUsuario > 0)//tine permiso de ver la vista
      {
          return TRUE;
      }
    else//no posee permisos para ver la vista                                 
      {
          return FALSE;
      }                           

  }
  public function ErrorNoAutenticado()
    {
        $mostrar["error"] = "Usted no se ha autenticado, y/o <font color = red>NO TIENE PERMISOS PARA REALIZAR ESTA ACCI&Oacute;N...</font>";
        $mostrar["contenido"] = "vista_error";
        $this->load->view("plantilla", $mostrar);
    }
 public function DevolverPrimerDiaDelMes()//fucion que devuelve el primer dia del mes SIN USO
	{
		
		$fecha	= new DateTime();
		$fecha->modify("first day of this month");
		return $fecha->format("Y-m-d");//formato mysql
		//$this->load->view("plantilla", $fecha);
		
	}
 public function VistaInicio()
  {
   $estaLogueado = $this->EstaLogueado(160);
    if($estaLogueado == TRUE)       
      {
        //$codigoInstitucion = $this->session->userdata("codigo_institucion");
        //$mostrar["informacionInstitucion"] = $this->Mimodelobuscar->BuscarDatosInstitucion($codigoInstitucion);       
  
        $mostrar["contenido"] = "vista_inicio";
        $this->load->view("plantilla", $mostrar);
      }
    else
      {
        $this->ErrorNoAutenticado();
      }
    
  }
 public function IniciarSesion()
  {
     if(!isset($_POST["usuario"]))
      {
        $mostrar["contenido"] = "vista_index";
        $this->load->view('plantilla', $mostrar);
      }
    else
      {
         //echo "hola" ;
        //definimos las reglas de validación
       $this->form_validation->set_rules('usuario','Usuario','required');
       $this->form_validation->set_rules('contrasena','Password','required');
        
        if($this->form_validation->run() == FALSE) //si no supera las reglas de validación se recarga la vista del formulario es decir no cumple con las condiciones arriba especificadas
          {
             $mostrar["contenido"] = "vista_index";
             $this->load->view('plantilla', $mostrar);
          }
        else//si pasa la validación
          {
            //busco en el modelo el usuario y contraseña ingresadas
            //pasandole como parámetros el usaurio y la contraseña
            $resultadosEncontrados  = $this->Mimodelobuscar->IniciarSesionUsuario($_POST["usuario"], $_POST["contrasena"]);
            //si encuentra resultado que guarde la sesión
            if($resultadosEncontrados)
              {
                                                    
                      /*                                              
                      @session_start();     
                      //inicio sesión y registro variables de sesión
                      $_SESSION["nombre_usuario"]       = $resultadosEncontrados[0]->nombre_usuario;
                      $_SESSION["tipodecuenta"]         = $resultadosEncontrados[0]->tipodecuenta;
                      redirect(base_url()."micontrolador/VistaInicio/");
                      */
                      $datosEnSesion = array(
                                              'id'=>$resultadosEncontrados[0]->id,
                                              'username'=>$resultadosEncontrados[0]->username,
                                              'nombres'=>$resultadosEncontrados[0]->nombres,
                                              'apellidos'=>$resultadosEncontrados[0]->apellidos,
                                              'tipousuario'=>$resultadosEncontrados[0]->tipousuario,
                                              'chequear'=>true     
                                            );
                      
                      //$mostrar["contenido"] = "vista_inicio";
                      $this->session->set_userdata($datosEnSesion); 
                     
                      redirect(base_url()."micontrolador/VistaInicio/");     
                 
              }
            else///si no se encontraron resultados es decir usuarios cohincidentes
              {
                 //$this->session->set_flashdata('error', 'El usuario o contraseña son incorrectos');
                 //redirect(base_url()."micontrolador/index/1");
                 $mostrar["error"] = "El suaurio y/o contraseña son incorrectos, intente de nuevo...";
                 $mostrar["contenido"] = "vista_index";
                 $this->load->view("plantilla", $mostrar);           
              }
          }

      }

      
  }
public function CerrarSesion()
  {
    $datosEnSesion = array(
                            'chequear'=>false     
                          );
    $this->session->sess_destroy();
     @session_start();
    @session_destroy(); 
    redirect(base_url()."micontrolador/index/");
     /*@session_start(); 
      @session_destroy(); // destruyo la sesión 
      redirect(base_url()."micontrolador/index/");//una vez destruyo la sesión llamo la función index()
			exit;*/
      
    

  }
  public function VistaBanco()
    {
      $estaLogueado = $this->EstaLogueado(152);//id del modulo de la tabla modulos
      if($estaLogueado == TRUE)                     
        {
          //ESTO ES PARA ELIMINAR LOS DATOS DE LA SESION DE LA CUENTAS
          @session_start();
          unset($_SESSION["cuentasAlaPartida"]);
          ///////fin ELIMINACION DE LOS DATOS DE LAS CUENTAS
          
          
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"]))
            {
                $filtro = $_POST["filtro"];
                $mostrar["listarCuentasBanco"]  = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
               // if($_SERVER["")
                $mostrar["contenido"] = "vista_banco";
                $this->load->view("plantilla", $mostrar);
            }
          else
            {
              $filtro = "";
              $mostrar["listarCuentasBanco"]  = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
              $mostrar["contenido"] = "vista_banco";
              $this->load->view("plantilla", $mostrar);
            }
                 
         
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function VistaNuevaCuenta()
    {
      $estaLogueado = $this->EstaLogueado(153);//id de la vista en la tabla modulos
      if($estaLogueado == TRUE)                     
        {
          $mostrar["listarCuentasContables"] = $this->Mimodelobuscar->ListarCuentasContables(); 
          $mostrar["listarTipoPartidas"] = $this->Mimodelobuscar->ListarTipoPartidas();
          $mostrar["contenido"] = "vista_nueva_cuenta";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function RegistrarCuentaBanco()
    {
      $estaLogueado = $this->EstaLogueado(153);
      if($estaLogueado == TRUE)
        {
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cuentacontable"])
              && isset($_POST["banco"]) && isset($_POST["numerocuenta"])
              && isset($_POST["ultimocheque"]) && isset($_POST["tipopartida"])
              && isset($_POST["tipoimpresion"]) && isset($_POST["inactiva"])
              && isset($_POST["nombreemite"]) && isset($_POST["cargoemite"])
              && isset($_POST["nombrerevisa"]) && isset($_POST["cargorevisa"])
              && isset($_POST["nombreautoriza"]) && isset($_POST["cargoautoriza"]))
              {
              
                 $cuentaContable = $_POST["cuentacontable"];
                 $numeroCuenta   = $_POST["numerocuenta"];
                 $banco          = $_POST["banco"];
                 $ultimoCheque   = $_POST["ultimocheque"];
                 $tipoPartida    = $_POST["tipopartida"];
                 $tipoImpresion  = $_POST["tipoimpresion"];
                 $inactiva       = $_POST["inactiva"];
                 $nombreEmite    = $_POST["nombreemite"];
                 $cargoEmite     = $_POST["cargoemite"];
                 $nombreRevisa   = $_POST["nombrerevisa"];
                 $cargoRevisa    = $_POST["cargorevisa"];
                 $nombreAutoriza = $_POST["nombreautoriza"];
                 $cargoAutoriza  = $_POST["cargoautoriza"];
                if($cuentaContable != "" && $numeroCuenta != "")
                      {
                       
                        
                        $buscarNumeroCuenta = $this->Mimodelobuscar->BuscarNumeroCuenta($numeroCuenta);
                        if(count($buscarNumeroCuenta))
                          {
                            
                            //$mostrar["contenido"] = "vista_nueva_cuenta";
                            redirect(base_url()."micontrolador/VistaNuevaCuenta/100/");
                          }
                        else
                          {
                            
                                $insertar = $this->Mimodeloinsertar->RegistrarCuentaBanco($cuentaContable, $numeroCuenta, $banco, $ultimoCheque, $tipoPartida, $tipoImpresion, $inactiva, $nombreEmite, $cargoEmite, $nombreRevisa, $cargoRevisa, $nombreAutoriza, $cargoAutoriza);
                                if($insertar == true)
                                  {
                                    redirect(base_url()."micontrolador/VistaNuevaCuenta/200/");
                                    exit;
                                  }
                                else
                                  {
                                    redirect(base_url()."micontrolador/VistaNuevaCuenta/300/");
                                  
                              
                                  }
                          }
                    }
                  else
                    {
                        $this->VistaNuevaCuenta();
                    }
              }
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
    }
  public function VistaCheque()
    {
      $estaLogueado = $this->EstaLogueado(155);//id de la vista en la tabla modulo
      if($estaLogueado == TRUE)                     
        {
        
          if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["idcuentabanco"])
              && isset($_POST["fechabanco"])
              && isset($_POST["fechabancohasta"])
              )
            {
                  $filtro                    = "";
                  $cuentaBancaria            = $_POST["idcuentabanco"];
                  $fechaBanco                = $_POST["fechabanco"];
                  $fechaBancoHasta           = $_POST["fechabancohasta"];
                  $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
        
                  $mostrar["listarCheques"]  = $this->Mimodelobuscar->LitarTodosLosChequesTranferencias($cuentaBancaria, $fechaBanco, $fechaBancoHasta);
                  //$mostrar["listarChequesNoContabilizados"] = $this->Mimodelobuscar->ListarChequesNoContabilizados($filtro);
                  $mostrar["contenido"]      = "vista_cheque";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
              $filtro = "";
              $cuentaBancaria            = "";
              $fechaBanco                = "";
              $fechaBancoHasta           = "";    
              $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
              $mostrar["listarCheques"]  = $this->Mimodelobuscar->LitarTodosLosChequesTranferencias($cuentaBancaria, $fechaBanco, $fechaBancoHasta);
              $mostrar["contenido"]      = "vista_cheque";
              $this->load->view("plantilla", $mostrar);
            }
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function VistaNuevoCheque()
    {
      $estaLogueado = $this->EstaLogueado(156);//id de la vista en la tabla modulo
      if($estaLogueado == TRUE)                     
        {
          
          $mostrar["listarCuentasBancairas"] = $this->Mimodelobuscar->ListarCuentasBancarias();
          $mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas();
          $mostrar["contenido"] = "vista_nuevo_cheque";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function VistaOtraCuentaBancariaAtransferir() 
  {
    $estaLogueado = $this->EstaLogueado(156);//id de la vista en la tabla modulo creacion de cheuqe
      if($estaLogueado == TRUE)                     
        {
          
          $idCuentaBancaria = $this->uri->segment(3,0);
         
          $mostrar["listarDatosParaConciliar"] = $this->Mimodelobuscar->BuscarOtraCuentaBancariaAtransferir($idCuentaBancaria);
          
          $mostrar["contenido"] = "vista_otra_cuenta_a_transferir";
          $this->load->view("vista_otra_cuenta_a_transferir", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
   public function RegistrarCheque()
    {
      $estaLogueado = $this->EstaLogueado(156);///creacion de cheque id de la vista en la tabla modulo
      if($estaLogueado == TRUE)                     
        {
          if($_SERVER["REQUEST_METHOD"] === "POST" 
              && isset($_POST["cuenta"])
              && isset($_POST["codigo"]) 
              && isset($_POST["anombrede"]) 
              && isset($_POST["tipopartida"]) 
              && isset($_POST["fecha"]) 
              && isset($_POST["concepto"]))
              {
              
                 $cuenta      = $_POST["cuenta"];
                 $codigoProve = $_POST["codigo"];
                 $anombrede   = $_POST["anombrede"];
                 $monto       = str_replace(',', '', $_POST["monto"]); //str_replace quito las comas si se las han ingresado
                 $tipoPartida = $_POST["tipopartida"];
                 $fecha       = $_POST["fecha"];
                 $concepto    = $_POST["concepto"];
				 
				 $textoLargo = $concepto;
				 $largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
				 $rompeLineas = '</br>';
				 $romper_palabras_largas = true; // rompe una palabra si es demacido larga
			     $concepto = wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
			
				 
                 $idUsuario = $this->session->userdata("id");
                 $userName = $this->session->userdata("username");
                 //$numeroCheque  = 0;
                if($cuenta != "" && $anombrede != "")
                  {  
                   
					 
                        //}
                      //generando el correlativo de la partida
                      $buscarCorrelativoPartida = $this->Mimodelobuscar->BuscarCorrlativoPartida($tipoPartida, $fecha);
                      if($buscarCorrelativoPartida)  //si hay correlativo para ese tipo de partida y fecha que sume uno mas para el siguiente numero
                        {
                          //traigo es correlativo
                          $extraerCorrelativoPartida = $this->Mimodelobuscar->ExtraerCorrelativoPartida($tipoPartida, $fecha);
                          $numeroSiguienteCorrelativoPartida =  $extraerCorrelativoPartida[0]->correlativo + 1;
                          
                          // y actualizo ese correlativo anterior
                          $this->Mimodeloactualizar->ActualizarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida); 
                        }
                      else //si ese tipo de partida no teien correlativo lo inserto
                        {
                           $numeroSiguienteCorrelativoPartida = 1;
                           //inserto el correlativo 1
                          $this->Mimodeloinsertar->InsertarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida);
                           
                           
                        }
          
                      $traerIdCuentaContable = $this->Mimodelobuscar->TraerIdCuentaContable($cuenta);
                      $idCuentaContable =  $traerIdCuentaContable[0]->id_cuenta_contable; 
                    
                    //traigo el maximo de la tabla ban_cheque para guardarlo en la tabla contapartidas
                     $maxUltimoIdCheque = $this->Mimodelobuscar->UltimoIdChequeSinFiltro();
                     $maxIdUltimoCheque  = $maxUltimoIdCheque[0]->id_cheque + 1;
                     
                      $noIncluirNomber = 1; 
					  $esTranferencia  = 1; //es cheque sin transferencia
                      //guardo la partida  
                      $insertar = $this->Mimodeloinsertar->InsertarNuevaPartida($fecha, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $idUsuario, $esTranferencia, $anombrede, $userName, $cuenta, $idCuentaContable, $maxIdUltimoCheque, $noIncluirNomber); //$idUltimoCheque);
                     
					/*inicio*/
					/*TODO ESTO ES PARA VER SI ES TRANSFEENCIA DE DINERO ENTRE CUENTAS BANCARIAS
					SI ES ASI QUE INSERTE UN CARGO A LA OTRA CUENTA BANCARIA SELECCIONADA
					ESTE REGISTRO DE CARGO APARECER COMO CHEQUE PERO CHEQUE EMITOD DESDE OTRA CUENTA BANCARIA
					Y SE PONDRA COMO IMPRESO PARA QUE SOLO QUEDE LA OPCION DE REIMPRIMR YA QUE NO ES UN CHEQUE EN SI*/
					 //veo si se ha chequeado le chexbox transferencia entre cuentas
					if(isset($_POST["tranferenciaentrecuentas"]) && isset($_POST["cuentaOtro"]))
						{
							$idCuentaBancairiaOtraTrnasferir = $_POST["cuentaOtro"];
							$transferirEntreCuentas = 1;
							$esTranferencia  = 0;
							if($transferirEntreCuentas == 1)//es transferencia enter cuentas banciarias se ha cehquedo el checkbox
							{
								$insertarTrasferenciaEntreCuentas = $this->Mimodeloinsertar->InsertarCargoAcuentaBancariaTransferida($fecha, $concepto, $monto, $esTranferencia, $anombrede, $userName, $idCuentaBancairiaOtraTrnasferir, $noIncluirNomber, $maxIdUltimoCheque);
								if($insertarTrasferenciaEntreCuentas == true)//si se insertaron los header(encabezados) de las tranferenicas entre cuentas bancarias
									{
										 //traigo el  ultimo ide del cheque de la cuenta bancaria a la que le hice el cargo
										   $ultimoIdCheque = $this->Mimodelobuscar->UltimoIdCheque($idCuentaBancairiaOtraTrnasferir);
										   $idUltimoCheque  = $ultimoIdCheque[0]->id_cheque;

										   //traigo el id de la partida creada a este momento por la emision del cheque
										   $traerIdDeLaPartidaCreadaPorChque = $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorChque($maxIdUltimoCheque);
										   $idDelaParidaPorCheque = $traerIdDeLaPartidaCreadaPorChque[0]->id;
											
											//traigo el id de la cuenta contable
											$traerIdCuentaContableT = $this->Mimodelobuscar->TraerIdCuentaContable($idCuentaBancairiaOtraTrnasferir);
											$idCuentaContableT =  $traerIdCuentaContableT[0]->id_cuenta_contable; 
										   /*fin del la codificacion innesaria si estubieran relacionadas**/
										   $noIncluirNomber = 1;//incluye el nombre en el detalle  
											$insertarDetalleChequeTrasferenciaEntreCuentas = $this->Mimodeloinsertar->InsertarDetalleChequeTrasferenciaEntreCuentas($concepto, $monto, $idUltimoCheque, $anombrede, $idCuentaContableT, $noIncluirNomber, $esTranferencia, $idDelaParidaPorCheque);
									}
							}
						}
					/*fin trasferencia entre cuentas*/
					  
                       
                       //$this->Mimodeloinsertar->InsertarNuevoCheque($numeroChequeque, $fecha, $monto, $anombrede, $concepto, $userName, $tipoPartida, $cuenta, $numeroSiguienteCorrelativoPartida);*/ 
                      //si se insertan los valores enviados a la
                      //tabla ban_cheque y la tabla contapartidas
                      //que inserte el detalle del cheque
                      //en la tabla ban_detalle_cheque 
                      if($insertar == true)
                         {
                           //traigo el  ultimo ide del cheque
                           $ultimoIdCheque = $this->Mimodelobuscar->UltimoIdCheque($cuenta);
                           $idUltimoCheque  = $ultimoIdCheque[0]->id_cheque;

                           //traigo el id de la partida creada a este momento por la emision del cheque
                           $traerIdDeLaPartidaCreadaPorChque = $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorChque($maxIdUltimoCheque);
                           $idDelaParidaPorCheque = $traerIdDeLaPartidaCreadaPorChque[0]->id;
                           
                           //traico el id de lacuetna, el nombre de la cuenta y i el id de la cuenta
                           //si las tablas estubieran relacionadas este proceso no seia necesario
                           $buscarIdCodigoYnombreCuenta = $this->Mimodelobuscar->BuscarIdCodigoYnombreCuenta($idCuentaContable);
                           $idCuenta                    = $buscarIdCodigoYnombreCuenta[0]->id;
                           $codigoCuenta                = $buscarIdCodigoYnombreCuenta[0]->codigo;
                           $nombreCuenta                = $buscarIdCodigoYnombreCuenta[0]->nombre;
                           /*fin del la codificacion innesaria si estubieran relacionadas**/
                           $noIncluirNomber = 1;//incluye el nombre en el detalle  
                            //inseto el detalle del chque y el primer detalle de la partida original
                             $insertarDetalleCheque = $this->Mimodeloinsertar->InsertarDetalleCheque($concepto, $monto, $idUltimoCheque, $idCuentaContable, $idDelaParidaPorCheque, $idCuenta, $codigoCuenta, $nombreCuenta, $anombrede, $noIncluirNomber, $esTranferencia);
                           if($insertarDetalleCheque == true)
                              {
                                unset($_SESSION["cuentasAlaPartida"]);
                                redirect(base_url()."micontrolador/VistaCrearPartidaDetalles/$idDelaParidaPorCheque/$maxIdUltimoCheque/");
								exit;
                              }
							
							
							
                          }
                        else
                          {
                               redirect(base_url()."micontrolador/VistaNuevoCheque/300/");
                                  
                              
                           }   
                  }
                else
                  {
                        $this->VistaNuevoCheque();
                  }
                 
              }
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function VistaCrearPartidaDetalles()
    {
      $estaLogueado = $this->EstaLogueado(158);//id de la vista en la tabla modulo contabilizar cheque
      if($estaLogueado == true)
        { 
          
       
          //global $idCheque;
          //$idDelaParidaPorCheque  = $this->uri->segment(3,0);
          
          $idCheque               							= $this->uri->segment(4,0);//4 porque el elemento 3 es un distractor
		  //traigo el id de la partid creada por estre id del cheque para que pueda mostrar el header(encabedado de la partida)y los detalles
		  //de la misama
		  $traerIdDeLaPartidaCreadaPorChequeOTransferencia	= $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorChequeOTransferencia($idCheque);
		  $idDelaParidaPorCheque							= $traerIdDeLaPartidaCreadaPorChequeOTransferencia[0]->id;
          
          $mostrar["listarPartidaNoProcesadaCheque"] = $this->Mimodelobuscar->ListarPartidaNoProcesadaCheque($idDelaParidaPorCheque, $idCheque);
          $mostrar["listarPrimerDetallePartida"] = $this->Mimodelobuscar->ListarPrimerDetallePartida($idDelaParidaPorCheque);
          $mostrar["contenido"] = "vista_crear_partida_detalles";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
          $this->ErrornoAutenticado();
        }
    }
  public function VistaCrearPartidaDetallesCXP()
    {
      $estaLogueado = $this->EstaLogueado(158);
      if($estaLogueado == true)
        { 
          
          
          $idDelaParidaPorCheque  = $this->uri->segment(3,0);
          
          $idCheque               = $this->uri->segment(4,0);
          
          $mostrar["listarDatosCuentaProveedorServicios"] = $this->Mimodelobuscar->ListarDatosCuentaProveedorServicios(); 
          $mostrar["listarPartidaNoProcesadaCheque"]      = $this->Mimodelobuscar->ListarPartidaNoProcesadaCheque($idDelaParidaPorCheque, $idCheque);
          $mostrar["listarPrimerDetallePartida"]          = $this->Mimodelobuscar->ListarPrimerDetallePartida($idDelaParidaPorCheque);
          $mostrar["contenido"]                           = "vista_crear_partida_detalles_cxp";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
          $this->ErrornoAutenticado();
        }
    }
   public function VistaBuscarProveedoresParaCrheque()
    {
      $estaLogueado = $this->EstaLogueado(156);//id de la vista en la tabla modulo cracion de cheque
      if($estaLogueado == TRUE)                     
        {
          //EM PRUEBA PUEDE FALLAR PARA EL FORMULARIO DE BUSQUEDA DE
          //PROVEEDORES NORMALES//
          @session_start();
          unset($_SESSION["agregarAbonos"]);
          /************************FIN DE LO DE PRUEBA ESTE BLOQUE DE ARRIBA SOLO
           *ES PARA EL FORMULARIO DE CHEQUES A CUENTAS POR PAGAR*/
           
                     
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"]))
          {
              $filtro = $_POST["filtro"];
              $mostrar["listarProveedoresParaCheque"] = $this->Mimodelobuscar->ListarProveedoresParaCheque($filtro);
            //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas(); 
              $mostrar["contenido"] = "vista_buscar_proceedores_para_cheque";
              $this->load->view("vista_buscar_proceedores_para_cheque", $mostrar);
          }
          ELSE
          {
              $filtro = "";
              $mostrar["listarProveedoresParaCheque"] = $this->Mimodelobuscar->ListarProveedoresParaCheque($filtro);
              $mostrar["contenido"] = "vista_buscar_proceedores_para_cheque";
              $this->load->view("vista_buscar_proceedores_para_cheque", $mostrar);
          }
          
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function VistaBuscarCuentasContables()
    {
      $estaLogueado = $this->EstaLogueado(158);//id de la vista en la tabla modulo
      if($estaLogueado == TRUE)                     
        {
            
            if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"]))
              {
                $filtro = $_POST["filtro"];
                $mostrar["listarCuentasContables"] = $this->Mimodelobuscar->LlistarCuentasContables($filtro);
              //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas(); 
                $mostrar["contenido"] = "vista_buscar_cuentas_contables";
                $this->load->view("plantilla", $mostrar);
              }
            else
              {
                $filtro = "";
                $mostrar["listarCuentasContables"] = $this->Mimodelobuscar->LlistarCuentasContables($filtro);
                $mostrar["contenido"] = "vista_buscar_cuentas_contables";
                $this->load->view("plantilla", $mostrar);
              }
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
    }
   public function AgregarCuentasAlaPartida()
    { 
      $estaLogueado = $this->EstaLogueado(158);//contabilizar chueque id de la vista en tabla modulo
      if($estaLogueado == TRUE)
         {
      			if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["cargo"])
                && isset($_POST["abono"]) && isset($_POST["conceptoDetalle"])
                && isset($_POST["conceptoOriginal"]))
                {
                  $conceptoDetalle  = $_POST["conceptoDetalle"];
				  
				  /*incio para cortar en lineas el concpto si es muy largo*/
				  $textoLargo = $conceptoDetalle;
					$largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
					$rompeLineas = '</br>';
					$romper_palabras_largas = true; // rompe una palabra si es demacido larga
				   $conceptoDetalle = wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
				   /*fin*/
				  
                  $conceptoOriginal = $_POST["conceptoOriginal"];
                  if($conceptoDetalle == "CONCEPTO")
                    {
                      $conceptoDetalle = $conceptoOriginal;
                    }
                  elseif($conceptoDetalle != "")
                    {
                      $conceptoDetalle = $_POST["conceptoDetalle"];
                    }
                  else 
                    {
                      $conceptoDetalle = $conceptoOriginal; 
                    }
                  if($cargo = $_POST["cargo"] > 0 || $abono = $_POST["abono"] > 0)
                    {
                      $cargo           = $_POST["cargo"];
                      $abono           = $_POST["abono"]; 
                      
                    }
                  else
                    {
                      $cargo = 0;  
                      $abono = 0;
                      
                    }
                }
             else
                {
                  $cargo = 0;
                  $abono = 0;
                  $conceptoDetalle = "CONCEPTO";
                }
                  $abono;
                  $cargo; 
                  $idCuentaContable   = $this->uri->segment(3,0);//3 es la posición del de la cuenta de la posicion de la url
                  $idPartida  = $this->uri->segment(4,0);
                  $idCheque   = $this->uri->segment(5,0);
                  //$codigoCliente    = $this->uri->segment(4,0);//4 es la posición del cliente
                  //$porcentaje       = $this->uri->segment(5,0);//5 es la posicion del porcentaje si tiene, si no tiene tendrá el valor de 0
                  //$buscarCliente    = $this->Mimodelobuscar->BuscarClietneParaEnviarPedio($codigoCliente);
                  $cuantaContableAbuscar  = $this->Mimodelobuscar->BuscarCuentasContablesAgregarApartida($idCuentaContable);
                  //print_r($cuantaContableAbuscar);
                  if($cuantaContableAbuscar)// && $buscarCliente)
                    {
                      if(!in_array($idCuentaContable, $_SESSION["cuentasAlaPartida"]))
                        {
                          $_SESSION["cuentasAlaPartida"][$idCuentaContable] = array(
                            "id" =>$cuantaContableAbuscar[0]->id,
                            "codigo" =>$cuantaContableAbuscar[0] ->codigo,
                            "nombre" =>$cuantaContableAbuscar[0] ->nombre,
                            "conceptoDetalle"=>$conceptoDetalle,
                            "cargo" =>$cargo,
                            //"codigoUsuario"=>$buscarCliente[0]->codigo_cliente,
                            //"porcentaje"=>$porcentaje
                            "abono"=>$abono
                            );
                          //$_SESSION["carro"] = $carro;
                          return redirect(base_url()."micontrolador/VistaCrearPartidaDetalles/$idPartida/$idCheque/");
                        }
                    }
              }
            else
              {
                $this->ErrorNoAutenticado();
              }      
    }
   public function VistaCrearPartidaDetallesPruebas()
    {
      $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == true)
        { 
          global   $idDelaParidaPorCheque;
          $idDelaParidaPorCheque  = $this->uri->segment(3,0);
          $idCheque               = $this->uri->segment(4,0);
          $mostrar["listarPartidaNoProcesadaCheque"] = $this->Mimodelobuscar->ListarPartidaNoProcesadaCheque($idDelaParidaPorCheque, $idCheque);
          
          $mostrar["listarPrimerDetallePartida"] = $this->Mimodelobuscar->ListarPrimerDetallePartida($idDelaParidaPorCheque);
          $mostrar["contenido"] = "vista_crear_partida_detallesPrueba";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
          $this->ErrornoAutenticado();
        }
    }
  public function AgregarCuentasAlaPartidaPruebas() //sin uso solo de prueba
    { 
      $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)
         {
      			if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["interactiva"]))
                {
                  
                  $interactiva = $_POST["interactiva"];
                  
                  $idCuentaContable   = $this->uri->segment(3,0);//3 es la posición del de la cuenta de la posicion de la url
                  $idPartida  = $this->uri->segment(4,0);
                  $idCheque   = $this->uri->segment(5,0);
                  //$codigoCliente    = $this->uri->segment(4,0);//4 es la posición del cliente
                  //$porcentaje       = $this->uri->segment(5,0);//5 es la posicion del porcentaje si tiene, si no tiene tendrá el valor de 0
                  //$buscarCliente    = $this->Mimodelobuscar->BuscarClietneParaEnviarPedio($codigoCliente);
                  $cuantaContableAbuscar  = $this->Mimodelobuscar->BuscarCuentasContablesAgregarApartida($interactiva);
                  //print_r($cuantaContableAbuscar);
                  if($cuantaContableAbuscar)// && $buscarCliente)
                    {
                      if(!in_array($idCuentaContable, $_SESSION["cuentasAlaPartida"]))
                        {
                          $_SESSION["cuentasAlaPartida"][$idCuentaContable] = array(
                            "id" =>$cuantaContableAbuscar[0]->id,
                            "codigo" =>$cuantaContableAbuscar[0] ->codigo,
                            "nombre" =>$cuantaContableAbuscar[0] ->nombre,
                            "conceptoDetalle"=>$conceptoDetalle,
                            "cargo" =>0,
                            //"codigoUsuario"=>$buscarCliente[0]->codigo_cliente,
                            //"porcentaje"=>$porcentaje
                            "abono"=>0
                            );
                          //$_SESSION["carro"] = $carro;
                          return redirect(base_url()."micontrolador/VistaCrearPartidaDetallesPruebas/$idPartida/$idCheque/");
                        }
                    }
                }
              }
            
            else
              {
                $this->ErrorNoAutenticado();
              }      
    }
  public function d() //sin uso solo prueba
    { 
      $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)
         {
      			if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["cargo"])
                && isset($_POST["abono"]) && isset($_POST["conceptoDetalle"])
                && isset($_POST["conceptoOriginal"]))
                {
                  $conceptoDetalle  = $_POST["conceptoDetalle"];
                  $conceptoOriginal = $_POST["conceptoOriginal"];
                  if($conceptoDetalle == "CONCEPTO")
                    {
                      $conceptoDetalle = $conceptoOriginal;
                    }
                  elseif($conceptoDetalle != "")
                    {
                      $conceptoDetalle = $_POST["conceptoDetalle"];
                    }
                  else 
                    {
                      $conceptoDetalle = $conceptoOriginal; 
                    }
                  if($cargo = $_POST["cargo"] > 0 || $abono = $_POST["abono"] > 0)
                    {
                      $cargo           = $_POST["cargo"];
                      $abono           = $_POST["abono"]; 
                      
                    }
                  else
                    {
                      $cargo = 0;  
                      $abono = 0;
                      
                    }
                }
             else
                {
                  $cargo = 0;
                  $abono = 0;
                  $conceptoDetalle = "CONCEPTO";
                }
                  $abono;
                  $cargo; 
                  $idCuentaContable   = $this->uri->segment(3,0);//3 es la posición del de la cuenta de la posicion de la url
                  $idPartida  = $this->uri->segment(4,0);
                  $idCheque   = $this->uri->segment(5,0);
                  //$codigoCliente    = $this->uri->segment(4,0);//4 es la posición del cliente
                  //$porcentaje       = $this->uri->segment(5,0);//5 es la posicion del porcentaje si tiene, si no tiene tendrá el valor de 0
                  //$buscarCliente    = $this->Mimodelobuscar->BuscarClietneParaEnviarPedio($codigoCliente);
                  $cuantaContableAbuscar  = $this->Mimodelobuscar->BuscarCuentasContablesAgregarApartida($idCuentaContable);
                  //print_r($cuantaContableAbuscar);
                  if($cuantaContableAbuscar)// && $buscarCliente)
                    {
                      if(!in_array($idCuentaContable, $_SESSION["cuentasAlaPartida"]))
                        {
                          $_SESSION["cuentasAlaPartida"][$idCuentaContable] = array(
                            "id" =>$cuantaContableAbuscar[0]->id,
                            "codigo" =>$cuantaContableAbuscar[0] ->codigo,
                            "nombre" =>$cuantaContableAbuscar[0] ->nombre,
                            "conceptoDetalle"=>$conceptoDetalle,
                            "cargo" =>$cargo,
                            //"codigoUsuario"=>$buscarCliente[0]->codigo_cliente,
                            //"porcentaje"=>$porcentaje
                            "abono"=>$abono
                            );
                          //$_SESSION["carro"] = $carro;
                          return redirect(base_url()."micontrolador/VistaCrearPartidaDetallesPruebas/$idPartida/$idCheque/");
                        }
                    }
              }
            else
              {
                $this->ErrorNoAutenticado();
              }      
    }
   public function EliminarDetallesPartidas()//elimina todos los detalles de la prtida
    {
       @session_start();
       $idPartida  = $this->uri->segment(3,0);//3 es la posición del id de la partida que no esta procesada de cheque
       $idCheque   = $this->uri->segment(4,0);//4 es la picicion del id del cheuqe
       unset($_SESSION["cuentasAlaPartida"]);
      redirect(base_url()."micontrolador/VistaCrearPartidaDetalles/$idPartida/$idCheque/");
    }
  public function EliminarLineaDetallesPartidas()//elimina una linea del detalle de la partidas por codigo de la partadia
    {
      $idCuentaContable = $this->uri->segment(3,0);//3 es la posición del elemento del array
      //ide de la partida simpre tengo que enviarlo porque si no pierde el resultado y no lo muestra en la partida
      $idPartida  = $this->uri->segment(4,0);//4 es la posición del id de la partida que no esta procesada de cheque
      $idCheque   = $this->uri->segment(5,0);//5 es la pocision del id del cheuqe par la partida que se ha cerado
      @session_start();
       if(!in_array($idCuentaContable, $_SESSION["cuentasAlaPartida"])) {
            unset($_SESSION["cuentasAlaPartida"][$idCuentaContable]);
      }	
     	return redirect(base_url()."micontrolador/VistaCrearPartidaDetalles/$idPartida/$idCheque/");
    } 
  public function GuardarYcontabilizar()//funcion que guarda los detalles de la partida elejida
   {
    $estaLogueado = $this->EstaLogueado(158);//id en la tabla modulo
    if($estaLogueado == true)
      {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["totalcargos"]) && isset($_POST["totalabonos"]))
          {
             $totalCargos           = str_replace(',', '', $_POST["totalcargos"]);
             $totalAbonos           = str_replace(',', '', $_POST["totalabonos"]);
             
             //$idPartida             = $this->uri->segment(3,0);//traigo del uri(url) el segmento que contiene el codigo de la partida
             $idChequeNoProcesado   = $this->uri->segment(4,0);//traigo del uri(url) el segmenteo que corresponde al id del cheque
			 //traigo el id de la partid creada por estre id del cheque para que pueda mostrar el header(encabedado de la partida)y los detalles
		  //de la misama
			  $traerIdDeLaPartidaCreadaPorChequeOTransferencia	= $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorChequeOTransferencia($idChequeNoProcesado);
			  $idPartida							= $traerIdDeLaPartidaCreadaPorChequeOTransferencia[0]->id;
             if($totalCargos == $totalAbonos && $totalCargos != "" && $totalAbonos != "")
              {
                 $cuentaEnLaSesionLlave = array_keys($_SESSION["cuentasAlaPartida"]);
                  ///recorriendo el array de la sesion cuentasAlaPartida
                  for($i = 0; $i < count($cuentaEnLaSesionLlave); $i ++) 
                      {
                          $enviarDatosAfuncion = $_SESSION["cuentasAlaPartida"][$cuentaEnLaSesionLlave[$i]];//un array que esta dentro de otro array y este dentor de un array
                          $insertar = $this->Mimodeloinsertar->GuardarYcontabilizar($enviarDatosAfuncion, $idPartida, $totalCargos, $totalAbonos, $idChequeNoProcesado);
                      }
                  if($insertar == true)
                    {
                      return redirect(base_url()."micontrolador/VistaCheque/$idPartida/1029/");
                     //eliiminio la sesion que contine los detalles de las cuentas de la partida
                     @session_start();
                      unset($_SESSION["cuentasAlaPartida"]);
                    }
                  else
                    {
                      return redirect(base_url()."micontrolador/VistaCrearPartidaDetalles/$idPartida/1029/");
                    }
              }
             else
              {
                return redirect(base_url()."micontrolador/VistaCrearPartidaDetalles/$idPartida");
              }
           }  
      }
    else
      {
        $this->ErrorNoAutenticado(); 
      }
  }
 public function GuardarYcontabilizarCXP()//funcion que guarda los detalles de la partida elejida para los cheques emitidos a los proveedores que se les debe
   {
    $estaLogueado = $this->EstaLogueado(158);
    if($estaLogueado == true)
      {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["totalcargos"]) 
        && isset($_POST["totalabonos"]) && isset($_POST["cargo"])
        &&  isset($_POST["abono"])  && isset($_POST["conceptodecuenta"])
        && isset($_POST["idcheque"]))
          {
           
             $totalCargos           = str_replace(',', '', $_POST["totalcargos"]);
             $totalAbonos           = str_replace(',', '', $_POST["totalabonos"]);
             $cargo                 = str_replace(',', '', $_POST["cargo"]);
             $abono                 = str_replace(',', '', $_POST["abono"]);
             $concepto              = $_POST["conceptodecuenta"];
             $idChequeNoProcesado   = $_POST["idcheque"]; 
              /*inicio*/
              //busco la cuenta contable de los proveedores de servicios
             $cuentaContable        = $this->Mimodelobuscar->ListarDatosCuentaProveedorServicios();  
             $idCcontable           = $cuentaContable[0]->id;
             $codigoContable        = $cuentaContable[0]->codigo;
             $nombreContable        = $cuentaContable[0]->nombre;
             /*fin*/
             
             $idPartida             = $this->uri->segment(3,0);//traigo del uri(url) el segmento que contiene el codigo de la partida
             if($totalCargos == $totalAbonos && $totalCargos != "" && $totalAbonos != ""
                && $cargo != ""  && $idChequeNoProcesado != ""
                )
              {
                                                                                                                                                        
                    $insertar = $this->Mimodeloinsertar->GuardarYcontabilizarCXP($idPartida, $idCcontable,  $codigoContable, $nombreContable, $concepto, $cargo, $abono, $totalCargos, $totalAbonos, $idChequeNoProcesado);
                    
                  if($insertar == true)
                    {
                      return redirect(base_url()."micontrolador/VistaCheque/$idPartida/1029/");
                     
                    }
                  else
                    {
                      return redirect(base_url()."micontrolador/VistaCrearPartidaDetallesCXP/$idPartida/1029/");
                    }
              }
             else
              {
                return redirect(base_url()."micontrolador/VistaCrearPartidaDetallesCXP/$idPartida/$idChequeNoProcesado/");
              }
           }  
      }
    else
      {
        $this->ErrorNoAutenticado(); 
      }
  }
 public function VistaImprimirChequeProcesado()
  {
    $estaLogueado = $this->EstaLogueado(161);//id de la vista en la tabla modulo
    if($estaLogueado == TRUE)
      {
        $idCheque = $this->uri->segment(3,0);//codigo del cheque traido desde la url
		
		$idCuentaBancaria = $this->uri->segment(6,0); //traido desde la url
		
		//veo si se ecribio algo en el campo numero cheque de la ventana emergente
		$numeroChequeque = $this->uri->segment(7,0);
		if($numeroChequeque != "")// si he escrito algo ese numero de cheque asignare, sion que lo buscque en la tabla ban_cheque
			{
				$numeroChequeque = $numeroChequeque;
				//veo si ese numero no ha sido asginado a esa misma cuenta bancaria
				$verSiEseNumeroChequeNoAsidoAsignadoMismaCuenta = $this->Mimodelobuscar->verSiEseNumeroChequeNoAsidoAsignadoMismaCuenta($idCuentaBancaria, $numeroChequeque);
			}
		else
			{
		
				//entonces, el numero del cheque se agarra
				 //de la tabla ban_cuenta_bancaria del último cheque emitido
				 
				$buscarUltimoNumeroCheque = $this->Mimodelobuscar->BuscarUltimoNumeroChequeTablaCuentaBancaria($idCuentaBancaria);
				$numeroChequeque = $buscarUltimoNumeroCheque[0]->ultimo_numero_cheque;
				$verSiEseNumeroChequeNoAsidoAsignadoMismaCuenta = 0;
			}
		if($verSiEseNumeroChequeNoAsidoAsignadoMismaCuenta == 0)
			{
				///busco el id de la partida
				$traerIdPartida = $this->Mimodelobuscar->ListarDatosParaImprimirChequeProcesado($idCheque);
				$idPartida		= $traerIdPartida[0]->id;
				
				//actualizo la tabla con el nuevo cheque a imprimir y el numero de cheque a los conceptos 
				//de del cheque y de la partida junto con su detalle partida
				$actualizarNumeroCheque = $this->Mimodeloactualizar->ActualizarNumeroCheque($idCuentaBancaria, $numeroChequeque, $idCheque, $idPartida);
		  
				 //envio el numero de chque a la vista par que se visto en un mensaje emergente.
				$mostrar["numeroCheque"]						   = $numeroChequeque;
				$mostrar["listarDatosParaImprimirChequeProcesado"] = $this->Mimodelobuscar->ListarDatosParaImprimirChequeProcesado($idCheque);
				$mostrar["listarPartida"] = $this->Mimodelobuscar->ListarPartida($idCheque);
				$this->Mimodeloactualizar->ActualizarChequeImpreso($idCheque);
				$mostrar["contenido"] = "vista_imprimir_cheque_procesado";
				$this->load->view("vista_imprimir_cheque_procesado", $mostrar);
			}
		else
			{
				return redirect(base_url()."micontrolador/VistaCheque/0/301/");
			}
         
      }
    else
      {
        $this->ErrorNoAutenticado();      
      }
  }
 public function VistaRemprimirImprimirChequeProcesado()
  {
    $estaLogueado = $this->EstaLogueado(161);//id de la vista en la tabla modulo
    if($estaLogueado == TRUE)
      {
        $idCheque = $this->uri->segment(3,0);//codigo del cheque traido desde la url
		
		$numeroChequeque  = $this->uri->segment(6,0);
		
				///busco el id de la partida
				$traerIdPartida = $this->Mimodelobuscar->ListarDatosParaImprimirChequeProcesado($idCheque);
				$idPartida		= $traerIdPartida[0]->id;
		  
				 //envio el numero de chque a la vista par que se visto en un mensaje emergente.
				$mostrar["numeroCheque"]						   = $numeroChequeque;
				$mostrar["listarDatosParaImprimirChequeProcesado"] = $this->Mimodelobuscar->ListarDatosParaImprimirChequeProcesado($idCheque);
				$mostrar["listarPartida"] = $this->Mimodelobuscar->ListarPartida($idCheque);
				$this->Mimodeloactualizar->ActualizarChequeImpreso($idCheque);
				$mostrar["contenido"] = "vista_imprimir_cheque_procesado";
				$this->load->view("vista_imprimir_cheque_procesado", $mostrar);
         
      }
    else
      {
        $this->ErrorNoAutenticado();      
      }
  }
public function VistaImprimirTransferencia()
  {
    $estaLogueado = $this->EstaLogueado(161);//id de la vista en la tabla modulos
    if($estaLogueado == TRUE)
      {
        $idCheque = $this->uri->segment(3,0);//codigo del cheque traido desde la url
        $mostrar["listarDatosParaImprimirChequeProcesado"] = $this->Mimodelobuscar->ListarDatosParaImprimirChequeProcesado($idCheque);
        $mostrar["listarPartida"] = $this->Mimodelobuscar->ListarPartida($idCheque);
        //$this->Mimodeloactualizar->ActualizarChequeImpreso($idCheque);
        $mostrar["contenido"] = "vista_imprimir_transferencia";
        $this->load->view("vista_imprimir_transferencia", $mostrar);
         
      }
    else
      {
        $this->ErrorNoAutenticado();      
      }
  }
 public function VistaImprimirTranssaccion()
  {
    $estaLogueado = $this->EstaLogueado(158);
    if($estaLogueado == TRUE)
      {
        $idTras = $this->uri->segment(3,0);//codigo de la transaccion traido desde la url
        $mostrar["listarDatosParaImprimirTransaccion"] = $this->Mimodelobuscar->ListarDatosParaImprimirTransaccion($idTras);
        $mostrar["listarPartida"] = $this->Mimodelobuscar->ListarPartidaTransaccion($idTras);
        //$this->Mimodeloactualizar->ActualizarChequeImpreso($idCheque);
        $mostrar["contenido"] = "vista_imprimir_trasaccion";
        $this->load->view("vista_imprimir_trasaccion", $mostrar);
         
      }
    else
      {
        $this->ErrorNoAutenticado();      
      }
  }    
 public function Interactivo()
  {
    if($_POST)
    {
       
      
      $q=$_POST['buscarpalabra'];
      
      $mostrar["busquedaInteractiva"] = $this->Mimodelobuscar->BusquedaInteractiva($q);
      $mostrar["contenido"] ="vista_interactiva";
      $this->load->view("vista_interactiva", $mostrar);
    }
  }
 
 public function VistaChequePorCuentaPorPagar()
    {
      $estaLogueado = $this->EstaLogueado(156);//id de la vista en la tabla modulo
      if($estaLogueado == TRUE)                     
        {
          
          $mostrar["listarCuentasBancairas"] = $this->Mimodelobuscar->ListarCuentasBancarias();
          $mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas();
          $mostrar["contenido"] = "vista_nuevo_cheque_cuenta_por_pagar";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
 public function VistaBuscarProveedorCuentaPorPagar()
    {
      $estaLogueado = $this->EstaLogueado(156);
      if($estaLogueado == TRUE)                     
        {
               
              $filtro = $this->uri->segment(3,0);
              $idProveedor = $this->uri->segment(4,0);
              $mostrar["listarProveedorCXP"] = $this->Mimodelobuscar->ListarProveedoreCXP($filtro);
              $mostrar["listarCXP"] = $this->Mimodelobuscar->ListarCXP($idProveedor); 
              $mostrar["contenido"] = "vista_buscar_proveedores_para_cheque_cxp";
              $this->load->view("vista_buscar_proveedores_para_cheque_cxp", $mostrar);
         
          
          
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function AgregarAbonoAsesion()
    { 
      $estaLogueado = $this->EstaLogueado(156);
      if($estaLogueado == TRUE)
         {
      			if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["abono"])
                && isset($_POST["cargo"]) 
                && isset($_POST["referencia"]))
                {
                  $abono      = $_POST["abono"];
                  $referencia = $_POST["referencia"];
                  $cargo      = $_POST["cargo"];
                  if($referencia != "")
                    {
                      $referencia = $_POST["referencia"];
                    }
                    
                  if($abono > 0 && $abono <= $cargo)
                    {
                      $abono           = $_POST["abono"]; 
                      
                    }
                  else
                    {
                       $abono = $cargo; 
                      
                    }
          
                  $idCuentaPorPagar   = $this->uri->segment(3,0);//3 es la posición del del id de la cuenta x pagar de la posicion de la url
                  $codigoProveedor    = $this->uri->segment(4,0);
                  $idProveedor        = $this->uri->segment(5,0);
                  
                   $idCuentaPorPagarAbuscar  = $this->Mimodelobuscar->ListarCXPagregarAsesion($idCuentaPorPagar);
                  //print_r($cuantaContableAbuscar);
                  if($idCuentaPorPagarAbuscar)// && $buscarCliente)
                    {
                      if(!in_array($idCuentaPorPagar, $_SESSION["agregarAbonos"]))
                        {
                          $_SESSION["agregarAbonos"][$idCuentaPorPagar] = array(
                            "id" =>$idCuentaPorPagarAbuscar[0]->id,
                            "documento" =>$idCuentaPorPagarAbuscar[0] ->documento,
                            //"nombre" =>$cuantaContableAbuscar[0] ->nombre,
                            "referencia"=>$referencia,
                            "cargo" =>$cargo,
                            //"codigoUsuario"=>$buscarCliente[0]->codigo_cliente,
                            //"porcentaje"=>$porcentaje
                            "abono"=>$abono
                            );
                          //$_SESSION["carro"] = $carro;
                          return redirect(base_url()."micontrolador/VistaBuscarProveedorCuentaPorPagar/$codigoProveedor/$idProveedor/");
                        }
                    }
                }
           
              }
            else
              {
                $this->ErrorNoAutenticado();
         }      
    }
  public function EliminarLineaAbonoAgregdo()//elimina una linea del del abono agregado
    {
        $idCuentaPorPagar   = $this->uri->segment(3,0);//3 es la posición del del id de la cuenta x pagar de la posicion de la url
        $codigoProveedor    = $this->uri->segment(4,0);
        $idProveedor        = $this->uri->segment(5,0);
        @session_start();
       if(!in_array($idCuentaPorPagar, $_SESSION["agregarAbonos"])) {
            unset($_SESSION["agregarAbonos"][$idCuentaPorPagar]);
      }	
     	return redirect(base_url()."micontrolador/VistaBuscarProveedorCuentaPorPagar/$codigoProveedor/$idProveedor/");
    }
  public function EliminarTodosAbonoAgregdo()//elimina una linea del del abono agregado
    {

        $codigoProveedor    = $this->uri->segment(3,0);
        $idProveedor        = $this->uri->segment(4,0);
        @session_start();
       unset($_SESSION["agregarAbonos"]);	
     	return redirect(base_url()."micontrolador/VistaBuscarProveedorCuentaPorPagar/$codigoProveedor/$idProveedor/");
    }
  public function RegistrarChequeCxP()
    {
      $estaLogueado = $this->EstaLogueado(156);//creacion de cheque id de la vista en la tabla modulo
      if($estaLogueado == TRUE)                     
        {
          if($_SERVER["REQUEST_METHOD"] === "POST" 
              && isset($_POST["cuenta"])
              && isset($_POST["codigo"]) 
              && isset($_POST["anombrede"]) 
              && isset($_POST["tipopartida"]) 
              && isset($_POST["fecha"]) 
              && isset($_POST["concepto"])
              && isset($_POST["idproveedor"]))
              {
              
                 $cuenta      = $_POST["cuenta"];
                 $codigoProve = $_POST["codigo"];
                 $anombrede   = $_POST["anombrede"];
                 $monto       = str_replace(',', '', $_POST["monto"]);
                 $tipoPartida = $_POST["tipopartida"];
                 $fecha       = $_POST["fecha"];
                 $concepto    = $_POST["concepto"];
				 
				 /*inicio*/
				 //para coartar en lineas el concepto ya que si no le pongo esto me lo guara en un sola linea
				 $textoLargo = $concepto;
				 $largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
			     $rompeLineas = '</br>';
			     $romper_palabras_largas = true; // rompe una palabra si es demacido larga
				 $concepto = wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
				/*fin*/
				
				
                 $idProveedor      = $_POST["idproveedor"];
                 $idUsuario = $this->session->userdata("id");
                 $userName = $this->session->userdata("username");
                 //$numeroCheque  = 0;
                if($cuenta != "" && $anombrede != "")
                  {
                    

                      //generando el correlativo de la partida
                      $buscarCorrelativoPartida = $this->Mimodelobuscar->BuscarCorrlativoPartida($tipoPartida, $fecha);
                      if($buscarCorrelativoPartida)  //si hay correlativo para ese tipo de partida y fecha que sume uno mas para el siguiente numero
                        {
                          //traigo es correlativo
                          $extraerCorrelativoPartida = $this->Mimodelobuscar->ExtraerCorrelativoPartida($tipoPartida, $fecha);
                          $numeroSiguienteCorrelativoPartida =  $extraerCorrelativoPartida[0]->correlativo + 1;
                          
                          // y actualizo ese correlativo anterior
                          $this->Mimodeloactualizar->ActualizarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida);
                        }
                      else //si ese tipo de partida no teien correlativo lo inserto
                        {
                           $numeroSiguienteCorrelativoPartida = 1;
                           //inserto el correlativo 1
                           $this->Mimodeloinsertar->InsertarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida);
                           
                           
                        }
      
                      $traerIdCuentaContable = $this->Mimodelobuscar->TraerIdCuentaContable($cuenta);
                      $idCuentaContable =  $traerIdCuentaContable[0]->id_cuenta_contable; 
                    
                    //traigo el maximo de la tabla ban_cheque para guardarlo en la tabla contapartidas
                     $maxUltimoIdCheque = $this->Mimodelobuscar->UltimoIdChequeSinFiltro();
                     $maxIdUltimoCheque  = $maxUltimoIdCheque[0]->id_cheque + 1;
                     
                      $noIncluirNomber = 0;//Icluye el nombre 
					  $esTranferencia  = 1; //esto no es transferencia es cheque por cuanta por pagar
                      //guardo la partida  
                      $insertar = $this->Mimodeloinsertar->InsertarNuevaPartida($fecha, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $idUsuario, $esTranferencia, $anombrede, $userName, $cuenta, $idCuentaContable, $maxIdUltimoCheque, $noIncluirNomber); //$idUltimoCheque);
                      
                       
                       //$this->Mimodeloinsertar->InsertarNuevoCheque($numeroChequeque, $fecha, $monto, $anombrede, $concepto, $userName, $tipoPartida, $cuenta, $numeroSiguienteCorrelativoPartida);*/ 
                      //si se insertan los valores enviados a la
                      //tabla ban_cheque y la tabla contapartidas
                      //que inserte el detalle del cheque
                      //en la tabla ban_detalle_cheque 
                      if($insertar == true)
                         {
                           //traigo el  ultimo ide del cheque
                           $ultimoIdCheque = $this->Mimodelobuscar->UltimoIdCheque($cuenta);
                           $idUltimoCheque  = $ultimoIdCheque[0]->id_cheque;

                           //traigo el id de la partida creada a este momento por la emision del cheque
                           $traerIdDeLaPartidaCreadaPorChque = $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorChque($maxIdUltimoCheque);
                           $idDelaParidaPorCheque = $traerIdDeLaPartidaCreadaPorChque[0]->id;
                           
                           //traico el id de lacuetna, el nombre de la cuenta y i el id de la cuenta
                           //si las tablas estubieran relacionadas este proceso no seia necesario
                           $buscarIdCodigoYnombreCuenta = $this->Mimodelobuscar->BuscarIdCodigoYnombreCuenta($idCuentaContable);
                           $idCuenta                    = $buscarIdCodigoYnombreCuenta[0]->id;
                           $codigoCuenta                = $buscarIdCodigoYnombreCuenta[0]->codigo;
                           $nombreCuenta                = $buscarIdCodigoYnombreCuenta[0]->nombre;
                           /*fin del la codificacion innesaria si estubieran relacionadas**/
                            $noIncluirNomber = 2;//incluye el nombre en el detalle
                            //inseto el detalle del chque y el primer detalle de la partida original
                             $insertarDetalleCheque = $this->Mimodeloinsertar->InsertarDetalleCheque($concepto, $monto, $idUltimoCheque, $idCuentaContable, $idDelaParidaPorCheque, $idCuenta, $codigoCuenta, $nombreCuenta, $anombrede, $noIncluirNomber, $esTranferencia);
                           
						   
						   /*busco los datos del registro creado para cuadrar la partida y no enviarle al formulario
								VistaCrearPartidaDetallesCXP debe contabilizarse automaticamente solo en este caso que es tranferencia a proveedores*/
								$traerCuentaContableDeProveedor				 	= $this->Mimodelobuscar->ListarDatosCuentaProveedorServicios();
								$idCuetnaProveedor								= $traerCuentaContableDeProveedor[0]->id;
								$codigoCuentaProveedor							= $traerCuentaContableDeProveedor[0]->codigo;
								$nombreCuentaProveedor							= $traerCuentaContableDeProveedor[0]->nombre;
								//$mostrar["listarPartidaNoProcesadaCheque"]      = $this->Mimodelobuscar->ListarPartidaNoProcesadaCheque($idDelaParidaPorCheque, $idUltimoCheque);
								//$mostrar["listarPrimerDetallePartida"]          = $this->Mimodelobuscar->ListarPrimerDetallePartida($idDelaParidaPorCheque);
								
								//cuadro la partida
								$esTrasfeEntreCuentasCXP = 0;
								$insertarParaCuadrarPartida						= $this->Mimodeloinsertar->InsertarParaCuadrarPartida($idDelaParidaPorCheque, $idCuetnaProveedor,  $codigoCuentaProveedor, $nombreCuentaProveedor, $concepto, $monto, $idUltimoCheque, $esTrasfeEntreCuentasCXP);
                               
						   
						   if($insertarDetalleCheque == true)
                              {
							  
                                $idCuentaPorPagarEnLaSesionLlave = array_keys($_SESSION["agregarAbonos"]);
                                ///recorriendo el array de la sesion cuentasAlaPartida
                                for($i = 0; $i < count($idCuentaPorPagarEnLaSesionLlave); $i ++) 
                                    {
                                        $enviarDatosAfuncion = $_SESSION["agregarAbonos"][$idCuentaPorPagarEnLaSesionLlave[$i]];//un array que esta dentro de otro array y este dentor de un array
                                        $insertarAbonos = $this->Mimodeloinsertar->InsertarAbonos($enviarDatosAfuncion, $idProveedor, $idDelaParidaPorCheque, $fecha, $concepto);
                                    }
                                 
                                if($insertarAbonos) //si se insertaron los abonos que borre la sesion
                                  {
                                    unset($_SESSION["agregarAbonos"]);//elimino los datos de la sesion de los abonos
                                    //redirect(base_url()."micontrolador/VistaCrearPartidaDetallesCXP/$idDelaParidaPorCheque/$maxIdUltimoCheque/");
									redirect(base_url()."micontrolador/VistaCheque/$idDelaParidaPorCheque/1029/");
									exit;
                                  }
                              }
                          }
                        else
                          {
                               redirect(base_url()."micontrolador/VistaNuevoCheque/300/");
                                  
                              
                           }   
                  }
                else
                  {
                        $this->VistaNuevoCheque();
                  }
                 
              }
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function RegistrarChequeCxPtransferencia()
    {
      $estaLogueado = $this->EstaLogueado(156);
      if($estaLogueado == TRUE)                     
        {
          if($_SERVER["REQUEST_METHOD"] === "POST" 
              && isset($_POST["cuenta"])
              && isset($_POST["codigo"]) 
              && isset($_POST["anombrede"]) 
              && isset($_POST["tipopartida"]) 
              && isset($_POST["fecha"]) 
              && isset($_POST["concepto"])
              && isset($_POST["idproveedor"]))
              {
              
                 $cuenta      = $_POST["cuenta"];
                 $codigoProve = $_POST["codigo"];
                 $anombrede   = $_POST["anombrede"];
                 $monto       =  str_replace(',', '', $_POST["monto"]);
                 $tipoPartida = $_POST["tipopartida"];
                 $fecha       = $_POST["fecha"];
                 $concepto    = $_POST["concepto"];
				 
				 	 /*inicio*/
				 //para coartar en lineas el concepto ya que si no le pongo esto me lo guara en un sola linea
				 $textoLargo = $concepto;
				 $largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
			     $rompeLineas = '</br>';
			     $romper_palabras_largas = true; // rompe una palabra si es demacido larga
				 $concepto = wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
				/*fin*/
				
				
                 $idProveedor      = $_POST["idproveedor"];
                 $idUsuario = $this->session->userdata("id");
                 $userName = $this->session->userdata("username");
                 //$numeroCheque  = 0;
                if($cuenta != "" && $anombrede != "")
                  {
                     
                      //generando el correlativo de la partida
                      $buscarCorrelativoPartida = $this->Mimodelobuscar->BuscarCorrlativoPartida($tipoPartida, $fecha);
                      if($buscarCorrelativoPartida)  //si hay correlativo para ese tipo de partida y fecha que sume uno mas para el siguiente numero
                        {
                          //traigo es correlativo
                          $extraerCorrelativoPartida = $this->Mimodelobuscar->ExtraerCorrelativoPartida($tipoPartida, $fecha);
                          $numeroSiguienteCorrelativoPartida =  $extraerCorrelativoPartida[0]->correlativo + 1;
                          
                          // y actualizo ese correlativo anterior
                          $this->Mimodeloactualizar->ActualizarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida);
                        }
                      else //si ese tipo de partida no teien correlativo lo inserto
                        {
                           $numeroSiguienteCorrelativoPartida = 1;
                           //inserto el correlativo 1
                           $this->Mimodeloinsertar->InsertarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida);
                           
                           
                        }
                
          
                      $traerIdCuentaContable = $this->Mimodelobuscar->TraerIdCuentaContable($cuenta);
                      $idCuentaContable =  $traerIdCuentaContable[0]->id_cuenta_contable; 
                    
                    //traigo el maximo de la tabla ban_cheque para guardarlo en la tabla contapartidas
                     //ANTES PERO ESTO ME DA EROR PORUQE SE VAN A REPETIR LOS NUM DE CHEQUES $maxUltimoIdCheque  = $this->Mimodelobuscar->UltimoIdCheque($cuenta);
                     $maxUltimoIdCheque  = $this->Mimodelobuscar->UltimoIdChequeSinFiltro();
					 $maxIdUltimoCheque  = $maxUltimoIdCheque[0]->id_cheque + 1;
                       
                      $numeroChequeque   = NULL; //porque el momiviento es transfenecia no con cheque
                      $noIncluirNomber   = 0;//pra que no inclua el nombre en el cocepto de la parsona o institucion a quien se emite el cheque
                      //guardo la partida  
                      $insertar = $this->Mimodeloinsertar->InsertarNuevaPartida($fecha, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $idUsuario, $numeroChequeque, $anombrede, $userName, $cuenta, $idCuentaContable, $maxIdUltimoCheque, $noIncluirNomber); //$idUltimoCheque);
                      
                       
 
                      //si se insertan los valores enviados a la
                      //tabla ban_cheque y la tabla contapartidas
                      //que inserte el detalle del cheque
                      //en la tabla ban_detalle_cheque 
                      if($insertar == true)
                         {
                           //traigo el  ultimo ide del cheque
                           $ultimoIdCheque = $this->Mimodelobuscar->UltimoIdCheque($cuenta);
                           $idUltimoCheque  = $ultimoIdCheque[0]->id_cheque;
                           
                           //traigo el id de la partida creada a este momento por la emision del cheque
                           $traerIdDeLaPartidaCreadaPorChque = $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorChque($maxIdUltimoCheque);
                           $idDelaParidaPorCheque = $traerIdDeLaPartidaCreadaPorChque[0]->id;
                           
                           //traico el id de lacuetna, el nombre de la cuenta y i el id de la cuenta
                           //si las tablas estubieran relacionadas este proceso no seia necesario
                           $buscarIdCodigoYnombreCuenta = $this->Mimodelobuscar->BuscarIdCodigoYnombreCuenta($idCuentaContable);
                           $idCuenta                    = $buscarIdCodigoYnombreCuenta[0]->id;
                           $codigoCuenta                = $buscarIdCodigoYnombreCuenta[0]->codigo;
                           $nombreCuenta                = $buscarIdCodigoYnombreCuenta[0]->nombre;
                           /*fin del la codificacion innesaria si estubieran relacionadas**/
                            $noIncluirNomber = 2;//incluye el nombre en el detalle
                            $numeroChequeque = 0;
                            
                            //inseto el detalle del chque y el primer detalle de la partida original
                             $insertarDetalleCheque = $this->Mimodeloinsertar->InsertarDetalleCheque($concepto, $monto, $idUltimoCheque, $idCuentaContable, $idDelaParidaPorCheque, $idCuenta, $codigoCuenta, $nombreCuenta,$anombrede, $noIncluirNomber, $numeroChequeque);
                           if($insertarDetalleCheque == true)
                              {
								/*busco los datos del registro creado para cuadrar la partida y no enviarle al formulario
								VistaCrearPartidaDetallesCXP debe contabilizarse automaticamente solo en este caso que es tranferencia a proveedores*/
								$traerCuentaContableDeProveedor				 	= $this->Mimodelobuscar->ListarDatosCuentaProveedorServicios();
								$idCuetnaProveedor								= $traerCuentaContableDeProveedor[0]->id;
								$codigoCuentaProveedor							= $traerCuentaContableDeProveedor[0]->codigo;
								$nombreCuentaProveedor							= $traerCuentaContableDeProveedor[0]->nombre;
								//$mostrar["listarPartidaNoProcesadaCheque"]      = $this->Mimodelobuscar->ListarPartidaNoProcesadaCheque($idDelaParidaPorCheque, $idUltimoCheque);
								//$mostrar["listarPrimerDetallePartida"]          = $this->Mimodelobuscar->ListarPrimerDetallePartida($idDelaParidaPorCheque);
								$esTrasfeEntreCuentasCXP	= 1;
								//cuadro la partida
								$insertarParaCuadrarPartida						= $this->Mimodeloinsertar->InsertarParaCuadrarPartida($idDelaParidaPorCheque, $idCuetnaProveedor,  $codigoCuentaProveedor, $nombreCuentaProveedor, $concepto, $monto, $maxIdUltimoCheque, $esTrasfeEntreCuentasCXP);
                               
										$idCuentaPorPagarEnLaSesionLlave = array_keys($_SESSION["agregarAbonos"]);
										///recorriendo el array de la sesion cuentasAlaPartida
										for($i = 0; $i < count($idCuentaPorPagarEnLaSesionLlave); $i ++) 
											{
												$enviarDatosAfuncion = $_SESSION["agregarAbonos"][$idCuentaPorPagarEnLaSesionLlave[$i]];//un array que esta dentro de otro array y este dentor de un array
												$insertarAbonos = $this->Mimodeloinsertar->InsertarAbonos($enviarDatosAfuncion, $idProveedor, $idDelaParidaPorCheque, $fecha, $concepto);
											}
										 
										if($insertarAbonos) //si se insertaron los abonos que borre la sesion
										  {
											unset($_SESSION["agregarAbonos"]);//elimino la sesion
											//redirect(base_url()."micontrolador/VistaCrearPartidaDetallesCXP/$idDelaParidaPorCheque/$maxIdUltimoCheque/");
											return redirect(base_url()."micontrolador/VistaCheque/$idDelaParidaPorCheque/1029/");
											//echo "<br>".$idDelaParidaPorCheque;
										  }
								
                              }
                          }
                        else
                          {
                               redirect(base_url()."micontrolador/VistaNuevoCheque/300/");
                                  
                              
                           }   
                  }
                else
                  {
                        $this->VistaNuevoCheque();
                  }
                 
              }
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
   /************TRANSACCIONES*/////////**/
  public function VistaTransacciones()
    {
      $estaLogueado = $this->EstaLogueado(162);///id de la vista en la tabla modulos               
      if($estaLogueado == TRUE)                     
        {
        
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["idcuentabanco"])
              && isset($_POST["fechabanco"])
              && isset($_POST["fechabancohasta"]))
            {
             
                  $filtro                    = "";
                  $cuentaBancaria            = $_POST["idcuentabanco"];
                  $fechaBanco                = $_POST["fechabanco"];
                  $fechaBancoHasta           = $_POST["fechabancohasta"];
                  $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
        
                  $mostrar["listarTransacciones"]  = $this->Mimodelobuscar->ListarTransacciones($cuentaBancaria, $fechaBanco, $fechaBancoHasta);
                  //$mostrar["listarChequesNoContabilizados"] = $this->Mimodelobuscar->ListarChequesNoContabilizados($filtro);
                  $mostrar["contenido"]      = "vista_transacciones";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
                {
                $filtro                    = "";   
               $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
              $mostrar["contenido"]      = "vista_transacciones";
              $this->load->view("plantilla", $mostrar);
              } 
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function VistaTiposTransacciones()
    {
      $estaLogueado = $this->EstaLogueado(163);
      if($estaLogueado == TRUE)                     
        {
           $mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas();
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"]))
            {
              $filtro                    = $_POST["filtro"];
             
                  
                  $mostrar["listarTiposTransacciones"]  = $this->Mimodelobuscar->ListarTiposTransaccion($filtro);
                  //$mostrar["listarChequesNoContabilizados"] = $this->Mimodelobuscar->ListarChequesNoContabilizados($filtro);
                  $mostrar["contenido"]      = "vista_tipos_transacciones";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
                {
                  
              //$mostrar["listarCheques"]  = $this->Mimodelobuscar->ListarChequesSinFiltro();
              //$mostrar["listarChequesNoContabilizados"] = $this->Mimodelobuscar->ListarChequesNoContabilizadosSinFiltro();
              $mostrar["contenido"]      = "vista_tipos_transacciones";
              $this->load->view("plantilla", $mostrar);
              } 
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function VistaCrearTipoTransaccion()
    {
      $estaLogueado = $this->EstaLogueado(163);
      if($estaLogueado == TRUE)                     
        {
              $mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas();
              $mostrar["contenido"]      = "vista_crear_tipo_transaccion";
              $this->load->view("plantilla", $mostrar);
      
      
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
 public function RegistrarTipoTransaccion()
  {
     $estaLogueado = $this->EstaLogueado(163);
      if($estaLogueado == TRUE)                     
        {
        
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["tipotransaccion"])
               && isset($_POST["tipopartida"]) && isset($_POST["transaccionsaldos"]) )
            {
                  $tipoTransaccion          = $_POST["tipotransaccion"];
                  $tipoPartida              = $_POST["tipopartida"];
                  $transaccionSaldos        = $_POST["transaccionsaldos"];
             
                  if($tipoTransaccion != "" && $tipoPartida != "" && $transaccionSaldos != "")
                    {
                      $insertar = $this->Mimodeloinsertar->InsertarTiposTransaccion($tipoTransaccion, $tipoPartida, $transaccionSaldos);
                      $retorno  = $insertar[0]->RETORNO ;
                      if($retorno == 1)
                        {
                          redirect(base_url()."micontrolador/VistaCrearTipoTransaccion/400/"); 
                        }
                      else
                        {
                          redirect(base_url()."micontrolador/VistaCrearTipoTransaccion/300/"); 
                        }
                    }
                  $mostrar["listarCheques"]  = $this->Mimodelobuscar->ListarTodosLosCheques($filtro);
                  //$mostrar["listarChequesNoContabilizados"] = $this->Mimodelobuscar->ListarChequesNoContabilizados($filtro);
                  $mostrar["contenido"]      = "vista_transacciones";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function VistaNuevaTransaccionBancaria()
  {
      $estaLogueado = $this->EstaLogueado(165);
      if($estaLogueado == TRUE)                     
        {
          $filtro =  "";
          $mostrar["listarCuentasBancairas"] = $this->Mimodelobuscar->ListarCuentasBancarias();
          $mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas();
          $mostrar["listarTiposTransaccionParaNuevaTransaccion"]  = $this->Mimodelobuscar->ListarTiposTransaccionParaNuevaTransaccion($filtro);
          $mostrar["contenido"] = "vista_nueva_transaccion_bancaria";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
 public function RegistrarTransaccionBancaria()
  {
      $estaLogueado = $this->EstaLogueado(165);
      if($estaLogueado == TRUE)                     
        {
          if($_SERVER["REQUEST_METHOD"] === "POST" 
              && isset($_POST["cuenta"])
              && isset($_POST["fechabanco"]) 
              && isset($_POST["fechacontable"])
              && isset($_POST["tipotransaccion"]) 
              /*&& isset($_POST["tipopartida"])*/ 
              && isset($_POST["monto"]) 
              && isset($_POST["concepto"]) )
              {
              
                  $cuenta               = $_POST["cuenta"];
                  $fechaBanco           = $_POST["fechabanco"]; 
                  $fechaContable        = $_POST["fechacontable"];
                  $tipoTransaccion      = $_POST["tipotransaccion"]; 
                  //$tipoPartida          = $_POST["tipopartida"]; 
                  $monto                = str_replace(',', '', $_POST["monto"]); 
                  //$contabilizar         = $_POST["contabilizar"];
                  $incluirConciliacion  = $_POST["incluirconciliacion"];
                  $concepto             = $_POST["concepto"];
				  
				  	 /*inicio*/
				 //para cortar en lineas el concepto ya que si no le pongo esto me lo guara en un sola linea
				 $textoLargo = $concepto;
				 $largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
			     $rompeLineas = '</br>';
			     $romper_palabras_largas = true; // rompe una palabra si es demacido larga
				 $concepto = wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
				/*fin*/
				  
                  $montoDebe            = 0; //para ver si la partida a generar es de debe/cargos
                  $montoHaber           = 0; //para ver si la partida a generar es de haber/abonos
                  
                 $idUsuario = $this->session->userdata("id");
                 $userName = $this->session->userdata("username");
                 //$numeroCheque  = 0;
                if($cuenta != "" && $monto != "" && $concepto != "")
                  {
                        
                       $traerParaVersiEsHaberOdebe = $this->Mimodelobuscar->TraerParaVerSiEsHaberOdebe($tipoTransaccion);
                       $trasaccionHaberOdebe       = $traerParaVersiEsHaberOdebe[0]->transaccion;
                       $tipoPartida                = $traerParaVersiEsHaberOdebe[0]->id_tipo_partida;
                       if($trasaccionHaberOdebe == 1)//si es 1 es tipo Debe/cargos
                        {
                          $montoDebe = $monto;
                        }
                       else//es de tipo Haber/abonos
                        {
                           $montoHaber = $monto;
                        }
                        //veo si se incluira en la conciliacion
                        if(isset($_POST["incluirconciliacion"]) == "on")
                          {
                            $siConciliacion = 1; //se incluye en la conciliacion
                          }
                        else
                          {
                            $siConciliacion = 0; //no se incluye en la conciliacion
                          }
                                                 
                     
						
                     //evalúo si se contablizará la transacción
                     if(isset($_POST["contabilizar"]) == "on")
                        {
                          $contabilizar = 1;//se contabilizara, generará partidas
                              //generando el correlativo de la partida
                              $buscarCorrelativoPartida = $this->Mimodelobuscar->BuscarCorrlativoPartida($tipoPartida, $fechaContable);
                              if($buscarCorrelativoPartida)  //si hay correlativo para ese tipo de partida y fecha que sume uno mas para el siguiente numero
                                {
                                  //traigo ese correlativo
                                  $extraerCorrelativoPartida = $this->Mimodelobuscar->ExtraerCorrelativoPartida($tipoPartida, $fechaContable);
                                  $numeroSiguienteCorrelativoPartida =  $extraerCorrelativoPartida[0]->correlativo + 1;
                                  
                                  // y actualizo ese correlativo anterior
                                  $this->Mimodeloactualizar->ActualizarCorrelativoPartida($tipoPartida, $fechaContable, $numeroSiguienteCorrelativoPartida);
                                }
                              else //si ese tipo de partida no teien correlativo lo inserto
                                {
                                   $numeroSiguienteCorrelativoPartida = 1;
                                   //inserto el correlativo 1
                                  $this->Mimodeloinsertar->InsertarCorrelativoPartida($tipoPartida, $fechaContable, $numeroSiguienteCorrelativoPartida);
                                   
                                   
                                }
                      
                  
                              $traerIdCuentaContable = $this->Mimodelobuscar->TraerIdCuentaContable($cuenta);
                              $idCuentaContable =  $traerIdCuentaContable[0]->id_cuenta_contable; 
                            
                              
                                //traigo el maximo de la tabla ban_transaccion para guardarlo en la tabla contapartidas
                               $maxUltimoIdTransaccion 		= $this->Mimodelobuscar->UltimoIdTransaccion();
                               $maxIdUltimoIdTransaccion  	= $maxUltimoIdTransaccion[0]->id_transaccion + 1; //par insertar el nuevo registro
                               
                                //$noIncluirNomber = 2;
                                //guardo la partida  
                                $insertar = $this->Mimodeloinsertar->InsertarNuevaPartidaTransaccionBancaria($fechaBanco, $fechaContable, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $contabilizar, $siConciliacion, $idUsuario, $userName, $cuenta, $idCuentaContable, $tipoTransaccion, $maxIdUltimoIdTransaccion); //$idUltimoCheque);
                                
                               
							   
							   /*inicio*/
								/*TODO ESTO ES PARA VER SI ES TRANSFEENCIA DE DINERO ENTRE CUENTAS BANCARIAS
								SI ES ASI QUE INSERTE UN CARGO A LA OTRA CUENTA BANCARIA SELECCIONADA
								ESTE REGISTRO DE CARGO APARECER COMO EMITIDA DESDE OTRA CUENTA BANCARIA
								*/
								 //veo si se ha chequeado le chexbox transferencia entre cuentas
								if(isset($_POST["tranferenciaentrecuentas"]) && isset($_POST["cuentaOtro"]))
									{
										$idCuentaBancairiaOtraTrnasferir = $_POST["cuentaOtro"];
										$transferirEntreCuentas = 1;
										if($transferirEntreCuentas == 1)//es transferencia enter cuentas banciarias se ha cehquedo el checkbox
										{
											
											//traigo el id de la partida creada a este momento por la emision del transacciones de la cuenta que transfirio
											 $traerIdDeLaPartidaCreadaPorTransaccion = $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorTransaccion($maxIdUltimoIdTransaccion);
											 $idDelaParidaPorTransaccion = $traerIdDeLaPartidaCreadaPorTransaccion[0]->id;
											$insertarTrasferenciaEntreCuentasTransacciones = $this->Mimodeloinsertar->InsertarCargoAcuentaBancariaTransaccion($fechaBanco, $fechaContable, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $contabilizar, $siConciliacion, $userName, $idCuentaBancairiaOtraTrnasferir, $tipoTransaccion, $idDelaParidaPorTransaccion);
											if($insertarTrasferenciaEntreCuentasTransacciones == true)//si se insertaron los header(encabezados) de las tranferenicas entre cuentas bancarias de transacciones
												{		
														//traigo el  ultimo ide de la transaccion creada por la cuenta a transferir
														$ultimoIdTransaccionTra = $this->Mimodelobuscar->UltimoIdTransaccionConFiltro($idCuentaBancairiaOtraTrnasferir);
														$idUltimoTransaccionTra = $ultimoIdTransaccionTra[0]->id_transaccion; 
														//traigo el id de la cuenta contable
														 $traerIdCuentaContableT = $this->Mimodelobuscar->TraerIdCuentaContable($idCuentaBancairiaOtraTrnasferir);
														 $idCuentaContableT =  $traerIdCuentaContableT[0]->id_cuenta_contable; 
													   //inserto los detalle de la transaccion por trasferencia de dinero entre cuentas
														$insertarDetalleTrasaccionTrasferenciaEntreCuentas = $this->Mimodeloinsertar->InsertarDetalleTransaccionTransferenciaEntreCuentas($concepto, $monto, $idCuentaContableT, $idUltimoTransaccionTra);
												}
										}
									}
								/*fin trasferencia entre cuentas*/
							   
         
                                //si se insertan los valores enviados a la
                                //tabla ban_transacciones y la tabla contapartidas
                                //que inserte el detalle de la transaccion
                                //en la tabla ban_transacciones_detalle 
                                if($insertar == true)
                                   {
                                      //traigo el  ultimo ide de la transaccion ESTO CREO QUE NO ES NCESARIIO
                                      //$ultimoIdTransaccion = $this->Mimodelobuscar->UltimoIdTransaccion();
                                     // $idUltimoTransaccion = $ultimoIdTransaccion[0]->id_transaccion; 
                                     
                                     //traigo el id de la partida creada a este momento por la emision del transacciones
                                     $traerIdDeLaPartidaCreadaPorTransaccion = $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorTransaccion($maxIdUltimoIdTransaccion);
                                     $idDelaParidaPorTransaccion = $traerIdDeLaPartidaCreadaPorTransaccion[0]->id;
                                     
                                     //traico el id de la cuenta, el nombre de la cuenta y i el id de la cuenta
                                     //si las tablas estubieran relacionadas este proceso no seia necesario
                                     $buscarIdCodigoYnombreCuenta = $this->Mimodelobuscar->BuscarIdCodigoYnombreCuentaTransaccion($idCuentaContable);
                                     $idCuenta                    = $buscarIdCodigoYnombreCuenta[0]->id;
                                     $codigoCuenta                = $buscarIdCodigoYnombreCuenta[0]->codigo;
                                     $nombreCuenta                = $buscarIdCodigoYnombreCuenta[0]->nombre;
                                     /*fin del la codificacion innesaria si estubieran relacionadas**/
                                      
                                      //inserto el detalle de la transaccion y el primer detalle de la partida original
                                       $insertarDetalleTransaccion = $this->Mimodeloinsertar->InsertarDetalleTransaccion($concepto, $montoDebe, $montoHaber, $idCuentaContable, $idDelaParidaPorTransaccion, $idCuenta, $codigoCuenta, $nombreCuenta, $maxIdUltimoIdTransaccion, $monto);
                                     if($insertarDetalleTransaccion == true)
                                        {
                                          unset($_SESSION["cuentasAlaPartidaTransaccion"]);//para eliminar todos los datos que haya de esta sesion, porque si no lo elimino pueden haber otros datos de otras partidas agregadas a la sesion
                                          redirect(base_url()."micontrolador/VistaCrearPartidaDetallesTransaccion/$idDelaParidaPorTransaccion/$maxIdUltimoIdTransaccion/");
                                        }
                                    }
                                  else
                                    {
                                         redirect(base_url()."micontrolador/VistaNuevaTransaccionBancaria/300/");
                                            
                                        
                                     }
                        }
                           else //no se contabilizará la transaccion
                            {
                              
                                
                               $contabilizar = 0;//no se contabilizará 
                               $insertarTransaccionNoContabilizada = $this->Mimodeloinsertar->InsertarNuevaPartidaTransaccionNoContabilizada($fechaBanco, $fechaContable, $concepto, $monto,  $siConciliacion, $contabilizar,  $userName, $cuenta, $tipoTransaccion, $tipoPartida);
                               //traigo el id de la cuetna contable de banco
                              $traerIdCuentaContable = $this->Mimodelobuscar->TraerIdCuentaContable($cuenta);
                              $idCuentaContable =  $traerIdCuentaContable[0]->id_cuenta_contable; 
                              
                              //si se inseto y devuelve un valor verdadero que insete los detalles
                               if($insertarTransaccionNoContabilizada == true)
                                {
                                   //traigo el  ultimo ide de la transaccion
                                      $ultimoIdTransaccion = $this->Mimodelobuscar->UltimoIdTransaccion();
                                      $idUltimoTransaccion = $ultimoIdTransaccion[0]->id_transaccion; 
                                     
                                  //inserto los detalles en la tabla ban_transacciones_detalle
                                  $insertarDetalleNoContabilizado = $this->Mimodeloinsertar->InsertarDetalleNoContabilizado($idCuentaContable, $concepto, $monto, $montoDebe, $montoHaber, $userName, $idUltimoTransaccion);
                                  
                                  //si se inserto el detalle de la transaccion retorna un valor verdadero
                                  if($insertarDetalleNoContabilizado == true)
                                    {
                                       redirect(base_url()."micontrolador/VistaTransacciones/400/400/"); 
                                    }
                                   else
                                     {
                                        redirect(base_url()."micontrolador/VistaNuevaTransaccionBancaria/300/");
                                     }
                                }
                            }
                            
                  }
                else
                  {
                        $this->VistaNuevaTransaccionBancaria();
                  } 
                 
              }
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
   
  }
 public function VistaCrearPartidaDetallesTransaccion()
    {
      $estaLogueado = $this->EstaLogueado(166);
      if($estaLogueado == true)
        { 
          
          
          //$idDelaParidaPorTransaccion  = $this->uri->segment(3,0);
          
          $idTransaccion               = $this->uri->segment(4,0);
          /*busco el id de la partida creada por esta transaccion*/
		  $traerIdPartidaPorTransaccion	= $this->Mimodelobuscar->TaerIdPartidaPorTransaccion($idTransaccion);
		  $idDelaParidaPorTransaccion	= $traerIdPartidaPorTransaccion[0]->id;//el id de la partida creada por transaccion
          $mostrar["listarPartidaNoProcesadaTransaccion"] = $this->Mimodelobuscar->ListarPartidaNoProcesadaTransaccion($idDelaParidaPorTransaccion, $idTransaccion);
          $mostrar["listarPrimerDetallePartida"] = $this->Mimodelobuscar->ListarPrimerDetallePartida($idDelaParidaPorTransaccion);
          $mostrar["contenido"] = "vista_crear_partida_detalles_transacciones";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
          $this->ErrornoAutenticado();
        }
    }
 public function InteractivoPartidaTransaccion()
  {
    if($_POST)
    {
       
      
      $q=$_POST['buscarpalabra'];//codigo o nombe de la cuenta
      
      $mostrar["busquedaInteractiva"] = $this->Mimodelobuscar->BusquedaInteractiva($q);
      $mostrar["contenido"] ="vista_interactiva_transacciones";
      $this->load->view("vista_interactiva_transacciones", $mostrar);
    }
  }
 public function AgregarCuentasAlaPartidaTransacciones()
    { 
      $estaLogueado = $this->EstaLogueado(166);
      if($estaLogueado == TRUE)
         {
      			if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["cargo"])
                && isset($_POST["abono"]) && isset($_POST["conceptoDetalle"])
                && isset($_POST["conceptoOriginal"]))
                {
                  $conceptoDetalle  = $_POST["conceptoDetalle"];
				  
				  	 /*inicio*/
				 //para coartar en lineas el concepto ya que si no le pongo esto me lo guara en un sola linea
				 $textoLargo = $conceptoDetalle;
				 $largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
			     $rompeLineas = '</br>';
			     $romper_palabras_largas = true; // rompe una palabra si es demacido larga
				 $conceptoDetalle = wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
				/*fin*/
				  
                  $conceptoOriginal = $_POST["conceptoOriginal"];
                  if($conceptoDetalle == "CONCEPTO")
                    {
                      $conceptoDetalle = $conceptoOriginal;
                    }
                  elseif($conceptoDetalle != "")
                    {
                      $conceptoDetalle = $_POST["conceptoDetalle"];
                    }
                  else 
                    {
                      $conceptoDetalle = $conceptoOriginal; 
                    }
                  if($cargo = $_POST["cargo"] > 0 || $abono = $_POST["abono"] > 0)
                    {
                      $cargo           = $_POST["cargo"];
                      $abono           = $_POST["abono"]; 
                      
                    }
                  else
                    {
                      $cargo = 0;  
                      $abono = 0;
                      
                    }
                }
             else
                {
                  $cargo = 0;
                  $abono = 0;
                  $conceptoDetalle = "CONCEPTO";
                }
                  
                  $idCuentaContable   = $this->uri->segment(3,0);//3 es la posición del de la cuenta de la posicion de la url
                  $idPartida          = $this->uri->segment(4,0);
                  $idTransaccion      = $this->uri->segment(5,0);
                  $cuantaContableAbuscar  = $this->Mimodelobuscar->BuscarCuentasContablesAgregarApartida($idCuentaContable);
                  //print_r($cuantaContableAbuscar);
                  if($cuantaContableAbuscar)// && $buscarCliente)
                    {
                      if(!in_array($idCuentaContable, $_SESSION["cuentasAlaPartidaTransaccion"]))
                        {
                          $_SESSION["cuentasAlaPartidaTransaccion"][$idCuentaContable] = array(
                            "id" =>$cuantaContableAbuscar[0]->id,
                            "codigo" =>$cuantaContableAbuscar[0] ->codigo,
                            "nombre" =>$cuantaContableAbuscar[0] ->nombre,
                            "conceptoDetalle"=>$conceptoDetalle,
                            "cargo" =>$cargo,
                            //"codigoUsuario"=>$buscarCliente[0]->codigo_cliente,
                            //"porcentaje"=>$porcentaje
                            "abono"=>$abono
                            );
                          //$_SESSION["carro"] = $carro;
                          return redirect(base_url()."micontrolador/VistaCrearPartidaDetallesTransaccion/$idPartida/$idTransaccion/");
                        }
                    }
              }
            else
              {
                $this->ErrorNoAutenticado();
              }      
    }
 public function EliminarLineaDetallesPartidasTransaccion()//elimina una linea del detalle de la partidas por codigo de la partadia
    {
      $idCuentaContable = $this->uri->segment(3,0);//3 es la posición del elemento del array
      //ide de la partida simpre tengo que enviarlo porque si no pierde el resultado y no lo muestra en la partida
      $idPartida        = $this->uri->segment(4,0);//4 es la posición del id de la partida que no esta procesada de cheque
      $idTransaccion    = $this->uri->segment(5,0);//5 es la pocision del id del cheuqe par la partida que se ha cerado
      @session_start();
       if(!in_array($idCuentaContable, $_SESSION["cuentasAlaPartidaTransaccion"])) {
            unset($_SESSION["cuentasAlaPartidaTransaccion"][$idCuentaContable]);
      }	
     	return redirect(base_url()."micontrolador/VistaCrearPartidaDetallesTransaccion/$idPartida/$idTransaccion/");
    }               
 public function EliminarDetallesPartidasTransaccion()//elimina todos los detalles de la prtida
    {
       @session_start();
       $idPartida       = $this->uri->segment(3,0);//3 es la posición del id de la partida que no esta procesada de cheque
       $idTransaccion   = $this->uri->segment(4,0);//4 es la picicion del id del cheuqe
       unset($_SESSION["cuentasAlaPartidaTransaccion"]);
      redirect(base_url()."micontrolador/VistaCrearPartidaDetallesTransaccion/$idPartida/$idTransaccion/");
    } 
 public function VistaBuscarCuentasContablesTransaciones()
    {
      $estaLogueado = $this->EstaLogueado(166);
      if($estaLogueado == TRUE)                     
        {
            
            if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"]))
              {
                $filtro = $_POST["filtro"];
                $mostrar["listarCuentasContables"] = $this->Mimodelobuscar->LlistarCuentasContables($filtro);
              //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas(); 
                $mostrar["contenido"] = "vista_buscar_cuentas_contables_transacciones";
                $this->load->view("plantilla", $mostrar);
              }
            else
              {
                $filtro = "";
                $mostrar["listarCuentasContables"] = $this->Mimodelobuscar->LlistarCuentasContables($filtro);
                $mostrar["contenido"] = "vista_buscar_cuentas_contables_transacciones";
                $this->load->view("plantilla", $mostrar);
              }
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
    }
 public function GuardarYcontabilizarTransaccion()//funcion que guarda los detalles de la partida elejida
   {
    $estaLogueado = $this->EstaLogueado(166);
    if($estaLogueado == true)
      {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["totalcargos"]) && isset($_POST["totalabonos"]))
          {
             $totalCargos           = str_replace(',', '', $_POST["totalcargos"]);
             $totalAbonos           = str_replace(',', '', $_POST["totalabonos"]);
             
             //antes $idPartida                  = $this->uri->segment(3,0);//traigo del uri(url) el segmento que contiene el codigo de la partida
             $idTransaccionNoprocesada   = $this->uri->segment(4,0);//traigo del uri(url) el segmenteo que corresponde al id de la transaccion
             /*busco el id de la partida creada por esta transaccion*/
			  $traerIdPartidaPorTransaccion	= $this->Mimodelobuscar->TaerIdPartidaPorTransaccion($idTransaccionNoprocesada);
			  $idPartida			 		= $traerIdPartidaPorTransaccion[0]->id;//el id de la partida creada por transaccion
             if($totalCargos == $totalAbonos && $totalCargos != "" && $totalAbonos != "")
              {
                 /*inico*/
                 //trayendo el corelativo de la pertida creada
				 $traerCorrelativoPartida    = $this->Mimodelobuscar->TraerCorrelativoPartida($idPartida);
                 $correlativoPartida         = $traerCorrelativoPartida[0]->correlativo; 
                 $cuentaEnLaSesionLlave = array_keys($_SESSION["cuentasAlaPartidaTransaccion"]);
                  ///recorriendo el array de la sesion cuentasAlaPartida
                  for($i = 0; $i < count($cuentaEnLaSesionLlave); $i ++) 
                      {
                          $enviarDatosAfuncion = $_SESSION["cuentasAlaPartidaTransaccion"][$cuentaEnLaSesionLlave[$i]];//un array que esta dentro de otro array y este dentor de un array
                          $insertar = $this->Mimodeloinsertar->GuardarYcontabilizarTransaccion($enviarDatosAfuncion, $idPartida, $totalCargos, $totalAbonos, $idTransaccionNoprocesada, $correlativoPartida);
                      }
                  if($insertar == true)
                    {
                      //eliiminio la sesion que contine los detalles de las cuentas de la partida
                     @session_start();
                      unset($_SESSION["cuentasAlaPartidaTransaccion"]);
                      return redirect(base_url()."micontrolador/VistaTransacciones/$idPartida/1029/");
                     
                    }
                  else
                    {
                      return redirect(base_url()."micontrolador/VistaCrearPartidaDetallesTransaccion/$idPartida/$idTransaccionNoprocesada/1029/");
                    }
              }
             else
              {
                return redirect(base_url()."micontrolador/VistaCrearPartidaDetallesTransaccion/$idPartida/$idTransaccionNoprocesada/");
              }
           }  
      }
    else
      {
        $this->ErrorNoAutenticado(); 
      }
  }
 public function ContabilizarTrnasaccionBancaria()//por si no se habia contabilizado cuando descheque el chexbox de contabilizar SIN COMPLETAR AUN
	{
		$estaLogueado = $this->EstaLogueado(166);
      if($estaLogueado == TRUE)                     
        {
			$idTransaccion					= $this->uri->segment(4,0); //3 sera un aleatoria distractor
			$taerTransaccionAcontabilizar	= $this->Mimodelobusvar->TaerTransaccionAcontabilizar($idTransaccion);
			$tipoTransaccion				= $taerTransaccionAcontabilizar[0]->id_tipo;
			$fechaContable					= $taerTransaccionAcontabilizar[0]->fecha_contable;
			$cuenta							= $taerTransaccionAcontabilizar[0]->id_cuenta_bancaria;
			
			$traerParaVersiEsHaberOdebe 	= $this->Mimodelobuscar->TraerParaVerSiEsHaberOdebe($tipoTransaccion);
            $trasaccionHaberOdebe       	= $traerParaVersiEsHaberOdebe[0]->transaccion;
            $tipoPartida                	= $traerParaVersiEsHaberOdebe[0]->id_tipo_partida;
            if($trasaccionHaberOdebe == 1)//si es 1 es tipo Debe/cargos
               {
                    $montoDebe = $monto;
               }
             else//es de tipo Haber/abonos
               {
                     $montoHaber = $monto;
               }
//generando el correlativo de la partida
                              $buscarCorrelativoPartida = $this->Mimodelobuscar->BuscarCorrlativoPartida($tipoPartida, $fechaContable);
                              if($buscarCorrelativoPartida)  //si hay correlativo para ese tipo de partida y fecha que sume uno mas para el siguiente numero
                                {
                                  //traigo ese correlativo
                                  $extraerCorrelativoPartida = $this->Mimodelobuscar->ExtraerCorrelativoPartida($tipoPartida, $fechaContable);
                                  $numeroSiguienteCorrelativoPartida =  $extraerCorrelativoPartida[0]->correlativo + 1;
                                  
                                  // y actualizo ese correlativo anterior
                                  $this->Mimodeloactualizar->ActualizarCorrelativoPartida($tipoPartida, $fechaContable, $numeroSiguienteCorrelativoPartida);
                                }
                              else //si ese tipo de partida no teien correlativo lo inserto
                                {
                                   $numeroSiguienteCorrelativoPartida = 1;
                                   //inserto el correlativo 1
                                  $this->Mimodeloinsertar->InsertarCorrelativoPartida($tipoPartida, $fechaContable, $numeroSiguienteCorrelativoPartida);
                                   
                                   
                                }
                      
                  
                              $traerIdCuentaContable = $this->Mimodelobuscar->TraerIdCuentaContable($cuenta);
                              $idCuentaContable =  $traerIdCuentaContable[0]->id_cuenta_contable; 
                            
                              
                                //traigo el maximo de la tabla ban_transaccion para guardarlo en la tabla contapartidas
                               $maxUltimoIdTransaccion = $this->Mimodelobuscar->UltimoIdTransaccion();
                               $maxIdUltimoIdTransaccion  = $maxUltimoIdTransaccion[0]->id_transaccion + 1;
                               
                                //$noIncluirNomber = 2;
                                //guardo la partida  
                                $insertar = $this->Mimodeloinsertar->InsertarNuevaPartidaTransaccionBancariaNoContablizadaAlInicio($fechaContable, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $cuenta, $idCuentaContable, $tipoTransaccion, $maxIdUltimoIdTransaccion); //$idUltimoCheque);
                                
                               
         
                                //si se insertan los valores enviados a la
                                //tabla ban_transacciones y la tabla contapartidas
                                //que inserte el detalle de la transaccion
                                //en la tabla ban_transacciones_detalle 
                                if($insertar == true)
                                   {
                                      //traigo el  ultimo ide de la transaccion ESTO CREO QUE NO ES NCESARIIO
                                      //$ultimoIdTransaccion = $this->Mimodelobuscar->UltimoIdTransaccion();
                                     // $idUltimoTransaccion = $ultimoIdTransaccion[0]->id_transaccion; 
                                     
                                     //traigo el id de la partida creada a este momento por la emision del transacciones
                                     $traerIdDeLaPartidaCreadaPorTransaccion = $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorTransaccion($maxIdUltimoIdTransaccion);
                                     $idDelaParidaPorTransaccion = $traerIdDeLaPartidaCreadaPorTransaccion[0]->id;
                                     
                                     //traico el id de la cuenta, el nombre de la cuenta y i el id de la cuenta
                                     //si las tablas estubieran relacionadas este proceso no seia necesario
                                     $buscarIdCodigoYnombreCuenta = $this->Mimodelobuscar->BuscarIdCodigoYnombreCuenta($idCuentaContable);
                                     $idCuenta                    = $buscarIdCodigoYnombreCuenta[0]->id;
                                     $codigoCuenta                = $buscarIdCodigoYnombreCuenta[0]->codigo;
                                     $nombreCuenta                = $buscarIdCodigoYnombreCuenta[0]->nombre;
                                     /*fin del la codificacion innesaria si estubieran relacionadas**/
                                      
                                      //inserto el detalle de la transaccion y el primer detalle de la partida original
                                       $insertarDetalleTransaccion = $this->Mimodeloinsertar->InsertarDetalleTransaccion($concepto, $montoDebe, $montoHaber, $idDelaParidaPorTransaccion, $idCuenta, $codigoCuenta, $nombreCuenta, $monto);
                                     if($insertarDetalleTransaccion == true)
                                        {
                                          unset($_SESSION["cuentasAlaPartidaTransaccion"]);//para eliminar todos los datos que haya de esta sesion, porque si no lo elimino pueden haber otros datos de otras partidas agregadas a la sesion
                                          redirect(base_url()."micontrolador/VistaCrearPartidaDetallesTransaccion/$idDelaParidaPorTransaccion/$maxIdUltimoIdTransaccion/");
                                        }
                                    }
                                  else
                                    {
                                         redirect(base_url()."micontrolador/VistaNuevaTransaccionBancaria/300/");
                                            
                                        
                                     }
		}
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
 public function VistaChequePorCuentaPorPagarTransferencia()
    {
      $estaLogueado = $this->EstaLogueado(156);///id de la vista en la tabla modulos
      if($estaLogueado == TRUE)                     
        {
          
          $mostrar["listarCuentasBancairas"] = $this->Mimodelobuscar->ListarCuentasBancarias();
          //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas();
          $mostrar["contenido"] = "vista_nuevo_cheque_cuenta_por_pagar_transferencias";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
 public function VistaListarConciliacinesFormulario()
    {
      $estaLogueado = $this->EstaLogueado(169);//id de la vista en la tabla modulo
      if($estaLogueado == TRUE)                     
        {
        
          
          
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cuenta"]) 
              && isset($_POST["annio"]))
            {
                $idCuetnaBancaria = $_POST["cuenta"];
                $annio            = $_POST["annio"];
               if($idCuetnaBancaria == "Elija..." && $annio == "Elija...")
                {
                  $idCuetnaBancaria = "";
                  $annio            = "";
                }
                $mostrar["listarConciliaciones"]              = $this->Mimodelobuscar->ListarConciliaciones($idCuetnaBancaria, $annio);
                $mostrar["listarAnniosConciliacion"]          = $this->Mimodelobuscar->ListarAnniosConciliaon();
                $mostrar["listarCuentasBancairas"] = $this->Mimodelobuscar->ListarCuentasBancarias();
               // if($_SERVER["")
                $mostrar["contenido"] = "vista_listar_conciliacion";
                $this->load->view("plantilla", $mostrar);
            }
          else
            {
              $idCuetnaBancaria = "";
              $annio     = "";
              $mostrar["listarConciliaciones"]  = $this->Mimodelobuscar->ListarConciliaciones($idCuetnaBancaria, $annio);
              $mostrar["listarAnniosConciliacion"]          = $this->Mimodelobuscar->ListarAnniosConciliaon();
              $mostrar["listarCuentasBancairas"] = $this->Mimodelobuscar->ListarCuentasBancarias();
              $mostrar["contenido"] = "vista_listar_conciliacion";
              $this->load->view("plantilla", $mostrar);
            }
                 
         
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
 public function VistaConciliacion()
    {
      $estaLogueado = $this->EstaLogueado(169);
      if($estaLogueado == TRUE)                     
        {
          
          //$mostrar["listarCuentasBancairas"] = $this->Mimodelobuscar->ListarCuentasBancarias();
          $mostrar["listarUltimaConciliacion"]  = $this->Mimodelobuscar->ListarUltimaConciliacion();
          $mostrar["contenido"] = "vista_conciliacion";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function VistaPrepararDatosConciliacion()
    {
      $estaLogueado = $this->EstaLogueado(170);
      if($estaLogueado == TRUE)                     
        {
          
          $mostrar["listarCuentasBancairas"]            = $this->Mimodelobuscar->ListarCuentasBancarias();
          $mostrar["listarUltimoAnnioMesConciliacion"]  = $this->Mimodelobuscar->TraerMesYannioDeConciliacion();
          $mostrar["contenido"]                         = "vista_preparar_datos_conciliacion";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }

 public function VistaDatosConciliacion() 
  {
    $estaLogueado = $this->EstaLogueado(170);
      if($estaLogueado == TRUE)                     
        {
          
          $idCuentaBancaria = $this->uri->segment(3,0);
          $fecha            = $this->uri->segment(4,0);
          $mostrar["listarDatosParaConciliar"] = $this->Mimodelobuscar->ListarDatosParaConciliar($idCuentaBancaria, $fecha);
          
          $mostrar["contenido"] = "vista_datos_conciliacion";
          $this->load->view("vista_datos_conciliacion", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function ExportarExcel()
  {
      /*$estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {*/
       
          $mostrar["contenido"] = "vista_exportar_excel";
          $this->load->view("vista_exportar_excel", $mostrar);
       /*}
      else
        {
            $this->ErrorNoAutenticado();
        } */
  }
public function ProcesarDatosConciliacion()
  {
    $estaLogueado = $this->EstaLogueado(170);
      if($estaLogueado == TRUE)                     
        {
       
          if($_SERVER["REQUEST_METHOD"] === "POST" 
                && isset($_POST["cuenta"])
                && isset($_POST["mes"]) 
                && isset($_POST["annio"])
                && isset($_POST["saldobanco"])  
                && isset($_POST["idtransCheqe"])
                
                )
              {
                
                    $correlativo      = time();
                    
                    
                    $cuentaBancaria   = $_POST["cuenta"];
                    $mes              = $_POST["mes"]; 
                    $annio            = $_POST["annio"];
                    $saldoBanco       = $_POST["saldobanco"];
                    $mesNumero        = date("m");//optengo el nuemro del mes actual
                    //$seleccion        = $_POST["seleccion"];
                    //armo la fecha para sumar el saldo segun contabilidad  para la conciliacion
                    $fechaArreglada = $annio."-".date("m")."-".date("d"); 
                    /*inicio*/
                    /*inicio veo si ya esta creada esta conciliacion*/
                    $yaEstaCreadaEstaConciliacionMesAnnio = $this->Mimodelobuscar->YaEstaCreadaEstaConciliacionMesAnnio($mesNumero, $annio, $cuentaBancaria, $fechaArreglada);
                   /*fin*/ 
                    if($yaEstaCreadaEstaConciliacionMesAnnio == 1) //si la conciliacion ya esta cerrada que envie un mesje de erro
                      {
                        redirect(base_url()."micontrolador/VistaPrepararDatosConciliacion/300/");//error ya existe la conciliacion y esta concilado todo (esta cerrada a 0)
                      }
                    else //no existe la conciliacion y la creo ya que no esta a 0 borro los antiguos registros
                      {
                        //elimino la conciliacion antigua con este mismo idetificador de año mes y cuentaContable
                        $eliminar             = $this->Mimodeloeliminar->EliminarDatosDeconciliacioParaAgregarNuevos($mesNumero, $annio, $cuentaBancaria);
                        
                       if(isset($_POST["seleccion"]))
                        { 
							$seleccion = $_POST["seleccion"];
                        /*actualizo a pagado_banco = 1(cheques) procesada_banco = 1(transacciones)*/
                        foreach($seleccion as $idTransaccionOcheque)
                                {
                                  //
                                 //utilizo explode porque en el value del chec le envio el numero de cheuqe pare saver que es cheque para saber si es cheque o no si el seugndo valor del explode es 0 no es cheque sino transaccon
                                  $extracion                = explode(",", $idTransaccionOcheque);
                                  $idChOtrans               = $extracion[0];//el id de la trasnacccion o cheque
                                  $numeorChequeOtransaccion =    $extracion[1];//el numero del cheque o transacccion para transccion siempre sera 0
                                  if($numeorChequeOtransaccion == 0)//es transaccion
                                    {
                                      //actualizo las transacciones
                                      $actualizarTrans = $this->Mimodeloactualizar->ActualizarRegistrosAconciliadosTransaccion($idChOtrans);
                                    }
                                  else
                                    {
                                      //es cheque
                                       $actualizarCheques = $this->Mimodeloactualizar->ActualizarRegistrosAconciliadosCheques($idChOtrans);
                                    }

                                }
                          
                          }
						
                        
                        /*guardo la conciliacion*/
                        $insertarConciliacion = $this->Mimodeloinsertar->InsertarConciliacion($correlativo, $cuentaBancaria, $mesNumero, $annio, $saldoBanco, $fechaArreglada);
                        if($insertarConciliacion == true)
                          {
							$insertar = false;
                            /*inserto los detalles TRANSACCIONES*/
                            /*busco las transacciones que estan a 0 en procesada_banco*/
                             $buscarTransaccionesDNC  = $this->Mimodelobuscar->BuscarTransaccionesDNC($cuentaBancaria, $fechaArreglada);
                             $buscarTransaccionesCNC  = $this->Mimodelobuscar->BuscarTransaccionesCNC($cuentaBancaria, $fechaArreglada);
                             $buscarTransaccionesDET  = $this->Mimodelobuscar->BuscarTransaccionesDET($cuentaBancaria, $fechaArreglada);
                             $buscarTransaccionesCP   = $this->Mimodelobuscar->BuscarTransaccionesCP($cuentaBancaria, $fechaArreglada);
                             foreach($buscarTransaccionesDNC as $algo):
                                     $numeroChequeTrans = 0;
                                     $insertar = $this->Mimodeloinsertar->InsertarDetalleConciliacion($correlativo, $algo->id_transaccion, $numeroChequeTrans, $algo->concepto, $algo->fecha_contable, $algo->valor, $algo->TIPO);//0 porque es transaccion
                              endforeach;
                              
                              /*INSERTO los cargos no contabilizados CNC*/
                              foreach($buscarTransaccionesCNC as $algo):
                                     $numeroChequeTrans = 0;
                                     $insertar = $this->Mimodeloinsertar->InsertarDetalleConciliacion($correlativo, $algo->id_transaccion, $numeroChequeTrans, $algo->concepto, $algo->fecha_contable, $algo->valor, $algo->TIPO);//0 porque es transaccion
                              endforeach;
                              
                              /*INSERTO los depositos en transito DET*/
                              foreach($buscarTransaccionesDET as $algo):
                                     $numeroChequeTrans = 0;
                                     $insertar = $this->Mimodeloinsertar->InsertarDetalleConciliacion($correlativo, $algo->id_transaccion, $numeroChequeTrans, $algo->concepto, $algo->fecha_contable, $algo->valor, $algo->TIPO);//0 porque es transaccion
                              endforeach;
                              
                               /*INSERTO los cargos pendientes CP*/
                              foreach($buscarTransaccionesCP as $algo):
                                     $numeroChequeTrans = 0;
                                     $insertar = $this->Mimodeloinsertar->InsertarDetalleConciliacion($correlativo, $algo->id_transaccion, $numeroChequeTrans, $algo->concepto, $algo->fecha_contable, $algo->valor, $algo->TIPO);//0 porque es transaccion
                              endforeach;
                              /*FIN DETALLES TRANSACCIONS*/
                              
                              
                              /*INSERTO DETALLES conciliacion CHEQUES*/


                             $buscarChequesDET  = $this->Mimodelobuscar->BuscarChequesDET($cuentaBancaria, $fechaArreglada);
                             $buscarChequesPEN  = $this->Mimodelobuscar->BuscarChequesPEN($cuentaBancaria, $fechaArreglada);
                             //inseto en detalles conciliacion los depostios en transito de los cheques DET
                             foreach($buscarChequesDET as $algo):
                                     $conceptoCon = $algo->a_nombre_de." - ".$algo->concepto_cheque;
                                     $insertar = $this->Mimodeloinsertar->InsertarDetalleConciliacion($correlativo, $algo->id_cheque, $algo->ID_CHEQUE_NUMERO, $conceptoCon , $algo->fecha_emision, $algo->DEPOSITOS_EN_TRANSITO_CHEQUES, $algo->TIPO);//0 porque es transaccion
                              endforeach;
                              
                              /*INSERTO los detalles conciliacion de los cheques pendientes PEN*/
                              foreach($buscarChequesPEN as $algo):
                                     $conceptoCon = $algo->a_nombre_de." - ".$algo->concepto_cheque;
                                     $insertar = $this->Mimodeloinsertar->InsertarDetalleConciliacion($correlativo, $algo->id_cheque, $algo->numero_cheque, $conceptoCon, $algo->fecha_emision, $algo->monto_cheque, $algo->TIPO);//0 porque es transaccion
                              endforeach;
                              
                              
                              
                              /*FIN detalles conciliacion CHEQUES*/
                              
                             /*busco los cheques que estan a 0 eb pagado_banco */
                             /*$buscarChequesNoConciliados = $this->Mimodelobuscar->BuscarChequesNoConciliadoss($cuentaBancaria, $fechaArreglada);
                             foreach($buscarChequesNoConciliados as $cheques):
                                    $insertarCheques = $this->Mimodeloinsertar->InsertarDetalleConciliacion($correlativo, $cheques->id_cheque, $cheques->numero_cheque, $cheques->concepto_cheque, $cheques->fecha_emision, $cheques->monto_cheque);//$cheques->numero_cheque para identificar si es cheque o trnasaccion aquei puedo poner cualquier numero distinto de 0 sin necesidad de mandarle el vlaor del arreglo
                             endforeach; */
                             if($insertar == true)
                              { 
                                redirect(base_url()."micontrolador/VistaImprimirReporteConciliacion/$correlativo/");
                              }
							 else
								{
									redirect(base_url()."micontrolador/CerrarConciliacion/$correlativo/$mesNumero/$annio/$cuentaBancaria/"); 

								}
                          }
                        else
                          {
                            redirect(base_url()."micontrolador/VistaPrepararDatosConciliacion/405/");
                          } 
                     } 
                    
              }
            else
              {
                redirect(base_url()."micontrolador/VistaPrepararDatosConciliacion/");   
              } 
                    

       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function GuardarConciliacion()//SIN USO*/*/*/*/*/*/*//*/*/**/  
  {
    $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {
       
          if($_SERVER["REQUEST_METHOD"] === "POST" 
                /*&& isset($_POST["idcuentabancaria"])
                && isset($_POST["mesennumero"]) 
                && isset($_POST["annio"]) */
                && isset($_POST["idconciliacion"])
                 && isset($_POST["idtransCheqe"]) 
                )
              {
                //print_r($_POST["idtransCheqe"]);
                $idConciliacon = $_POST["idconciliacion"];
                   if(isset($_POST["seleccion"])) //si se ha creado el checkbox esque ai cheques o transaciones noc conciliadas
                    {
                           $seleccion = $_POST["seleccion"];
                           /*inicio*/
                           //veo si esa conciliacion a guardar no esta cerrada
                           $conciliacionNocerrada   = $this->Mimodelobuscar->ListarUltimaConciliacion();
                           $conciliacionCerradoOno  = $conciliacionNocerrada[0]->conciliacion_cerrada;
                           $correlativoConciliacion = $conciliacionNocerrada[0]->correlativo;
                           /*fin*/
                           
                           if($conciliacionCerradoOno == 0)//la conciliacion ya fue cerrada
                            {
                              redirect(base_url()."micontrolador/VistaConciliacion/425/");//la conciliacion ya ha sido cerra que muestre un error 
                            }
                           else //sino que guarde los cambios
                            {
                                //$insertar = false;
                               foreach($seleccion as $idTransaccionOcheque)
                                {
                                  //
                                 //utilizo explode porque en el value del chec le envio el numero de cheuqe pare saver que es cheque para saber si es cheque o no si el seugndo valor del explode es 0 no es cheque sino transaccon
                                  $extracion                = explode(",", $idTransaccionOcheque);
                                  $idChOtrans               = $extracion[0];//el id de la trasnacccion o cheque
                                  $numeorChequeOtransaccion =    $extracion[1];//el numero del cheque o transacccion para transccion siempre sera 0
                                  $insertar = $this->Mimodeloinsertar->InsertarDetalleConciliacion($correlativoConciliacion, $idChOtrans, $numeorChequeOtransaccion);
                                }
                              if($insertar == true)
                                {
                                  redirect(base_url()."micontrolador/VistaImprimirReporteConciliacion/$idConciliacon/");  
                                }
                              else
                                {
                                  redirect(base_url()."micontrolador/VistaConciliacion/300/");  
                                }
                            }
                   
                      }//fin del si se ha crado el checkbox
                    else  //si no se creo el chexbox es porque todos los datos etan conciliados
                      {
                         /*que envie el id de la conciliacon para cerrarla-*/
                        redirect(base_url()."micontrolador/CerrarConciliacion/$idConciliacon/"); 
                      } 
                    
              }
            else
              {
                redirect(base_url()."micontrolador/VistaConciliacion/");   
              } 
                    

       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function CerrarConciliacion()
  {
     $estaLogueado = $this->EstaLogueado(172);
    if($estaLogueado == TRUE)
      {
          /*inicio*/
          //estos datos se traen de la funcion GuardarConciliacion donde se preparan los datos a conciliar
          //esta funcion se ejecutara solo cuando no este chequeado ningun checkbox
      
          $idConciliacion   = $this->uri->segment(3,0);//id de la conciliacion a cerrar
          $mes              = $this->uri->segment(4,0);
          $annio            = $this->uri->segment(5,0);
          $idCuentaBancaria = $this->uri->segment(6,0);
          /*fin*/
          
          /*valido el mes y annio*/
          if($mes == 12)
            {
              $mes = 1;
              $annio = $annio + 1;
            }
          else
            {
              $mes = $mes + 1;
              $annio = $annio;
            }
          
          
          $actualizarEstadoConciliacion = $this->Mimodeloactualizar->ActualizarEstadoConciliacion($idConciliacion, $mes, $annio);
          //$insertoLaNuevaConciliacion   = $this->Mimodeloinsertar->InsertarLaNuevaConciliacion($mes, $annio);//esta se inserta para que tome el max para cuando voi a crear la conciliacon muestre el año y el mes en la vista VistaPrepararDatosConciliacion
          if($actualizarEstadoConciliacion == true) //si se actualizo correctamente
            {
              redirect(base_url()."micontrolador/VistaListarConciliacinesFormulario/900/");//900 conciliacion cerrada con exito
            }
          else
            {
               redirect(base_url()."micontrolador/VistaListarConciliacinesFormulario/300/");//300 error inesperado
            }
      }
    else
      {
          $this->ErrorNoAutenticado();
      } 
  }
 public function VistaImprimirReporteConciliacion()
  {
    $estaLogueado = $this->EstaLogueado(171);
    if($estaLogueado == TRUE)
      {
        $idConciliacion = $this->uri->segment(3,0);//codigo de la conciliacion traido desde la url
        //$tipos    = $this->Mimodelobuscar->ListarTipos($idConciliacion);
        //$mostrar["listarTipos"]  = $this->Mimodelobuscar->ListarTipos($idConciliacion);
        
        $mostrar["listarDatosParaImprimirConciliacion"] = $this->Mimodelobuscar->ListarDatosParaImprimirConciliacion($idConciliacion);
        
        //$mostrar["listarDatosParaImprimirConciliacion"] = $this->Mimodelobuscar->ListarDatosParaImprimirConciliacion($idConciliacion);
        $mostrar["contenido"] = "vista_imprimir_conciliacion";
        $this->load->view("vista_imprimir_conciliacion", $mostrar);
         
      }
    else
      {
        $this->ErrorNoAutenticado();      
      }
  }
 public function ActualizarEstadoChequeOtransaccion()
  {
      $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {
       
         $idTrasOcheque   = $this->uri->segment(3,0);
         $numeroCheqOTrnas  = $this->uri->segment(4,0);
         
         if($numeroCheqOTrnas == 0)//es transaccion
          {
            $actualizar = $this->Mimodeloactualizar->ActualizarRegistrosAconciliadosTransaccion($idTrasOcheque);
          }
        else
          {
            //es cheque
            $actualizar = $this->Mimodeloactualizar->ActualizarRegistrosAconciliadosCheques($idTrasOcheque);
          }
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function VistaReportes()
  {
    $estaLogueado = $this->EstaLogueado(173);//id de la vista en la tabal modulo
      if($estaLogueado == TRUE)                     
        {
          $mostrar["contenido"]  = "vista_reportes";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function VistaReporteCuentasBancairas() 
  {
    $estaLogueado = $this->EstaLogueado(174);
      if($estaLogueado == TRUE)                     
        {
          
          $filtro = "";
          $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
          
          $mostrar["contenido"] = "vista_reporte_cuentas_bancarias";
          $this->load->view("vista_reporte_cuentas_bancarias", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function VistaReporteChques()
  {
     $estaLogueado = $this->EstaLogueado(175);
      if($estaLogueado == TRUE)                     
        {
        
          if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["idcuentabanco"])
              && isset($_POST["fechabanco"])
              && isset($_POST["fechabancohasta"])
              )
            {
                  $filtro                    = "";
                  $cuentaBancaria            = $_POST["idcuentabanco"];
                  $fechaBanco                = $_POST["fechabanco"];
                  $fechaBancoHasta           = $_POST["fechabancohasta"];
                  $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
        
                  $mostrar["listarCheques"]  = $this->Mimodelobuscar->LitarTodosLosChequesTranferencias($cuentaBancaria, $fechaBanco, $fechaBancoHasta);
                  //$mostrar["listarChequesNoContabilizados"] = $this->Mimodelobuscar->ListarChequesNoContabilizados($filtro);
                  $mostrar["contenido"]      = "vista_reporte_cheques";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
              $filtro = "";
              $cuentaBancaria            = "";
              $fechaBanco                = "";
              $fechaBancoHasta           = "";    
              $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
              $mostrar["listarCheques"]  = $this->Mimodelobuscar->LitarTodosLosChequesTranferencias($cuentaBancaria, $fechaBanco, $fechaBancoHasta);
              $mostrar["contenido"]      = "vista_reporte_cheques";
              $this->load->view("plantilla", $mostrar);
            } 
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function VistaReporteTransacciones()
    {
      $estaLogueado = $this->EstaLogueado(176);               
      if($estaLogueado == TRUE)                     
        {
        
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["fechahasta"]) 
          && isset($_POST["fecha"])
          && isset($_POST["idcuentabanco"]))
            {
                  $fechaHasta                       = $_POST["fechahasta"];
                  $fecha                            = $_POST["fecha"];
                  $IdCuentaBancaria                 = $_POST["idcuentabanco"];
                  $filtro                           = "";
                  $mostrar["listarTransacciones"]    = $this->Mimodelobuscar->ListarTransaccionesPorRangoFechaYcuentaBancaria($IdCuentaBancaria, $fecha, $fechaHasta);
                  $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
                  $mostrar["contenido"]      = "vista_reporte_transacciones";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
                {
               $filtro            = "";
               $fechaHasta        = "";
               $fecha             = "";
               $IdCuentaBancaria  = "";
               $mostrar["listarTransacciones"]    = $this->Mimodelobuscar->ListarTransaccionesPorRangoFechaYcuentaBancaria($IdCuentaBancaria, $fecha, $fechaHasta);   
              //$mostrar["listarCheques"]  = $this->Mimodelobuscar->ListarChequesSinFiltro();
              $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
              $mostrar["contenido"]      = "vista_reporte_transacciones";
              $this->load->view("plantilla", $mostrar);
              } 
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function VistaReporteConciliaciones() 
  {
    $estaLogueado = $this->EstaLogueado(177);
      if($estaLogueado == TRUE)                     
        {
          
          $idCuetnaBancaria = "";     
          $annio            = "";
          $mostrar["listarConciliaciones"]              = $this->Mimodelobuscar->ListarConciliaciones($idCuetnaBancaria, $annio);
            // if($_SERVER["")
          $mostrar["contenido"] = "vista_reporte_conciliacion";
          $this->load->view("vista_reporte_conciliacion", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  } 
public function VistaLibroBancoAntes()  //SIN USO
  {
    $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {
         
        
              $filtro           = "";

              $mostrar["listarCuentasBanco"]      = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);

              $mostrar["contenido"] = "vista_libro_banco";
              $this->load->view("plantilla", $mostrar);
          
                 
         
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  } 
public function ReporteLibroBanco()//SIN USO 
  {
    $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {
         
        
            
              $idCuentaBancaria = $this->uri->segment(3,0);

              $mostrar["listaReporteLibroBanco"]  = $this->Mimodelobuscar->ListaReporteLibroBanco($idCuentaBancaria);
              $mostrar["contenido"] = "vista_reporte_libro_banco";
              $this->load->view("vista_reporte_libro_banco", $mostrar);
          
                 
         
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
public function VistaLibroBanco()
  {
     $estaLogueado = $this->EstaLogueado(178);
      if($estaLogueado == TRUE)                     
        {                                                  
        
          if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["idcuentabanco"])
              && isset($_POST["fechabanco"])
              && isset($_POST["fechabancohasta"])
              )
            {
                  $filtro                    = "";
                  $cuentaBancaria            = $_POST["idcuentabanco"];
                  $fechaBanco                = $_POST["fechabanco"];
                  $fechaBancoHasta           = $_POST["fechabancohasta"];
                  $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
				  //$traerIdCuentaContable	 		 = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
				 //echo $idCuentaContable					 = $traerIdCuentaContable[0]->id_cuenta_contable;
                  $mostrar["listarSaldosAnteriores"] = $this->Mimodelobuscar->ListarSaldosAnteriores($cuentaBancaria, $fechaBanco, $fechaBancoHasta);
                  $mostrar["listaReporteLibroBanco"]  = $this->Mimodelobuscar->ListaReporteLibroBanco($cuentaBancaria, $fechaBanco, $fechaBancoHasta);
                  //$mostrar["listarChequesNoContabilizados"] = $this->Mimodelobuscar->ListarChequesNoContabilizados($filtro);
                  $mostrar["contenido"]      = "vista_libro_banco";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
              $filtro = "";
              $cuentaBancaria            = "";
              $fechaBanco                = "";
              $fechaBancoHasta           = "";
			  //$idCuentaContable			 = "";
              $mostrar["listarCuetnasBancarias"] = $this->Mimodelobuscar->ListarCuentasBancariasPorFiltro($filtro);
              $mostrar["listaReporteLibroBanco"]  = $this->Mimodelobuscar->ListaReporteLibroBanco($cuentaBancaria, $fechaBanco, $fechaBancoHasta);
              $mostrar["contenido"]      = "vista_libro_banco";
              $this->load->view("plantilla", $mostrar);
            } 
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
public function VistaAnularChequeTrasferencia()
  {
   $estaLogueado = $this->EstaLogueado(157);//id de la vista en la tababla modulos
      if($estaLogueado == TRUE)                     
        {
              //compruebao se no se ha contabilizado el cheque o la transferencia
              $idChequeOtransaferencia     = $this->uri->segment(3,0);
              $verSiSeContabilizo          = $this->Mimodelobuscar->BuscarSiEsCXP($idChequeOtransaferencia);
              $idPartida                   = $verSiSeContabilizo[0]->id_partida;
              if($idPartida == NULL) //esto es praa que no se pueda anular si no se ha contabilizado ya que si se anula sin contabilizar no la pone a 0.00
                {
                  redirect(base_url()."micontrolador/VistaCheque/0/111000/");  
                }
              else
                {
                  $mostrar["contenido"]      = "vista_anular_cheque_trans";
                  $this->load->view("plantilla", $mostrar);
                }   

        }
      else
        {
            $this->ErrorNoAutenticado();
        }  
  }
public function AnularChequeTransferencia()
  {
    $estaLogueado = $this->EstaLogueado(157);
      if($estaLogueado == TRUE)                     
        {
           if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["banco"])
              && isset($_POST["idtranscheque"])
              )
            {
        
              $idChequeOtransaferencia     = $_POST["idtranscheque"];
              $motivoAnulacion             = $_POST["banco"];
              $anular                      = $this->Mimodeloactualizar->AnularChequeTransferencia($idChequeOtransaferencia, $motivoAnulacion);
                  if($anular == true)
                    {
                     redirect(base_url()."micontrolador/VistaCheque/0/1300/");
                    }
                  else
                    {
                     redirect(base_url()."micontrolador/VistaCheque/0/300/"); 
                    }
              
             }
           else
            {
              redirect(base_url()."micontrolador/VistaAnularChequeTrasferencia/"); 
            }

        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function AnularTransaccion()
  {
    $estaLogueado = $this->EstaLogueado(167);
      if($estaLogueado == TRUE)                     
        {
          
              $idTransaccion                      = $this->uri->segment(3,0);//traigo el id de la transaccion a anular
              $verSiTransaccionEstaContabilizada  = $this->Mimodelobuscar->VerSiTransaccionEstaContabilizada($idTransaccion);
              $idPartida                          = $verSiTransaccionEstaContabilizada[0]->id;//id de la partida a anular
              $anular                             = $this->Mimodeloactualizar->AnularTransaccion($idTransaccion, $idPartida);
              if($anular == true)
                {
                 redirect(base_url()."micontrolador/VistaTransacciones/0/1300/");
                }
              else
                {
                 redirect(base_url()."micontrolador/VistaTransacciones/0/300/"); 
                }
          
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 
	
    /*ACCIONES DE EDITAR DATOS*/
public function VistaModificarChequeNormal()
    {
      $estaLogueado = $this->EstaLogueado(159);
      if($estaLogueado == TRUE)                     
        {
          
          $idCheque                          	  = $this->uri->segment(4,0);//4 porque el elemento 3 es un distractor
		  //traigo el id de la partid creada por estre id del cheque para que pueda mostrar el header(encabedado de la partida)y los detalles
		  //de la misama
		  $traerIdDeLaPartidaCreadaPorChequeOTransferencia	= $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorChequeOTransferencia($idCheque);
		  $idDelaParidaPorCheque							= $traerIdDeLaPartidaCreadaPorChequeOTransferencia[0]->id;
          $mostrar["listarCuentasBancairas"] 	  = $this->Mimodelobuscar->ListarCuentasBancarias();
          $mostrar["listarDatosChequeAmodificar"] = $this->Mimodelobuscar->ListarDatosChequeAmodificar($idCheque);
		 
		  //busco el id del otro chque si es que hay
		  $elIdDelOtroCheque     		  = $this->Mimodelobuscar->IdDelOtroChque($idDelaParidaPorCheque);
		  //traigo el resultado para evaluar si hay dos registos con la misma id de la partida
		  $idDelOtroCheque			  = $elIdDelOtroCheque[0]->ID_DEL_OTRO_CHEQUE;
		  $cuenta					  = $elIdDelOtroCheque[0]->CUENTA;
		  if($cuenta == 1)//siginifica que es una transferencia con cheque normal
			{
				//buscao la otra cuenta bancaria del otro cheque para mostrarla en la vista
				$mostrar["listarDatosChequeAmodificarChequeDos"] = $this->Mimodelobuscar->ListarDatosChequeAmodificar($idDelOtroCheque);
				$mostrar["estado"]	= true;//true para que muestre la otra cuanta bancaria
			}
		  else
			{
				$mostrar["estado"]	= false;//es porque no se hizo cheque a travez de tranferencia y no mostrara la otra cuenta bancaria
			}
		 
		  $mostrar["contenido"] = "vista_modificar_cheque";
		  $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function ActualizarCheque()
	{
		$estaLogueado = $this->EstaLogueado(159);
		if($estaLogueado == true)
			{
				if($_SERVER["REQUEST_METHOD"] === "POST" 
              && isset($_POST["cuenta"])
              && isset($_POST["codigo"]) 
              && isset($_POST["anombrede"]) 
              && isset($_POST["tipopartida"]) 
              && isset($_POST["fecha"]) 
              && isset($_POST["concepto"])
			  && isset($_POST["otroidcheque"])
			  && isset($_POST["idchequeori"]))
              {
              
                 $cuenta      = $_POST["cuenta"];
                 $anombrede   = $_POST["anombrede"];
                 $monto       = str_replace(',', '', $_POST["monto"]); //str_replace quito las comas si se las han ingresado
                 $tipoPartida = $_POST["tipopartida"];
                 $fecha       = $_POST["fecha"];
                 $concepto    = $_POST["concepto"];
				 $idOtroCheque	   = $_POST["otroidcheque"];
				 $numeroChequeOri  = $_POST["numerochequeori"];//numero del cheque original
				 $idChequeOri      = $_POST["idchequeori"];//id del cheque original
				 
				 $textoLargo = $concepto;
				 $largoMax = 100; // numero maximo de caracteres antes de hacer un salto de linea
				 $rompeLineas = '</br>';
				 $romper_palabras_largas = true; // rompe una palabra si es demacido larga
			     $concepto = wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);
				
				 $idDeLaPartidaDelCheque				  = $this->uri->segment(3,0);
				 $idCheque                          	  = $this->uri->segment(4,0);
				//si le doy pos y envio es $idCheque no funciona tengo que traerlo desde una caja de texto de la vista
				//por ese se puso arriba $idChequeOri.
				
				
                 $idUsuario = $this->session->userdata("id");
                 $userName = $this->session->userdata("username");
				 if($cuenta != "" && $anombrede != "")
					{
						/*inicio*/
							/*TODO ESTO ES PARA VER SI ES TRANSFEENCIA DE DINERO ENTRE CUENTAS BANCARIAS
							SI ES ASI QUE INSERTE UN CARGO A LA OTRA CUENTA BANCARIA SELECCIONADA
							ESTE REGISTRO DE CARGO APARECER COMO CHEQUE PERO CHEQUE EMITOD DESDE OTRA CUENTA BANCARIA
							Y SE PONDRA COMO IMPRESO PARA QUE SOLO QUEDE LA OPCION DE REIMPRIMR YA QUE NO ES UN CHEQUE EN SI*/
							 //veo si se ha chequeado le chexbox transferencia entre cuentas
							if(isset($_POST["tranferenciaentrecuentas"]) && isset($_POST["cuentaOtro"]))//se chequeo el checkbox
								{
									$idCuentaBancairiaOtraTrnasferir = $_POST["cuentaOtro"];
									$transferirEntreCuentas = 1; 
									if($transferirEntreCuentas == 1)//es transferencia enter cuentas banciarias se ha cehquedo el checkbox
									{
										//traigo el id de la cuenta contable
										$traerIdCuentaContableT = $this->Mimodelobuscar->TraerIdCuentaContable($idCuentaBancairiaOtraTrnasferir);
										$idCuentaContableT =  $traerIdCuentaContableT[0]->id_cuenta_contable;
										$actualizarDatosTransferenciaEntreCuentasBancarias = $this->Mimodeloactualizar->ActualizarChequeDos($fecha, $concepto, $monto, $anombrede, $userName, $idCuentaContableT,  $idCuentaBancairiaOtraTrnasferir, $idOtroCheque);
									}
								}
							else
								{
									$transferirEntreCuentas = 0; //no es transferencia
									$idCuentaBancairiaOtraTrnasferir = 0;//para indicarle que no se ha chequedo el checkbox
									$idCuentaContableT				 = 0;//para indicarle que no se ha chequedo el checkbox
									//actualizo el cargo de la otra cuanta automaticamente a la que se hace la transferenica sin cambiar la cuenta bancaria
									if($idOtroCheque != 0)
										{
											$this->Mimodeloactualizar->ActualizarChequeDos($fecha, $concepto, $monto, $anombrede, $userName, $idCuentaContableT,  $idCuentaBancairiaOtraTrnasferir, $idOtroCheque);
										}
								}
							
							/*fin trasferencia entre cuentas*/
						
						
						//traigo el id de la cuenta contable elejido desde la vista cheques
						$traerIdCuentaContableChE = $this->Mimodelobuscar->TraerIdCuentaContable($cuenta);
						$idCuentaContableChE =  $traerIdCuentaContableChE[0]->id_cuenta_contable;
						
						//traico el id de lacuenta contable, el nombre de la cuenta contable y i el id de la cuenta contable
						//del bonco que eleji para hacer el cheque
						
                           //si las tablas estubieran relacionadas este proceso no seia necesario
                           $buscarIdCodigoYnombreCuenta = $this->Mimodelobuscar->BuscarIdCodigoYnombreCuenta($idCuentaContableChE);
                           $idCuenta                    = $buscarIdCodigoYnombreCuenta[0]->id;
                           $codigoCuenta                = $buscarIdCodigoYnombreCuenta[0]->codigo;
                           $nombreCuenta                = $buscarIdCodigoYnombreCuenta[0]->nombre;
						

						//traigo el id de la partida creada a este momento por la emision del cheque
						$traerIdDeLaPartidaCreadaPorChque = $this->Mimodelobuscar->TraerIdDeLaPartidaCreadaPorChque($idChequeOri);
						$idDelaParidaPorCheque = $traerIdDeLaPartidaCreadaPorChque[0]->id;
						
						/*acutualizo el registro del cheque elejido desde la vista de los cheques*/
						$actualizarDatosTransferenciaEntreCuentasChequeEle = $this->Mimodeloactualizar->ActualizarChequeElejido($fecha, $concepto, $monto, $anombrede, $userName, $idCuentaContableChE,  $cuenta, $idChequeOri, $numeroChequeOri, $idDelaParidaPorCheque, $idCuenta, $codigoCuenta, $nombreCuenta, $transferirEntreCuentas);
						if($actualizarDatosTransferenciaEntreCuentasChequeEle)//si se actualizo correctamente
							{
								redirect(base_url()."micontrolador/VistaCrearPartidaDetalles/".time()."/$idChequeOri/");
								//redirect(base_url()."micontrolador/VistaCheque/0/-1525/");//mesjaje de exito
							}
						else
							{
								redirect(base_url()."micontrolador/VistaCheque/0/300/");//error inesperado
							}
					}
				else
					{
						redirec(base_url()."micontrolador/VistaModificarChequeNormal/$idDelaParidaPorCheque/$idCheque/");
					}
			   }
			}
		
		else
			{
				$this->ErrorNoAutenticado();
			}
	}
   public function VistaEditarCuentaBancaria()
    {
      $estaLogueado = $this->EstaLogueado(154);//id de la vista de la tabla modulos
      if($estaLogueado == TRUE)                     
        {
		  $idCuentaBancaria					  = $this->uri->segment(4,0);//traigo el id de la cuenta bancaira el 3 es para un aleatorio despistar nadamas
		  $mostrar["listarDatosAmodificarCB"] = $this->Mimodelobuscar->ListarDatosAmodificarCB($idCuentaBancaria);
          $mostrar["listarCuentasContables"]  = $this->Mimodelobuscar->ListarCuentasContables(); 
          $mostrar["listarTipoPartidas"] 	  = $this->Mimodelobuscar->ListarTipoPartidas();
          $mostrar["contenido"] = "vista_edutar_cuenta_bancaria";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function ActualizarCuentaBanco()
	{
		$estaLogueado = $this->EstaLogueado(154);
      if($estaLogueado == TRUE)
        {
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cuentacontable"])
              && isset($_POST["banco"]) && isset($_POST["numerocuenta"])
              && isset($_POST["ultimocheque"]) && isset($_POST["tipopartida"])
              && isset($_POST["tipoimpresion"]) && isset($_POST["inactiva"])
              && isset($_POST["nombreemite"]) && isset($_POST["cargoemite"])
              && isset($_POST["nombrerevisa"]) && isset($_POST["cargorevisa"])
              && isset($_POST["nombreautoriza"]) && isset($_POST["cargoautoriza"])
			  && isset($_POST["idcuentabancaria"]))
              {
              
                 $cuentaContable = $_POST["cuentacontable"];
                 $numeroCuenta   = $_POST["numerocuenta"];
                 $banco          = $_POST["banco"];
                 $ultimoCheque   = $_POST["ultimocheque"];
                 $tipoPartida    = $_POST["tipopartida"];
                 $tipoImpresion  = $_POST["tipoimpresion"];
                 $inactiva       = $_POST["inactiva"];
                 $nombreEmite    = $_POST["nombreemite"];
                 $cargoEmite     = $_POST["cargoemite"];
                 $nombreRevisa   = $_POST["nombrerevisa"];
                 $cargoRevisa    = $_POST["cargorevisa"];
                 $nombreAutoriza = $_POST["nombreautoriza"];
                 $cargoAutoriza  = $_POST["cargoautoriza"];
				 $idCuentaBCari	 = $_POST["idcuentabancaria"];
                if($cuentaContable != "" && $numeroCuenta != "" && $idCuentaBCari != "")
                      {
                     
                            
                                $actualizar = $this->Mimodeloactualizar->ActualizarCuentaBanco($cuentaContable, $numeroCuenta, $banco, $ultimoCheque, $tipoPartida, $tipoImpresion, $inactiva, $nombreEmite, $cargoEmite, $nombreRevisa, $cargoRevisa, $nombreAutoriza, $cargoAutoriza, $idCuentaBCari);
                                if($actualizar == true)
                                  {
                                    redirect(base_url()."micontrolador/VistaEditarCuentaBancaria/".time()."/$cuentaContable/200/");
                                    //exit;
                                  }
                                else
                                  {
                                    redirect(base_url()."micontrolador/VistaEditarCuentaBancaria/".time()."/$cuentaContable/300/");
                                  
                              
                                  }
                          
                    }
                  else
                    {
                        $this->VistaNuevaCuenta();
                    }
              }
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
	}
 public function VistaActualizarTipoTransaccion()
    {
      $estaLogueado = $this->EstaLogueado(164);
      if($estaLogueado == TRUE)                     
        {
			  $idTransaccion				  = $this->uri->segment(4,0);//el 3 sera un distractor
			 // $idTransaccion				  = $this->uri->segment(4,0);//el 3 sera un distractor
			  $mostrar["listarDatosAmodificarTransaccion"] = $this->Mimodelobuscar->ListarDatosAmodificarTransaccion($idTransaccion);
              $mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas();
              $mostrar["contenido"]      = "vista_actualizar_tipo_transaccion";
              $this->load->view("plantilla", $mostrar);
      
      
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function ActualizarTipoTransaccion()
  {
     $estaLogueado = $this->EstaLogueado(164);
      if($estaLogueado == TRUE)                     
        {
        
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["tipotransaccion"])
               && isset($_POST["tipopartida"]) && isset($_POST["transaccionsaldos"]) )
            {
                  $idTipoTrnasaccion		= $this->uri->segment(4,0);//el tres es un distractor
				  $tipoTransaccion          = $_POST["tipotransaccion"];
                  $tipoPartida              = $_POST["tipopartida"];
                  $transaccionSaldos        = $_POST["transaccionsaldos"];
             
                  if($tipoTransaccion != "" && $tipoPartida != "" && $transaccionSaldos != "" )
                    {
                      $actulizar = $this->Mimodeloactualizar->ActualizarTipoTransaccion($idTipoTrnasaccion, $tipoTransaccion, $tipoPartida, $transaccionSaldos);
                      
                      if($actulizar == true)
                        {
                          redirect(base_url()."micontrolador/VistaActualizarTipoTransaccion/".time()."/$idTipoTrnasaccion/400/"); 
                        }
                      else
                        {
                          redirect(base_url()."micontrolador/VistaActualizarTipoTransaccion/".time()."/$idTipoTrnasaccion/300/"); //ERROR INESPERADO
                        }
                    }
                  
                 
               
            }
		else
			{
					redirect(base_url()."micontrolador/VistaActualizarTipoTransaccion/".time()."/$idTipoTrnasaccion/");
			}
          
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
  
  
  
 
 
 /**************************MODULO COMPRAS**********************************/
 public function VistaCompras()
    {
      $estaLogueado = $this->EstaLogueado(179);//id de la vista en la tabla modulo
      if($estaLogueado == TRUE)                     
        {
          
          @session_start();
		unset($_SESSION["carro2"]);//elimino la sesion del carro2
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["fechadesde"])  && isset($_POST["fechahasta"]))
            {
                $fechaDesde	=$_POST["fechadesde"];
				$fechaHasta	= $_POST["fechahasta"];
                $mostrar["listarOrdenesCompras"]  = $this->Mimodelobuscar->ListarOrdenesOrdenesDeCompra($fechaDesde, $fechaHasta);
               // if($_SERVER["")
                $mostrar["contenido"] = "vista_compras";
                $this->load->view("plantilla", $mostrar);
            }
          else
            {
                $fechaDesde	="";
				$fechaHasta	="";
                $mostrar["listarOrdenesCompras"]  = $this->Mimodelobuscar->ListarOrdenesOrdenesDeCompra($fechaDesde, $fechaHasta);
               // if($_SERVER["")
                $mostrar["contenido"] = "vista_compras";
                $this->load->view("plantilla", $mostrar);
            }
                 
         
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function VistaNuevaOrdenCompra()
	{
		$estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)                     
        {
          
          $mostrar["listarCentrosDeCostos"]   = $this->Mimodelobuscar->ListarCentrosDeCostos();
          $mostrar["listarCondicionesDePago"] = $this->Mimodelobuscar->ListarCondicionesDePago();
          $mostrar["contenido"] = "vista_nueva_orden_compra";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
public function VistaBuscarProveedoresParaNuevaOrdenCompra()
    {
      $estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)                     
        {
          
           
                     
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"]))
          {
              $filtro = $_POST["filtro"];
              $mostrar["listarProveedoresParaNuevaOrdenCompra"] = $this->Mimodelobuscar->ListarProveedoresTodosCampos($filtro);
            //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas(); 
              $mostrar["contenido"] = "vista_buscar_proveedores_nueva_orden_compra";
              $this->load->view("vista_buscar_proveedores_nueva_orden_compra", $mostrar);
          }
          ELSE
          {
              $filtro = "";
              $mostrar["listarProveedoresParaNuevaOrdenCompra"] = $this->Mimodelobuscar->ListarProveedoresTodosCampos($filtro);
              $mostrar["contenido"] = "vista_buscar_proveedores_nueva_orden_compra";
              $this->load->view("vista_buscar_proveedores_nueva_orden_compra", $mostrar);
          }
          
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function VistaBuscarCuentasContablesNuevaOrdenCompra()
    {
      $estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)                     
        {
            
            if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"]))
              {
                $filtro = $_POST["filtro"];
                $mostrar["listarCuentasContables"] = $this->Mimodelobuscar->LlistarCuentasContables($filtro);
              //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas(); 
                $mostrar["contenido"] = "vista_buscar_cuentas_contables_nueva_orden_compra";
                $this->load->view("vista_buscar_cuentas_contables_nueva_orden_compra", $mostrar);
              }
            else
              {
                $filtro = "";
                $mostrar["listarCuentasContables"] = $this->Mimodelobuscar->LlistarCuentasContables($filtro);
                $mostrar["contenido"] = "vista_buscar_cuentas_contables_nueva_orden_compra";
                $this->load->view("vista_buscar_cuentas_contables_nueva_orden_compra", $mostrar);
              }
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
    }
public function RegistrarOrdenDeCompra()
	{
		$estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)
        {
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["idcondicionpago"])
              && isset($_POST["formapago"]) && isset($_POST["diascredito"])
              && isset($_POST["centrocosto"]) && isset($_POST["tipocomprobante"])
			  && isset($_POST["codigo"])
              && isset($_POST["idproveedor"]) && isset($_POST["nombreprove"])
              && isset($_POST["nit"]) && isset($_POST["nrc"])
              && isset($_POST["condicionpago"])
              && isset($_POST["fecha"]) && isset($_POST["solicitadapor"])
			  && isset($_POST["tamannocontribuyente"])
			  && isset($_POST["condicionpagoCombo"])
			  )
              {
              
                 $idCondicionPago		= $_POST["idcondicionpago"];
				 $formaPago				= $_POST["formapago"];
				 $diasCredito			= $_POST["diascredito"];
				 $centroCosto			= $_POST["centrocosto"];
				 $tipoComprobante		= $_POST["tipocomprobante"];
				 $codigoProveedor		= $_POST["codigo"];
				 $idProveedor			= $_POST["idproveedor"];
				 $nombreProveedor		= $_POST["nombreprove"];
				 $nit					= $_POST["nit"];
				 $nrc					= $_POST["nrc"];
				 $condiconPago			= $_POST["condicionpago"];
				
				 $fecha					= $_POST["fecha"];
				 $solicitadaPor			= $_POST["solicitadapor"];
				 $tamannoCotribuyente	= $_POST["tamannocontribuyente"];
				 $condicionpagoCombo	= $_POST["condicionpagoCombo"];
				 ///$idComprobante 		= time();
				 
				 //traigo el ultimo id de la compra generada
				 $traerUltimoIdComprobante = $this->Mimodelobuscar->TaerUlitimoIdComprobante();
				 //extraigo los primero 4 digitos del id_comprobante que es el año
				 $annio       = substr($traerUltimoIdComprobante, 0, 4);//extraigo la porcion del año del id_comprobante
				 $correlativo = substr($traerUltimoIdComprobante, 4, 5);//extraigo la porcion del correlativo del id_comprobante
				 
				 //veo si el año es igual al del servidor
				 //si es igual entonces que sume el correlativo siguiente
				 //sino el correlativo será 1
				 if($annio == date("Y"))
					{
						$correlativo = $correlativo + 1; 
						$annio = $annio; ///si el año es igual al año extraido, entonces que mantenga el año
					}
				 else// es otro año entonces el correlativo sera igual a 1
					{
						$correlativo = 1;
						$annio = date("Y");//pero si el año es distinto al extraido, entonces, que ponga el nuevo año
					}
				 
				 //evaluo para ver cuantos cerros lleva el correlativo
				 if($correlativo <= 9)
                    {
                        $correlativoConAnnioYcereos = $annio."0000".$correlativo;
                    }
                 else if($correlativo <= 99)
                    {
                        $correlativoConAnnioYcereos = $annio."000".$correlativo;
                    }
                 else if($correlativo <= 999)
                    {
                        $correlativoConAnnioYcereos = $annio."00".$correlativo;
                    }
				 else if($correlativo <= 9999)
					{
						$correlativoConAnnioYcereos = $annio."0".$correlativo;
					}
                 else
                    {
                        $correlativoConAnnioYcereos = $annio.$correlativo;
                    } 
				  $idComprobante = $correlativoConAnnioYcereos;
				 
                if($idCondicionPago != "" && $formaPago != "" && $nombreProveedor != "")
                    {
                     
                       //inseto en la tabla con_compras
						$insertarCompra	= $this->Mimodeloinsertar->RegistrarOrdenDeCompra($idComprobante, $idCondicionPago, $formaPago, $diasCredito, $centroCosto, $tipoComprobante, $codigoProveedor,  $idProveedor, $nombreProveedor, $nit, $nrc, $condiconPago, $fecha, $solicitadaPor, $tamannoCotribuyente);    
						if($insertarCompra == true)
							{
								redirect(base_url()."micontrolador/VistaNuevaOrdenCompra/$idComprobante/1029/"); 
							}
						else
							{
								//error inesperado
								redirect(base_url()."micontrolador/VistaNuevaOrdenCompra/$idComprobante/300/"); 
							}
						
					}
                  else
                    {
                        $this->VistaNuevaOrdenCompra();
                    }
              }
			else
				{
					$this->VistaNuevaOrdenCompra();
					
				}
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
	}
public function VistaCrearDetallesNuevaOrdenCompra()
	{
		$estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)                     
        {
          
          $idComprobante		= $this->uri->segment(3,0);
		  if($idComprobante != null)
			{
				  //veo si el contribuyente es distinto a grande para ver el iva retenido 1% ya que 
				  //tambien quieren verlo en la cracion de los detalles de la orden de compra
				  $traerElIdDelProveedorDesdeLaCompra = $this->Mimodelobuscar->TaerIdProveedorDesdeCompra($idComprobante);
				  $idProveedor						= $traerElIdDelProveedorDesdeLaCompra[0]->id_proveedor;
				  //traigo los datos del proveedor para poder hacer operaciones contables con el
				  $traigoLosDatosDelProveedor		= $this->Mimodelobuscar->BuscarProveedorPorId($idProveedor);
				  //envio el tamaño del contribuyente a la vista en la varialbe tamannioProveedor
				  $mostrar["tamannioProveedor"]		= $traigoLosDatosDelProveedor[0]->tamanocontribuyente;
				  //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas();
				  $mostrar["contenido"] = "vista_nuev_detalle_orden_compra";
				  $this->load->view("plantilla", $mostrar);
		  }
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
public function InteractivoProductos()
  {
	/*$estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {*/
			if($_POST)
			{
			   
			  
			  $q=$_POST['buscarpalabra'];
			  
			  $mostrar["busquedaInteractivaMateriales"] = $this->Mimodelobuscar->BusquedaInteractivaProductos($q);
			  $mostrar["contenido"] ="vista_interactiva_materiales";
			  $this->load->view("vista_interactiva_materiales", $mostrar);
			}
		    /*}
      else
        {
            $this->ErrorNoAutenticado();
        } */
  }
public function AgregarProductosAlCarro()
    { 
      $estaLogueado = $this->EstaLogueado(180);
	  if($estaLogueado == true)
		{
				
				$codigoProducto   = $this->uri->segment(4,0);//3 es la posición del codigo del producto de la url
				if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["cantidad"])
					&& isset($_POST["costo"])
				)
				  {
					
					if(isset($_POST["descripcion"]))
						{
							$descripcion 	= $_POST["descripcion"];
							if($descripcion != "")
								{
										$descripcion 	= $_POST["descripcion"];
								}
							else
								{
									$codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($codigoProducto);
									$descripcion = $codiogoProductoAbuscar[0]->descripcion;
								}
						}
					if(isset($_POST["costo"]))
						{
							$costo = $_POST["costo"];
							if($costo != "")
								{
									$costo = $_POST["costo"];
									
								}
							else
								{
									$codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($codigoProducto);
									$costo = $codiogoProductoAbuscar[0]->costo;
								}
								
						}
					
					if($cantidad = $_POST["cantidad"] > 1)
					  {
						$cantidad = $_POST["cantidad"];
					  }
					else
					  {
						$cantidad = 1;  
					  }
				  }
			   else
				  {
					$cantidad = 1;
					$codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($codigoProducto);
					$descripcion = $codiogoProductoAbuscar[0]->descripcion;
					$costo 		 = $codiogoProductoAbuscar[0]->costo;
				  }
					/*$correlativo = time();
					$detalles = $correlativo;
					*/
					$idCompra		  = $this->uri->segment(3,0);//4 es la posición del cliente
					
					$codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($codigoProducto);
                  //print_r($cuantaContableAbuscar);
                  if($codiogoProductoAbuscar)
                    {
                      if(!in_array($codigoProducto, $_SESSION["carro"]))
                        {
                          $_SESSION["carro"][$codigoProducto] = array(
						  //"corelativo"=>$correlativo,
                            "id" =>$codiogoProductoAbuscar[0]->id,
                            "codigo" =>$codiogoProductoAbuscar[0] ->codigo,
                            "descripcion" =>$descripcion,
							"costo" =>$costo,
							"idcompra"=>$idCompra,
							"cantidad"=>$cantidad,
							"subtotal"=>str_replace(',', '', $cantidad) * str_replace(',', '', $costo),
                            );
                          //$_SESSION["carro"] = $carro;
                          return redirect(base_url()."micontrolador/VistaCrearDetallesNuevaOrdenCompra/$idCompra/$codigoProducto/");
                        }
                    }
					
		}
	 else
		{
			$this->ErrorNoAutenticado();
			
		}
    }
 public function EliminarProductosDelCarro()
    {
		$estaLogueado = $this->EstaLogueado(180);
	  if($estaLogueado == true)
		{
		  $idCompra	  = $this->uri->segment(3,0);//3 es la pocion del elemento del array el id de la compra
		  @session_start();
		  unset($_SESSION["carro"]);
		  redirect(base_url()."micontrolador/VistaCrearDetallesNuevaOrdenCompra/$idCompra/");
		}
	 else
		{
			$this->ErrorNoAutenticado();
			
		}
    }
 public function EliminarLineaProductoCarro()
    {
		$estaLogueado = $this->EstaLogueado(180);
	  if($estaLogueado == true)
		{
		  $idProducto = $this->uri->segment(3,0);//3 es la posición del elemento del array
		  $idCompra	  = $this->uri->segment(4,0);//4 es la pocion del elemento del array el id de la compra
		  @session_start();
		   if(!in_array($idProducto, $_SESSION["carro"])) {
				unset($_SESSION["carro"][$idProducto]);
		  }	
			return redirect(base_url()."micontrolador/VistaCrearDetallesNuevaOrdenCompra/$idCompra");
		}
	 else
		{
			$this->ErrorNoAutenticado();
			
		}
    }	
public function RegistrarDetalleCompra()
	{
		$estaLogueado = $this->EstaLogueado(180);
		if($estaLogueado === true)
			{
				if($_SERVER["REQUEST_METHOD"] ==="POST" && isset($_POST["idcuentacontable"]) 
				&& isset($_POST["totalsiniva"]) && isset($_POST["idcompra"])
				&& isset($_POST["observaciones"])
				)
				{
					$idCuentaContable		= $_POST["idcuentacontable"];
					$totalSinIva			= str_replace(',','', $_POST["totalsiniva"]);
					$idCompra				= $_POST["idcompra"];
					$observaciones				= $_POST["observaciones"];
					
				$productoEnElCarroLlave = array_keys($_SESSION["carro"]);
				 //echo $productoEnElCarroLlave[0]["idcompra"];
				  
				  //veo si el id de la compra existe y no esta despachada
				  $buscarIdCompra		= $this->Mimodelobuscar->BuscarElIdDeLaCompraVerSiFueProcesada($idCompra);
				  if($buscarIdCompra == 1)//esta pendiente de procesarr
					{
						$traerElIdDelProveedorDesdeLaCompra = $this->Mimodelobuscar->TaerIdProveedorDesdeCompra($idCompra);
						$idProveedor						= $traerElIdDelProveedorDesdeLaCompra[0]->id_proveedor;
						//traigo los datos del proveedor para poder hacer operaciones contables con el
						$traigoLosDatosDelProveedor		= $this->Mimodelobuscar->BuscarProveedorPorId($idProveedor);
						
						//calculando el iva
						$iva = $totalSinIva * 0.13;
						//veo si el cliente es pequeño o mediano para retener el 1% y si es mayor a $100
						$tamannoContribuyente	= $traigoLosDatosDelProveedor[0]->tamanocontribuyente;
						$unoPorCiento = 0;
						if($tamannoContribuyente != "G" && $totalSinIva > 100)//es pequeño o mediado y la compra es mayor a $100
							{
								$unoPorCiento	= $totalSinIva * 0.01;
							}
						$totalDelDocumento = ($totalSinIva - $unoPorCiento) + $iva;
						
						//inserto el detalle y actualizo la tabla con_compra
						$actualizarLaCompra	= $this->Mimodeloactualizar->ActulizarCompra($idCompra, $iva, $unoPorCiento, $totalDelDocumento, $totalSinIva, $observaciones);
						if($actualizarLaCompra == true)
							{
								//inserto los detalles de la compra
								 ///recorriendo el array del carrro
								  for($i = 0; $i < count($productoEnElCarroLlave); $i ++) 
									  {
										  $enviarDatosAfuncion = $_SESSION["carro"][$productoEnElCarroLlave[$i]];//un array que esta dentro de otro array y este dentor de un array
										  ////inserto el detalle de la compra y un header de la tabal compra
										  $insertarDetalle = $this->Mimodeloinsertar->RegistrarDetalleCompra($enviarDatosAfuncion, $idCompra, $idCuentaContable);
										  										  
									  }
								if($insertarDetalle == true)//los sql no produjeron errores
									{
										//actulizao el estado de la compra
										$actualizarEstadoCompra = $this->Mimodeloactualizar->ActualizarEstadoCompra($idCompra);
										//elimino la sesion del carro
										@session_start();
										unset($_SESSION["carro"]);
										redirect(base_url()."micontrolador/VistaCompras/1029/$idCompra");
									}
								else
									{
										//se produjo cualquier error
										redirect(base_url()."micontrolador/VistaCrearDetallesNuevaOrdenCompra/$idCompra/300/");
									}
							}
						else
							{
								//se produjo cualquier error
								redirect(base_url()."micontrolador/VistaCrearDetallesNuevaOrdenCompra/$idCompra/300/");
							}
					}
				  else
					{
						redirect(base_url()."micontrolador/VistaCrearDetallesNuevaOrdenCompra/$idCompra/301/");//la compra ya ha sido procesada
					}
				 
				}
						
			}
		else
			{
				$this->ErrorNoAutenticado();
			}
	}
public function VistaImprimirOrdenDeCompra()
  {
    $estaLogueado = $this->EstaLogueado(183);
    if($estaLogueado == TRUE)
      {
        $idCompra = $this->uri->segment(3,0);//codigo del de la orden de compra traido desde la url
		
        $mostrar["listarDatosParaImprimirOrdenCompra"] = $this->Mimodelobuscar->ListarDatosParaImprimirOrdenCompra($idCompra);
        //$mostrar["listarPartida"] = $this->Mimodelobuscar->ListarPartida($idCheque);
        //$this->Mimodeloactualizar->ActualizarChequeImpreso($idCheque);
        $mostrar["contenido"] = "vista_imprimir_orden_compra";
        $this->load->view("vista_imprimir_orden_compra", $mostrar);
         
      }
    else
      {
        $this->ErrorNoAutenticado();      
      }
  }
 public function VistaProcesarAlaCXP()
  {
	$estaLogueado = $this->EstaLogueado(181);
      if($estaLogueado == TRUE)                     
        {
              //extraigo de la url el id de la compra
              $idComprobante			   = $this->uri->segment(3,0);
              
              $mostrar["contenido"]      = "vista_procesar_compra_a_cxp";
              $this->load->view("plantilla", $mostrar);
                  

        }
      else
        {
            $this->ErrorNoAutenticado();
        }  
  }
 public function ProCesarCompraYcontabilizar()
	{
		$estaLogueado = $this->EstaLogueado(181);
		if($estaLogueado == true)
			{
				if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["idcomprobante"])
					&& isset($_POST["seriedocumento"])
					&& isset($_POST["numerodocumento"])
					&& isset($_POST["fecha"])
				)
					{
						$idComprobante		= $_POST["idcomprobante"];
						$serieDocumento		= $_POST["seriedocumento"];
						$numeroDocumento	= $_POST["numerodocumento"];
						$fechaDocumento		= $_POST["fecha"];
						$fechaActual		= date("Y-m-d");
						$concepto			= "Por la provision de servicios y/o materiales documento: ".$numeroDocumento;
						if($idComprobante != "" && $serieDocumento != "")
							{
								//traigo el ultimo correlativo por mes
								$fechaDeContabilizacion		  = date("m");//solo el mes actual para buscar con este
								//mes el ultimo correlativo generado
								$traerUltimoCorrelativoPorMes = $this->Mimodelobuscar->TaerUltimoCorreltaivoPorMes($fechaActual);
								
								if($traerUltimoCorrelativoPorMes =! -1029)//si es distinto a -1029 es porque ya existe un correlativo
									{
										//le sumo uno mas
										$siguienteCorrelativoPorMes = $traerUltimoCorrelativoPorMes + 1;
									}
								else
									{
										//no tiene correlativo y se le asigno el numero -1029, entonces, el correlativo será 1
										$siguienteCorrelativoPorMes = 1;
									}
								
								
								//veo si esa compra existe y si ya esta autorizada esta el campo estado_compra = 2
								$verSiExisteCompraYsiEstaAutorizada = $this->Mimodelobuscar->VerSiEstaAutorizadaCompraYsiExiste($idComprobante);
								$existeCompra						= $verSiExisteCompraYsiEstaAutorizada[0]->RESULTADO;
								$estadoCompra						= $verSiExisteCompraYsiEstaAutorizada[0]->estado_compra;
								if($existeCompra == 0)//la comrpa no existe
									{
										redirect(base_url()."micontrolador/VistaProcesarAlaCXP/$idComprobante/1212/");
									}
								elseif($estadoCompra == 2)//ya esta autorizada solo esperando el documento en fisico
									{
										
										//traigo todos los datos de la compra ver si es factura, CCF, Nota de CRedito, Nota de debito o REcibo
										//y si es al credito o al contado dependiendo del tipo se cargan y abonan las cuentas
										$traerTodosLosDatosDeLaCompra	= $this->Mimodelobuscar->ListarDatosParaImprimirOrdenCompra($idComprobante);
										$tipoDocumento					= $traerTodosLosDatosDeLaCompra[0]->id_tipo_comprobante;
										$alContadoOcredito				= $traerTodosLosDatosDeLaCompra[0]->dias_credito;
										$idCuentaContableCostoGasto		= $traerTodosLosDatosDeLaCompra[0]->id_cuenta_contable;				
										$totalAfecto					= $traerTodosLosDatosDeLaCompra[0]->total_afecto;
										$iva							= $traerTodosLosDatosDeLaCompra[0]->total_iva;
										$ivaRetenido					= $traerTodosLosDatosDeLaCompra[0]->total_impuesto2;
										$idProveedor					= $traerTodosLosDatosDeLaCompra[0]->id_proveedor;
										$nombreProveedor				= $traerTodosLosDatosDeLaCompra[0]->nombre;
										
										$totalSinIva					= ($totalAfecto - $iva) + $ivaRetenido;
										
										$tipoPartida = 6;//provisiones aunque sean al contado todas van a ir a la cuetna por pagar
											
											//generando el correlativo de la partida
										  $buscarCorrelativoPartida = $this->Mimodelobuscar->BuscarCorrlativoPartida($tipoPartida, $fechaActual);
										  if($buscarCorrelativoPartida)  //si hay correlativo para ese tipo de partida y fecha que sume uno mas para el siguiente numero
											{
											  //traigo es correlativo
											  $extraerCorrelativoPartida = $this->Mimodelobuscar->ExtraerCorrelativoPartida($tipoPartida, $fechaActual);
											  $numeroSiguienteCorrelativoPartida =  $extraerCorrelativoPartida[0]->correlativo + 1;
											  
											  // y actualizo ese correlativo anterior
											  $this->Mimodeloactualizar->ActualizarCorrelativoPartida($tipoPartida, $fechaActual, $numeroSiguienteCorrelativoPartida); 
											}
										  else //si ese tipo de partida no teien correlativo lo inserto
											{
											   $numeroSiguienteCorrelativoPartida = 1;
											   //inserto el correlativo 1
											  $this->Mimodeloinsertar->InsertarCorrelativoPartida($tipoPartida, $fechaActual, $numeroSiguienteCorrelativoPartida);
											   
											   
											}
												//busco la cuenta contables para la genereacion de partidas
												$traerCuentasContables 			= $this->Mimodelobuscar->ListarCuentasContablesParaPartidaCompras($idCuentaContableCostoGasto);
											   //print_r($traerCuentasContables);
													
											   foreach($traerCuentasContables as $cuentasEncontradas):
												if($cuentasEncontradas->NUMERO_CUALQUIERA == '1029')//cuenta cotnable del costo gasto
													{
														$idCuentaContable            = $cuentasEncontradas->id;
														$codigoCuentaContable        = $cuentasEncontradas->codigo;
														$nombreCuentaContable        = $cuentasEncontradas->nombre;
													}
												elseif($cuentasEncontradas->NUMERO_CUALQUIERA == '1030')//cuenta contable del iva credito fiscal
													{
														 $idCuentaContableIVA            = $cuentasEncontradas->id;
														 $codigoCuentaContableIVA        = $cuentasEncontradas->codigo;
														 $nombreCuentaContableIVA        = $cuentasEncontradas->nombre;
													}
												elseif($cuentasEncontradas->NUMERO_CUALQUIERA == '1031')//cuenta contable del proveedores
													{
														$idCuentaContableProveedores     = $cuentasEncontradas->id;
														$codigoCuentaContableProveedores = $cuentasEncontradas->codigo;
														$nombreCuentaContableProveedores = $cuentasEncontradas->nombre;
													}
												elseif($cuentasEncontradas->NUMERO_CUALQUIERA == '1032')//cuetna contable iva retenido 1%
													{
														 $idCuentaContableIVAretenido     = $cuentasEncontradas->id;
														 $codigoCuentaContableIVAretenido = $cuentasEncontradas->codigo;
														 $nombreCuentaContableIVAretenido = $cuentasEncontradas->nombre;
													}
												endforeach;

											//traigo el ultimo id de la partida para generarlo
											//antes estaba abajo del if $alcontadoOcredito
											 $traerMaxIdPartida			  = $this->Mimodelobuscar->TaerMaximoIdPartida();
											 $ultimoIDPartida			  = $traerMaxIdPartida[0]->id + 1;
										
												if($tipoDocumento == 1 || $tipoDocumento == 3) //el tipo de documento es un comprabante de cridito fiscal o una nata de debito
													{
														//como la compra es al credito ingreso en la tabla cuentasporpagar
														
														//inserto la partida
														$insertarPartidaCompraCredito = $this->Mimodeloinsertar->InsertarPartidaCompraCredito($idComprobante, $ultimoIDPartida, $tipoPartida, $numeroSiguienteCorrelativoPartida, $idCuentaContable, $codigoCuentaContable, $nombreCuentaContable, $idCuentaContableIVA, $codigoCuentaContableIVA, $nombreCuentaContableIVA, $idCuentaContableProveedores, $codigoCuentaContableProveedores, $nombreCuentaContableProveedores, $idCuentaContableIVAretenido, $codigoCuentaContableIVAretenido, $nombreCuentaContableIVAretenido, $serieDocumento, $numeroDocumento, $fechaDocumento, $fechaActual, $concepto, $totalAfecto, $iva, $ivaRetenido, $totalSinIva, $idProveedor, $nombreProveedor, $alContadoOcredito, $siguienteCorrelativoPorMes);
														
														//si se registro/actualizao correctamente
														if($insertarPartidaCompraCredito == true)
															{
																redirect(base_url()."micontrolador/VistaCompras/1030/0/$ultimoIDPartida/");
															}
														else
															{
																
																redirect(base_url()."micontrolador/VistaProcesarAlaCXP/$idComprobante/300/");
															}
													}
												/*elseif($tipoDocumento == 2)//si el documento es una nota de credito lo abondao se carga y lo cargado se abona
													{
														//como la compra es al credito ingreso en la tabla cuentasporpagar
														
														//inserto la partida
														$insertarPartidaCompraCreditoNC = $this->Mimodeloinsertar->InsertarPartidaCompraCreditoNC($idComprobante, $ultimoIDPartida, $tipoPartida, $numeroSiguienteCorrelativoPartida, $idCuentaContable, $codigoCuentaContable, $nombreCuentaContable, $idCuentaContableIVA, $codigoCuentaContableIVA, $nombreCuentaContableIVA, $idCuentaContableProveedores, $codigoCuentaContableProveedores, $nombreCuentaContableProveedores, $idCuentaContableIVAretenido, $codigoCuentaContableIVAretenido, $nombreCuentaContableIVAretenido, $serieDocumento, $numeroDocumento, $fechaDocumento, $fechaActual, $concepto, $totalAfecto, $iva, $ivaRetenido, $totalSinIva, $idProveedor, $nombreProveedor);
														
														//si se registro/actualizao correctamente
														if($insertarPartidaCompraCredito == true)
															{
																redirect(base_url()."micontrolador/VistaCompras/1030/0/$ultimoIDPartida/");
															}
														else
															{
																
																redirect(base_url()."micontrolador/VistaProcesarAlaCXP/$idComprobante/300/");
															}
													}*/
												elseif($tipoDocumento == 4)//el tipo de documento es una factura i al credito
													{
														//inserto la partida como una factura
														$insertarPartidaDocumentoFactura = $this->Mimodeloinsertar->InsertarPartidaDocumentoFactura($idComprobante, $ultimoIDPartida, $tipoPartida, $numeroSiguienteCorrelativoPartida, $idCuentaContable, $codigoCuentaContable, $nombreCuentaContable, $idCuentaContableProveedores, $codigoCuentaContableProveedores, $nombreCuentaContableProveedores, $idCuentaContableIVAretenido, $codigoCuentaContableIVAretenido, $nombreCuentaContableIVAretenido, $serieDocumento, $numeroDocumento, $fechaDocumento, $fechaActual, $concepto, $totalAfecto, $iva, $ivaRetenido, $totalSinIva, $idProveedor, $nombreProveedor, $alContadoOcredito, $siguienteCorrelativoPorMes);
														
														//si las cosultas se ejecutaron con exito
														if($insertarPartidaDocumentoFactura == true)
															{
																redirect(base_url()."micontrolador/VistaCompras/1030/0/$ultimoIDPartida/");
															}
														else
															{
																
																redirect(base_url()."micontrolador/VistaProcesarAlaCXP/$idComprobante/300/");
															}
													}
												elseif($tipoDocumento == 5)//es el tipo de documento un recibo
													{
														//inserto la partida con tipo de documento recibo
														$insertarPartidaDocumentoRecibo = $this->Mimodeloinsertar->InsertarPartidaDocumentoRecibo($idComprobante, $ultimoIDPartida, $tipoPartida, $numeroSiguienteCorrelativoPartida, $idCuentaContable, $codigoCuentaContable, $nombreCuentaContable, $idCuentaContableProveedores, $codigoCuentaContableProveedores, $nombreCuentaContableProveedores, $serieDocumento, $numeroDocumento, $fechaDocumento, $fechaActual, $concepto, $totalAfecto, $idProveedor, $nombreProveedor, $alContadoOcredito);
														
														
														//si las cosultas se ejecutaron con exito
														if($insertarPartidaDocumentoRecibo == true)
															{
																redirect(base_url()."micontrolador/VistaCompras/1030/0/$ultimoIDPartida/");
															}
														else
															{
																
																redirect(base_url()."micontrolador/VistaProcesarAlaCXP/$idComprobante/300/");
															}
													}
													
											
										
										
									}
								else
									{
										redirect(base_url()."micontrolador/VistaProcesarAlaCXP/$idComprobante/1213/");
									}
							}
						
					}
				else
					{
						redirect(base_url()."micontrolador/VistaProcesarAlaCXP/$idComprobante/");
					}
		    }
		else
			{
				$this->ErrorNoAutenticado();
			}
	}
public function AnularOrdenCompraSinCotabilizar()
  {
    $estaLogueado = $this->EstaLogueado(182);
      if($estaLogueado == TRUE)                     
        {
          
              $idComprobante                      = $this->uri->segment(3,0);//traigo el id de la transaccion a anular
              $anular                             = $this->Mimodeloactualizar->AnularOrdenCompraSinCotabilizar($idComprobante);
              if($anular == true)
                {
                 redirect(base_url()."micontrolador/VistaCompras/1300/$idComprobante/");
                }
              else
                {
                 redirect(base_url()."micontrolador/VistaCompras/300/"); //ERROR INESPERADO
                }
          
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
public function BuscarDetallesOrdenCompraModificar()
	{
		$estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)                     
        {
          
         //para que elimine la sesion del carro 2
		 //si vuelvo a dar clic en compras y elijo editar esta compra otra vez
		 //asi me trae lo valores originales de la tabla con_compra_detalle
		 @session_start();
		  unset($_SESSION["carro2"]);
		  
          $idComprobante	 = $this->uri->segment(3,0);
		  $productosAeditar  = $this->Mimodelobuscar->BuscarProductosAeditar($idComprobante);
		  //$idProducto		 = $productosAeditar[0]->id_producto;
		  $correlativo = time();
                  //print_r($cuantaContableAbuscar);
				 // print_r($productosAeditar);
                  if($productosAeditar)
                    {
						
						foreach($productosAeditar as $detallesEcontrados):
						  if(!@in_array($detallesEcontrados->id_producto, $_SESSION["carro2"]))
							{
							  $_SESSION["carro2"][$detallesEcontrados->id_producto] = array(
							  "corelativo"=>$correlativo,
								"id" =>$detallesEcontrados->id,
								"codigo" =>$detallesEcontrados->codigo,
								"descripcion" =>$detallesEcontrados->descripcion,
								"costo" =>$detallesEcontrados->precio_unitario,
								"cantidad"=>$detallesEcontrados->cantidad,
								"subtotal"=>$detallesEcontrados->cantidad * $detallesEcontrados->precio_unitario,
								);
							  //$_SESSION["carro"] = $carro;
							  //return redirect(base_url()."micontrolador/VistaCrearDetallesNuevaOrdenCompra/$idCompra/$codigoProducto/");
							}
						endforeach;
						 return redirect(base_url()."micontrolador/VistaModificarDetallesOrdenCompra/$idComprobante/");
                    }
        
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
public function VistaModificarDetallesOrdenCompra()
	{
		$estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)                     
        {
          /*siguieene para buscar la cunta contable del costo gasto y el nombre de la misma
		   y ponerla en los campos correspondientes de la vista y asi evitar que se busquen nuevamente*/
		  $idComprobante							= $this->uri->segment(3,0);
		  
		  
		  //veo si el contribuyente es distinto a grande para ver el iva retenido 1% ya que 
		  //tambien quieren verlo en la cracion de los detalles de la orden de compra
		  $traerElIdDelProveedorDesdeLaCompra = $this->Mimodelobuscar->TaerIdProveedorDesdeCompra($idComprobante);
		  $idProveedor						= $traerElIdDelProveedorDesdeLaCompra[0]->id_proveedor;
		  //traigo los datos del proveedor para poder hacer operaciones contables con el
		  $traigoLosDatosDelProveedor		= $this->Mimodelobuscar->BuscarProveedorPorId($idProveedor);
		  //envio el tamaño del contribuyente a la vista en la varialbe tamannioProveedor
		  $mostrar["tamannioProveedor"]		= $traigoLosDatosDelProveedor[0]->tamanocontribuyente;
		  
		  $mostrar["listarCuentaContableProductos"]	= $this->Mimodelobuscar->ListarDatosParaImprimirOrdenCompra($idComprobante);
          /*fin de la busqueda de la cuenta contable*/
		  
		  $mostrar["contenido"] 					= "vista_modificar_detalle_orden_compra";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
public function EliminarProductosDelCarro2()
    {
		$estaLogueado = $this->EstaLogueado(180);
	  if($estaLogueado == true)
		{
		  $idCompra	  = $this->uri->segment(3,0);//3 es la pocion del elemento del array el id de la compra
		  @session_start();
		  unset($_SESSION["carro2"]);
		  redirect(base_url()."micontrolador/VistaModificarDetallesOrdenCompra/$idCompra/");
		}
	 else
		{
			$this->ErrorNoAutenticado();
			
		}
    }
 public function EliminarLineaProductoCarro2()
    {
		$estaLogueado = $this->EstaLogueado(180);
	  if($estaLogueado == true)
		{
		  $idProducto = $this->uri->segment(3,0);//3 es la posición del elemento del array
		  $idCompra	  = $this->uri->segment(4,0);//4 es la pocion del elemento del array el id de la compra
		  @session_start();
		   if(!in_array($idProducto, $_SESSION["carro2"])) {
				unset($_SESSION["carro2"][$idProducto]);
		  }	
			return redirect(base_url()."micontrolador/VistaModificarDetallesOrdenCompra/$idCompra");
		}
	 else
		{
			$this->ErrorNoAutenticado();
			
		}
    }	 
public function InteractivoProductosOrdenAmodificar()
  {
	/*$estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {*/
			if($_POST)
			{
			   
			  
			  $q=$_POST['buscarpalabra'];
			  
			  $mostrar["busquedaInteractivaMateriales"] = $this->Mimodelobuscar->BusquedaInteractivaProductos($q);
			  $mostrar["contenido"] ="vista_interactiva_materiales_orden_modificar";
			  $this->load->view("vista_interactiva_materiales_orden_modificar", $mostrar);
			}
		    /*}
      else
        {
            $this->ErrorNoAutenticado();
        } */
  }
public function AgregarProductosAlCarroOrdenAmodificar()
    { 
      $estaLogueado = $this->EstaLogueado(180);
	  if($estaLogueado == true)
		{
				
				$codigoProducto   = $this->uri->segment(4,0);//3 es la posición del codigo del producto de la url
				if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["cantidad"])
					&& isset($_POST["costo"])
				)
				  {
					
					if(isset($_POST["descripcion"]))
						{
							$descripcion 	= $_POST["descripcion"];
							if($descripcion != "")
								{
										$descripcion 	= $_POST["descripcion"];
								}
							else
								{
									$codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($codigoProducto);
									$descripcion = $codiogoProductoAbuscar[0]->descripcion;
								}
						}
					if(isset($_POST["costo"]))
						{
							$costo = $_POST["costo"];
							if($costo != "")
								{
									$costo = $_POST["costo"];
								}
							else
								{
									$codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($codigoProducto);
									$costo = $codiogoProductoAbuscar[0]->costo;
								}
						}
					
					if($cantidad = $_POST["cantidad"] > 1)
					  {
						$cantidad = $_POST["cantidad"];
					  }
					else
					  {
						$cantidad = 1;  
					  }
				  }
			   else
				  {
					$cantidad = 1;
					$codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($codigoProducto);
					$descripcion = $codiogoProductoAbuscar[0]->descripcion;
					$costo = $codiogoProductoAbuscar[0]->costo;
				  }
					/*$correlativo = time();
					$detalles = $correlativo;
					*/
					$idCompra		  = $this->uri->segment(3,0);//4 es la posición del cliente
					
					$codiogoProductoAbuscar  = $this->Mimodelobuscar->BuscarProductoAagregarAlCarro($codigoProducto);
                  //print_r($cuantaContableAbuscar);
                  if($codiogoProductoAbuscar)
                    {
                      if(!in_array($codigoProducto, $_SESSION["carro2"]))
                        {
                          $_SESSION["carro2"][$codigoProducto] = array(
						  //"corelativo"=>$correlativo,
                            "id" =>$codiogoProductoAbuscar[0]->id,
                            "codigo" =>$codiogoProductoAbuscar[0] ->codigo,
                            "descripcion" =>$descripcion,
							"costo" =>$costo,
							"idcompra"=>$idCompra,
							"cantidad"=>$cantidad,
							"subtotal"=>str_replace(',', '', $cantidad) * str_replace(',', '', $costo),
                            );
                          //$_SESSION["carro"] = $carro;
                          return redirect(base_url()."micontrolador/VistaModificarDetallesOrdenCompra/$idCompra/$codigoProducto/");
                        }
                    }
					
		}
	 else
		{
			$this->ErrorNoAutenticado();
			
		}
    }
public function ActualizarDetalleCompra()
	{
		$estaLogueado = $this->EstaLogueado(180);
		if($estaLogueado === true)
			{
				if($_SERVER["REQUEST_METHOD"] ==="POST" && isset($_POST["idcuentacontable"]) 
				&& isset($_POST["totalsiniva"]) && isset($_POST["idcompra"])
				&& isset($_POST["observaciones"])
				)
				{
					$idCuentaContable		= $_POST["idcuentacontable"];
					$totalSinIva			= str_replace(',','', $_POST["totalsiniva"]);
					$idCompra				= $_POST["idcompra"];
					$observaciones				= $_POST["observaciones"];
					
				$productoEnElCarroLlave = array_keys($_SESSION["carro2"]);
				 //echo $productoEnElCarroLlave[0]["idcompra"];
				  
				  //veo la compra ya fuee impresa y ya solo esta esperando el quedan, si es asi que pueda editar sino no
				  $buscarIdCompra		= $this->Mimodelobuscar->BuscarElIdDeLaCompraVerSiYaTieneDetallesEsperandoQuedan($idCompra);
				  if($buscarIdCompra == 1)//puede editarse ya que solo se esta esperando el quedan
					{
						$traerElIdDelProveedorDesdeLaCompra = $this->Mimodelobuscar->TaerIdProveedorDesdeCompra($idCompra);
						$idProveedor						= $traerElIdDelProveedorDesdeLaCompra[0]->id_proveedor;
						//traigo los datos del proveedor para poder hacer operaciones contables con el
						$traigoLosDatosDelProveedor		= $this->Mimodelobuscar->BuscarProveedorPorId($idProveedor);
						
						//calculando el iva
						$iva = $totalSinIva * 0.13;
						//veo si el cliente es pequeño o mediano para retener el 1% y si es mayor a $100
						$tamannoContribuyente	= $traigoLosDatosDelProveedor[0]->tamanocontribuyente;
						$unoPorCiento = 0;
						if($tamannoContribuyente != "G" && $totalSinIva > 100)//es pequeño o mediado y la compra es mayor a $100
							{
								$unoPorCiento	= $totalSinIva * 0.01;
							}
						$totalDelDocumento = ($totalSinIva - $unoPorCiento) + $iva;
						
						//inserto el detalle y actualizo la tabla con_compra
						$actualizarLaCompra	= $this->Mimodeloactualizar->ActulizarCompraNuevosDetalles($idCompra, $iva, $unoPorCiento, $totalDelDocumento, $totalSinIva, $observaciones);
						if($actualizarLaCompra == true)
							{
								//elimino los datalles anteriores de esta compra
								$eliminarDetallesAnteriores = $this->Mimodeloeliminar->EliminarDetallesAnteriores($idCompra);
								if($eliminarDetallesAnteriores == true)//si se eliminaron correctamente que inserte los nuevos detalles3
									{
										//inserto los nuevos detalles de la compra
										 ///recorriendo el array del carrro
										  for($i = 0; $i < count($productoEnElCarroLlave); $i ++) 
											  {
												  $enviarDatosAfuncion = $_SESSION["carro2"][$productoEnElCarroLlave[$i]];//un array que esta dentro de otro array y este dentor de un array
												  ////inserto el detalle de la compra
												  $insertarDetalle = $this->Mimodeloinsertar->RegistrarDetalleCompra($enviarDatosAfuncion, $idCompra, $idCuentaContable);
												  
											  }
										if($insertarDetalle == true)//los sql no produjeron errores
											{
												//actulizao el estado de la compra
												$actualizarEstadoCompra = $this->Mimodeloactualizar->ActualizarEstadoCompra($idCompra);
												//elimino la sesion del carro
												@session_start();
												unset($_SESSION["carro2"]);
												redirect(base_url()."micontrolador/VistaCompras/11102587/$idCompra");//registrada exitosamente
											}
										else
											{
												//se produjo cualquier error
												redirect(base_url()."micontrolador/VistaModificarDetallesOrdenCompra/$idCompra/300/");
											}
									}
								else
									{
										//un error inesperado
										redirect(base_url()."micontrolador/VistaModificarDetallesOrdenCompra/$idCompra/300/");
									}
							}
						else
							{
								//se produjo cualquier error
								redirect(base_url()."micontrolador/VistaModificarDetallesOrdenCompra/$idCompra/300/");
							}
					}
				  else
					{
						redirect(base_url()."micontrolador/VistaModificarDetallesOrdenCompra/$idCompra/301/");//la no ha sido despachada es decir no ha sido impresa
					}
				  
				}
						
			}
		else
			{
				$this->ErrorNoAutenticado();
			}
	}
public function VistaReportesCompras()
  {
    $estaLogueado = $this->EstaLogueado(186);
      if($estaLogueado == TRUE)                     
        {
          $mostrar["contenido"]  = "vista_reportes_compras";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
public function VistaLibroIVAcompras()
	{
     $estaLogueado = $this->EstaLogueado(188);
      if($estaLogueado == TRUE)                     
        {                                                  
        
          if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["annio"])
              && isset($_POST["mes"])
              )
            {
                
                
                  $annio = $_POST["annio"];
                  $mes   = $_POST["mes"];
                 
                  $mostrar["listaReporteLibroComprasIVA"]  = $this->Mimodelobuscar->ListarRegistroGenerarLibroIVACompras($mes, $annio);
                  $mostrar["contenido"]      = "vista_libro_iva_compras";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
             
              
			  $mostrar["listaReporteLibroComprasIVA"] = -1029;
			  $mostrar["contenido"]      			  = "vista_libro_iva_compras";
              $this->load->view("plantilla", $mostrar);
            }
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
 public function VistaEditarIVA()
  {
	$estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {
              //extraigo de la url el id de la compra
              $idComprobante			   	  = $this->uri->segment(3,0);
              $mostrar["traigoElIVAorigina"]  = $this->Mimodelobuscar->ListarDatosParaImprimirOrdenCompra($idComprobante);
			  $mostrar["contenido"]      = "vista_editar_iva";
              $this->load->view("plantilla", $mostrar);
                  

        }
      else
        {
            $this->ErrorNoAutenticado();
        }  
  }
public function ActualizarIVAOrdenCompra()
	{
		$estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {                                                  
        
          if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["idcomprobante"])
              && isset($_POST["iva"])
              )
            {
                
                
                  $idComprobante = $_POST["idcomprobante"];
                  $iva           = $_POST["iva"];
				  
				  //veo si el idComprobante esta en estado_compra = 3, es decir, ya contabilizada
				  $verSiYaEstaContabilizadaLaCompra	= $this->Mimodelobuscar->VerSiYaEstaContabilizadaLaCompra($idComprobante);
				   if($verSiYaEstaContabilizadaLaCompra == 1)//existe la compra y esta contabilizada
						{
							//guardo la actualizacion
							$actualizar = $this->Mimodeloactualizar->ActualizarIVAOrdenCompra($idComprobante, $iva);
							if($actualizar == true)//si se actualizo correctamente
								{
									redirect(base_url()."micontrolador/VistaLibroIVAcompras/1029/$idComprobante/");
								}
							else
								{
									redirect(base_url()."micontrolador/VistaEditarIVA/$idComprobante/300/");//error inesparado
								}
						}
					else
						{
							redirect(base_url()."micontrolador/VistaEditarIVA/$idComprobante/301/");//la compra no esta contabilizada o no existe
						}
				 
                  $mostrar["listaReporteLibroComprasIVA"]  = $this->Mimodelobuscar->ListarRegistroGenerarLibroIVACompras($mes, $annio);
                  $mostrar["contenido"]      = "vista_libro_iva_compras";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
             
              
			  $mostrar["listaReporteLibroComprasIVA"] = 0;
			  $mostrar["contenido"]      			  = "vista_libro_iva_compras";
              $this->load->view("plantilla", $mostrar);
            }
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
public function VistaReporteLibroIVAcompras()
	{
     $estaLogueado = $this->EstaLogueado(188);
      if($estaLogueado == TRUE)                     
        {                                                  
        
          if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["annio"])
              && isset($_POST["mes"])
              )
            {
                
                
                  $annio = $_POST["annio"];
                  $mes   = $_POST["mes"];
                 
                  $mostrar["listaReporteLibroComprasIVA"]  = $this->Mimodelobuscar->ListarRegistroGenerarLibroIVACompras($mes, $annio);
                  $mostrar["contenido"]      = "vista_reporte_libro_iva_compras";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
             
              
			  $mostrar["listaReporteLibroComprasIVA"] = -1029;//no me acuerdo para que es esto al ver la vista me voi a a cordar
			  $mostrar["contenido"]      			  = "vista_reporte_libro_iva_compras";
              $this->load->view("plantilla", $mostrar);
            }
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
	

	///+++++++++++++++++++++++MODULO PRODUCTOS Y SERVICIOS++++++++++++++++++++++
public function VistaNuevoProductoServicioDesdeCompras()
    {
      $estaLogueado = $this->EstaLogueado(184);
      if($estaLogueado == TRUE)                     
        {
            ///traigo el elemento de la uri para ver desde donde estoy creadono el producto o servicio
			//esto para mostralo a unos usuarios de una manera y de otra a otros usuarios
			
			$verDesdeDondeSeCrea	= $this->uri->segment(3,0);	
			//si el segmento es decir $verDesdeDondeSeCrea  es = 1
			//es desde la bodega
			//si es 2 es del modulo compras
			if($verDesdeDondeSeCrea == 2)//es del modulo compras
				{
					$filtro 					  = "";
					$mostrar["listarProveedores"] = $this->Mimodelobuscar->ListarProveedoresParaCheque($filtro);
					$mostrar["contenido"] = "vista_nuevo_producto_servicio";
					$this->load->view("vista_nuevo_producto_servicio", $mostrar);
				}
			else//es desde bodega
				{
               		$mostrar["contenido"] = "vista_nuevo_producto_servicio";
					$this->load->view("plantilla", $mostrar);
				}
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
    }
public function RegistrarProductoServicio()
	{
		$estaLogueado = $this->EstaLogueado(184);
		if($estaLogueado === true)
			{
				if($_SERVER["REQUEST_METHOD"] ==="POST" && isset($_POST["categoria"]) 
				&& isset($_POST["codigoproductoservicio"]) && isset($_POST["unidad"])
				&& isset($_POST["costo"]) && isset($_POST["descripcion"])
				&& isset($_POST["iddedondesecreaelproductoservicio"])
				)
				{
					$categoria							= $_POST["categoria"];
					$codigoProductoServicio				= $_POST["codigoproductoservicio"];
					$unidadMedida						= $_POST["unidad"];
					$costo								= str_replace(',', '', $_POST["costo"]);
					$descripcion						= $_POST["descripcion"];
					$idDeDondeSeCreaElProductoServicio	= $_POST["iddedondesecreaelproductoservicio"];
				    
					if($categoria != "")
						{
							//veo si el codigo del producto/servicio no esta ya registrado
							$verSiExiteCodigoProductoServicio = $this->Mimodelobuscar->VerSiExisteProductoServicio($codigoProductoServicio);
							
							
							if($verSiExiteCodigoProductoServicio != 0)
								{
										redirect(base_url()."micontrolador/VistaNuevoProductoServicioDesdeCompras/$idDeDondeSeCreaElProductoServicio/1030/");//el codigo ya existe
								}
							else
								{
									$insertarProductoServicio = $this->Mimodeloinsertar->InsertarProductoServicio($categoria, $codigoProductoServicio, $unidadMedida, $costo, $descripcion);
									if($insertarProductoServicio == true)
										{
											//traigo el id del procuto creado a l momento ++++++++++sin uso por el momento++++++++++++++++++++
											/*$traerIdDelProuctoCreadoHastaElMomento = $this->Mimodelobuscar->TraerIdCreadoHastaElMomento($codigoProductoServicio);*/
											
											
											redirect(base_url()."micontrolador/VistaNuevoProductoServicioDesdeCompras/$idDeDondeSeCreaElProductoServicio/1029/$codigoProductoServicio/");//lleve el nuevo id del producto para enviarlo al carro de de productos
											exit;
										}
								}
								
							
						}
					else
						{
							redirec(baser_url()."micontrolador/VistaNuevoProductoServicioDesdeCompras/$idDeDondeSeCreaElProductoServicio/");
						}
				
				  
				 
				}
						
			}
		else
			{
				$this->ErrorNoAutenticado();
			}
	}
public function InteractivoVerSiExisteProductoServicio()
  {
	$estaLogueado = $this->EstaLogueado(184);
      if($estaLogueado == TRUE)                     
        {
			if($_POST)
			{
			   
			  
			  $q=$_POST['buscarpalabra'];
			  
			  $mostrar["busquedaInteractivaMateriales"] = $this->Mimodelobuscar->VerSiExisteProductoServicio($q);
			  $mostrar["contenido"] ="vista_interactiva_ya_existe_producto";
			  $this->load->view("vista_interactiva_ya_existe_producto", $mostrar);
			}
		    }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
public function VistaReporteHistoricoXProveedor()
	{
		$estaLogueado = $this->EstaLogueado(186);
		if($estaLogueado == true)
			{
				if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["annio"])
              && isset($_POST["mes"])
              )
            {
                
                
                  $annio = $_POST["annio"];
                  $mes   = $_POST["mes"];
                 
                  $mostrar["listaReporteLibroComprasIVA"]  = $this->Mimodelobuscar->ListarRegistroGenerarLibroIVACompras($mes, $annio);
                  $mostrar["contenido"]      = "vista_reporte_historico_x_proveedor";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
             
              
			 
			  $mostrar["contenido"]      			  = "vista_reporte_historico_x_proveedor";
              $this->load->view("plantilla", $mostrar);
            }
			}
		else
			{
				$this->ErrorNoAutenticado();
			}
	}
public function ReporteHistoricoXProveedor()
  {
     $estaLogueado = $this->EstaLogueado(186);
      if($estaLogueado == TRUE)                     
        {
        
          if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["codigo"])
              && isset($_POST["fechabanco"])
              && isset($_POST["fechabancohasta"])
              )
            {
                 
                   $codigoProveedor           = $_POST["codigo"];
                   $fechaBanco                = $_POST["fechabanco"];
                   $fechaBancoHasta           = $_POST["fechabancohasta"];
                 

                  $mostrar["listarCompraHistoricoXProveedor"] = $this->Mimodelobuscar->ListarComprasHistoricoXProveedor($codigoProveedor, $fechaBanco, $fechaBancoHasta);
				  
                  $mostrar["contenido"]      = "vista_reporte_historico_x_proveedor";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
             
              $codigoProveedor           = "";
              $fechaBanco                = "";
              $fechaBancoHasta           = "";
			  
              $mostrar["listarCompraHistoricoXProveedor"]  = -1029;// para que no me de error en la vista diciendo que la variable listarComprasHistoricoXProveedor no estra definida
                  $mostrar["contenido"]      = "vista_reporte_historico_x_proveedor";
                  $this->load->view("plantilla", $mostrar);
            } 
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
public function ReporteHistoricoXProducto()
  {
     $estaLogueado = $this->EstaLogueado(187);
      if($estaLogueado == TRUE)                     
        {
        
          if($_SERVER["REQUEST_METHOD"] === "POST"
              && isset($_POST["codigo"])
              && isset($_POST["fechabanco"])
              && isset($_POST["fechabancohasta"])
              )
            {
                 
                   $codigoProducto            = $_POST["codigo"];
                   $fechaBanco                = $_POST["fechabanco"];
                   $fechaBancoHasta           = $_POST["fechabancohasta"];
                 

                  $mostrar["listarCompraHistoricoXProducto"] = $this->Mimodelobuscar->ListarCompraHistoricoXProducto($codigoProducto, $fechaBanco, $fechaBancoHasta);
				  
                  $mostrar["contenido"]      = "vista_reporte_historico_x_producto";
                  $this->load->view("plantilla", $mostrar);
                 
               
            }
          else
            {
             
              $codigoProducto           = "";
              $fechaBanco                = "";
              $fechaBancoHasta           = "";
			  
              $mostrar["listarCompraHistoricoXProducto"]  = -1029;// para que no me de error en la vista diciendo que la variable listarComprasHistoricoXProveedor no estra definida
                  $mostrar["contenido"]      = "vista_reporte_historico_x_producto";
                  $this->load->view("plantilla", $mostrar);
            } 
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
  }
 public function BuscarProductos()
    {
      $estaLogueado = $this->EstaLogueado(184);
      if($estaLogueado == TRUE)                     
        {
          
                     
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"]))
          {
              $filtro = $_POST["filtro"];
              $mostrar["listarMateriales"] = $this->Mimodelobuscar->BuscarProductos($filtro);
            //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas(); 
              $mostrar["contenido"] = "vista_buscar_materiales";
              $this->load->view("vista_buscar_materiales", $mostrar);
          }
          ELSE
          {
              $filtro = "";
              $mostrar["listarMateriales"] = $this->Mimodelobuscar->BuscarProductos($filtro);
              $mostrar["contenido"] = "vista_buscar_materiales";
              $this->load->view("vista_buscar_materiales", $mostrar);
          }
          
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function VistaMateriales()
    {
      $estaLogueado = $this->EstaLogueado(184);
      if($estaLogueado == TRUE)                     
        {
          
                     
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"])
			)
          {
              $filtro 		= $_POST["filtro"];
			  //$categoria	= $_POST["categoria"];
              $mostrar["listarMaterialesServicios"] = $this->Mimodelobuscar->BuscarProductosPorNombreOcategoria($filtro);
            //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas(); 
              $mostrar["contenido"] = "vista_materiales";
              $this->load->view("plantilla", $mostrar);
          }
          ELSE
          {
              $filtro 		= "";
			  //$categoria 	= "";
              $mostrar["listarMaterialesServicios"] = $this->Mimodelobuscar->BuscarProductosPorNombreOcategoria($filtro);
              $mostrar["contenido"] = "vista_materiales";
              $this->load->view("plantilla", $mostrar);
          }
          
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function VistaModificarProductoServicioDesdeCompras()
    {
      $estaLogueado = $this->EstaLogueado(185);
      if($estaLogueado == TRUE)                     
        {
           
					$idProductoServicio						     = $this->uri->segment(3,0);
					$mostrar["listarProductoServicioAmodificar"] = $this->Mimodelobuscar->ListarProductoServicioAmodificar($idProductoServicio);
					$mostrar["contenido"] = "vista_modificar_producto_servicio";
					$this->load->view("plantilla", $mostrar);
			
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
    }
public function ModificarProductoServicio()
	{
		$estaLogueado = $this->EstaLogueado(185);
		if($estaLogueado === true)
			{
				if($_SERVER["REQUEST_METHOD"] ==="POST" 
				&& isset($_POST["idproductoservivio"]) && isset($_POST["unidad"])
				&& isset($_POST["costo"]) && isset($_POST["descripcion"])
				&& isset($_POST["codigo"]) & isset($_POST["codigo2"])
				
				)
				{
					
					$codigoProductoServicio				= $_POST["idproductoservivio"];//id del Producto/Servicio
					$codigo								= $_POST["codigo"];
					$codigo2							= $_POST["codigo2"];
					$unidadMedida						= $_POST["unidad"];
					$costo								= str_replace(',', '', $_POST["costo"]);
					$descripcion						= $_POST["descripcion"];
					
				    
					if($codigoProductoServicio != "" && $codigo2 != "")
						{
							//veo si el codigo ha sido modificado y lo comparo con el codigo original
							if($codigo != $codigo2)
								{
									//veo si el codigo del producto/servicio no esta ya registrado
									$verSiExiteCodigoProductoServicio = $this->Mimodelobuscar->VerSiExisteProductoServicio($codigo);
							
								}
							else
								{
									$verSiExiteCodigoProductoServicio = 0;
								}
							if($verSiExiteCodigoProductoServicio != 0)
								{
										redirect(base_url()."micontrolador/VistaModificarProductoServicioDesdeCompras/$codigoProductoServicio/1030/$codigo/");//el codigo ya existe
								}
							else
								{
									$actualizarProductoServicio = $this->Mimodeloactualizar->ActualizarProductoServicio($codigoProductoServicio, $unidadMedida, $costo, $descripcion, $codigo);
									if($actualizarProductoServicio == true)
										{
											
											redirect(base_url()."micontrolador/VistaMateriales/1029/");
											exit;
										}
									else
										{
											redirect(base_url()."micontrolador/VistaModificarProductoServicioDesdeCompras/$codigoProductoServicio/300/");
											exit;
										}
							
								}
							
						}
					else
						{
							redirec(baser_url()."micontrolador/VistaModificarProductoServicioDesdeCompras/$codigoProductoServicio/".time()."/");
						}
				
				  
				 
				}
						
			}
		else
			{
				$this->ErrorNoAutenticado();
			}
	}
public function VistaActualizarEncabezadoOrdenCompra()
	{
		$estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)                     
        {
          $idComprobante = $this->uri->segment(3,0);
          $mostrar["listarCentrosDeCostos"]   = $this->Mimodelobuscar->ListarCentrosDeCostos();
          $mostrar["listarCondicionesDePago"] = $this->Mimodelobuscar->ListarCondicionesDePago();
		  $mostrar["listarEncabezadoOrdenCompraModificar"]	  = $this->Mimodelobuscar->ListarEncabezadoOrdenCompraModificar($idComprobante);
          $mostrar["contenido"] = "vista_actualiar_encabezado_compra";
          $this->load->view("plantilla", $mostrar);
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
	}
public function ActualizarEncabezadoOrdenCompra()
	{
		$estaLogueado = $this->EstaLogueado(180);
      if($estaLogueado == TRUE)
        {
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["idcondicionpago"])
              && isset($_POST["formapago"]) && isset($_POST["diascredito"])
              && isset($_POST["centrocosto"]) && isset($_POST["tipocomprobante"])
			  && isset($_POST["codigo"])
              && isset($_POST["idproveedor"]) && isset($_POST["nombreprove"])
              && isset($_POST["nit"]) && isset($_POST["nrc"])
              && isset($_POST["condicionpago"])
              && isset($_POST["fecha"]) && isset($_POST["solicitadapor"])
			  && isset($_POST["tamannocontribuyente"])
			  && isset($_POST["condicionpagoCombo"]) && isset($_POST["idcomprobante"])
			  )
              {
              
                 $idCondicionPago		= $_POST["idcondicionpago"];
				 $formaPago				= $_POST["formapago"];
				 $diasCredito			= $_POST["diascredito"];
				 $centroCosto			= $_POST["centrocosto"];
				 $tipoComprobante		= $_POST["tipocomprobante"];
				 $codigoProveedor		= $_POST["codigo"];
				 $idProveedor			= $_POST["idproveedor"];
				 $nombreProveedor		= $_POST["nombreprove"];
				 $nit					= $_POST["nit"];
				 $nrc					= $_POST["nrc"];
				 $condiconPago			= $_POST["condicionpago"];
				
				 $fecha					= $_POST["fecha"];
				 $solicitadaPor			= $_POST["solicitadapor"];
				 $tamannoCotribuyente	= $_POST["tamannocontribuyente"];
				 $condicionpagoCombo	= $_POST["condicionpagoCombo"];
				 $idComprobante			= $_POST["idcomprobante"];
				 ///$idComprobante 		= time();
				 
				
				 
                if($idCondicionPago != "" && $formaPago != "" && $nombreProveedor != "" && $idComprobante != "")
                    {
                     
                       //inseto en la tabla con_compras
						$actualizarEncabezadoCompra	= $this->Mimodeloactualizar->ActualizarEncabezadoOrdenCompra($idComprobante, $idCondicionPago, $formaPago, $diasCredito, $centroCosto, $tipoComprobante, $codigoProveedor,  $idProveedor, $nombreProveedor, $nit, $nrc, $condiconPago, $fecha, $solicitadaPor, $tamannoCotribuyente); //la variable $tamannoCotribuyente y $idCondicionPago no se utilizan   
						if($actualizarEncabezadoCompra == true)
							{
								redirect(base_url()."micontrolador/VistaCompras/1400/$idComprobante/"); 
								exit;
							}
						else
							{
								//error inesperado
								redirect(base_url()."micontrolador/VistaActualizarEncabezadoOrdenCompra/300$idComprobante/"); 
							}
						
					}
                  else
                    {
                        redirect(base_url()."micontrolador/VistaActualizarEncabezadoOrdenCompra/$idComprobante/"); 
                    }
              }
			
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
	}
	
///////////////////////////++++++++++++++++++++CENTROS DE COSTO++++++++++++++++**************/////////////
public function VistaCentroCostos()
    {
      $estaLogueado = $this->EstaLogueado(189);
      if($estaLogueado == TRUE)                     
        {
          
                     
          if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["filtro"])
			)
          {
              $filtro 		= $_POST["filtro"];
			  //$categoria	= $_POST["categoria"];
              $mostrar["listarMaterialesCentrosCostos"] = $this->Mimodelobuscar->BuscarCentroCostoPorNombreOcategoria($filtro);
            //$mostrar["listarTiposPartidas"] = $this->Mimodelobuscar->ListarTiposPartidas(); 
              $mostrar["contenido"] = "vista_centros_costos";
              $this->load->view("plantilla", $mostrar);
          }
          ELSE
          {
              $filtro 		= "";
			  //$categoria 	= "";
              $mostrar["listarMaterialesCentrosCostos"] = $this->Mimodelobuscar->BuscarCentroCostoPorNombreOcategoria($filtro);
              $mostrar["contenido"] = "vista_centros_costos";
              $this->load->view("plantilla", $mostrar);
          }
          
       }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
public function VistaNuevoCentroCosto()
    {
      $estaLogueado = $this->EstaLogueado(190);
      if($estaLogueado == TRUE)                     
        {
           
               		$mostrar["contenido"] = "vista_nuevo_centro_costo";
					$this->load->view("plantilla", $mostrar);
		
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
    }
public function RegistrarCentroCosto()
	{
		$estaLogueado = $this->EstaLogueado(190);
		if($estaLogueado === true)
			{
				if($_SERVER["REQUEST_METHOD"] ==="POST" && isset($_POST["codigocentrocosto"])
				&& isset($_POST["descripcion"])
				)
				{
					$codigoCentroCosto		= $_POST["codigocentrocosto"];
					$descripcion						= $_POST["descripcion"];
					if($codigoCentroCosto != "" && $descripcion)
						{
							//veo si el codigo del del centro de costo no esta ya registrado
							$verSiExiteCentroCosto = $this->Mimodelobuscar->VerSiExisteCentroCosto($codigoCentroCosto);
							
							
							if($verSiExiteCentroCosto != 0)
								{
										redirect(base_url()."micontrolador/VistaNuevoCentroCosto/$codigoCentroCosto/1030/");//el codigo ya existe
								}
							else
								{
									$insertarCentroCosto = $this->Mimodeloinsertar->InsertarCentroCosto($codigoCentroCosto, $descripcion);
									if($insertarCentroCosto == true)
										{
											
											
											redirect(base_url()."micontrolador/VistaNuevoCentroCosto/$codigoCentroCosto/1029/");//se registro satisfactoriamente
											exit;
										}
								}
								
							
						}
					else
						{
							redirec(baser_url()."micontrolador/VistaNuevoCentroCosto/");
						}
				
				  
				 
				}
						
			}
		else
			{
				$this->ErrorNoAutenticado();
			}
	}
public function VistaModificarCentroCosto()
    {
      $estaLogueado = $this->EstaLogueado(191);
      if($estaLogueado == TRUE)                     
        {
           
					$idCentroCosto						     = $this->uri->segment(3,0);
					$mostrar["listarCentroCostoAmodificar"] = $this->Mimodelobuscar->ListarCentroCostoAmodificar($idCentroCosto);
					$mostrar["contenido"] = "vista_modificar_centro_costo";
					$this->load->view("plantilla", $mostrar);
			
        }
      else
        {
          $this->ErrorNoAutenticado();
        }
    }
public function ModificarCentroCosto()
	{
		$estaLogueado = $this->EstaLogueado(191);
		if($estaLogueado === true)
			{
				if($_SERVER["REQUEST_METHOD"] ==="POST" 
				&& isset($_POST["idcentrocosto"])  && isset($_POST["descripcion"])
				
				)
				{
					
					$idCentroCosto				= $_POST["idcentrocosto"];//id del centro de costo
					$descripcion						= $_POST["descripcion"];
					
				    
					if($idCentroCosto != "")
						{
							
									$actualizarCentroCosto = $this->Mimodeloactualizar->ActualizarCentroCosto($idCentroCosto, $descripcion);
									if($actualizarCentroCosto == true)
										{
											
											redirect(base_url()."micontrolador/VistaCentroCostos/1029/");
											exit;
										}
									else
										{
											redirect(base_url()."micontrolador/VistaModificarProductoServicioDesdeCompras/300/");
											exit;
										}
							
								
							
						}
					else
						{
							redirec(baser_url()."micontrolador/VistaModificarCentroCosto/$idCentroCosto/".time()."/");
						}
				
				  
				 
				}
						
			}
		else
			{
				$this->ErrorNoAutenticado();
			}
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */