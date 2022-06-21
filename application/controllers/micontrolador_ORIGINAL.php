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
  } 
  public function index()
	 {
	   $mostrar["contenido"] = "vista_index";   
     $this->load->view("plantilla", $mostrar);
	 }
 public function EstaLogueado()     
  {
    
    if(isset($this->session->userdata['username']))
      {
          return TRUE;
      }
    else                                 
      {
          return FALSE;
      }                           

  }
  public function ErrorNoAutenticado()
    {
        $mostrar["error"] = "Usted no se ha autenticado...";
        $mostrar["contenido"] = "vista_error";
        $this->load->view("plantilla", $mostrar);
    }
 public function VistaInicio()
  {
    $estaLogueado = $this->EstaLogueado();
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
  public function VistaBanco()
    {
      $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {
          $mostrar["listarCuentasBanco"]  = $this->Mimodelobuscar->ListarCuentasBancarias();
         // if($_SERVER["")
          $mostrar["contenido"] = "vista_banco";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function VistaNuevaCuenta()
    {
      $estaLogueado = $this->EstaLogueado();
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
      $estaLogueado = $this->EstaLogueado();
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
                                    //exit;
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
      $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {
          $mostrar["listarCheques"]  = $this->Mimodelobuscar->ListarCheques();
          $mostrar["listarChequesNoContabilizados"] = $this->Mimodelobuscar->ListarChequesNoContabilizados();
          $mostrar["contenido"]      = "vista_cheque";
          $this->load->view("plantilla", $mostrar);
        }
      else
        {
            $this->ErrorNoAutenticado();
        } 
    }
  public function VistaNuevoCheque()
    {
      $estaLogueado = $this->EstaLogueado();
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
   public function RegistrarCheque()
    {
      $estaLogueado = $this->EstaLogueado();
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
              
                 echo $cuenta      = $_POST["cuenta"];
                 echo $codigoProve = $_POST["codigo"];
                 echo $anombrede   = $_POST["anombrede"];
                 echo $monto       = $_POST["monto"];
                 echo "<br>Tipo de partida: ".$tipoPartida = $_POST["tipopartida"];
                 echo "<br>".$fecha       = $_POST["fecha"];
                 echo $concepto    = $_POST["concepto"];
                 $idUsuario = $this->session->userdata("id");
                 $userName = $this->session->userdata("username");
                 //$numeroCheque  = 0;
                if($cuenta != "" && $anombrede != "")
                  {
                     $buscarCuenta = $this->Mimodelobuscar->BuscarCuentaEnCheque($cuenta);
                      if($buscarCuenta)  //ya hay numero de cheque en la tabla ban_cheque  y busco el maximo
                        {
                          $buscarUltimoNumeroCheque = $this->Mimodelobuscar->BuscarUltimoNumeroCheque($cuenta);
                          $numeroChequeque = $buscarUltimoNumeroCheque[0]->numero_cheque + 1;
 
                        
                        }
                      else  
                        {
                          // no ai registron en la tabal ban_cheque,
                          //entonces, el numero del cheque se agarra
                          //de la tabla ban_cuenta_bancaria del último cheque emitido
                          $buscarUltimoNumeroCheque = $this->Mimodelobuscar->BuscarUltimoNumeroChequeTablaCuentaBancaria($cuenta);
                         $numeroChequeque = $buscarUltimoNumeroCheque[0]->ultimo_numero_cheque + 1;
                        }
                      //generando el correlativo de la partida
                      $buscarCorrelativoPartida = $this->Mimodelobuscar->BuscarCorrlativoPartida($tipoPartida, $fecha);
                      if($buscarCorrelativoPartida)  //si hay correlativo para ese tipo de partida y fecha que sume uno mas para el siguiente numero
                        {
                          //traigo es correlativo
                          $extraerCorrelativoPartida = $this->Mimodelobuscar->ExtraerCorrelativoPartida($tipoPartida, $fecha);
                          $numeroSiguienteCorrelativoPartida =  $extraerCorrelativoPartida[0]->correlativo + 1;
                          
                          // y actualico ese correlativo anterior
                          /*$this->Mimodeloactualizar->ActualizarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida); */
                        }
                      else //si ese tipo de partida no teien correlativo lo inserto
                        {
                           $numeroSiguienteCorrelativoPartida = 1;
                           //inseto el correlativo 1
                          /* $this->Mimodeloinsertar->InsertarCorrelativoPartida($tipoPartida, $fecha, $numeroSiguienteCorrelativoPartida);
                           */
                           
                        }
          /*extraer el maximo numero de partida creada desde cheque
          $miIdentificador  = $this->Mimodelobuscar->ExtraerCorrelativoDesdeCheque();
          if($miIdentificador)//si hay algun numero existente que le sume uno
            {
              $identificadorPartidaCheque = $miIdentificador[0]->correlativo_partida_creada_desde_cheque + 1;
            }  //sino que sea igual a 1
          else
            {
               $identificadorPartidaCheque = 1;
            }          
          */          
          
                      $traerIdCuentaContable = $this->Mimodelobuscar->TraerIdCuentaContable($cuenta);
                      $idCuentaContable =  $traerIdCuentaContable[0]->id_cuenta_contable; 
                    
                    //traigo el maximo de la tabla ban_cheque para guardarlo en la tabla contapartidas
                     $maxUltimoIdCheque = $this->Mimodelobuscar->UltimoIdCheque();
                     $maxIdUltimoCheque  = $maxUltimoIdCheque[0]->id_cheque + 1;
                     
                       
                      //guardo la partida  
                      $insertar = $this->Mimodeloinsertar->InsertarNuevaPartida($fecha, $tipoPartida, $numeroSiguienteCorrelativoPartida, $concepto, $monto, $idUsuario, $numeroChequeque, $anombrede, $userName, $cuenta, $idCuentaContable, $maxIdUltimoCheque); //$idUltimoCheque);
                      
                       
                       //$this->Mimodeloinsertar->InsertarNuevoCheque($numeroChequeque, $fecha, $monto, $anombrede, $concepto, $userName, $tipoPartida, $cuenta, $numeroSiguienteCorrelativoPartida);*/ 
                      //si se insertan los valores enviados a la
                      //tabla ban_cheque y la tabla contapartidas
                      //que inserte el detalle del cheque
                      //en la tabla ban_detalle_cheque 
                      if($insertar == true)
                         {
                           //traigo el  ultimo ide del cheque
                           $ultimoIdCheque = $this->Mimodelobuscar->UltimoIdCheque();
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
                           
                            //inseto el detalle del chque y el primer detalle de la partida original
                             $insertarDetalleCheque = $this->Mimodeloinsertar->InsertarDetalleCheque($concepto, $monto, $idUltimoCheque, $idCuentaContable, $idDelaParidaPorCheque, $idCuenta, $codigoCuenta, $nombreCuenta);
                           if($insertarDetalleCheque == true)
                              {
                                unset($_SESSION["cuentasAlaPartida"]);
                                redirect(base_url()."micontrolador/VistaCrearPartidaDetalles/$idDelaParidaPorCheque/$maxIdUltimoCheque/");
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
      $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == true)
        {
          $idDelaParidaPorCheque  = $this->uri->segment(3,0);
          $idCheque               = $this->uri->segment(4,0);
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
   public function VistaBuscarProveedoresParaCrheque()
    {
      $estaLogueado = $this->EstaLogueado();
      if($estaLogueado == TRUE)                     
        {
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
      $estaLogueado = $this->EstaLogueado();
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
                  echo $abono;
                  echo $cargo; 
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
    $estaLogueado = $this->EstaLogueado();
    if($estaLogueado == true)
      {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["totalcargos"]) && isset($_POST["totalabonos"]))
          {
             $totalCargos           = $_POST["totalcargos"];
             $totalAbonos           = $_POST["totalabonos"];
             
             $idPartida             = $this->uri->segment(3,0);//traigo del uri(url) el segmento que contiene el codigo de la partida
             if($totalCargos == $totalAbonos && $totalCargos != "" && $totalAbonos != "")
              {
                 $cuentaEnLaSesionLlave = array_keys($_SESSION["cuentasAlaPartida"]);
                  ///recorriendo el array de la sesion cuentasAlaPartida
                  for($i = 0; $i < count($cuentaEnLaSesionLlave); $i ++) 
                      {
                          $enviarDatosAfuncion = $_SESSION["cuentasAlaPartida"][$cuentaEnLaSesionLlave[$i]];//un array que esta dentro de otro array y este dentor de un array
                          $insertar = $this->Mimodeloinsertar->GuardarYcontabilizar($enviarDatosAfuncion, $idPartida, $totalCargos, $totalAbonos);
                      }
                  if($insertar == true)
                    {
                      return redirect(base_url()."micontrolador/VistaCheque/$idPartida/1029/");
                     //eliiminio la sesion que contine los detalles de las cuentas de la partida
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
 public function VistaImprimirChequeProcesado()
  {
    $estaLogueado = $this->EstaLogueado();
    if($estaLogueado == TRUE)
      {
        $idCheque = $this->uri->segment(3,0);//codigo del cheque traido desde la url
        $mostrar["listarDatosParaImprimirChequeProcesado"] = $this->Mimodelobuscar->ListarDatosParaImprimirChequeProcesado($idCheque);
        $mostrar["contenido"] = "vista_imprimir_cheque_procesado";
        $this->load->view("vista_imprimir_cheque_procesado", $mostrar);
      }
    else
      {
        $this->ErrorNoAutenticado();
      }
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */