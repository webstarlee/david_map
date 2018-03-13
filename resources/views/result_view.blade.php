@foreach ($comercializadores1 as $single_data)
    <div class="sinle-data-container">
        <p class="title">
            <a href="/search-result/{{$single_data->id}}/1">{{$single_data->RAZON_SOCIAL}}</a>
            @if ($single_data->COORDENADA_X != null || $single_data->COORDENADA_X != "")
                <label class="find-con-map-success">(Encontrado en el mapa)</label>
            @else
                <label class="find-con-map-failed">(No encontrado en el mapa)</label>
            @endif
        </p>
        <p class="operator-title">{{$single_data->TIPO_OPERADOR}}</p>
        <p>{{$single_data->DIRECCION}}, {{$single_data->PROVINCIA}} {{$single_data->CP}}</p>
    </div>
@endforeach
@foreach ($comercializadores2 as $single_data)
    <div class="sinle-data-container">
        <p class="title">
            <a href="/search-result/{{$single_data->id}}/2">{{$single_data->RAZON_SOCIAL}}</a>
            @if ($single_data->COORDENADA_X != null || $single_data->COORDENADA_X != "")
                <label class="find-con-map-success">(Encontrado en el mapa)</label>
            @else
                <label class="find-con-map-failed">(No encontrado en el mapa)</label>
            @endif
        </p>
        <p class="operator-title">{{$single_data->TIPO_OPERADOR}}</p>
        <p>{{$single_data->DIRECCION}}, {{$single_data->PROVINCIA}} {{$single_data->CP}}</p>
    </div>
@endforeach
@foreach ($comercializadores3 as $single_data)
    <div class="sinle-data-container">
        <p class="title">
            <a href="/search-result/{{$single_data->id}}/3">{{$single_data->RAZON_SOCIAL}}</a>
            @if ($single_data->COORDENADA_X != null || $single_data->COORDENADA_X != "")
                <label class="find-con-map-success">(Encontrado en el mapa)</label>
            @else
                <label class="find-con-map-failed">(No encontrado en el mapa)</label>
            @endif
        </p>
        <p class="operator-title">{{$single_data->TIPO_OPERADOR}}</p>
        <p>{{$single_data->DIRECCION}}, {{$single_data->PROVINCIA}} {{$single_data->CP}}</p>
        <p class="operator-title">PRODUCTOS:</p>
        <p>{{$single_data->PRODUCTOS}}</p>
    </div>
@endforeach
