# Slick Scrollbar

---

## 📖 About

**Slick Scrollbar** is a lightweight plugin that gives your Filament v4 panels clean, theme-aware scrollbars.  
It automatically inherits your panel’s colors (secondary → primary) and works seamlessly in both light and dark mode.

---

## ✨ Features

- 🎨 **Automatic theme colors** — Uses panel secondary (500/600), or falls back to primary (500/600).
- 🎛️ **Customizable** — Override size, color, and hover color with CSS variables, hex, RGB, OKLCH, or Filament Color palettes.
- 🖥️ **Cross-browser support** — Works on Firefox, Chrome, Edge, and Safari.
- 🌗 **Dark mode ready** — Adapts to your Filament theme out of the box.

---

## 📦 Installation

Install via Composer:

```sh
composer require muazzam/slick-scrollbar
```

Filament will auto-discover the service provider.

---

## ⚙️ Usage

Enable the plugin in your panel provider:

```php
use Muazzam\SlickScrollbar\SlickScrollbarPlugin;

public function panel(\Filament\Panel $panel): \Filament\Panel
{
    return $panel->plugins([
        SlickScrollbarPlugin::make(),
    ]);
}
```

That’s it 🎉 — scrollbars will automatically use your panel’s theme colors.

---

## 🎨 Configuration & Customization

### Default behavior

If your panel defines custom colors:

```php
->colors([
    'primary' => \Filament\Support\Colors\Color::Amber,
    'secondary' => \Filament\Support\Colors\Color::Cyan,
])
```

The plugin will use:

- **Secondary:** 500 for normal, 600 for hover  
- If no secondary is defined → **Primary:** 500 for normal, 600 for hover  
- If neither are set, the plugin falls back to safe defaults (amber / cyan).

### Override settings

```php
use Filament\Support\Colors\Color;

SlickScrollbarPlugin::make()
    ->size('6px')                   // scrollbar width/height (default: 8px)
    ->palette('primary')            // force panel palette ('primary' or 'secondary')
    ->color(Color::Amber)           // use a Filament palette (500 normal, 600 auto for hover)
    ->hoverColor(Color::Amber, 700) // pick a custom shade
    ->color('#ef4444')              // hex
    ->hoverColor('rgb(220 38 38)')  // rgb()
    ->color('var(--primary-500)');  // reference CSS vars directly
```

---

## 📸 Screenshots

*(Add your light + dark mode screenshots/gifs here)*

---

## 📋 Requirements

- PHP ^8.2
- Laravel ^10 | ^11 | ^12
- Filament ^4.0

---

## 🚀 Versioning

- **v1.x** → Compatible with Filament v4
- Future Filament majors will get their own major version of this package (e.g. v2.x).

---

## 🔧 Development

Clone and install:

```sh
git clone git@github.com:muazzam/slick-scrollbar.git
cd slick-scrollbar
composer install
```

In your app’s `composer.json`:

```json
"repositories": [
  {
    "type": "path",
    "url": "../slick-scrollbar",
    "options": { "symlink": true }
  }
]
```

Require it locally:

```sh
composer require muazzam/slick-scrollbar:*@dev
```

---

## 📝 License

This package is open-sourced software licensed under the MIT license.

---

## ❤️ Credits

- **Muazzam Khan** – Author
- **Filament** – Admin