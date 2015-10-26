<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 13.10.2015 - 18:30
 * Copyright: Prowect
 */

namespace Drips\ClassLoader;

/**
 * Class ClassLoader
 *
 * Diese Klasse ermöglicht das selbständige Laden von PHP-Klassen.
 * Somit können PHP-Dateien automatisch eingebunden werden, wenn eine Klasse
 * benötigt wird, die noch nicht included ist.
 *
 * Anhand des Namespaces der jeweiligen Klasse wird der entsprechende Dateipfad
 * ermittelt.
 */
class ClassLoader
{
    /**
     * Legt fest, in welchem Verzeichnis der ClassLoader nach entsprechenden
     * PHP-Dateien suchen soll.
     *
     * @var string
     */
    public $load_dir;

    /**
     * Beinhaltet alle zulässigen Dateiendungen, nach denen gesucht werden soll.
     *
     * @var array
     */
    public $extensions = array('.php');

    /**
     * Beinhaltet alle manuell definierten Namespaces und in welchem Verzeichnis
     * diese zu finden sind.
     *
     * @var array
     */
    protected $namespaces = array();

    /**
     * Erzeugt eine neue ClassLoader-Instanz und registriert sich automatisch
     * mithilfe der integrierten PHP-Funktion spl_autoload_register.
     */
    public function __construct()
    {
        spl_autoload_register(array($this, "load"));
    }

    /**
     * Versucht die übergebene Klasse zu laden. Gibt TRUE oder FALSE zurück.
     *
     * @param string $class Gibt den vollständigen Klassennamen an (mit Namespace), der Klasse, die geladen werden soll.
     *
     * @return bool Gibt zurück, ob das Laden der Klasse möglich war oder nicht.
     */
    public function load($class)
    {
        if(!$this->autoload($class)){
            return $this->manualload($class);
        }
        return true;
    }

    /**
     * Versucht die Klasse automatisch mithilfe der spl_autoload-Funktion zu laden.
     * Anschließend wird TRUE oder FALSE zurückgeliefert, je nachdem ob das Laden
     * der Klasse erfolgreich war oder nicht.
     *
     * @param string $class Gibt den vollständigen Klassennamen an (mit Namespace), der Klasse, die geladen werden soll.
     *
     * @return bool Gibt zurück, ob das Laden der Klasse möglich war oder nicht.
     */
    public function autoload($class)
    {
        spl_autoload($class, implode(",", $this->extensions));
        return class_exists($class);
    }

    /**
     * Versucht die Klasse manuell zu laden. Dabei wird versucht anhand der
     * manuell registrierten Namespaces die Klasse richtig in einen Dateipfad
     * aufzulösen.
     * Im Gegensatz zur automatischen Lade-Funktion (autoload) wird hierbei das
     * load_dir berücksichtigt.
     *
     * @param string $class Gibt den vollständigen Klassennamen an (mit Namespace), der Klasse, die geladen werden soll.
     *
     * @return bool Gibt zurück, ob das Laden der Klasse möglich war oder nicht.
     */
    public function manualload($class)
    {
        $parts = explode('\\', $class);
        if (count($parts) >= 2) {
            $namespace = $parts[0];
            if (array_key_exists($namespace, $this->namespaces)) {
                if($this->tryload($class, $this->namespaces[$namespace])){
                    return true;
                }
            }
        }
        return $this->tryload($class);
    }

    /**
     * Versucht eine bestimmte Klasse zu laden, ohne die registrierten Namespaces
     * zu berücksichtigen. Außerdem kann ein Verzeichnis übergeben werden, in
     * welchem nach der Klasse gesucht werden soll.
     * Ist das Attribut load_dir gesetzt, wird dieses dem übergebenen Dateipfad
     * vorangestellt, somit ist der übergebene Verzeichnispfad dann lediglich ein
     * Unterverzeichnis des load_dir-Verzeichnisses.
     *
     * @param string $class Gibt den vollständigen Klassennamen an (mit Namespace), der Klasse, die geladen werden soll.
     * @param string $dir Gibt das Unterverzeichnis an, in welchem, nach der Klasse, gesucht werden soll. (Optional)
     *
     * @return bool Gibt zurück, ob das Laden der Klasse möglich war oder nicht.
     */
    protected function tryload($class, $dir = "")
    {
        foreach ($this->extensions as $extension) {
            $path = $dir.DIRECTORY_SEPARATOR.strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class)).$extension;
            if (isset($this->load_dir)) {
                $path = $this->load_dir.DIRECTORY_SEPARATOR.$path;
            }
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
        }
        return false;
    }

    /**
     * Ermöglich das manuelle registrieren von Namespaces.
     * Hierbei wird ein bestimmter Namespace (Beginn) festgelegt und in welchem
     * Verzeichnis dieser zu finden ist.
     *
     * @param string $namespace Gibt den Namespace an, welcher sich in einem Unterverzeichnis befindet.
     * @param string $directory Gibt das Zielverzeichnis an, in welchem sich die Klassen des übergebenen Namespaces befinden.
     */
    public function registerNamespace($namespace, $directory)
    {
        $this->namespaces[$namespace] = $directory;
    }
}
