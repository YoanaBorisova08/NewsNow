<?php require_once __DIR__ . '/../../inc/config.php'; ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?= BASE_URL ?>/imgs/logo.svg" type="image/svg+xml" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/normalize.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/styles.css" />
    <title>Admin</title>
  </head>
  <body>

    <nav class="nav">
      <div class="container">
        <div class="nav__layout">
          <a class="nav-brand" href="index.php">
            <svg class="nav-brand__logo" viewBox="0 0 200 200">
              <defs>
                <linearGradient id="gradN" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#ff3d3d" />
                  <stop offset="50%" stop-color="#ffaa2a" />
                  <stop offset="100%" stop-color="#007bff" />
                </linearGradient>
              </defs>
              <path
                d="M30 170 L30 30 L90 100 L150 30 L150 170 L90 100 Z"
                fill="url(#gradN)"
              />
              <circle cx="150" cy="30" r="10" fill="url(#gradN)" />
            </svg>
            NewsNow
          </a>
        </div>
      </div>
    </nav>

    <main class="main">
      <div class="container">