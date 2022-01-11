<?php
namespace App\Http\Controllers;
// use http\Env\Reques;
use Illuminate\Http\Request;
use App\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    //public fuction

    //registro
    public function register( Request $req ){
      //metod para obtener fecha
      $now = new \DateTime();

      //forma de obtener el pin atraves de una url
      //$GetPin = file_get_contents('https://discordapp.com/api/guilds/653372841961455627/widget.json');
      //convertimos json a una varialble
      //$json_pin = json_decode($GetPin);

      // consultamos la disponibilidad de billeteras
      $billeteras = DB::table('billeteras')->select('ID_BILLETERA','BILLETERA_ASIGNADA')->where('BILLETERA_ASIGNADA',"N")->first();
      // si la consulta de billeterasa disponibles no muestra resultaados su valor sera nulo
      if($billeteras!=null){
      // validamos los datos
      //          'ID_CLIENTE','IDENTIDAD', 'PRIMER_NOMBRE','SEGUNDO_NOMBRE','PRIMER_APELLIDO',
      //          'SEGUNDO_APELLIDO','FECHA_NACIMIENTO','SEXO','EMAIL','DIRECCION',
      //          'ESTADO_CLIENTE','USU_CRE','FEC_CRE','USU_MOD','FEC_MOD'
         $this->validate($req, [
            'identidad' => 'required | min:13|max:13',
            'primer_nombre' => 'required | min:3|max:45',
            'primer_apellido' => 'required | min:3|max:45',
            'FECHA_NACIMIENTO' => 'requiered | date',
            'SEXO'=>'requiered|min:1|max:1',
            'email' => 'required|email',
            'USU_CRE'=>'requiered | min:3| max:45',
            'FEC_CRE' => 'requiered | date',
         ]);
         try {
            $cliente = new Cliente();
            $cliente->identidad = $req->input('identidad');
            $cliente->primer_nombre = $req->input('primer_nombre');
            $cliente->Segundo_nombre = $req->input('segundo_nombre');
            $cliente->primer_apellido = $req->input('primer_apellido');
            $cliente->segundo_apellido= $req->input('segundo_apellido');
            $cliente->fecha_nacimiento = $req->input('fecha_nacimiento');
            $cliente->sexo = $req->input('sexo');
            $cliente->email = $req->input('email');
            $cliente->direccion = $req->input('direccion');
            $cliente->estado_cliente = "a";
            // generamos la fecha de manera automatica
            $cliente->Fec_cre = $now->format('Y-m-d H:i:s');
            $cliente->usu_cre = $req->input('usu_cre');
            // no son necesarios hasta actualizar
            $cliente->usu_mod = $req->input('usu_mod');
            $cliente->Fec_mod = $req->input('fec_mod');
            
            // pedimos el pin
            //$cliente->pin = Hash::make($req->input('pin'));
            $cliente->pin = $req->input('pin');
            //guardamos
            $cliente->save();
            // consultamos por el id_cliente usando la identidad como referencia
            $asignacion_cliente = DB::table('clientes')->select('id_cliente')->where('identidad', $req->input('identidad'))->first();
            //llamamos una billetera disponible
            $asignacion_billetera = DB::table('billeteras')->select('id_billetera')->where('BILLETERA_ASIGNADA',"N")->first();
            //la actualizamos
            $actualizacion_billeteras = DB::table('billeteras')->where('id_billetera', $asignacion_billetera->id_billetera)
            ->update([
               'BILLETERA_ASIGNADA' => "S", 
               'Fec_mod' => $now->format('Y-m-d H:i:s'), 'usu_mod' => $req->input('usu_cre')
            ]);
            //insertamos en billeteras_cliente
            $insercion_billetera = DB::table('billeteras_clientes')->insert([
               'id_cliente' => $asignacion_cliente->id_cliente, 'id_billetera' => $asignacion_billetera->id_billetera,
               'Fec_cre'=> $now->format('Y-m-d H:i:s'),'usu_cre' => $req->input('usu_cre')
            ]);
            //creamos el saldo del nuevo usuario
            $creacion_saldo = DB::table('saldo_billetera')->insert([
               'id_billetera' => $asignacion_billetera->id_billetera,'saldo_billetera' => 0,
               'Fec_cre'=> $now->format('Y-m-d H:i:s'),'usu_cre' => $req->input('usu_cre')
            ]);
            return response()->json(['estado' => 'creacion correcta', 
            'numero de billetera' => $asignacion_billetera,'fecha de creacion' =>$now->format('Y-m-d H:i:s')]);
         } catch(QueryException $ex) {
            return response()->json(['error'=>$ex->getMessage()]);
         }
      }else{
         //resultado de 0 billeteras disponibles
         return response()->json(['estado'=>'fallido, no hay billeteras disponibles']);
      }
    }


}
