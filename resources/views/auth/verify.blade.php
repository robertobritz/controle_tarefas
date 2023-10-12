@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Falta pouco agora! Precisamos apenas que você valide seu e-mail</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Reenviamos um e-mail com um link de validação!
                        </div>
                    @endif

                    Antes de utilizar os recursos da apliacação, por favor valida seu e-mail!<br>
                    Caso você não tenha recebido o  e-mail de verificação, clique no link a seguir para receber um novo e-mail. <br>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Clique aqui!</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
