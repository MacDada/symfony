<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Twig\Tests\Validator\Constraints;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Validator\Constraints\Twig;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Loader\AttributeLoader;

/**
 * @author Mokhtar Tlili <tlili.mokhtar@gmail.com>
 */
class TwigTest extends TestCase
{
    public function testAttributes()
    {
        $metadata = new ClassMetadata(TwigDummy::class);
        $loader = new AttributeLoader();
        self::assertTrue($loader->loadClassMetadata($metadata));

        [$bConstraint] = $metadata->getPropertyMetadata('b')[0]->getConstraints();
        self::assertSame('myMessage', $bConstraint->message);
        self::assertSame(['Default', 'TwigDummy'], $bConstraint->groups);

        [$cConstraint] = $metadata->getPropertyMetadata('c')[0]->getConstraints();
        self::assertSame(['my_group'], $cConstraint->groups);
        self::assertSame('some attached data', $cConstraint->payload);

        [$dConstraint] = $metadata->getPropertyMetadata('d')[0]->getConstraints();
        self::assertFalse($dConstraint->skipDeprecations);
    }
}

class TwigDummy
{
    #[Twig]
    private $a;

    #[Twig(message: 'myMessage')]
    private $b;

    #[Twig(groups: ['my_group'], payload: 'some attached data')]
    private $c;

    #[Twig(skipDeprecations: false)]
    private $d;
}
