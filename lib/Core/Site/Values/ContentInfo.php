<?php

namespace Netgen\EzPlatformSite\Core\Site\Values;

use Netgen\EzPlatformSite\API\Values\ContentInfo as APIContentInfo;

final class ContentInfo extends APIContentInfo
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $languageCode;

    /**
     * @var \eZ\Publish\API\Repository\Values\Content\ContentInfo
     */
    protected $innerContentInfo;

    /**
     * @var \eZ\Publish\API\Repository\Values\ContentType\ContentType
     */
    protected $innerContentType;

    /**
     * Magic getter for retrieving convenience properties.
     *
     * @param string $property The name of the property to retrieve
     *
     * @return mixed
     */
    public function __get($property)
    {
        switch ($property) {
            case 'id':
                return $this->innerContentInfo->id;
            case 'mainLocationId':
                return $this->innerContentInfo->mainLocationId;
            case 'contentTypeIdentifier':
                return $this->innerContentType->identifier;
        }

        return parent::__get($property);
    }

    /**
     * Magic isset for signaling existence of convenience properties.
     *
     * @param string $property
     *
     * @return bool
     */
    public function __isset($property)
    {
        switch ($property) {
            case 'id':
            case 'mainLocationId':
            case 'contentTypeIdentifier':
                return true;
        }

        return parent::__isset($property);
    }
}