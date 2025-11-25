<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $recipe->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #f97316;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #f97316;
            margin-bottom: 10px;
        }
        .recipe-title {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin: 20px 0 10px 0;
        }
        .author-info {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .author-name {
            font-weight: bold;
            color: #374151;
            font-size: 16px;
        }
        .date {
            color: #6b7280;
            font-size: 14px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #f97316;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #fed7aa;
        }
        .ingredients-list {
            list-style: none;
            padding: 0;
        }
        .ingredients-list li {
            padding: 8px 0 8px 25px;
            position: relative;
            background-color: #fff7ed;
            margin-bottom: 5px;
            border-radius: 4px;
        }
        .ingredients-list li:before {
            content: "✓";
            position: absolute;
            left: 8px;
            color: #f97316;
            font-weight: bold;
        }
        .steps-list {
            list-style: none;
            counter-reset: step-counter;
            padding: 0;
        }
        .steps-list li {
            counter-increment: step-counter;
            padding: 12px 12px 12px 45px;
            position: relative;
            background-color: #f9fafb;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .steps-list li:before {
            content: counter(step-counter);
            position: absolute;
            left: 10px;
            top: 10px;
            background-color: #f97316;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">ResepinAja</div>
        <div style="color: #6b7280; font-size: 14px;">Berbagi Resep, Berbagi Cinta</div>
    </div>

    <!-- Recipe Title -->
    <h1 class="recipe-title">{{ $recipe->title }}</h1>

    <!-- Author Info -->
    <div class="author-info">
        <div class="author-name">Oleh: {{ $recipe->user->name }}</div>
        <div class="date">Dibuat pada: {{ $recipe->created_at->format('d F Y') }}</div>
    </div>

    <!-- Ingredients Section -->
    <div class="section">
        <h2 class="section-title">Bahan-Bahan</h2>
        <ul class="ingredients-list">
            @foreach($recipe->ingredients as $ingredient)
                <li>{{ $ingredient }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Steps Section -->
    <div class="section">
        <h2 class="section-title">Langkah-Langkah Pembuatan</h2>
        <ol class="steps-list">
            @foreach($recipe->steps as $step)
                <li>{{ $step }}</li>
            @endforeach
        </ol>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Resep ini didownload dari ResepinAja.com</p>
        <p>© {{ date('Y') }} ResepinAja. Berbagi Resep, Berbagi Cinta.</p>
    </div>
</body>
</html>