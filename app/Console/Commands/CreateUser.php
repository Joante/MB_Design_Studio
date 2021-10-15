<?php

namespace App\Console\Commands;

use App\Models\Acounts;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear usuario para utilizar en el sistema';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->obtainData();

        $this->info('Validando datos');

        $validator = $this->validateData($data);

        //Muestro los mensajes de error y vuelvo a preguntar los datos si fallo la validacion.
        while($validator->fails())
        {
            $this->info('Validacion fallida');

            $messages = $validator->messages();

            foreach ($messages->all() as $message)
            {
                $this->info($message);
            }
            $data = $this->obtainData();
            $this->info('Validando datos');
            $validator = $this->validateData($data);
        }

        //Creo el usuario y lo guardo.
        $user = new User();
        $user->password = Hash::make($data['password']);
        $user->username = $data['username'];
        $user->name = $data['name'];
        $user->description = 'Insertar descripcion';

        if($user->save()){
            Acounts::create(['type' => 'personal']);
            Acounts::create(['type' => 'mb']);
            $this->info('Guardado exitoso');
        }else
        {
            $this->info('Guardado fallido');
        }
    }

    /**
     * Valido los datos ingresados.
     *
     * @return Validator instance.
     */
    public function validateData(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'alpha_dash', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Obtengo los datos
     *
     * @return array de datos.
     */
    public function obtainData()
    {
        $passwordComparison = false;

        $name = $this->ask('Ingresar nombre');

        $username = $this->ask('Ingresar nombre de usuario');

        //Comparo las contraseñas para confirmarlas.
        while(! $passwordComparison){
            $password = $this->secret('Ingrese contraseña');
            $confirmPassword = $this->secret('Confirme contraseña');
            if(strcmp($password, $confirmPassword)==0){
                    $passwordComparison = true;
                }
                else {
                    $this->info('Las contraseñas no coinciden. Ingrese nuevamente');
                }
        }
        return array(
            'username' => $username,
            'name' => $name,
            'password' => $password,
        );
    }
}
