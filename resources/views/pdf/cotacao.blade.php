<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cotação</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 13px;
      color: #333;
      margin: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
      text-transform: uppercase;
    }

    header img {
            height: 60px;
            margin-right: 15px;
        }

    .info {
      margin-bottom: 20px;
    }

    .info p {
      margin: 4px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    thead {
      background-color: #f0f0f0;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      text-transform: uppercase;
      font-size: 12px;
      background-color: #f5f5f5;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .totals {
      margin-top: 30px;
    }

    .totals table {
      width: auto;
      margin-left: auto;
      border: none;
    }

    .totals td {
      padding: 5px 10px;
    }

    .totals .label {
      font-weight: bold;
    }

    .nowrap {
      white-space: nowrap;
    }

    .xl {
      width: 110px;
    }

    .lg {
      width: 50px;
    }

    .footer {
      text-align: center;
      font-size: 11px;
      margin-top: 40px;
      color: #777;
    }

  </style>
</head>
<body>

<table width="100%" style="border: none; border-collapse: collapse; margin-bottom: 20px;">
  <tr>
    <td style="width: 50%; vertical-align: top; border: none;">
      <img src="{{ public_path('logo_color.png') }}" alt="Logo" style="height: 40px;">
    </td>
    <td style="width: 50%; text-align: right; vertical-align: top; border: none;" class="info">
      <p><strong>{{ $dados['empresaName'] }}</strong></p>
      <p>{{ $dados['vendedorName'] }} {{ $dados['vendedorLastName'] }}</p>
      <p>{{ $dados['vendedorPhoneNumber'] }}</p>
      <p>{{ $dados['vendedorEmail'] }}</p>
    </td>
  </tr>
</table>


  <div class="header">
    <h1>Documento de Cotação</h1>
    <p>Data: {{ now()->format('d/m/Y') }}</p>
  </div>

  <div class="info">
    <p><strong>Categoria:</strong> {{ $dados['productCategory'] }}</p>
     <p><strong>Produto:</strong> {{ $dados['productName'] }}</p>
    <p><strong>Quantidade:</strong> {{ $dados['quantidadeProduto'] }} und.</p>
    <p><strong>Valor Unitário Base:</strong> R$ {{ number_format($dados['precoUnitProduto'], 2, ',', '.') }}</p>
  </div>

  <h3>Detalhamento</h3>
  <table>
    <thead>
      <tr>
        <th>Descrição</th>
        <th class="text-center">Qtd.</th>
        <th class="text-center">Valor</th>
      </tr>
    </thead>
    <tbody>
       <tr>
          <td>{{ $dados['productDescricao'] }}</td>
          <td class="text-center lg">{{ $dados['quantidadeProduto'] }}</td>
          <td class="text-left nowrap lg">R$ {{ number_format($dados['precoUnitProduto'], 2, ',', '.') }}</td>
        </tr>
      @foreach ($dados['selectedItensAdicionais'] as $item)
        <tr>
          <td>{{ $item['descricao'] }}</td>
          <td class="text-center lg">{{ $item['quantidade'] }}</td>
          <td class="text-left lg">R$ {{ number_format($item['valorTotal'], 2, ',', '.') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="totals">
    <table>
      <tr>
        <td class="label">Valor Undidade:</td>
        <td class="text-right xl">R$ {{ number_format($dados['valorTotalUnitario'], 2, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Total Geral:</td>
        <td class="text-right xl"><strong>R$ {{ number_format($dados['valorProducaoTotal'], 2, ',', '.') }}<strong></td>
      </tr>
    </table>
  </div>

  <div class="footer">
    Este documento foi gerado automaticamente. Em caso de dúvidas, entre em contato com o seu representante.
  </div>

  <div class="footer">
    <hr style="width: 60%; margin-bottom: 15px; margin-top:50px; border: none; background-color: black;">
    
    <span>{{ $dados['vendedorName'] }} {{ $dados['vendedorLastName'] }}</span>
    <p><strong>Representante</strong></p>
  </div>

</body>
</html>
