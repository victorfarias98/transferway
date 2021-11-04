<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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
        $users = $this->user->paginate();
        return response()->json([
            'error' => 'Nenhum usuário encontrado'
        ], Response::HTTP_NOT_FOUND);
        if($users){
            return response()->json([
                'data' => $users
            ], Response::HTTP_OK);
        }
    }
    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->user;
        $user->name = $request->name;
        $user->document = $request->document;
        $user->type = $request->type;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        if($user->save()){
            return response()->json([
                'message' => 'Usuário cadastrado com sucesso',
                'user' => $user
            ], Response::HTTP_CREATED);
        }
        return response()->json([
            'error' => 'Erro ao cadastrar usuário'
        ], Response::HTTP_BAD_REQUEST);
    }
    /**
     * Display the user resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = $this->user->find($id);
        if(!$user){
            return response()->json([
                'error' => 'Usuário não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            $user
        ], Response::HTTP_OK);
    }
    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\UpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $this->user->find($request->user_id);
        if(!$user){
            return response()->json([
                'error' => 'Usuário não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'message' => 'Usuário atualizado com sucesso',
            $user
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = $this->user->find($id);
        if(!$user){
            return response()->json([
                'error' => 'Usuário não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }
        $user->delete();
        return response()->json([
            'message' => 'Usuário deletado com sucesso'
        ], Response::HTTP_OK);
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
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
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
                return response()->json($response, Response::HTTP_OK);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], Response::HTTP_BAD_REQUEST);
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
                return response()->json($response, Response::HTTP_OK);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], Response::HTTP_BAD_REQUEST);
            }
        }
    }
}