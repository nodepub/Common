<?php

namespace NodePub\Common;

use Symfony\Component\Finder\Finder;

interface SourceDirectoryAwareInterface
{
    /**
     * Adds a source directory
     */
    public function addSource($sourcePath, $useStrict);
    
    /**
     * Searches source directories for criteria in given Finder
     */
     public function findInSourceDirs(Finder $finder);
}