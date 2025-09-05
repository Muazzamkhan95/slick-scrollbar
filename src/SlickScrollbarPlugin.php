<?php

namespace Muazzam\SlickScrollbar;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Support\Facades\FilamentView;
use Filament\Support\Facades\FilamentColor;

class SlickScrollbarPlugin implements Plugin
{
    protected ?string $thumb = "#f59e0b";       // final CSS color token
    protected ?string $thumbHover = null;  // final CSS color token
    protected string $size = '8px';

    public static function make(): static { return new static(); }

    public function getId(): string { return 'slick-scrollbar'; }

    public function register(Panel $panel): void
    {
        // no-op
    }

    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(PanelsRenderHook::STYLES_AFTER, function (): string {
            $thumb = $this->thumb
                ?? $this->shade('secondary', 500)
                ?? $this->shade('primary', 500)
                ?? '#f59e0b';   // amber-500 fallback

            $thumbHover = $this->thumbHover
                ?? $this->shade('secondary', 600)
                ?? $this->shade('primary', 600)
                ?? '#0891b2';   // cyan-600 fallback

            return '<style>:root'
                . "{--sb-size: {$this->size};--sb-thumb: {$thumb};--sb-thumb-hover: {$thumbHover};}"
                . '</style>';
        });
    }

    /** Read a shade from Filament v4 color registry (OKLCH/hex/rgb string) */
    protected function shade(string $name, int $shade): ?string
    {
        $colors = FilamentColor::getColors(); // ['primary' => [50=>..., 500=>...], 'secondary'=>...]
        return $colors[$name][$shade] ?? null;
    }

    /** Accept string (hex/rgb()/oklch()/var(...)) or palette array (e.g., Color::Amber) */
    public function color(string|array $value, int $shade = 500): static
    {
        $this->thumb = $this->normalizeColorInput($value, $shade);
        // If hover not set and a palette was passed, auto-pick hover shade 600
        if ($this->thumbHover === null && is_array($value)) {
            $this->thumbHover = $this->normalizeColorInput($value, 600);
        }
        return $this;
    }

    public function hoverColor(string|array $value, int $shade = 600): static
    {
        $this->thumbHover = $this->normalizeColorInput($value, $shade);
        return $this;
    }

    public function size(string $value): static
    {
        $this->size = $value;
        return $this;
    }

    /** Force using a panel palette by name: 'primary' or 'secondary' */
    public function palette(string $name = 'primary'): static
    {
        $this->thumb      = "var(--{$name}-500)";
        $this->thumbHover = "var(--{$name}-600)";
        return $this;
    }

    /** Turn inputs into valid CSS color tokens */
    protected function normalizeColorInput(string|array $value, int $preferredShade): string
    {
        if (is_array($value)) {
            // e.g., Color::Amber returns palette shades
            if (isset($value[$preferredShade])) {
                return $value[$preferredShade];
            }
            // Fallback: first available shade
            $first = reset($value);
            return is_string($first) ? $first : '#f59e0b';
        }

        $v = trim($value);

        // Pass through CSS var / hex / rgb() / oklch() / hsl() as-is
        if (
            str_starts_with($v, 'var(') ||
            str_starts_with($v, 'rgb(') ||
            str_starts_with($v, 'oklch(') ||
            str_starts_with($v, 'hsl(') ||
            preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $v)
        ) {
            return $v;
        }

        // Convert "R G B" triplet to rgb()
        if (preg_match('/^\d{1,3}\s+\d{1,3}\s+\d{1,3}$/', $v)) {
            return "rgb({$v})";
        }

        // Last resort: return as-is
        return $v;
    }
}
