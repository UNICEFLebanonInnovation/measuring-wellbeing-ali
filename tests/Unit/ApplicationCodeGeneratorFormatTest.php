<?php

namespace Tests\Unit;

use App\Sdq\ApplicationCodeGenerator;
use PHPUnit\Framework\TestCase;

class ApplicationCodeGeneratorFormatTest extends TestCase
{
    public function test_default_format_matches_the_2021_guidance_note(): void
    {
        $generator = new ApplicationCodeGenerator('{year}-{partner}-{collector}-{n}');

        $this->assertSame('2021-ROB-MICH-1', $generator->format(2021, 'rob', ' mich ', 1));
    }

    public function test_legacy_format_without_year_is_supported(): void
    {
        $generator = new ApplicationCodeGenerator('{partner}-{collector}-{n}');

        $this->assertSame('ROB-MICH-12', $generator->format(2020, 'ROB', 'MICH', 12));
    }
}
