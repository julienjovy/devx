# devx

[![Latest Version on Packagist](https://img.shields.io/packagist/v/julienjovy/devx.svg?style=flat-square)](https://packagist.org/packages/julienjovy/devx)
[![PHP Version](https://img.shields.io/badge/php-%5E8.3-blue?logo=php&style=flat-square)](https://www.php.net/)
[![License](https://img.shields.io/github/license/julienjovy/devx?style=flat-square)](LICENSE)

**The Laravel-friendly CLI to automate development environments.**
From initializing fullstack apps (Laravel + Nuxt) to updating dependencies, devx does the boring stuff for you.

---

## 🚀 What is devx?

`devx` is a command-line tool that helps developers quickly set up, maintain, and scale local development environments for Laravel-based stacks.

It supports:

- Laravel backend scaffolding
- Nuxt frontend pairing
- Composer and Node/NPM automation
- Custom aliases, `.bashrc` generation, OTP/OAuth setup
- And more to come...

---

## 🧰 Installation

```
composer global require julienjovy/devx
```

Make sure your global Composer bin directory is in your `$PATH`:

- **Linux/macOS**:

  ```bash
  export PATH="$HOME/.config/composer/vendor/bin:$PATH"
  ```

- **Windows (PowerShell)**:
  ```powershell
  set PATH=%APPDATA%\Composer\vendor\bin;%PATH%
  ```

Once installed, use `devx` from anywhere:

```
devx --help
```

---

## ⚙️ Available Commands

### 🏗️ Scaffold a Laravel + Nuxt fullstack app

```
devx install --stack=laravel-nuxt --project=my-app --mode=split
```

Options:

- `--stack=laravel-nuxt|laravel-only`
- `--mode=split|fullstack`
  `split` = frontend & backend in separate folders
  `fullstack` = front (e.g. Vite/Blade) inside Laravel app

---

### 🧪 Environment checks

```
devx doctor
```

Checks:

- PHP, Composer, Node, NPM, NVM
- Docker installed?
- Laravel tools present?

---

<!-- ## 📦 Roadmap


--- -->

## 💬 Feedback

Made with ❤️ && ☕ by [Julien Jovy](https://github.com/julienjovy)

Pull requests welcome.
