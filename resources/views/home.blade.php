<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dictionary</title>
  @vite(['resources/css/styles.css'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style></style>
</head>
<body>
  <div class="background-pattern"></div>
  
  <div class="container">
    <h1>Dictionary</h1>

    <div class="search-box">
      <h2>What Word Piques Your Interest?</h2>
      <div class="search-input">
        <input type="text" placeholder="Yawa" />
        <button>Search</button>
      </div>
      <p class="suggestion">Suggested concepts: Yawa, Lintian, code, sun...</p>
    </div>

    <div class="word-box">
      <h2 class="word">yawa</h2>
      <div class="pronunciation">/ˈja.wa/ <span class="sound-icon">🔊</span></div>
    </div>

    <div class="definition-box">
      <h3 class="part-of-speech">noun</h3>
      <p><strong>Def:</strong> The study of art or beauty.</p>
      <p><strong>Def:</strong> That which appeals to the senses.</p>
      <p><strong>Def:</strong> The artistic motifs defining a collection of things, especially works of art; more broadly, their vibe.</p>
      <p class="example">e.g. Her most recent works have this quirky, half-serious 90’s teen culture-inspired aesthetic.</p>
    </div>
  </div>
</body>
</html>
