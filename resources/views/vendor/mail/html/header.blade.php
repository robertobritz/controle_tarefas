@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Controle de tarefas')
<img src="{{ asset('img/logo.png') }}" alt="Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
