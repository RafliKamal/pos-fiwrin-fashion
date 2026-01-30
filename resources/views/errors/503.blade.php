<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Dalam Pemeliharaan</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a212c 0%, #1a212c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .container {
            text-align: center;
            color: white;
        }

        h1 {
            font-size: 8rem;
            margin: 0;
        }

        p {
            font-size: 1.5rem;
            margin: 1rem 0;
        }

        a {
            display: inline-block;
            padding: 12px 24px;
            background: #2d9564;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 1rem;
        }

        a:hover {
            background: #69b190;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>503</h1>
        <p>Sistem sedang dalam pemeliharaan. Silakan kembali beberapa saat lagi.</p>
        <a href="{{ url('/') }}">Coba Lagi</a>
    </div>
</body>

</html>