<?php

namespace Tests\Unit;

use Illuminate\Contracts\Console\Kernel;
use PHPUnit\Framework\TestCase;

class FilamentCompatibilityTest extends TestCase
{
    public function test_legacy_section_class_is_available_for_filament_v5(): void
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        $this->assertTrue(class_exists(\Filament\Forms\Components\Section::class));
    }
}
