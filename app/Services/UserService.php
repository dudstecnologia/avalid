<?php

namespace App\Services;

use App\Models\AvaliacaoFuncionario;
use App\Models\AvaliacaoResposta;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UserService
{
    public static function admin() {
        if (Auth::user()) {
            return Auth::user()->admin;
        }

        return false;
    }

    public static function show($id)
    {
        try {
            return User::findOrFail($id);
        } catch (Throwable $th) {
            return null;
        }
    }

    public static function store($request)
    {
        try {
            return User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'admin' => $request['admin'],
                'status' => $request['status']
            ]);
        } catch (Throwable $th) {
            return null;
        }
    }

    public static function update($request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if (isset($request['password'])) {
                $request['password'] = Hash::make($request['password']);
            }

            $user->update($request);
            return $user;
        } catch (Throwable $th) {
            return null;
        }
    }

    public static function alterarStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['status' => $user->status ? false : true]);
            return $user;
        } catch (Throwable $th) {
            return null;
        }
    }

    public static function listarAvaliados($avaliacao_funcionario)
    {
        try {
            $avaliados = User::whereStatus(true)
                            ->whereAdmin(false)
                            ->whereNotIn('id', [Auth::user()->id])
                            ->select('id', 'name', 'foto')
                            ->get();

            $avaliados = $avaliados->map(function($a) use($avaliacao_funcionario) {

                $a['avaliado'] = false;
                
                $verificaAvaliacao = AvaliacaoResposta::whereAvaliacaoFuncionarioId($avaliacao_funcionario)
                                        ->whereAvaliadorId(Auth::user()->id)
                                        ->whereAvaliadoId($a->id)
                                        ->count();

                if ($verificaAvaliacao > 0) {
                    $a['avaliado'] = true;
                }

                return $a;
            });

            return array(
                'status' => true,
                'avaliados' => $avaliados
            );
        } catch (Throwable $th) {
            return array(
                'status' => false,
                'msg' => 'Erro ao listar os avaliados',
                'erro' => $th->getMessage()
            );
        }
    }

    public static function listarAvaliadosAdmin($avaliacao_funcionario)
    {
        try {

            $avFunc = AvaliacaoFuncionario::findOrFail($avaliacao_funcionario);
            $totalQuestoes = $avFunc->avaliacao->questoes->count();

            $avaliados = User::whereStatus(true)
                            ->whereAdmin(false)
                            ->whereDate('created_at', '<=', $avFunc->created_at)
                            ->select('id', 'name', 'foto')
                            ->get();

            $avaliados = $avaliados->map(function($a) use($avaliacao_funcionario, $totalQuestoes) {

                $a['totalAvaliados'] = 0;
                
                $verificaRespostas = AvaliacaoResposta::whereAvaliacaoFuncionarioId($avaliacao_funcionario)
                                        ->whereAvaliadorId($a->id)
                                        ->count();

                if ($verificaRespostas > 0) {
                    $a['totalAvaliados'] = $verificaRespostas / $totalQuestoes;
                }

                return $a;
            });

            return array(
                'status' => true,
                'avaliados' => $avaliados
            );
        } catch (Throwable $th) {
            return array(
                'status' => false,
                'msg' => 'Erro ao listar os avaliados',
                'erro' => $th->getMessage()
            );
        }
    }

    public static function updateUserFuncionario($request)
    {
        try {
            if (isset($request['foto']) && $request['foto']) {
                $request['foto'] = self::uploadImagem($request['foto']);
            } else {
                unset($request['foto']);
            }

            $request['password'] = Hash::make($request['password']);

            auth()->user()->update($request);

            return array(
                'status' => true,
                'msg' => 'Dados de perfil atualizados com sucesso'
            );
        } catch (Throwable $th) {
            dd($th->getMessage());
            return array(
                'status' => false,
                'msg' => 'Erro ao atualizar os dados do perfil',
                'erro' => $th->getMessage()
            );
        }
    }

    public static function uploadImagem($imgBase64)
    {
        $pasta =  '/img/';
        $nomeImagem = auth()->user()->id . '.png';
        $imagem = substr($imgBase64, strpos($imgBase64, ',') + 1);
        $status = file_put_contents(public_path() . $pasta . $nomeImagem, base64_decode($imagem));
        
        return $status ? $pasta . $nomeImagem : null;
    }
}
