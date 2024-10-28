<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tarjeta de Responsabilidad</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-table img {
            width: 80px;
        }

        .header-content {
            text-align: center;
            font-size: 14px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section p {
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }

        .signature-table {
            width: 100%;
            margin-top: 30px;
            text-align: center;
        }

        .signature-cell {
            max-width: 100px;
            text-align: center;
        }

        .signature-container {
            position: fixed;
            bottom: 5mm;
            width: 100%;
        }

        .signature-content {
            text-align: left;
            margin-left: -10mm;
        }

        .watermark {
            position: fixed;
            top: 40%;
            width: 100%;
            text-align: center;
            color: #ff0000;
            font-size: 24mm;
            opacity: .6;
            transform: rotate(-20deg);
            transform-origin: 50% 50%;
            z-index: -1000;
        }
    </style>
</head>



<body>
    @foreach ($lines as $lineGroup)
        @if (count($lineGroup) > 0)
            <div class="container" @if (!$loop->last) style="page-break-after: always;" @endif>
                @if ($sheet->status === '{{ App\Utils\Enums\ResponsabilitySheetStatusEnum::Transferred->value }}')
                    <div class="watermark">
                        Transferido
                    </div>
                @endif

                @if ($sheet->status === '{{ App\Utils\Enums\ResponsabilitySheetStatusEnum::Canceled->value }}')
                    <div class="watermark">
                        Dado de baja
                    </div>
                @endif

                <!-- Header with Logo to the Left -->
                @if ($show_sheet_header)
                    <table class="header-table">
                        <tr>
                            <td style="width: 80px;">
                                <x-application-logo public style="margin-left: 20mm;" alt="Logo de la municipalidad" />
                            </td>
                            <td class="header-content" class="title">
                                <p style="margin-left: -25mm;">Municipalidad de Santa María Chiquimula, Totonicapán</p>
                                <p style="margin-left: -25mm;">Dirección de Administración Financiera Integrada
                                    Municipal</p>
                                <p style="margin-left: -25mm; margin-top: 2mm;">TARJETA DE RESPONSABILIDAD</p>
                            </td>
                        </tr>
                    </table>

                    <!-- Tarjeta Info -->
                    <div class="section">
                        <p style="margin-left: 1mm;">
                            <span>
                                <strong>Nombre:</strong> ____________________________________________________________
                                <span
                                    style="position: relative; top: -0.50mm; left: -100mm;">{{ $sheet->responsible->name }}</span>
                            </span>
                            <span style="float: right; margin-right: 14mm;">
                                <strong>Tarjeta No.:</strong> _______________
                                <span style="position: relative; top: -0.50mm; left: -15mm;">{{ $sheet->number }}</span>
                            </span>
                        </p>
                        <p style="margin-left: 30mm; margin-top: 4mm;">
                            <strong>Cargo:</strong> _____________________________________________
                            <span
                                style="position: relative; top: -0.50mm; left: -75mm;">{{ $sheet->responsible->work_position }}</span>
                        </p>
                    </div>
                @else
                    <div class="section" style="margin-top: 42mm;"></div>
                @endif

                <!-- Table -->
                <table class="table" style="width: 265mm;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">Fecha</th>
                            <th style="width: 10%;">Número de Identificación</th>
                            <th style="width: 40%;">Descripción del Artículo</th>
                            <th style="width: 5%;">Debe</th>
                            <th style="width: 5%;">Haber</th>
                            <th style="width: 10%;">Saldo</th>
                            <th style="width: 25%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lineGroup as $line)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($line->date)) }}</td>
                                <td>{{ $line->id_item }}</td>
                                <td>{{ $line->item->description }}</td>
                                <td>{{ $line->cash_in }}</td>
                                <td>{{ $line->cash_out }}</td>
                                <td>{{ $line->balance }}</td>
                                <td>{{ $line->observations }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Signatures using a table -->
                @if ($show_sheet_header)
                    <div class="signature-container">
                        <table class="signature-table">
                            <tr>
                                <td class="signature-cell" style="width: 50%; text-align: left;">
                                    <div class="signature-content">
                                        <p style="margin-left: 25mm;">___________________________</p>
                                        <p style="margin-left: 35mm;">Recibí Conforme</p>
                                    </div>
                                </td>
                                <td class="signature-cell" style="width: 25%; margin-left: -10mm;">
                                    <div style="margin-top: 2mm;">
                                        <p style="display: inline; margin-left: -55mm;">Vo. Bo.</p>
                                        <p style="display: inline; margin-left: 15mm;">___________________________</p>
                                    </div>
                                    <p style="margin-left: -27mm;">Alcalde Municipal</p>
                                </td>
                                <td class="signature-cell" style="width: 25%;">
                                    <p style="margin-left: -20mm;">___________________________</p>
                                    <p style="margin-left: -20mm;">Director AFIM</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</body>

</html>
