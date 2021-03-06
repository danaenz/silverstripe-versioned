<?php

namespace SilverStripe\Versioned\GraphQL\Operations;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DataObjectInterface;
use SilverStripe\Security\Member;
use SilverStripe\Versioned\Versioned;

// GraphQL dependency is optional in versioned,
// and legacy implementation relies on existence of this class (in GraphQL v3)
if (!class_exists(PublishOperation::class)) {
    return;
}

/**
 * Scaffolds a generic update operation for DataObjects.
 *
 * @deprecated 4.8..5.0 Use silverstripe/graphql:^4 functionality.
 */
class Unpublish extends PublishOperation
{
    /**
     * @return string
     */
    protected function createOperationName()
    {
        return 'unpublish'.ucfirst($this->getTypeName());
    }

    /**
     * @param DataObjectInterface $obj
     */
    protected function doMutation(DataObjectInterface $obj)
    {
        /** @var Versioned|DataObject $obj */
        $obj->doUnpublish();
    }

    /**
     * @param DataObjectInterface $obj
     * @param Member $member
     * @return boolean
     */
    protected function checkPermission(DataObjectInterface $obj, Member $member = null)
    {
        /** @var Versioned|DataObject $obj */
        return $obj->canUnpublish($member);
    }

    /**
     * Set the stage for the read query
     */
    protected function getReadingStage()
    {
        return Versioned::LIVE;
    }
}
