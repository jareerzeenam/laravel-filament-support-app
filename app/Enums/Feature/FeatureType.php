<?php

namespace App\Enums\Feature;

enum FeatureType: string
{
    case Feature = 'Feature';
    case Bug = 'Bug';
    case Improvement = 'Improvement';
    case Task = 'Task';
    case Integration = 'Integration';
}
