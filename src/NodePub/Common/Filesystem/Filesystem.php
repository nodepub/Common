<?php

namespace NodePub\Common\Filesystem;

use Symfony\Component\Filesystem\Filesystem as SFFilesystem;
use Symfony\Component\Filesystem\Exception\IOException;

class Filesystem extends SFFilesystem
{
    public function matchOwnersIfPossible($target_filename, $match_from_filename)
    {
        try {
            if (false === ($intended_uid = fileowner($match_from_filename)) ) throw new \Exception("fileowner failed on source");
            if (false === ($intended_gid = filegroup($match_from_filename)) ) throw new \Exception("filegroup failed on source");

            if (false === ($uid = fileowner($target_filename)) ) throw new \Exception("fileowner failed on target");
            if (false === ($gid = filegroup($target_filename)) ) throw new \Exception("filegroup failed on target");
            
            if ($intended_uid != $uid && ! $this->chown($target_filename, $intended_uid)) throw new \Exception("chown failed on target");
            if ($intended_gid != $gid && ! $this->chgrp($target_filename, $intended_gid)) throw new \Exception("chgrp failed on target");
        } catch (\Exception $e) {
            throw new IOException("Cannot assign ownership of [$target_filename] to owner of [$match_from_filename]: " . $e->getMessage());
        }
    }

    public function filePutContentsAsDirOwner($filename, $data)
    {
        if (false !== ($ret = file_put_contents($filename, $data)) ) {
            $this->matchOwnersIfPossible($filename, dirname($filename));
        }
        return $ret;
    }

    public function mkdirAsParentOwner($pathname, $mode = 0777, $recursive = false)
    {
        if (false !== ($ret = mkdir($pathname, $mode, $recursive)) ) {
            $this->matchOwnersIfPossible($pathname, dirname($pathname));
        }

        return $ret;
    }
}