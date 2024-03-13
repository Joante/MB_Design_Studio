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
    protected $description = 'Create admin user.';

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

        $this->info('Validating data.');

        $validator = $this->validateData($data);

        //If the validations fails show a error message and run the form again
        while($validator->fails())
        {
            $this->info('Validation failed.');

            $messages = $validator->messages();

            foreach ($messages->all() as $message)
            {
                $this->info($message);
            }
            $data = $this->obtainData();
            $this->info('Validating data.');
            $validator = $this->validateData($data);
        }

        //Create and store the user.
        $user = new User();
        $user->password = Hash::make($data['password']);
        $user->username = $data['username'];
        $user->name = $data['name'];

        if($user->save()){
            Acounts::create(['type' => 'personal']);
            Acounts::create(['type' => 'mb']);
            $this->info('Save successful');
        }else
        {
            $this->info('Save failed.');
        }
    }

    /**
     * Validate the form data.
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
     * User form
     *
     * @return array of data.
     */
    public function obtainData()
    {
        $passwordComparison = false;

        $name = $this->ask('Name');

        $username = $this->ask('Username');

        //Compare the password and password confirmation field.
        while(! $passwordComparison){
            $password = $this->secret('Password');
            $confirmPassword = $this->secret('Repeat password');
            if(strcmp($password, $confirmPassword)==0){
                    $passwordComparison = true;
                }
                else {
                    $this->info('The passwords does not match. Try again.');
                }
        }
        return array(
            'username' => $username,
            'name' => $name,
            'password' => $password,
        );
    }
}
