<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExport;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;

        $tarefas = Tarefa::where('user_id', $user_id)->paginate(1);
        return view('tarefa.index', ['tarefas' => $tarefas, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all('tarefa', 'data_limite_conclusao');
        $dados['user_id'] = auth()->user()->id;

        $tarefa = Tarefa::create($dados);
        $destinatario = auth()->user()->email; // pegando o e-mail do usuário

        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));
        

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        //dd($tarefa->getAttributes());
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if($tarefa->user_id == $user_id){
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }

        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }

        $tarefa['user_id'] = auth()->user()->id;
        $tarefa->update($request->all());

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }

        $tarefa->delete();
        return redirect()->route('tarefa.index');
    }

    public function exportacao($extensao){
        $nome_arquivo = 'lista_de_tarefas';

        if($extensao == 'xlsx'){
            $nome_arquivo .= '.'.$extensao;
        }else if($extensao == 'csv'){
            $nome_arquivo .= '.'.$extensao;
        }else {
            return redirect()->route('tarefa.index');
        }
        
        return Excel::download(new TarefasExport, $nome_arquivo);
    }
}
