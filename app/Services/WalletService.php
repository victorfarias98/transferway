<?php

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use App\Models\User;
use App\Services\AuthorizationService;
use App\Services\NotificationService;
class WalletService
{
    protected $user;
    protected $authService;
    protected $notificationService;
    public function __construct()
    {
        $this->user = new User();
        $this->authService = app(AuthorizationService::class);
        $this->notificationService = app(NotificationService::class);
    }
    public function getBalance(int $user_id): Array
    {
        $user = $this->user->find($user_id);
        if($user && $user->balance){
            return ["Balance" => $user->balance];
        }
        throw new \Exception('Erro ao consultar saldo');
    }
    public function transfer(int $payer_id, int $payee_id, float $amount) : Array
    {
        $payer = $this->user->find($payer_id);
        $payee = $this->user->find($payee_id);
        if($payer->type === "PJ"){
            throw new \Exception('Lojistas não podem fazer transferências');
        }
        if ($payer->balance < $amount) {
            throw new \Exception('Saldo insuficiente');
        }
        if($payer->transfer($payee, $amount) && $this->authService->authorizeTransaction($payer->id) ){
            if($this->notificationService->sendNotice()){
                return ["message"=>"Transferência realizada com sucesso. Enviamos uma confirmação no seu e-mail"];
            }
            return ["message"=>"Transferência realizada com sucesso"];
        }
        if($payer->paid($payee)){
            $payer->refund($payee);
        }
        throw new \Exception('Erro ao realizar transferência, não se preocupe nenhum valor foi transitado.');
    }
    public function deposit(int $user_id, float $amount) : Array
    {
        $user = $this->user->find($user_id);
        if($user->deposit($amount) && $this->authService->authorizeTransaction($user->id)){
            return ["message"=>"Depósito realizado com sucesso"];
        }
        throw new \Exception('Erro ao realizar depósito');
    }

}