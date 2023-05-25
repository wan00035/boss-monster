<?php
  function setGameData () {
    $_SESSION['game'] = [
      "monster_hp" => 30,
      "player_hp" => 25,
      "player_max_hp" => 25,
      "monster_min_attack" => 3,
      "monster_max_attack" => 8,
      "player_min_attack" => 3,
      "player_max_attack" => 7,
      "player_min_heal" => 8,
      "player_max_heal" => 12,
      "heal_cool_down" => 0,
      "is_active" => true,
      "response" => ""
    ];

    return isset($_SESSION['game']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boss Monster</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
  <main class="container pt-5 mt-5">
    <div class="row">
      <div class="col">
        <p class="text-center fs-2">Monster<br>30</p>
      </div>
      <div class="col">
        <p class="text-center fs-2">Player<br>25</p>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col">
        <div class="alert alert-info">Response message</div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col d-flex justify-content-center">
        <a href="#" class="btn btn-danger me-3">Attack</a>
        <a href="#" class="btn btn-primary">Heal</a>
      </div>
    </div>
  
    <div class="row mt-5">
      <div class="col d-flex justify-content-center">
        <a href="#" class="btn btn-secondary">Play Again</a>
      </div>
    </div>

  </main>
</body>
</html>