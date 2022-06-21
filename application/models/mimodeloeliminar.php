<?php
class Mimodeloeliminar extends CI_Model
{
  public function EliminarDatosDeconciliacioParaAgregarNuevos($mes, $annio, $cuentaBancaria)
    {
      $eliminar = $this->db->delete("ban_conciliaciones", array("mes"=> $mes, "annio"=>$annio, "id_cuenta_bancaria"=>$cuentaBancaria));
      if($eliminar)
        {
          return true;
        }
      else
        {
          return false;
        }
    }
public function EliminarDetallesAnteriores($idCompra)
	{
		$this->db->where("id_comprobante", $idCompra);
		
		$eliminar = $this->db->delete("con_compra_detalle");//nombre de la tabla
		if($eliminar)
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