<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ordre de mission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.8;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .content {
            margin: 30px 0;
            text-align: justify;
        }
        .info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f5f5f5;
            border-left: 4px solid #4CAF50;
        }
        .info p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 60px;
        }
        .signature {
            text-align: right;
            margin-top: 40px;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 250px;
            margin-left: auto;
            padding-top: 5px;
        }
        .date {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ordre de mission</h1>
        <p>University Management System</p>
    </div>

    <div class="content">
        <p>L'administration autorise l'enseignant(e) suivant(e) à effectuer une mission :</p>

        <div class="info">
            <p><strong>Nom :</strong> {{ $teacher->user?->name ?? $teacher->full_name }}</p>
            <p><strong>Matricule :</strong> {{ $teacher->employee_number ?? 'N/A' }}</p>
            <p><strong>Destination :</strong> {{ $request->destination ?? 'N/A' }}</p>
            <p><strong>Période :</strong>
                @if($request->start_date && $request->end_date)
                    {{ $request->start_date->format('d/m/Y') }} au {{ $request->end_date->format('d/m/Y') }}
                @else
                    N/A
                @endif
            </p>
            <p><strong>Motif :</strong> {{ $request->purpose ?? $request->description }}</p>
        </div>

        <p>Le présent ordre de mission est délivré à la demande de l'intéressé(e) et après validation de l'administration.</p>
    </div>

    <div class="footer">
        <div class="date">
            <p>Date : {{ now()->format('d/m/Y') }}</p>
        </div>

        <div class="signature">
            <div class="signature-line">Administration</div>
            <p>Signature & Cachet</p>
        </div>
    </div>
</body>
</html>
