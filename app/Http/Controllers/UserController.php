<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Services\WalletService;

class UserController extends Controller
{
    protected $walletService;
    protected $user;
    public function __construct(WalletService $walletService, User $user)
    {
        $this->walletService = $walletService;
        $this->user = $user;
    }
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->all();
        if($users){
            return response()->json([
                "data" => $users
            ], 200);
        }
        return response()->json([
            "error" => "Nenhum usuário cadastrado"
        ], 400);
    }
    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->user->create($request->all());
        if($user){
            return response()->json([
                "message" => "Usuário cadastrado com sucesso",
                "data" => $user
            ], 201);
        }
        return response()->json([
            "error" => "Erro ao cadastrar usuário"
        ], 400);
    }

    /**
     * Display the user resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = $this->user->find($user->id);
        if($user){
            return response()->json([
                "data" => $user
            ], 200);
        }
        return response()->json([
            "error" => "Usuário não encontrado"
        ], 400);
    }
    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\UpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $this->user->find($request->id);
        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return response()->json([
                "message" => "Usuário atualizado com sucesso",
                "data" => $user
            ], 200);
        }
        return response()->json([
            "error" => "Usuário não encontrado"
        ], 400);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = $this->user->find($user->id);
        if($user->destroy()){
            return response()->json([
                "message" => "Usuário deletado com sucesso"
            ], 200);
        }
        return response()->json([
            "error" => "Usuário não encontrado"
        ], 400);
    }
    /**
     * Return user balance
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getBalance(Request $request)
    {
        try {
            $response = $this->walletService->getBalance($request->user_id);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
        ], 400);
        }
    }
    /**
     * Deposit user funds from an amount
     *
     * @param  \App\Http\Requests\DepositRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function deposit(DepositRequest $request)
    {
        if ($request->validated()) {
            try {
                $response = $this->walletService->deposit($request->user_id, $request->amount);
                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                "error" => $e->getMessage()
            ], 400);
            }
        }
    }
    /**
     * Transfer funds from one user to another
     * @param  \App\Http\Requests\TransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function transfer(TransferRequest $request)
    {
        if ($request->validated()) {
            try {
                $response = $this->walletService->transfer($request->payer_id, $request->payee_id, $request->amount);
                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                    "error" => $e->getMessage()
                ], 400);
            }
        }
    }
}