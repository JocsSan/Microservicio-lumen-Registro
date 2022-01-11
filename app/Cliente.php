<?php


namespace App;
use Illuminate\Database\Eloquent\Model;
class Cliente extends Model
{
//creado manualmente, en teoria comunica la database con los controladores ya que el model es el unico capaz de hacerlo
protected $table = 'clientes';
    //le decimos al modelo cual es la clave primaria
    protected $primaryKey = 'ID_CLIENTE';
    //definimos los valores predeterminados en la creaion de los usuarios
    protected $fillable = [
        'IDENTIDAD', 'PRIMER_NOMBRE','SEGUNDO_NOMBRE','PRIMER_APELLIDO',
        'SEGUNDO_APELLIDO','FECHA_NACIMIENTO','SEXO','EMAIL','DIRECCION','ESTADO_CLIENTE',
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'PIN',
    ];

}
