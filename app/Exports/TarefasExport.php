<?php

namespace App\Exports;

use App\Models\Tarefa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarefasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Tarefa::all();

        return auth()->user()->tarefas;
    }

    public function headings() :array { // declarando o tipo de retorno. Serve para o cabeçalho
        return ['ID da tarefa', 'Tarefa', 'Data limite conclusão', 'Tarefa de:'];
    }

    public function map($linha) :array { // serve para mapear o que será enviado para a planilha
        
        return [
            $linha->id,
            $linha->tarefa,
            date('d/m/Y', strtotime($linha->data_limite_conclusao)),
            auth()->user()->name,
        ];

    }
}
