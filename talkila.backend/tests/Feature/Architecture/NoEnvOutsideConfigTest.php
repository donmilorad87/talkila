<?php

namespace Tests\Feature\Architecture;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Production runs `php artisan config:cache` on every deploy. After that, env() and getenv() return null everywhere
 * except in config/ files: a value read that way silently disappears (activation e-mails once had no domain).
 * Application code must use config('…') instead.
 */
class NoEnvOutsideConfigTest extends TestCase
{
    public function test_application_code_reads_settings_through_config_not_env(): void
    {
        $offenders = [];
        $root = dirname(__DIR__, 3);
        foreach (['app', 'routes', 'resources/views'] as $directory) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$root/$directory"));
            foreach ($files as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }
                foreach (file($file->getPathname()) as $number => $line) {
                    if (preg_match('/(?<![\w>:$])(env|getenv)\s*\(/', $line)) {
                        $offenders[] = substr($file->getPathname(), strlen($root) + 1).':'.($number + 1).'  '.trim($line);
                    }
                }
            }
        }

        $this->assertSame([], $offenders, "Use config('…') instead of env()/getenv() outside config/:\n".implode("\n", $offenders));
    }
}
