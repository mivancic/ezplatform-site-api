<?php

namespace Netgen\EzPlatformSiteApi\Core\Site\QueryType\Content\Relations;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion\FieldRelation;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\MatchNone;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator;
use Netgen\EzPlatformSiteApi\API\Values\Content as SiteContent;
use Netgen\EzPlatformSiteApi\Core\Site\QueryType\Content;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * QueryType for finding reverse relations from specific fields towards a Content.
 */
final class ReverseFields extends Content
{
    public static function getName()
    {
        return 'SiteAPI:Content/Relations/ReverseFields';
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'content',
            'relation_field',
        ]);

        $resolver->setAllowedTypes('content', SiteContent::class);
        $resolver->setAllowedTypes('relation_field', ['string', 'array']);
        $resolver->setAllowedValues(
            'relation_field',
            function ($fields) {
                if (!is_array($fields)) {
                    return true;
                }

                foreach ($fields as $field) {
                    if (!is_string($field)) {
                        return false;
                    }
                }

                return true;
            }
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    protected function getFilterCriteria(array $parameters)
    {
        $fields = (array) $parameters['relation_field'];

        if (empty($fields)) {
            return new MatchNone();
        }

        /** @var \Netgen\EzPlatformSiteApi\API\Values\Content $content */
        $content = $parameters['content'];
        $criteria = [];

        foreach ($fields as $identifier) {
            $criteria[] = new FieldRelation($identifier, Operator::CONTAINS, [$content->id]);
        }

        return $criteria;
    }
}
