@extends('template.master')

@section('title', 'Gerenciar Veículos')

@section('css')
<link rel="stylesheet" href="{{ asset('css/categoria_veiculo.css') }}">
<style>
    .no-veiculos {
        text-align: center;
        padding: 150px;
        margin: 0 auto;
        font-size: 24px;
        color: #888;
    }
    form {
        background-color: white;
        border: 1px solid rgba(140,141,142, 0.4);
    }
</style>
@endsection

@section('content')
<section id="section_veiculo">

    <!-- ==== Exibe veiculo cadastrado do entregador === -->
    <h3 class="text-center p-2">Meus veículos</h3>
    @if(count($veiculos) > 0)
    <div class="col-6 mx-auto">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Renavam</th>
                <th>Categoria</th>
                <th>Status</th>
            </tr>
        @foreach($veiculos as $veiculo)
            <tr>
                <td>{{ $veiculo->id }}</td>
                <td>{{ $veiculo->placa }}</td>
                <td>{{ $veiculo->renavam }}</td>
                <td>{{ ucfirst($veiculo->categoria_veiculo) }}</td>
                <td><span style="color: orange; font-weight: bold">Em avaliação <i class="fa fa-clock"></span></td>
                <td>
                    <span style="cursor:pointer" onclick="removeVeiculo({{ $veiculo->id }})"><i title="Remover" class="fa fa-trash fa-lg"></i></span>
                </td>
            </tr>
            

        @endforeach
        </table>    
    </div>
        
    @else 
        <div class="no-veiculo mx-auto p-5">
            <div class="text-muted text-center" style="font-size: 24px;">
                <p>Você ainda não tem veículos cadastrados</p>
                <p style="font-size: 38px">(;-;)</p>
            </div>
        </div>
    @endif
    <div class="col-md-8 mx-auto">
        <form action="{{ url('entregador/veiculo/criar') }}" method="POST" class="p-4 ml-5 mr-5">
            {{ csrf_field() }}
            <input type="hidden" name="entregador_id" value="{{ auth()->user()->entregador->id }}">
            <div class="form-group">
                <label for="placa">Placa</label>
                <input type="text" class="form-control" id="placa" name="placa" placeholder="xxx-xxxx" max-length="8" required>
            </div>
            <div class="form-group">
                <label for="renavam">Renavam</label>
                <input type="text" class="form-control" id="renavam" name="renavam" placeholder="000000000" max-length="9" required>
            </div>

            <div id="categoria_veiculo_section" class="form-group">
                <p>Categoria do veículo</p>
                <label for="radio_moto">
                    <input type="radio" name="categoria_veiculo" value="moto" id="radio_moto">
                    <i class="fa fa-motorcycle fa-lg" style="font-size: 38px"></i>
                    <p>Moto</p>
                </label>
                <label for="radio_carro">
                    <input type="radio" name="categoria_veiculo" value="carro" id="radio_carro">
                    <i class="fa fa-car fa-lg" style="font-size: 38px"></i>
                    <p>Carro</p>
                </label>
                <label for="radio_caminhao">
                    <input type="radio" name="categoria_veiculo" value="caminhao" id="radio_caminhao">
                    <i class="fa fa-truck fa-lg" style="font-size: 38px"></i>
                    <p>Caminhão</p>
                </label>
            </div>
            <button type="submit" class="btn btn-light text-dark mt-5" style="border: 1px solid #888">Cadastrar veículo</button>
        </form>
    </div>
    
    <!-- === Fim listagem dos veiculos do entregador === -->

</section>
@endsection

@section('script')
<script>
var removeVeiculo = function(id) {
    var isRemovable = confirm("Essa ação é irreversível, deseja continuar?");
    if (isRemovable) {
        window.location.href = "{{ url('entregador/veiculo/remover/id=') }}"+id;
    }
}
$(document).ready(function(){
    $('#placa').mask('AAA-0000');
    $('#renavam').mask('000000000');
});
</script>
@endsection