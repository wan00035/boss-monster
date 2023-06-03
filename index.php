<?php
  session_start();

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

  function playerAttack () {
    $attack = rand($_SESSION['game']['player_min_attack'], $_SESSION['game']['player_max_attack']); 
    $_SESSION['game']['monster_hp'] -= $attack;

    return $attack;
  }

  function playerHeal () {
    $heal = 0;

    if ($_SESSION['game']['heal_cool_down'] == 0) {
      $heal = rand($_SESSION['game']['player_min_heal'], $_SESSION['game']['player_max_heal']);

      $_SESSION['game']['player_hp'] = $_SESSION['game']['player_hp'] + $heal > $_SESSION['game']['player_max_hp'] ? $_SESSION['game']['player_max_hp'] : $_SESSION['game']['player_hp'] + $heal;
      $_SESSION['game']['heal_cool_down'] = 3;
    }

    return $heal;
  }

  function healRegenerate () {
    if ($_SESSION['game']['heal_cool_down'] > 0) {
      $_SESSION['game']['heal_cool_down']--;
    }

    return $_SESSION['game']['heal_cool_down'];
  }

  function monsterAttack () {
    $attack = rand($_SESSION['game']['monster_min_attack'], $_SESSION['game']['monster_max_attack']);
    $_SESSION['game']['player_hp'] -= $attack;

    return $attack;
  }

  function gameLogic () {
    if ($_SESSION['game']['monster_hp'] > 0) {
      healRegenerate();
      monsterAttack();

      if ($_SESSION['game']['player_hp'] <= 0) {
        $_SESSION['game']['is_active'] = false; 
        $_SESSION['game']['response'] = "You have been defeated!";
      }
    } else {
      $_SESSION['game']['is_active'] = false;
      $_SESSION['game']['response'] = "You have defeated the monster!";
    }
  }

  if (isset($_GET['action'])) {
      switch ($_GET['action']) {
        case "attack":
          playerAttack();
          gameLogic();
          break;
        case "heal":
          playerHeal();
          gameLogic();
          break;
        case "reset":
          setGameData();
          break;
      }
  }

  if (!isset($_SESSION['game'])) {
    setGameData();
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
        <p class="text-center fs-2">Monster<br><?php echo $_SESSION['game']['monster_hp']; ?></p>
      </div>
      <div class="col">
        <p class="text-center fs-2">Player<br><?php echo $_SESSION['game']['player_hp']; ?></p>
      </div>
    </div>
    <?php if ($_SESSION['game']['response']) : ?>
    <div class="row mt-5">
      <div class="col">
        <div class="alert alert-info"><?php echo $_SESSION['game']['response']; ?></div>
      </div>
    </div>
    <?php endif; ?>
    <div class="row mt-5">
      <div class="col d-flex justify-content-center">
        <a href="?action=attack" class="btn btn-danger me-3 <?php if (!$_SESSION['game']['is_active']): ?>disabled<?php endif; ?>">Attack</a>
        <a href="?action=heal" class="btn btn-primary <?php if ($_SESSION['game']['heal_cool_down'] != 0 || !$_SESSION['game']['is_active']): ?>disabled<?php endif; ?>">Heal</a>
      </div>
    </div>
    <?php if (!$_SESSION['game']['is_active']): ?>
    <div class="row mt-5">
      <div class="col d-flex justify-content-center">
        <a href="?action=reset" class="btn btn-secondary">Play Again</a>
      </div>
    </div>
    <?php endif; ?>
  </main>
</body>
</html>