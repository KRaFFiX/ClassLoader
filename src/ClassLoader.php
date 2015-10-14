<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 13.10.2015 - 18:30
 */

namespace Drips\ClassLoader;

/**
 * Class ClassLoader
 *
 * This class allows the automatic loading of PHP files or PHP classes based on
 * their namespaces.
 */
class ClassLoader
{
    /**
     * Specifies the directory in which according to the associated PHP files to
     * be searched.
     *
     * @var string
     */
    public $load_dir;

    /**
     * Defines valid file extensions to be searched for by those fixed.
     *
     * @var array
     */
    public $extensions = array('.php', '.class.php', '.inc.php');

    /**
     * Contains the assignment of different namespaces to different (sub)
     * directories
     *
     * @var array
     */
    protected $namespaces = array();

    /**
     * Creates a new class loader instance and registers the same classloader by
     * spl_autoload_register.
     */
    public function __construct()
    {
        spl_autoload_register(function ($class) {
            $this->load($class);
        });
    }

    /**
     * Attempts to load the given class.
     *
     * @param string $class specifies the full class name, the class to load
     */
    public function load($class)
    {
        // set include path
        $include_path = $this->load_dir;
        if(!isset($this->load_dir)){
            $include_path = ".";
        }
        set_include_path($include_path.DIRECTORY_SEPARATOR);
        // try autoloading the right php file
        spl_autoload($class, implode(',', $this->extensions));
        // if load was not successful try loading manually
        if (!class_exists($class)) {
            $parts = explode('\\', $class);
            if (count($parts) >= 2) {
                $namespace = $parts[0];
                if (array_key_exists($namespace, $this->namespaces)) {
                    $dir = $this->namespaces[$namespace];
                    foreach ($this->extensions as $extension) {
                        $path = $dir.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class).$extension;
                        if (isset($this->load_dir)) {
                            $path = $this->load_dir.DIRECTORY_SEPARATOR.$path;
                        }
                        if (file_exists($path)) {
                            require_once $path;
                            break;
                        }
                    }
                }
            }
        }
    }

    /**
     * Allows you to associate different namespaces to different directories.
     *
     * @param string $namespace sets the namespace, which is located in a subdirectory.
     * @param string $directory specifies the target directory where the files of the specified namespaces are
     */
    public function registerNamespace($namespace, $directory)
    {
        $this->namespaces[$namespace] = $directory;
    }
}
