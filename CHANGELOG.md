Version 0.1.2
==============================
Features
---------------
 - `tryload`-Methode hinzugefügt
 - Extensions (Dateiendungen) können nach wie vor manuell hinzugefügt werden - aktuell ist standardmäßig ausschließlich die Endung `.php` zulässig (Performance)

Bugs
---------------
 - Ist das load_dir Attribut gesetzt worden, wurde dennoch nicht die entsprechende Klasse geladen.

Version 0.1.1
==============================
Features
---------------
 - `load`-Methode wurde gekürzt, indem sie auf 2 weitere Methoden ausgelagert wurde. (`autoload` und `manualload`)

Bugs
---------------
 - Auf Linux-Systemen, wurde die Groß- und Kleinschreibung von Dateinamen berücksichtig, weshalb das Laden von Klassen teilweise nicht möglich war. Aus diesem Grund können von nun an ausschließlich lowercase-Dateien geladen werden.

Version 0.1
==============================
Features
---------------
 - Automatisches Laden von PHP-Klassen bzw. PHP-Dateien anhand von Namespaces
 - Registrierung von Namespaces für bestimmte Verzeichnisse
 - Festlegen eines Lade-Verzeichnisses, von dem die PHP-Klassen geladen werden sollen
