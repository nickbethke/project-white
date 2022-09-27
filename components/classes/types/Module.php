<?php

use Laravie\Parser\Xml\Document;
use Laravie\Parser\Xml\Reader;

class Module
{
    private string $path;
    private string $name;
    private string $description;
    private string $author;
    private string $author_uri;
    private string $version;

    public function __construct(string $module_path)
    {
        $this->path = $module_path;

        $xml = (new Reader(new Document()))->load($this->get_xml_path());
        $module = $xml->parse([
            'name' => ['uses' => 'name'],
            'description' => ['uses' => 'description'],
            'author' => ['uses' => 'author'],
            'author_uri' => ['uses' => 'author_uri'],
            'version' => ['uses' => 'version']
        ]);
        $this->name = $module['name'];
        $this->description = $module['description'];
        $this->author = $module['author'];
        $this->author_uri = $module['author_uri'];
        $this->version = $module['version'];
    }

    public function get_xml_path(): string
    {
        return ABSPATH . "modules" . DIRECTORY_SEPARATOR . dirname($this->path) . DIRECTORY_SEPARATOR . "module.xml";
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getAuthorUri(): string
    {
        return $this->author_uri;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }


    
    
}