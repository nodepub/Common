<?php

namespace NodePub\Common;

use Symfony\Component\Finder\Finder;

trait SourceDirectoryAwareTrait
{
    /**
     * @var array
     */
    protected $sourceDirs = array();
    
    /**
     * Adds a directory to the array of sources that will
     * be searched for themes to load.
     */
    public function addSource($sourcePath, $useStrict=true)
    {
        if (is_link($sourcePath)) {
            return $this->addSource(realpath($sourcePath), $useStrict);
        }
        
        if (is_dir($sourcePath)) {
            $this->sourceDirs[] = $sourcePath;
        } elseif (true === $useStrict) {
            throw new \Exception(sprintf('Path {%s} is not a readable directory', $sourcePath));
        }
        
        return $this;
    }
    
    /**
     * Searches source directories for criteria in given Finder
     *
     * @return Finder
     */
    public function findInSourceDirs(Finder $finder)
    {
        foreach ($this->sourceDirs as $dir) {
            $finder->in($dir);
        }

        return $finder;
    }
}