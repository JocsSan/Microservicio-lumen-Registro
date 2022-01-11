<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // //conectar con tabla
    // protected $table = 'clientes';
    // //le decimos al modelo cual es la clave primaria
    // protected $primaryKey = 'id_cliente';
    // //definimos los valores predeterminados en la creaion de los usuarios
    // protected $fillable = [
    //     'IDENTIDAD', 'PRIMER_NOMBRE','SEGUNDO_NOMBRE','PRIMER_APELLIDO',
    //     'SEGUNDO_APELLIDO','FECHA_NACIMIENTO','SEXO','EMAIL','DIRECCION','ESTADO_CLIENTE',
    // ];
    // // adapatmos los timestamps a nuestra tabla 
    // /**
    //  * The attributes excluded from the model's JSON form.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'PIN',
    // ];
}
