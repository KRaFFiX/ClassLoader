# ClassLoader

[![Build Status](https://travis-ci.org/Prowect/ClassLoader.svg)](https://travis-ci.org/Prowect/ClassLoader)
[![Code Climate](https://codeclimate.com/github/Prowect/ClassLoader/badges/gpa.svg)](https://codeclimate.com/github/Prowect/ClassLoader)
[![Test Coverage](https://codeclimate.com/github/Prowect/ClassLoader/badges/coverage.svg)](https://codeclimate.com/github/Prowect/ClassLoader/coverage)

## Beschreibung

Der ClassLoader lädt automatisch PHP-Dateien bzw. -Klassen. Hierfür erfolgt anhand des Namespaces eine Zuordnung zu einer bestimmten Datei, welche anschließend included wird.

## Installation

1. Zuerst muss die PHP-Datei, die den ClassLoader beinhaltet included werden.
2. Anschließend muss der ClassLoader angelegt (registriert) werden.

```php
<?php
use Drips\ClassLoader\ClassLoader;
require_once 'classloader.php';
$loader = new ClassLoader;
```

## Verwendung

Neben dem Laden von Klassen mithilfe der `load`-Methode können Namespaces auch manuell registriert werden, wenn diese beispielsweise in einem anderem (Unter-)Verzeichnis liegen.

```php
<?php
$loader->registerNamespace("Drips", "core/lib");
```

Somit können Dateien, die im Namespace `Drips` liegen von `core/lib/Drips` geladen werden.

Außerdem kann ein Standardverzeichnis festgelegt werden, von welchem der ClassLoader die Dateien beziehen soll.

```php
<?php
$loader->load_dir = "core/lib";
```

Dadurch werden alle Klassen die vom ClassLoader geladen werden sollen im Verzeichnis `core/lib` gesucht.
