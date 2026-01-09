<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Testes Jikan API</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #000;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        h1 {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .anime-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .anime-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .anime-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0,0,0,0.2);
        }
        
        .anime-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        
        .anime-content {
            padding: 20px;
        }
        
        .anime-rank {
            display: inline-block;
            background: #000;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .anime-title {
            font-size: 1.3em;
            margin-bottom: 10px;
            color: #333;
        }
        
        .anime-description {
            color: #666;
            line-height: 1.6;
            font-size: 0.95em;
        }
        
        .error {
            background: white;
            padding: 20px;
            border-radius: 10px;
            color: #d32f2f;
            text-align: center;
        }
        
        .loading {
            text-align: center;
            color: white;
            font-size: 1.5em;
            padding: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Top 3 Anime</h1>
        
        <?php
        // Fetch top anime from Jikan API
        $apiUrl = 'https://api.jikan.moe/v4/top/anime?limit=3';
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            echo '<div class="error">Error fetching data: ' . curl_error($ch) . '</div>';
            curl_close($ch);
            exit;
        }
        
        curl_close($ch);
        
        // Check if request was successful
        if ($httpCode !== 200) {
            echo '<div class="error">API returned error code: ' . $httpCode . '</div>';
            exit;
        }
        
        // Decode JSON response
        $data = json_decode($response, true);
        
        if (!$data || !isset($data['data'])) {
            echo '<div class="error">Invalid API response</div>';
            exit;
        }
        
        $animeList = $data['data'];
        ?>
        
        <div class="anime-grid">
            <?php foreach ($animeList as $index => $anime): ?>
                <div class="anime-card">
                    <img src="<?php echo htmlspecialchars($anime['images']['jpg']['large_image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($anime['title']); ?>" 
                         class="anime-image">
                    <div class="anime-content">
                        <span class="anime-rank">#<?php echo $index + 1; ?></span>
                        <h2 class="anime-title"><?php echo htmlspecialchars($anime['title']); ?></h2>
                        <p class="anime-description">
                            <?php 
                            $synopsis = $anime['synopsis'] ?? 'No description available.';
                            // Limit description to 200 characters
                            echo htmlspecialchars(strlen($synopsis) > 200 ? substr($synopsis, 0, 200) . '...' : $synopsis);
                            ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container">
        <h1 style="margin-top: 30px;">Top 3 Manga</h1>
        
        <?php
        // Fetch top anime from Jikan API
        $apiUrl = 'https://api.jikan.moe/v4/top/manga?limit=3';
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        // Decode JSON response
        $data = json_decode($response, true);
        
        $animeList = $data['data'];
        ?>
        
        <div class="anime-grid">
            <?php foreach ($animeList as $index => $anime): ?>
                <div class="anime-card">
                    <img src="<?php echo htmlspecialchars($anime['images']['jpg']['large_image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($anime['title']); ?>" 
                         class="anime-image">
                    <div class="anime-content">
                        <span class="anime-rank">#<?php echo $index + 1; ?></span>
                        <h2 class="anime-title"><?php echo htmlspecialchars($anime['title']); ?></h2>
                        <p class="anime-description">
                            <?php 
                            $synopsis = $anime['synopsis'] ?? 'No description available.';
                            // Limit description to 200 characters
                            echo htmlspecialchars(strlen($synopsis) > 200 ? substr($synopsis, 0, 200) . '...' : $synopsis);
                            ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container">
        <h1 style="margin-top: 30px;">Top 3 People</h1>
        
        <?php
        // Fetch top anime from Jikan API
        $apiUrl = 'https://api.jikan.moe/v4/top/people?limit=3';
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        // Decode JSON response
        $data = json_decode($response, true);
        
        $animeList = $data['data'];
        ?>
        
        <div class="anime-grid">
            <?php foreach ($animeList as $index => $anime): ?>
                <div class="anime-card">
                    <img src="<?php echo htmlspecialchars($anime['images']['jpg']['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($anime['name']); ?>" 
                         class="anime-image">
                    <div class="anime-content">
                        <span class="anime-rank">#<?php echo $index + 1; ?></span>
                        <h2 class="anime-title"><?php echo htmlspecialchars($anime['name']); ?></h2>
                        <p class="anime-description">
                            <?php 
                            $synopsis = $anime['about'] ?? 'No description available.';
                            // Limit description to 200 characters
                            echo htmlspecialchars(strlen($synopsis) > 200 ? substr($synopsis, 0, 200) . '...' : $synopsis);
                            ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container">
        <h1 style="margin-top: 30px;">Top 3 Character</h1>
        
        <?php
        // Fetch top anime from Jikan API
        $apiUrl = 'https://api.jikan.moe/v4/top/characters?limit=3';
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        // Decode JSON response
        $data = json_decode($response, true);
        
        $animeList = $data['data'];
        ?>
        
        <div class="anime-grid">
            <?php foreach ($animeList as $index => $anime): ?>
                <div class="anime-card">
                    <img src="<?php echo htmlspecialchars($anime['images']['jpg']['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($anime['name']); ?>" 
                         class="anime-image">
                    <div class="anime-content">
                        <span class="anime-rank">#<?php echo $index + 1; ?></span>
                        <h2 class="anime-title"><?php echo htmlspecialchars($anime['name']); ?></h2>
                        <p class="anime-description">
                            <?php 
                            $synopsis = $anime['about'] ?? 'No description available.';
                            // Limit description to 200 characters
                            echo htmlspecialchars(strlen($synopsis) > 200 ? substr($synopsis, 0, 200) . '...' : $synopsis);
                            ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>