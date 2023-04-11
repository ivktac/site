<?php

use SimpleCaptcha\Builder;

$builder = Builder::create();

$builder->applyPostEffects = false;
$builder->applyScatterEffect = false;
$builder->applyNoise = false;
$builder->bgColor = "#ffffff";
$builder->build();