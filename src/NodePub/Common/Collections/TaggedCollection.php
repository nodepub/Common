<?php

namespace NodePub\Common\Collections;

use Doctrine\Common\Collections\ArrayCollection;

class TaggedCollection extends ArrayCollection
{
    const DATE_FORMAT = 'F Y';

    protected $taggings;

    public function __construct(array $items = array())
    {
        parent::__construct($items);
        $this->expand();
    }

    /**
     * Returns associative array of tags and the slugs of items
     * with those tags
     * i.e. 'tagfoo' => array('foo', 'bar')
     *
     * Caches the result so it does the loop once.
     */
    public function getTaggings()
    {
        if (is_null($this->taggings)) {
            foreach ($this as $key => $item) {
                if (empty($item['tags'])) {
                    continue;
                }
                foreach ($item['tags'] as $tagging) {
                    if (!in_array($tagging, array_keys($item['tags']))) {
                        $this->taggings[$tagging] = array();
                    }
                    $this->taggings[$tagging][] = $slug;
                }
            }
        }
        
        return $this->taggings;
    }

    /**
     * Returns array of all tag names
     */
    public function getTags()
    {
        return array_keys($this->getTaggings());
    }

    /**
     * Returns array of items tagged with the given tag
     */
    public function getByTag($tag)
    {
        $taggings = $this->getTaggings();
        
        if (array_key_exists($tag, $taggings)) {
            return $taggings[$tag];
        }
        
        return array();
    }

    /**
     * Expands each collection item with extra data
     */
    protected function expand()
    {
        foreach ($this as $key => $item) {
            $item['slug'] = $key;

            if (isset($item['date'])) {
                $item['formatted_date'] = date(self::DATE_FORMAT, $item['date']);
            }

            $this->set($key, $item);
        }
    }
}