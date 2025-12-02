<?php

use Controllers\WebController; ?>
<link rel="stylesheet" href="<?= WebController::getAddonPath() ?>code/style.css">

<div class="container text-white text-center py-5">
    <!-- Hero section -->
    <div class="mb-5">
        <i class="bi bi-lightning-charge-fill display-1 text-warning"></i>
        <h1 class="fw-bold mt-3">New Web Project Maker</h1>
        <p class="lead">Une base Slim PHP rapide, propre et prête à coder.</p>
    </div>

    <!-- Grid cards section -->
    <div id="features" class="row justify-content-center g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card bg-dark bg-opacity-50 shadow-sm h-100">
                <div class="card-body text-start">
                    <h5 class="card-title"><i class="bi bi-info-circle-fill me-2 text-secondary"></i>Présentation</h5>
                    <p class="card-text">
                        Une base <strong>clé en main</strong> avec Slim PHP pour gagner du temps à chaque nouveau projet.
                        Clones, modifies, déploies.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card bg-dark bg-opacity-50 shadow-sm h-100">
                <div class="card-body text-start">
                    <h5 class="card-title"><i class="bi bi-terminal-fill me-2 text-warning"></i>Prérequis</h5>
                    <ul class="mb-0">
                        <li>PHP ≥ 7.4</li>
                        <li>Composer</li>
                        <li>Apache / Nginx</li>
                        <li>Git & SSH (optionnel)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>