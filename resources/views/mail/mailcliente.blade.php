<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4A90E2;
            text-align: center;
        }
        .info {
            margin: 15px 0;
            padding: 10px;
            border-left: 5px solid #4A90E2;
            background: #f1f1f1;
        }
        .label {
            font-weight: bold;
            color: #222;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detalhes da Reserva</h2>

        <div class="info">
            <span class="label">Cliente:</span> {{ $clientName }}
        </div>

        <div class="info">
            <span class="label">Modelo:</span> {{ $detalhes->modelo }}
        </div>

        <div class="info">
            <span class="label">Combustível:</span> {{ $detalhes->combustivel }}
        </div>

        <div class="info">
            <span class="label">Por dia:</span> €{{ number_format($detalhes->preco_diario, 2, ',', '.') }}
        </div>

        <div class="info">
            <span class="label">Valor Pago:</span> €{{ number_format($reserva->preco_total, 2, ',', '.') }}
        </div>
        
        <div class="info">
            <span class="label">Datas de Retirada e Devolução:</span> {{\Carbon\Carbon::parse($reserva->data_inicio)->format('d/m/Y') }} - {{\Carbon\Carbon::parse($reserva->data_fim)->format('d/m/Y')}}
        </div>
        
        <div class="info">
            <span class="label">Reserva realizada em</span> {{ \Carbon\Carbon::parse($reserva->created_at)->format('d/m/Y') }} 
        </div>

        <div class="info">
            <span class="label">Localização:</span> {{ $detalhes->cidade }}, {{ $detalhes->filial }} - {{ $detalhes->posicao }}
        </div>

        <div class="info">
            <span class="label">Características:</span> {{ $detalhes->caracteristicas }}
        </div>
    </div>
</body>
</html>
