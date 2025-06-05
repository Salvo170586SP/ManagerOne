<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fattura {{ $invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .invoice-details,
        .client-details {
            width: 48%;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007bff;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .detail-row {
            margin-bottom: 8px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .project-section {
            margin: 30px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .amount-section {
            margin-top: 30px;
            text-align: right;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            margin-top: 10px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .signature-section {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">La Tua Azienda</div>
        <div>Via Example, 123 - 90100 Palermo (PA)</div>
        <div>P.IVA: 12345678901 - Tel: +39 091 1234567</div>
    </div>

    <div class="invoice-title">FATTURA {{ $invoice_number }}</div>

    <div class="invoice-info">
        <div class="invoice-details">
            <div class="section-title">Dettagli Fattura</div>
            <div class="detail-row">
                <span class="label">Numero:</span> {{ $invoice_number }}
            </div>
            <div class="detail-row">
                <span class="label">Data:</span> {{ $date }}
            </div>
            <div class="detail-row">
                <span class="label">Creata da:</span> {{ $admin->name }} {{ $admin->surname }}
            </div>
        </div>

        <div class="client-details">
            <div class="section-title">Cliente</div>
            <div class="detail-row">
                <span class="label">Nome:</span> {{ $client->name }} {{ $client->surname }}
            </div>
            <div class="detail-row">
                <span class="label">Email:</span> {{ $client->email }}
            </div>
            @if($client->phone)
            <div class="detail-row">
                <span class="label">Telefono:</span> {{ $client->phone }}
            </div>
            @endif
            @if($client->address)
            <div class="detail-row">
                <span class="label">Indirizzo:</span> {{ $client->address }}
            </div>
            @endif
        </div>
    </div>

    <div class="project-section">
        <div class="section-title">Dettagli Progetto</div>
        <div class="detail-row">
            <span class="label">Nome Progetto:</span> {{ $project->name }}
        </div>
        @if($project->description)
        <div class="detail-row">
            <span class="label">Descrizione:</span> {{ $project->description }}
        </div>
        @endif
        <div class="detail-row">
            <span class="label">Data Creazione:</span> {{ $project->created_at->format('d/m/Y H:i') }}
        </div>
        @if($project->is_available)
        <div class="detail-row">
            <span class="label">Stato:</span> <span style="color: #28a745; font-weight: bold;">Disponibile</span>
        </div>
        @endif
    </div>

    <div class="amount-section">
        <div style="font-size: 18px; margin-bottom: 10px;">
            <span class="label">Importo Preventivo:</span> €{{ number_format($invoice->preventive, 2, ',', '.') }}
        </div>

        <div class="total-amount">
            TOTALE: €{{ number_format($invoice->preventive, 2, ',', '.') }}
        </div>
    </div>

    <div class="signature-section">
        <div style="margin-top: 40px;">
            <div>_________________________</div>
            <div style="margin-top: 10px;">Firma del Cliente</div>
        </div>
    </div>

    <div class="footer">
        <p>Fattura generata automaticamente il {{ now()->format('d/m/Y H:i') }}</p>
        <p>Per informazioni: info@tuaazienda.it</p>
    </div>
</body>

</html>