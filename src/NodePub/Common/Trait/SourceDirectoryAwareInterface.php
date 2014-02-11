<?php

namespace NodePub\Common\Trait;

use Symfony\Component\Finder\Finder;

interface SourceDirectoryAwareInterface
{
    
    /**
     * @var array
     */
    protected $sourceDirs;
    
    /**
     * Adds a source directory
     */
    public function addSource($sourcePath, $useStrict);
    
    /**
     * Searches source directories for criteria in given Finder
     */
    protected function findInSourceDirs(Finder $finder);
}