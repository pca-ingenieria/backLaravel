<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class Apicontroller extends Controller
{
    public function getUsers()
    {
        return User::selectRaw("id, name, lastName, amount, email, telephone, 
            CASE WHEN amount < 2000  THEN amount ELSE (amount * 0.1) END AS betAvailable, true AS flagLess, 
            CASE WHEN amount < 2000  THEN true ELSE false END AS flagMore")->get();
    }

    public function betUser(){
        $probabilidad = mt_rand(1, 100);
        if($probabilidad <= 49){
            return 3;
        }
        if($probabilidad > 49 && $probabilidad <= 98 ){
            return 2;
        }
        if($probabilidad > 98){
            return 1;
        }
        return $probabilidad;
    }

    public function amountBet($amount)
    {
        if($amount < 2000){
            return $amount;
        }
        return ($amount * (mt_rand(10, 15) / 100));
    }
    
    public function getUsersAutomatic()
    {
        $data = User::selectRaw("id, name, lastName, amount, email, telephone, 
            CASE WHEN amount < 2000  THEN amount ELSE (amount * 0.1) END AS betAvailable, true AS flagLess, 
            CASE WHEN amount < 2000  THEN true ELSE false END AS flagMore")->get();

            for ($i=0; $i < count($data); $i++) { 
                if($data[$i]->amount > 0){
                    $data[$i]->bet = $this->betUser();
                    $data[$i]->betAvailable = $this->amountBet($data[$i]->amount);
                }
            }
            return $data;
    }    

    public function saveUser(Request $request)
    {
        try{
            $data = json_decode($request->getContent(), true);
            $userValidate = User::where("email",$data['email'])->first();
            if(isset($userValidate)){
                throw new \InvalidArgumentException("Ya existe un usuario con ese correo");
            }
            if(!is_numeric($data['amount'])){
                throw new \InvalidArgumentException("El número de identificación no puede tener letras");
            }
            if(!is_numeric($data['telephone'])){
                throw new \InvalidArgumentException("El teléfono no puede tener letras");
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("El formato del correo eléctronico no es valido");
            }

            
            $user = new User();
            $user->name = $data['name'];
            $user->lastName = $data['lastName'];
            $user->amount = $data['amount'];
            $user->email = $data['email'];
            $user->telephone = $data['telephone'];
            $user->save(); 

            $response['status'] = "ok";
            return response()->json($response);
    } catch (\InvalidArgumentException $ex) {
        $response['estado']  = "error";
        $response['mensaje'] = $ex->getMessage();
        return response()->json($response, 422);
    } catch (\Exception $ex) {
        $response['estado']  = "error";
        $response['mensaje'] = $ex->getMessage();
        return response()->json($response, 500);
    }
    }

    public function showUser($id)
    {
        return User::find($id);
    }
    
    public function editUser(Request $request)
    {
        try{
            $re = json_decode($request->getContent(), true);
            $data = $re["data"];
            $userValidate = User::where("email",$data['email'])->where("id","!=",$re['id'])->first();
            //dd($userValidate);
            if(isset($userValidate)){
                throw new \InvalidArgumentException("Ya existe un usuario con ese correo");
            }
            if(!is_numeric($data['amount'])){
                throw new \InvalidArgumentException("El número de identificación no puede tener letras");
            }
            if(!is_numeric($data['telephone'])){
                throw new \InvalidArgumentException("El teléfono no puede tener letras");
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("El formato del correo eléctronico no es valido");
            }

            $user = User::find($re['id']);
            $user->name = $data['name'];
            $user->lastName = $data['lastName'];
            $user->amount = $data['amount'];
            $user->email = $data['email'];
            $user->telephone = $data['telephone'];
            $user->save(); 
            $response['status'] = "ok";
            return response()->json($response);
        } catch (\InvalidArgumentException $ex) {
            $response['estado']  = "error";
            $response['mensaje'] = $ex->getMessage();
            return response()->json($response, 422);
        } catch (\Exception $ex) {
            $response['estado']  = "error";
            $response['mensaje'] = $ex->getMessage();
            return response()->json($response, 500);
        }
    }  
    
    public function updateBet(Request $request)
    {
        try{
            $re = json_decode($request->getContent(), true);
            $data = $re["data"];
            foreach ($data as $value) {
                if(isset($value['bet'])){
                    $user = User::find($value['id']);
                    if($value['bet'] == $re['bet']){
                        if($re['bet'] == 1){
                            $user->amount += $value['betAvailable'] * 19;
                        }else{
                            $user->amount += $value['betAvailable'];
                        }
                    }else{
                        $user->amount -= $value['betAvailable'];
                    }
                    $user->save(); 
                }               
            }
            $p = mt_rand(1, 3);
            $response['status'] = $p;
            return response()->json($response);
        } catch (\InvalidArgumentException $ex) {
            $response['estado']  = "error";
            $response['mensaje'] = $ex->getMessage();
            return response()->json($response, 422);
        } catch (\Exception $ex) {
            $response['estado']  = "error";
            $response['mensaje'] = $ex->getMessage();
            return response()->json($response, 500);
        }
    }  

    public function deleteUser($id)
    {
        try{
            User::where('id', $id)->delete();
            $response['status'] = "ok";
            return response()->json($response);
        } catch (\InvalidArgumentException $ex) {
            $response['estado']  = "error";
            $response['mensaje'] = $ex->getMessage();
            return response()->json($response, 422);
        } catch (\Exception $ex) {
            $response['estado']  = "error";
            $response['mensaje'] = $ex->getMessage();
            return response()->json($response, 500);
        }       
    }
}
