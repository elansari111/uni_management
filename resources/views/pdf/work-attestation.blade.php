<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attestation de travail</title>
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
        <h1>Attestation de travail</h1>
        <p>University Management System</p>
    </div>

    <div class="content">
        <p>Je soussigné(e), responsable de l'administration de l'établissement, atteste que :</p>

        <div class="info">
            <p><strong>Nom :</strong> {{ $teacher->user?->name ?? $teacher->full_name }}</p>
            <p><strong>Matricule :</strong> {{ $teacher->employee_number ?? 'N/A' }}</p>
            <p><strong>Spécialité :</strong> {{ $teacher->specialization ?? 'N/A' }}</p>
        </div>

        <p>est employé(e) en tant qu'enseignant(e) au sein de l'établissement. La présente attestation est délivrée à la demande de l'intéressé(e) pour servir et valoir ce que de droit.</p>
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
