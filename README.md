# ClassLoader

![Build-Status](https://gitlab.com/ci/projects/10677/status.png?ref=master)

## Beschreibung

Der ClassLoader lädt automatisch PHP-Dateien bzw. -Klassen. Hierfür erfolgt anhand des Namespaces eine Zuordnung zu einer bestimmten Datei, welche anschließend included wird.

## Installation

1. Zuerst muss die PHP-Datei, die den ClassLoader beinhaltet included werden.
2. Anschließend muss der ClassLoader angelegt (registriert) werden.

```php
<?php
use Drips\ClassLoader\ClassLoader;
require_once 'ClassLoader.php';
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
